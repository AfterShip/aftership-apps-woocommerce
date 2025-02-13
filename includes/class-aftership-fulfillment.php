<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class AfterShip_Fulfillment {

    private static $instance;

    public static function get_instance() {
        if ( null === self::$instance ) {

            self::$instance = new self();
        }

        return self::$instance;
    }

    // 前端版本控制器、前端灰度
    public function frontend_version_controller()
    {
		// return 'v2';
        $version = 'v1';
        $options = get_option( 'aftership_option_name' );
        if ($options) {
            $enable_fulfillment_tracking = safeArrayGet($options, 'enable_fulfillment_tracking', 0);
            if ($enable_fulfillment_tracking === 1) {
                $version = 'v2';
            }
        }
        return $version;
    }

    public function get_order_fulfillments_controller() {
        try {
            check_ajax_referer( 'get-tracking-item', 'security', true );

            if ( empty( $_REQUEST['order_id'] ) ) {
                AfterShip_Actions::get_instance()->format_aftership_tracking_output( 422, 'missing order_id field' );
            }
            $order_id = wc_clean( $_REQUEST['order_id'] );

            // migrate old tracking data
            AfterShip_Actions::get_instance()->convert_old_meta_in_order( $order_id );

            $order_line_items = AfterShip_Actions::get_instance()->get_order_item_data( $order_id );
            $order_fulfillment_items = $this->get_fulfillments_by_wc( $order_id );
//		error_log('order_fulfillment_items' . var_export($order_fulfillment_items, true));

            $order = new WC_Order( $order_id );
            $order_trackings = array(
                'line_items' => $order_line_items,
                'fulfillments'  => $order_fulfillment_items,
                'number'     => (string) $order->get_order_number(),
            );

            AfterShip_Actions::get_instance()->format_aftership_tracking_output( 200, 'success', $order_trackings );
        } catch (Exception $e) {
            AfterShip_Actions::get_instance()->format_aftership_tracking_output( 500, 'server error' . $e->getMessage() );
        }
    }

    public function trackings_to_fulfillments($trackings)
    {
        $fulfillments = array();
        foreach ($trackings as $index => $tracking ) {
            $f = [];
            $f['id'] = (string)($index+1);
            $f['items'] = safeArrayGet($tracking, 'line_items', []);
            if (isset($tracking['metrics'])) {
                $f['created_at'] = safeArrayGet($tracking['metrics'], 'created_at', '');
                $f['updated_at'] = safeArrayGet($tracking['metrics'], 'updated_at', '');
            }
            $f['from_tracking'] = true;

            // trackings to fulfillment trackings
            $tracking_numbers = explode(',', $tracking['tracking_number']);
            $t_arr = [];
            foreach ($tracking_numbers as $tracking_number) {
                $t_arr[] = [
                    'tracking_id' => safeArrayGet($tracking, 'tracking_id', ''),
                    'tracking_number'=> $tracking_number,
                    'slug' => safeArrayGet($tracking, 'slug', ''),
                    'additional_fields' => safeArrayGet($tracking, 'additional_fields', []),
                ];
            }
            $f['trackings'] = $t_arr;
            $fulfillments[] = $f;
        }
        return $fulfillments;
    }

    public function get_fulfillments_by_wc($order_id)
    {
        $order          = new WC_Order($order_id);
        $fulfillments = $order->get_meta( '_aftership_fulfillments', true );
        if (!empty($fulfillments)) {
            return $fulfillments;
        }
        $trackings = AfterShip_Actions::get_instance()->get_tracking_items($order_id);
        $fulfillments = $this->trackings_to_fulfillments($trackings);
        $this->save_fulfillments_to_wc($order_id, $fulfillments);
        return $fulfillments;
    }

    public function save_order_fulfillments_controller()
    {
        try {
            check_ajax_referer( 'create-tracking-item', 'security', true );
            $params          = json_decode( file_get_contents( 'php://input' ), true );
            $order_id        = wc_clean( $params['order_id'] );
            $order_fulfillments = $params['fulfillments'];
            // check
            $order_fulfillments = $this->check_aftership_fulfillments_fields($order_id, $order_fulfillments);
            $this->check_order_fulfillments_items($order_id, $order_fulfillments);
            // clear old tracking
            $old_trackings = $this->fulfillments_to_trackings($order_fulfillments);
            // migrate old tracking data
            AfterShip_Actions::get_instance()->save_tracking_items( $order_id, $old_trackings);
            // save
            $this->save_fulfillments_to_wc($order_id, $order_fulfillments);
            // date_modified update
            $order = new WC_Order( $order_id );
            $order->set_date_modified( current_time( 'mysql' ) );
            $order->save();
            // response
            AfterShip_Actions::get_instance()->format_aftership_tracking_output( 200, 'success' );
        } catch (Exception $e) {
            AfterShip_Actions::get_instance()->format_aftership_tracking_output( 500, 'server error' . $e->getMessage() );
        }
    }

    private function check_order_fulfillments_items( $order_id, $fulfillments, $only_check = false ) {
        // get order line items
        $order_line_items   = AfterShip_Actions::get_instance()->get_order_item_data( $order_id );
        $line_item_quantity = absint( array_sum( array_column( $order_line_items, 'quantity' ) ) );
        $fulfillment_items     = array_column( $fulfillments, 'items' );

        $tmp = array();
        foreach ( $fulfillment_items as $one ) {
            $result = array_merge( $tmp, $one );
            $tmp    = $result;
        }
        $fulfill_items_quantity = absint( array_sum( array_column( $tmp, 'quantity' ) ) );

        if ( $fulfill_items_quantity > $line_item_quantity ) {
            if ( $only_check ) {
                return true;
            }
            AfterShip_Actions::get_instance()->format_aftership_tracking_output( 422, 'fulfill item quantity gte order item qiantity' );
        }
    }

    private function check_aftership_fulfillments_fields( $order_id, $fulfillments ) {
        if ( empty( $order_id ) || empty( $fulfillments ) || ! is_array( $fulfillments )) {
            AfterShip_Actions::get_instance()->format_aftership_tracking_output( 422, 'missing required field' );
        }

        foreach ($fulfillments as $i => $fulfillment) {
            if (empty($fulfillment['trackings']) || !is_array($fulfillment['trackings'])){
                AfterShip_Actions::get_instance()->format_aftership_tracking_output( 422, 'missing required field' );
            }
            foreach ($fulfillment['trackings'] as $j => $tracking) {
                $tracking_number = str_replace(' ', '', safeArrayGet($tracking, 'tracking_number', ''));
                if (empty($tracking_number) || empty($tracking['slug'])) {
                    AfterShip_Actions::get_instance()->format_aftership_tracking_output( 422, 'missing required field' );
                }
                if (strlen($tracking_number) > 256 || strlen($tracking['slug']) > 256 || strlen($tracking['tracking_id']) > 256) {
                    AfterShip_Actions::get_instance()->format_aftership_tracking_output( 400, 'bad request' );
                }
                $fulfillments[$i]['trackings'][$j]['tracking_number'] = $tracking_number;

                $additional_fields = safeArrayGet($tracking, 'additional_fields', []);
                foreach ($additional_fields as $key => $value) {
                    $value = str_replace(' ', '', isset($value) ? $value : '');
                    if (strlen($value) > 256) {
                        AfterShip_Actions::get_instance()->format_aftership_tracking_output( 400, 'bad request' );
                    }
                    $fulfillments[$i]['trackings'][$j]['additional_fields'][$key] = $value;
                }
            }
        }
        return $fulfillments;
    }

    private function fulfillments_to_trackings($fulfillments)
    {
        $trackings = array();
        foreach ($fulfillments as $fulfillment) {
            foreach ($fulfillment['trackings'] as $tracking) {
                $tracking['tracking_number'] = safeArrayGet($tracking, 'tracking_number', '');
                $tracking['tracking_id'] = safeArrayGet($tracking, 'tracking_id', '');
                $tracking['additional_fields'] = safeArrayGet($tracking, 'additional_fields', []);
                $tracking['slug'] = safeArrayGet($tracking, 'slug', '');
                $tracking['line_items'] = safeArrayGet($fulfillment, 'items', []);
                $tracking['metrics']['created_at'] = safeArrayGet($fulfillment, 'created_at', '');
                $tracking['metrics']['updated_at'] = safeArrayGet($fulfillment, 'updated_at', '');
                $trackings[] = $tracking;
            }
        }
        return $trackings;
    }

    public function save_fulfillments_to_wc($order_id, $fulfillments)
    {
//		error_log("save_fulfillments_to_wc".var_export($fulfillments, true));
        $order = new WC_Order($order_id);
        $order->update_meta_data('_aftership_fulfillments', $fulfillments);
        if ( custom_orders_table_usage_is_enabled() ) {
            $order->save();
        } else {
            $order->save_meta_data();
        }
    }

    public function delete_order_fulfillments_controller() {
        try {
            check_ajax_referer( 'delete-tracking-item', 'security', true );

            $params      = json_decode( file_get_contents( 'php://input' ), true );
            $order_id    = wc_clean( $params['order_id'] );
            $fulfillment_id = wc_clean( $params['fulfillment_id'] );

            if ( empty( $order_id ) ) {
                AfterShip_Actions::get_instance()->format_aftership_tracking_output( 422, 'missing required field' );
            }

            $deleted_fulfillment = $this->delete_fulfillment($order_id, $fulfillment_id);
            foreach (safeArrayGet($deleted_fulfillment, 'trackings', []) as $tracking) {
                AfterShip_Actions::get_instance()->delete_tracking_item( $order_id, $tracking['tracking_id'] );
            }

            // date_modified update
            $order = new WC_Order( $order_id );
            $order->set_date_modified( current_time( 'mysql' ) );
            $order->save();

            AfterShip_Actions::get_instance()->format_aftership_tracking_output( 200, 'success' );
        } catch (Exception $e) {
            AfterShip_Actions::get_instance()->format_aftership_tracking_output( 500, 'server error' . $e->getMessage() );
        }
    }

    public function delete_fulfillment( $order_id, $fulfillment_id )
    {
        $fulfillments = $this->get_fulfillments_by_wc($order_id);
        $deleted_fulfillment = null;

        if ( count( $fulfillments ) > 0 ) {
            foreach ( $fulfillments as $key => $item ) {
                if ( $item['id'] == $fulfillment_id ) {
                    $deleted_fulfillment = $item;
                    unset( $fulfillments[ $key ] );
                    break;
                }
            }
            $this->save_fulfillments_to_wc( $order_id, array_values( $fulfillments ) );
        }
        return $deleted_fulfillment;
    }

    public function delete_order_fulfillment_tracking_controller() {
        try {
            check_ajax_referer( 'delete-tracking-item', 'security', true );

            $params      = json_decode( file_get_contents( 'php://input' ), true );
            $order_id    = wc_clean( $params['order_id'] );
            $tracking_id = wc_clean( $params['tracking_id'] );

            if ( empty( $order_id ) || empty( $tracking_id ) ) {
                AfterShip_Actions::get_instance()->format_aftership_tracking_output( 422, 'missing required field' );
            }

            $this->delete_fulfillment_tracking( $order_id, $tracking_id );
            AfterShip_Actions::get_instance()->delete_tracking_item( $order_id, $tracking_id );

            // date_modified update
            $order = new WC_Order( $order_id );
            $order->set_date_modified( current_time( 'mysql' ) );
            $order->save();

            AfterShip_Actions::get_instance()->format_aftership_tracking_output( 200, 'success' );
        } catch (Exception $e) {
            AfterShip_Actions::get_instance()->format_aftership_tracking_output( 500, 'server error' . $e->getMessage() );
        }
    }

    public function delete_fulfillment_tracking( $order_id, $tracking_id )
    {
        $fulfillments = $this->get_fulfillments_by_wc($order_id);
        if (count($fulfillments) <= 0) {
            return;
        }

        foreach ( $fulfillments as $index => $fulfillment ) {
            if (isset($fulfillment['trackings'])) {
                $trackings = $fulfillment['trackings'];
                foreach ($trackings as $key => $item) {
                    if ($item['tracking_id'] === $tracking_id) {
                        unset($trackings[$key]);
                        break;
                    }
                }
                $fulfillment['trackings'] = array_values($trackings);

                if (count($fulfillment['trackings']) === 0) {
                    unset($fulfillments[$index]);
                } else {
                    $fulfillments[$index] = $fulfillment;
                }
            }
        }
        $this->save_fulfillments_to_wc( $order_id, array_values( $fulfillments ) );
    }
}