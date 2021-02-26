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

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class AfterShip_API_V3_Orders extends AfterShip_API_Resource {


	/** @var string $base the route base */
	protected $base = '/v3/orders';

	/**
	 * Register the routes for this class
	 *
	 * GET /orders
	 *
	 * @param array $routes
	 *
	 * @return array
	 * @since 2.1
	 */
	public function register_routes( $routes ) {
		// GET /orders/ping
		$routes[ $this->base . '/ping' ] = array(
			array( array( $this, 'ping' ), AfterShip_API_Server::READABLE ),
		);

		// GET /orders
		$routes[ $this->base ] = array(
			array( array( $this, 'get_orders' ), AfterShip_API_Server::READABLE ),
		);

		// GET /orders/:id
		$routes[ $this->base . '/(?P<id>[\d]+)' ] = array(
			array( array( $this, 'get_order' ), AfterShip_API_Server::READABLE ),
		);

		return $routes;
	}

	/**
	 * heath checkendpoint for WordPress url validation
	 *
	 * @return string
	 * @since 2.1
	 */
	public function ping() {
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
	 */
	public function get_orders( $fields = null, $filter = array(), $status = null, $page = 1 ) {
		if ( ! empty( $status ) ) {
			$filter['status'] = $status;
		}

		$filter['page'] = $page;

		$query = $this->query_orders( $filter );

		// define pagination
		$pagination = array(
			'page'  => $query->query['paged'],
			'limit' => intval( $query->query['posts_per_page'] ),
			'total' => intval( $query->found_posts ),
		);

		$orders = array();
		foreach ( $query->posts as $order_id ) {
			if ( ! $this->is_readable( $order_id ) ) {
				continue;
			}
			$orders[] = current( $this->get_order( $order_id, $fields ) );
		}

		return array(
			'orders'     => $orders,
			'pagination' => $pagination,
		);
	}

	/**
	 * get single order by id
	 *
	 * @param $id
	 * @return array|int|WP_Error
	 * @throws Exception
	 */
	public function get_order( $id, $fields = null ) {
		$weight_unit = get_option( 'woocommerce_weight_unit' );
		$dp          = wc_get_price_decimals();
		// ensure order ID is valid & user has permission to read
		$id = $this->validate_request( $id, 'shop_order', 'read' );
		if ( is_wp_error( $id ) ) {
			return $id;
		}
		$order                   = new WC_Order( $id );
		$customer                = new WC_Customer( $order->get_customer_id() );
		$current_shipping_method = current( $order->get_shipping_methods() );
		$shipping_method         = null;
		if ( $current_shipping_method['method_id'] && $current_shipping_method['name'] ) {
			$shipping_method = array(
				'code' => $current_shipping_method['method_id'],
				'name' => $current_shipping_method['name'],
			);
		}
		$order_data = array(
			'id'               => (string) $order->get_id(),
			'order_number'     => (string) $order->get_order_number(),
			'order_name'       => '#' . (string) $order->get_order_number(),
			'taxes_included'   => ( $order->get_total_tax() > 0 ),
			'shipping_method'  => $shipping_method,
			'order_total'      => array(
				'currency' => $order->get_currency(),
				'amount'   => (float) wc_format_decimal( $order->get_total(), 2 ),
			),
			'note'             => $order->get_customer_note(),
			'locale'           => get_locale(),
			'metrics'          => array(
				'placed_at'                     => $this->server->format_datetime( $order->get_date_created()->getTimestamp() ),
				'updated_at'                    => $this->server->format_datetime( $order->get_date_modified()->getTimestamp() ),
				'fully_shipped_at'              => null,
				'expected_earliest_delivery_at' => null,
				'expected_last_delivery_at'     => null,
			),
			'customer'         => array(
				'id'         => (string) $order->get_customer_id(),
				'first_name' => $customer->get_first_name(),
				'last_name'  => $customer->get_last_name(),
				'emails'     => ( $customer->get_email() ) ? array( $customer->get_email() ) : array(),
				'phones'     => ( $customer->get_billing_phone() ) ? array(
					array(
						'country_code' => null,
						'number'       => $customer->get_billing_phone(),
					),
				) : array(),
			),
			'shipping_address' => array(
				'first_name'     => $order->get_shipping_first_name(),
				'last_name'      => $order->get_shipping_last_name(),
				'company'        => $order->get_shipping_company(),
				'address_line_1' => $order->get_shipping_address_1(),
				'address_line_2' => $order->get_shipping_address_2(),
				'city'           => $order->get_shipping_city(),
				'state'          => $order->get_shipping_state(),
				'country'        => $this->server->convert_country_code( $order->get_shipping_country() ),
				'postal_code'    => $order->get_shipping_postcode(),
				'email'          => $order->get_billing_email(),
				'phone'          => array(
					'country_code' => null,
					'number'       => $order->get_billing_phone(),
				),
				'address_type'   => null,
				'tax_number'     => null,
			),
			'billing_address'  => array(
				'first_name'     => $order->get_billing_first_name(),
				'last_name'      => $order->get_billing_last_name(),
				'company'        => $order->get_billing_company(),
				'address_line_1' => $order->get_billing_address_1(),
				'address_line_2' => $order->get_billing_address_2(),
				'city'           => $order->get_billing_city(),
				'state'          => $order->get_billing_state(),
				'postal_code'    => $order->get_billing_postcode(),
				'country'        => $this->server->convert_country_code( $order->get_billing_country() ),
				'email'          => $order->get_billing_email(),
				'phone'          => array(
					'country_code' => null,
					'number'       => $order->get_billing_phone(),
				),
				'address_type'   => null,
				'tax_number'     => null,
			),
			'status'           => $order->get_status(),
			'items'            => array(),
			'trackings'        => array(),
		);

		// add line items
		foreach ( $order->get_items() as $item_id => $item ) {
			if ( is_callable( $item, 'get_product' ) ) {
				$product = $item->get_product();
			} else {
				$product = $order->get_product_from_item( $item );
			}

			$product_id       = 0;
			$variation_id     = 0;
			$product_sku      = null;
			$weight           = '';
			$product_image_id = 0;

			// Check if the product exists.
			if ( is_object( $product ) ) {
				$product_id       = $item->get_product_id();
				$variation_id     = $item->get_variation_id();
				$product_sku      = $product->get_sku();
				$weight           = $product->get_weight();
				$product_image_id = $product->get_image_id();
			}
			$subtotal = wc_format_decimal( $order->get_line_subtotal( $item, false, false ), $dp );
			$total    = wc_format_decimal( $order->get_line_total( $item, false, false ), $dp );
			// set the response object
			$terms_tags   = get_the_terms( $product_id, 'product_tag' );
			$product_tags = array();
			foreach ( $terms_tags as $termsKey => $termsVal ) {
				$product_tags[] = $termsVal->name;
			}
			$product_categories = array();

			$categories = get_the_terms( $product_id, 'product_cat' );
			foreach ( $categories as $categoriesKey => $categoriesVal ) {
				$product_categories[] = $categoriesVal->name;
			}
			$order_data['items'][] = array(
				'id'                  => (string) $item_id,
				'product_id'          => $product_id ? (string) $product_id : null,
				'variant_id'          => $variation_id ? (string) $variation_id : null,
				'sku'                 => $product_sku,
				'title'               => $item['name'],
				'quantity'            => (int) $item['qty'],
				'returnable_quantity' => (int) ( $item['qty'] - abs( $order->get_qty_refunded_for_item( $item_id ) ) ),
				'unit_weight'         => array(
					'unit'  => $weight_unit,
					'value' => $weight === '' ? null : (float) $weight,
				),
				'unit_price'          => array(
					'currency' => $order->get_currency(),
					'amount'   => round( floatval( $subtotal ) / intval( $item['qty'] ), $dp ),
				),
				'discount'            => array(
					'currency' => $order->get_currency(),
					'amount'   => (float) ( $subtotal - $total ),
				),
				'image_urls'          => $product_image_id && wp_get_attachment_url( $product_image_id ) ? array( wp_get_attachment_url( $product_image_id ) ) : array(),
				'tags'                => $product_tags,
				'categories'          => $product_categories,
			);
		}

		$trackings = array();
		// The function definition will be available after installing the aftership plugin.
		if ( function_exists( 'order_post_meta_getter' ) ) {
			$aftership_tracking_number = order_post_meta_getter( $order, 'aftership_tracking_number' );
			if ( ! empty( $aftership_tracking_number ) ) {
				$trackings[] = array(
					'slug'              => order_post_meta_getter( $order, 'aftership_tracking_provider' ),
					'tracking_number'   => $aftership_tracking_number,
					'additional_fields' => array(
						'account_number'      => order_post_meta_getter( $order, 'aftership_tracking_account' ),
						'key'                 => order_post_meta_getter( $order, 'aftership_tracking_key' ),
						'postal_code'         => order_post_meta_getter( $order, 'aftership_tracking_postal' ),
						'ship_date'           => order_post_meta_getter( $order, 'aftership_tracking_shipdate' ),
						'destination_country' => order_post_meta_getter( $order, 'aftership_tracking_destination_country' ),
						'state'               => null,
						'origin_country'      => null,
					),
				);
			}

			// 兼容 woocommerce 官方的 tracking 插件
			$woocommerce_tracking_arr = order_post_meta_getter( $order, 'wc_shipment_tracking_items' );
			if ( empty( $aftership_tracking_number ) && ! empty( $woocommerce_tracking_arr ) ) {
				foreach ( $woocommerce_tracking_arr as $trackingKey => $trackingVal ) {
					$trackingInfo = $this->getTrackingInfoByShipmentTracking( $trackingVal );
					$trackings[]  = array(
						'slug'              => ! empty( $trackingInfo ) ? $trackingInfo['tracking_provider'] : $trackingVal['tracking_provider'],
						'tracking_number'   => $trackingVal['tracking_number'],
						'additional_fields' => array(
							'account_number'      => null,
							'key'                 => null,
							'postal_code'         => ! empty( $trackingInfo ) ? $trackingInfo['tracking_postal_code'] : null,
							'ship_date'           => null,
							'destination_country' => null,
							'state'               => null,
							'origin_country'      => null,
						),
					);
				}
			}
			$order_data['trackings'] = $trackings;
		}

		return array( 'order' => apply_filters( 'aftership_api_order_response', $order_data, $order, $fields, $this->server ) );
	}

	/**
	 * 从wc ShipmentTracking 插件获取 Postalcode  - postnl
	 *
	 * @param $tracking_items
	 * @return array
	 */
	private function getTrackingInfoByShipmentTracking( $tracking_items ) {
		if ( ! isset( $tracking_items['custom_tracking_link'] ) ) {
			return array();
		}

		// 获取 postnl  Postalcode
		$urlArr = parse_url( stripslashes( $tracking_items['custom_tracking_link'] ) );

		if ( $urlArr === false ) {
			return array();
		}

		if ( ! isset( $urlArr['host'] ) ) {
			return array();
		}

		$hostArr      = explode( '.', $urlArr['host'] );
		$hostArrIndex = count( $hostArr ) - 2;
		if ( empty( $hostArr ) || ! isset( $hostArr[ $hostArrIndex ] ) ) {
			return array();
		}

		if ( $hostArr[ $hostArrIndex ] == 'postnl' ) {
			parse_str( $urlArr['query'], $queryArr );
			if ( ! isset( $queryArr['Postalcode'] ) ) {
				return array();
			}

			return array(
				'tracking_provider'    => 'postnl',
				'tracking_postal_code' => str_replace( ' ', '', $queryArr['Postalcode'] ),
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
	 */
	private function query_orders( $args ) {

		function aftership_wpbo_get_woo_version_number() {
			// If get_plugins() isn't available, require it
			if ( ! function_exists( 'get_plugins' ) ) {
				require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			}

			// Create the plugins folder and file variables
			$plugin_folder = get_plugins( '/' . 'woocommerce' );
			$plugin_file   = 'woocommerce.php';

			// If the plugin version number is set, return it
			if ( isset( $plugin_folder[ $plugin_file ]['Version'] ) ) {
				return $plugin_folder[ $plugin_file ]['Version'];

			} else {
				// Otherwise return null
				return null;
			}
		}

		$woo_version = aftership_wpbo_get_woo_version_number();

		if ( $woo_version >= 2.2 ) {
			// set base query arguments
			$query_args = array(
				'fields'      => 'ids',
				'post_type'   => 'shop_order',
				// 'post_status' => 'publish',
				'post_status' => array_keys( wc_get_order_statuses() ),
			);
		} else {
			// set base query arguments
			$query_args = array(
				'fields'      => 'ids',
				'post_type'   => 'shop_order',
				'post_status' => 'publish',
			);
		}

		// add status argument
		if ( ! empty( $args['status'] ) ) {

			$statuses = explode( ',', $args['status'] );

			$query_args['tax_query'] = array(
				array(
					'taxonomy' => 'shop_order_status',
					'field'    => 'slug',
					'terms'    => $statuses,
				),
			);

			unset( $args['status'] );
		}

		$query_args = $this->merge_query_args( $query_args, $args );

		return new WP_Query( $query_args );
	}

}
