<?php
/**
 * AfterShip API Orders Class
 *
 * Handles requests to the /orders endpoint
 *
 * @author      AfterShip
 * @category    API
 * @package     AfterShip/API
 * @since       1.0
 */

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

class AfterShip_API_V2_Orders extends AfterShip_API_Resource
{

    /** @var string $base the route base */
    protected $base = '/v2/orders';

    /**
     * Register the routes for this class
     *
     * GET /orders
     *
     * @param array $routes
     *
     * @return array
     * @since 2.1
     *
     */
    public function register_routes($routes)
    {
        # GET /orders/ping
        $routes[$this->base . '/ping'] = [
            [[$this, 'ping'], AfterShip_API_Server::READABLE],
        ];

        # GET /orders
        $routes[$this->base] = [
            [[$this, 'get_orders'], AfterShip_API_Server::READABLE]
        ];

        # GET /orders/:id
        $routes[$this->base . '/(?P<id>[\d]+)'] = [
            [[$this, 'get_order'], AfterShip_API_Server::READABLE],
        ];

        return $routes;
    }

    /**
     * heath checkendpoint for wordpress url validation
     *
     * @return string
     * @since 2.1
     */
    public function ping()
    {
        return 'pong';
    }

    /**
     * Get orders
     *
     * @param string $updated_at_min
     * @param string $updated_at_max
     * @param string $max_results_number
     *
     * @return array
     * @throws Exception
     * @since 2.1
     *
     */
    public function get_orders($updated_at_min = null, $updated_at_max = null, $max_results_number = null)
    {
        $args = [
            'updated_at_min' => $updated_at_min,
            'updated_at_max' => $updated_at_max,
            'orderby' => 'modified',
            'order' => 'ASC',
            'limit' => $max_results_number,
            'page' => !empty($_GET['page']) && intval($_GET['page']) > 1 ? absint($_GET['page']) : 1
        ];

        $query = $this->query_orders($args);

        //define pagination
        $pagination = [
            'page' => $query->query['paged'],
            'limit' => intval($query->query['posts_per_page']),
            'total' => intval($query->found_posts)
        ];

        $orders = [];
        foreach ($query->posts as $order_id) {
            if (!$this->is_readable($order_id)) {
                continue;
            }
            $orders[] = $this->get_order($order_id);
        }

        return ['orders' => $orders, 'pagination' => $pagination];
    }

    /**
     * get single order by id
     * @param $id
     * @return array|int|WP_Error
     * @throws Exception
     */
    public function get_order($id)
    {
        $weight_unit = get_option('woocommerce_weight_unit');
        // ensure order ID is valid & user has permission to read
        $id = $this->validate_request($id, 'shop_order', 'read');
        if (is_wp_error($id)) {
            return $id;
        }
        $order = new WC_Order($id);
        $customer = new WC_Customer($order->get_customer_id());
        $shipping_method = current($order->get_shipping_methods());
        $order_data = [
            'id' => (string)$order->get_id(),
            'order_number' => $order->get_order_number(),
            'order_name' => $order->get_order_number(),
            'taxes_included' => ($order->get_total_tax() > 0),
            'shipping_method' => [
                'code' => $shipping_method['method_id'],
                'name' => $shipping_method['name'],
            ],
            'order_total' => [
                'currency' => $order->get_currency(),
                'amount' => (float)wc_format_decimal($order->get_total(), 2),
            ],
            'note' => $order->get_customer_note(),
            'locale' => get_locale(),
            'metrics' => [
                'placed_at' => $this->server->format_datetime($order->get_date_created()),
                'updated_at' => $this->server->format_datetime($order->get_date_modified()),
                'fully_shipped_at' => null,
                'expected_earliest_delivery_at' => null,
                'expected_last_delivery_at' => null,
            ],
            'customer' => [
                'id' => (string)$order->get_customer_id(),
                'first_name' => $customer->get_first_name(),
                'last_name' => $customer->get_last_name(),
                'emails' => ($customer->get_email()) ? [$customer->get_email()] : [],
                'phones' => ($customer->get_billing_phone()) ? [[
                    'country_code' => null,
                    'number' => $customer->get_billing_phone()
                ]] : [],
            ],
            'shipping_address' => [
                'first_name' => $order->get_shipping_first_name(),
                'last_name' => $order->get_shipping_last_name(),
                'company' => $order->get_shipping_company(),
                'address_line_1' => $order->get_shipping_address_1(),
                'address_line_2' => $order->get_shipping_address_2(),
                'city' => $order->get_shipping_city(),
                'state' => $order->get_shipping_state(),
                'country' => $this->server->convert_country_code($order->get_shipping_country()),
                'postal_code' => $order->get_shipping_postcode(),
                'email' => $order->get_billing_email(),
                'phone' => [
                    'country_code' => null,
                    'number' => $order->get_billing_phone()
                ],
                'address_type' => null,
                'tax_number' => null,
            ],
            'billing_address' => array(
                'first_name' => $order->get_billing_first_name(),
                'last_name' => $order->get_billing_last_name(),
                'company' => $order->get_billing_company(),
                'address_line_1' => $order->get_billing_address_1(),
                'address_line_2' => $order->get_billing_address_2(),
                'city' => $order->get_billing_city(),
                'state' => $order->get_billing_state(),
                'postal_code' => $order->get_billing_postcode(),
                'country' => $this->server->convert_country_code($order->get_billing_country()),
                'email' => $order->get_billing_email(),
                'phone' => [
                    'country_code' => null,
                    'number' => $order->get_billing_phone()
                ],
                'address_type' => null,
                'tax_number' => null,
            ),
            'status' => $order->get_status(),
            'items' => [],
            'trackings' => []
        ];


        // add line items
        foreach ($order->get_items() as $item_id => $item) {
            if (is_callable($item, 'get_product')) {
                $product = $item->get_product();
            } else {
                $product = $order->get_product_from_item($item);
            }
            if (empty($product)) continue;
            $weight = $product->get_weight();
            $product_id = (isset($product->variation_id)) ? $product->variation_id : $product->get_id();
            // set the response object
            $terms_tags = get_the_terms($product_id, 'product_tag');
            $product_tags = [];
            foreach ($terms_tags as $termsKey => $termsVal) {
                $product_tags[] = $termsVal->name;
            }
            $product_categories = [];

            $categories = get_the_terms($product_id, 'product_cat');
            foreach ($categories as $categoriesKey => $categoriesVal) {
                $product_categories[] = $categoriesVal->name;
            }
            $order_data['items'][] = [
                'id' => $item_id,
                'product_id' => $product_id,
                'sku' => is_object($product) ? $product->get_sku() : null,
                'title' => $item['name'],
                'quantity' => (int)$item['qty'],
                'returnable_quantity' => (int)($item['qty'] - $order->get_qty_refunded_for_item($item_id)),

                'unit_weight' => [
                    'unit' => $weight_unit,
                    'value' => (float)$weight,
                ],
                'unit_price' => [
                    'currency' => $order->get_currency(),
                    'amount' => (float)wc_format_decimal($order->get_item_total($item), 2),
                ],
                'discount' => null,
                'image_urls' => [wp_get_attachment_url($product->image_id)],
                'tags' => $product_tags,
                'categories' => $product_categories,
            ];
        }

        // tracking field will be
        /*
        {
			tracking_number: fulfillment.tracking_number,
			slug: mapped_slug,
			additional_fields: {
				account_number: null,
				key: null,
				postal_code: (data.shipping_address && data.shipping_address.zip) ? data.shipping_address.zip : null,
				ship_date: moment(fulfillment.updated_at).utcOffset('+0000').format('YYYYMMDD'),
				state: null,
				origin_country: null,
				destination_country: (data.shipping_address && data.shipping_address.country_code) ? beautifyAddress({country: data.shipping_address.country_code}).country_iso3 : null,
			},
		}
         */

        $trackings = [];
        //The function definition will be available after installing the aftership plugin.
        if(function_exists('order_post_meta_getter')) {
            $aftership_tracking_number = order_post_meta_getter($order, 'aftership_tracking_number');
            if (!empty($aftership_tracking_number)) {
                $trackings[] = [
                    'slug' => order_post_meta_getter($order, 'aftership_tracking_provider'),
                    'tracking_number' => $aftership_tracking_number,
                    'additional_fields' => [
                        'postal_code' => order_post_meta_getter($order, 'aftership_tracking_postal'),
                    ],
                ];
            }

            // 兼容 woocommerce 官方的 tracking 插件
            $woocommerce_tracking_arr = order_post_meta_getter($order, 'wc_shipment_tracking_items');
            if (empty($aftership_tracking_number) && !empty($woocommerce_tracking_arr)) {
                foreach ($woocommerce_tracking_arr as $trackingKey => $trackingVal) {
                    $trackingArr = $this->getTrackingInfoByShipmentTracking($trackingVal);
                    if (!empty($trackingArr)) {
                        $trackings[] = [
                            'slug' => $trackingArr['tracking_provider'],
                            'tracking_number' => $trackingVal["tracking_number"],
                            'additional_fields' => [
                                'postal_code' => $trackingArr['tracking_postal_code'],
                            ],
                        ];
                    } else {
                        $trackings[] = [
                            'slug' => $trackingVal["tracking_provider"],
                            'tracking_number' =>$trackingVal["tracking_number"],
                            'additional_fields'=> [
                                'postal_code' => null,
                            ]
                        ];
                    }
                }
            }
            $order_data['trackings'] = $trackings;
        }

        return $order_data;
    }

    /**
     * 从wc ShipmentTracking 插件获取 Postalcode  - postnl
     * @param $tracking_items
     * @return array
     */
    private function getTrackingInfoByShipmentTracking($tracking_items)
    {
        if (!isset($tracking_items['custom_tracking_link'])) {
            return array();
        }

        // 获取 postnl  Postalcode
        $urlArr = parse_url(stripslashes($tracking_items['custom_tracking_link']));

        if ($urlArr === false) {
            return array();
        }

        if (!isset($urlArr['host'])) {
            return array();
        }

        $hostArr = explode(".", $urlArr['host']);
        $hostArrIndex = count($hostArr) - 2;
        if (empty($hostArr) || !isset($hostArr[$hostArrIndex])) {
            return array();
        }

        if ($hostArr[$hostArrIndex] == 'postnl') {
            parse_str($urlArr['query'], $queryArr);
            if (!isset($queryArr['Postalcode'])) {
                return array();
            }

            return array(
                'tracking_provider' => 'postnl',
                'tracking_postal_code' => str_replace(" ", "", $queryArr['Postalcode']),
            );
        }
        return array();
    }


    /**
     * Helper method to get order post objects
     *
     * @param array $args request arguments for filtering query
     *
     * @return WP_Query
     * @since 2.1
     *
     */
    private function query_orders($args)
    {

        function aftership_wpbo_get_woo_version_number()
        {
            // If get_plugins() isn't available, require it
            if (!function_exists('get_plugins'))
                require_once(ABSPATH . 'wp-admin/includes/plugin.php');

            // Create the plugins folder and file variables
            $plugin_folder = get_plugins('/' . 'woocommerce');
            $plugin_file = 'woocommerce.php';

            // If the plugin version number is set, return it
            if (isset($plugin_folder[$plugin_file]['Version'])) {
                return $plugin_folder[$plugin_file]['Version'];

            } else {
                // Otherwise return null
                return NULL;
            }
        }

        $woo_version = aftership_wpbo_get_woo_version_number();

        if ($woo_version >= 2.2) {
            // set base query arguments
            $query_args = array(
                'fields' => 'ids',
                'post_type' => 'shop_order',
                //			'post_status' => 'publish',
                'post_status' => array_keys(wc_get_order_statuses())
            );
        } else {
            // set base query arguments
            $query_args = array(
                'fields' => 'ids',
                'post_type' => 'shop_order',
                'post_status' => 'publish',
            );
        }

        // add status argument
        if (!empty($args['status'])) {

            $statuses = explode(',', $args['status']);

            $query_args['tax_query'] = array(
                array(
                    'taxonomy' => 'shop_order_status',
                    'field' => 'slug',
                    'terms' => $statuses,
                ),
            );

            unset($args['status']);
        }

        $query_args = $this->merge_query_args($query_args, $args);

        return new WP_Query($query_args);
    }

}
