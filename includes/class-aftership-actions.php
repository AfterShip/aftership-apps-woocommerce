<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * AfterShip Actions
 */
class AfterShip_Actions {


	/**
	 * Instance of this class.
	 *
	 * @var object Class Instance
	 */
	private static $instance;

	/**
	 * Get the class instance
	 *
	 * @return AfterShip_Actions
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {

			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Get courier detail by slug
	 *
	 * @param string $slug
	 * @return array
	 */
	public function get_courier_by_slug( $slug ) {
		$courier = array();
		foreach ( $GLOBALS['AfterShip']->couriers as $item ) {
			if ( $item['slug'] == $slug ) {
				$courier = $item;
			}
		}
		return $courier;
	}

	/**
	 * Localisation.
	 */
	public function load_plugin_textdomain() {
		$plugin_file = $GLOBALS['AfterShip']->plugin_file;
		load_plugin_textdomain( 'aftership', false, dirname( plugin_basename( $plugin_file ) ) . '/languages/' );
	}

	/**
	 * Initial order actions for Add Tracking button
	 */
	public static function init_aftership_show_orders_actions() {
		$init_aftership_options = get_option( 'aftership_option_name' ) ? get_option( 'aftership_option_name' ) : array();
		if ( empty( $init_aftership_options['show_orders_actions'] ) ) {
			$init_aftership_options['show_orders_actions'] = 'processing,completed,partial-shipped';
			update_option( 'aftership_option_name', $init_aftership_options );
		}
	}

	/**
	 * Load admin styles.
	 */
	public function admin_styles() {
		$plugin_url = $GLOBALS['AfterShip']->plugin_url;
		wp_enqueue_style( 'aftership_styles', $plugin_url . '/assets/css/admin.css', array(), AFTERSHIP_VERSION );
	}

	/**
	 * Load aftership orders page script.
	 * Comment：
	 *   1. This function is applied on 2 pages
	 *      orders list page: page id = "edit-shop_order"
	 *      order edit page: page id = "shop_order"
	 */
	public function load_orders_page_script( $hook ) {
		if (!in_array($hook, ['edit.php', 'woocommerce_page_wc-orders'])) {
			return;
		}
		// The following code will be executed only when the detect page which the function belongs to
		$page_screen            = get_current_screen()->id;
		$screen_handle_tracking = array(
            'woocommerce_page_wc-orders',
			'edit-shop_order',
			'shop_order',
		);
		if ( ! in_array( $page_screen, $screen_handle_tracking ) ) {
			return;
		}

		woocommerce_wp_hidden_input(
			array(
				'id'    => 'aftership_get_nonce',
				'value' => wp_create_nonce( 'get-tracking-item' ),
			)
		);
		woocommerce_wp_hidden_input(
			array(
				'id'    => 'aftership_delete_nonce',
				'value' => wp_create_nonce( 'delete-tracking-item' ),
			)
		);
		woocommerce_wp_hidden_input(
			array(
				'id'    => 'aftership_create_nonce',
				'value' => wp_create_nonce( 'create-tracking-item' ),
			)
		);
		echo '<aftership-orders-modal></aftership-orders-modal>';

		// 前端灰度
        $plugin_url = $GLOBALS['AfterShip']->plugin_url;
        $version = AfterShip_Fulfillment::get_instance()->frontend_version_controller();
		$src = '';
		switch ($version) {
			case 'v1':
				$src = $plugin_url . '/assets/frontend/dist/orders/index.js';
				break;
			case 'v2':
				$src = $plugin_url . '/assets/frontendv2/dist/orders/index.js';
				break;
		}

		wp_enqueue_script(
			'aftership-orders-page-script',
            $src,
			array( 'wc-admin-order-meta-boxes' ),
			AFTERSHIP_VERSION
		);
	}


	/**
	 * Add the meta box for shipment info on the order page
	 */
	public function add_meta_box() {
		add_meta_box( 'woocommerce-aftership', __( 'AfterShip', 'aftership' ), array( $this, 'meta_box' ), get_order_admin_screen(), 'side', 'high' );
	}

	/**
	 * Returns a HTML node for a tracking item for the admin meta box
	 *
	 * @param $order_id string
	 * @param $item array
	 * @param $index number
	 */
	public function display_html_tracking_item_for_meta_box( $order_id, $item, $index ) {
		$courier = $this->get_courier_by_slug( $item['slug'] );
		$link    = $this->generate_tracking_page_link( $item );
		?>
		<div
			class="tracking-item"
			data-tracking="<?php echo esc_html( $item['tracking_number'] ); ?>"
			data-slug="<?php echo esc_html( $item['slug'] ); ?>"
			id="tracking-item-<?php echo esc_attr( $item['tracking_id'] ); ?>"
		>
			<div class="tracking-item-title">
				<div>Shipment <?php echo esc_html( $index ); ?></div>
				<div>
					<a
						href="#"
						class="edit-tracking"
					rel="<?php echo esc_attr( $item['tracking_id'] ); ?>"
					>
						<?php _e( 'Edit', 'aftership' ); ?>
					</a>
					<a
						href="#" class="delete-tracking"
						rel="<?php echo esc_attr( $item['tracking_id'] ); ?>"
					>
						<?php _e( 'Delete', 'aftership' ); ?>
					</a>
				</div>
			</div>
			<div class="tracking-item-content">
				<div>
					<strong><?php echo esc_html( $courier['name'] ); ?></strong>
				</div>
				<div>
					<a target="_blank" href="<?php echo esc_html( $link ); ?>">
						<?php echo esc_html( $item['tracking_number'] ); ?>
					</a>
				</div>
			</div>

		</div>
		<?php
	}

	/**
	 * Generate tracking page links
	 *
	 * @param $item
	 * @return string
	 */
	public function generate_tracking_page_link( $item ) {
		$custom_domain = str_replace( array( 'https://', 'http://' ), '', $GLOBALS['AfterShip']->custom_domain );
		return sprintf( 'https://%s/%s', $custom_domain,  safeArrayGet($item, 'tracking_number', ''));
	}

	/**
	 * Normalize custom domain.
	 *
	 * @param string $url input url.
	 * @return string
	 */
	public function normalize_custom_domain( $url ) {
		if ( filter_var( $url, FILTER_VALIDATE_URL ) === false ) {
			return $url;

		}
		$domain = parse_url( $url, PHP_URL_HOST );
		return $domain;
	}

	/**
	 * Do some migrate staff
	 */
	public function migrate() {
		// CNT-7928
		$options = get_option( 'aftership_option_name' );
		$domain  = $this->normalize_custom_domain( $options['custom_domain'] );
		if ( $domain != $options['custom_domain'] ) {
			$options['custom_domain'] = $domain;
			update_option( 'aftership_option_name', $options );
		}
	}

	/**
	 * Show the meta box for shipment info on the order page
	 */
	public function meta_box() {
		global $post;

		$this->convert_old_meta_in_order( isset($post->ID) ? $post->ID : 0);

		$this->migrate();

		woocommerce_wp_hidden_input(
			array(
				'id'    => 'aftership_get_nonce',
				'value' => wp_create_nonce( 'get-tracking-item' ),
			)
		);

		woocommerce_wp_hidden_input(
			array(
				'id'    => 'aftership_delete_nonce',
				'value' => wp_create_nonce( 'delete-tracking-item' ),
			)
		);

		woocommerce_wp_hidden_input(
			array(
				'id'    => 'aftership_create_nonce',
				'value' => wp_create_nonce( 'create-tracking-item' ),
			)
		);

		echo '<aftership-meta-box></aftership-meta-box>';

        // 前端灰度
        $plugin_url = $GLOBALS['AfterShip']->plugin_url;
        $version = AfterShip_Fulfillment::get_instance()->frontend_version_controller();
        $src = '';
        switch ($version) {
            case 'v1':
                $src = $plugin_url . '/assets/frontend/dist/metabox/index.js';
                break;
            case 'v2':
                $src = $plugin_url . '/assets/frontendv2/dist/metabox/index.js';
                break;
        }

		wp_enqueue_script( 'aftership-js-tracking-items', $src, array(), AFTERSHIP_VERSION );
	}

	/**
	 * Order Tracking Save
	 *
	 * Function for saving tracking items
	 *
	 * @param $post_id string
	 * @param $post array
	 */
	public function save_meta_box( $post_id, $post ) {
		if ( isset( $_POST['aftership_tracking_number'] ) && strlen( $_POST['aftership_tracking_number'] ) > 0 ) {
			$args = array(
				'slug'              => wc_clean( $_POST['aftership_tracking_slug'] ),
				'tracking_number'   => wc_clean( $_POST['aftership_tracking_number'] ),
				'additional_fields' => array(
					'account_number'      => wc_clean( $_POST['aftership_tracking_account_number'] ),
					'key'                 => wc_clean( $_POST['aftership_tracking_key'] ),
					'postal_code'         => wc_clean( $_POST['aftership_tracking_postal_code'] ),
					'ship_date'           => wc_clean( $_POST['aftership_tracking_ship_date'] ),
					'destination_country' => wc_clean( $_POST['aftership_tracking_destination_country'] ),
					'state'               => wc_clean( $_POST['aftership_tracking_state'] ),
				),
			);

			$this->add_tracking_item( $post_id, $args );
		}
	}

	/**
	 * Order Tracking Get All Order Items AJAX
	 *
	 * Function for getting all tracking items associated with the order
	 */
	public function get_meta_box_items_ajax() {
		check_ajax_referer( 'get-tracking-item', 'security', true );

		$order_id = wc_clean( $_POST['order_id'] );
		// migrate old tracking data
		$this->convert_old_meta_in_order( $order_id );
		$tracking_items = $this->get_tracking_items( $order_id );

		$count = 1;
		foreach ( $tracking_items as $index => $tracking_item ) {
			$this->display_html_tracking_item_for_meta_box( $order_id, $tracking_item, $count );
			$count++;
		}

		die();
	}

	/**
	 * Order Tracking Save AJAX
	 *
	 * Function for saving tracking items via AJAX
	 *
	 * @throws WC_Data_Exception
	 */
	public function save_meta_box_ajax() {
		check_ajax_referer( 'create-tracking-item', 'security', true );

		if ( isset( $_POST['aftership_tracking_number'] ) && strlen( $_POST['aftership_tracking_number'] ) > 0 ) {

			$order_id = wc_clean( $_POST['order_id'] );
			$args     = array(
				'slug'              => wc_clean( $_POST['aftership_tracking_slug'] ),
				'tracking_number'   => wc_clean( $_POST['aftership_tracking_number'] ),
				'additional_fields' => array(
					'account_number'      => wc_clean( $_POST['aftership_tracking_account_number'] ),
					'key'                 => wc_clean( $_POST['aftership_tracking_key'] ),
					'postal_code'         => wc_clean( $_POST['aftership_tracking_postal_code'] ),
					'ship_date'           => wc_clean( $_POST['aftership_tracking_ship_date'] ),
					'destination_country' => wc_clean( $_POST['aftership_tracking_destination_country'] ),
					'state'               => wc_clean( $_POST['aftership_tracking_state'] ),
				),
			);

			$post_tracking_id = wc_clean( $_POST['aftership_tracking_id'] );
			$tracking_id      = md5( "{$args['slug']}-{$args['tracking_number']}" );
			if ( $post_tracking_id && $tracking_id !== $post_tracking_id ) {
				$this->delete_tracking_item( $order_id, $post_tracking_id );
			}
			$tracking_item = $this->add_tracking_item( $order_id, $args );
			$order         = new WC_Order( $order_id );
			$order->set_date_modified( current_time( 'mysql' ) );
			$order->save();
		}

		die();
	}

	/**
	 * Order Tracking Delete
	 *
	 * Function to delete a tracking item
	 *
	 * @throws WC_Data_Exception
	 */
	public function meta_box_delete_tracking() {
		check_ajax_referer( 'delete-tracking-item', 'security', true );

		$order_id    = wc_clean( $_POST['order_id'] );
		$tracking_id = wc_clean( $_POST['tracking_id'] );

		$this->delete_tracking_item( $order_id, $tracking_id );

		$order = new WC_Order( $order_id );
		$order->set_date_modified( current_time( 'mysql' ) );
		$order->save();
	}


	/**
	 * Get single tracking info
	 *
	 * Function to show tracking edit form
	 */
	public function get_meta_box_item_ajax() {
		check_ajax_referer( 'get-tracking-item', 'security', true );

		$order_id                 = wc_clean( $_POST['order_id'] );
		$tracking_id              = wc_clean( $_POST['tracking_id'] );
		$tracking_item            = $this->get_tracking_item( $order_id, $tracking_id );
		$tracking_item['courier'] = $this->get_courier_by_slug( $tracking_item['slug'] );
		header( 'Content-Type: application/json' );
		echo json_encode( $tracking_item, true );
		die();
	}

	/**
	 * Display Shipment info in the frontend (order view/tracking page).
	 *
	 * @param  string $order_id
	 */
	public function display_tracking_info( $order_id ) {
		wc_get_template(
			'myaccount/view-order.php',
			array(
				'tracking_items'   => $this->get_tracking_items_for_display( $order_id ),
				'use_track_button' => $GLOBALS['AfterShip']->use_track_button,
				// tracking button 中的 domain 是不可以带有前面的 https:// 或者 http:// 的
				'domain'           => str_replace( array( 'https://', 'http://' ), '', $GLOBALS['AfterShip']->custom_domain ),
			),
			'aftership-woocommerce-tracking/',
			$GLOBALS['AfterShip']->get_plugin_path() . '/templates/'
		);
	}

	/**
	 * Display shipment info in customer emails.
	 *
	 * @param WC_Order $order Order object.
	 * @param bool     $sent_to_admin Whether the email is being sent to admin or not.
	 * @param bool     $plain_text Whether email is in plain text or not.
	 * @param WC_Email $email Email object.
	 */
	public function email_display( $order, $sent_to_admin, $plain_text = null, $email = null ) {
		/**
		 * Don't include tracking information in refunded email.
		 *
		 * When email instance is `WC_Email_Customer_Refunded_Order`, it may
		 * full or partial refund.
		 */
		if ( is_a( $email, 'WC_Email_Customer_Refunded_Order' ) ) {
			return;
		}

		$order_id = $order->get_id();
		if ( true === $plain_text ) {
			wc_get_template( 'email/plain/tracking-info.php', array( 'tracking_items' => $this->get_tracking_items_for_display( $order_id ) ), 'aftership-woocommerce-tracking/', $GLOBALS['AfterShip']->get_plugin_path() . '/templates/' );
		} else {
			wc_get_template( 'email/tracking-info.php', array( 'tracking_items' => $this->get_tracking_items_for_display( $order_id ) ), 'aftership-woocommerce-tracking/', $GLOBALS['AfterShip']->get_plugin_path() . '/templates/' );
		}
	}

	/**
	 * Prevents data being copied to subscription renewals
	 */
	public function woocommerce_subscriptions_renewal_order_meta_query( $order_meta_query, $original_order_id, $renewal_order_id, $new_order_role ) {
		$order_meta_query .= " AND `meta_key` NOT IN ( '_aftership_tracking_items' )";
		return $order_meta_query;
	}

	/*
	 * Adds a tracking item to the post_meta array, used by Import Tracking
	 *
	 * @param int   $order_id    Order ID
	 * @param array $tracking_items List of tracking item
	 *
	 * @return array Tracking item
	 */
	public function post_order_tracking( $order_id, $args ) {
		$tracking_item                    = array();
		$tracking_item['slug']            = wc_clean( $args['slug'] );
		$tracking_item['tracking_number'] = wc_clean( $args['tracking_number'] );
		$tracking_item['tracking_id']     = md5( "{$tracking_item['slug']}-{$tracking_item['tracking_number']}" );
		// need apply default value
		$tracking_item['additional_fields'] = new stdClass();
		// line items for each tracking
		if ( isset( $args['line_items'] ) && is_array( $args['line_items'] ) && count( $args['line_items'] ) ) {
			$tracking_item['line_items'] = $args['line_items'];
		}

		$tracking_item['metrics'] = array(
			'created_at' => current_time( 'Y-m-d\TH:i:s\Z' ),
			'updated_at' => current_time( 'Y-m-d\TH:i:s\Z' ),
		);
		$tracking_items           = $this->get_tracking_items( $order_id );
		$exist                    = false;
		foreach ( $tracking_items as $key => $item ) {
			if ( $item['tracking_id'] == $tracking_item['tracking_id'] ) {
				$exist = true;
				if ( isset( $item['metrics'] ) && isset( $item['metrics']['created_at'] ) ) {
					$tracking_item['metrics']['created_at'] = $item['metrics']['created_at'];
				}
				$tracking_items[ $key ] = $tracking_item;
			}
		}
		if ( ! $exist ) {
			$tracking_items[] = $tracking_item;
		}

		// check order tracking, fulfill line items quantity <= order line items quantity
		$check_exceed = $this->check_order_fulfill_items( $order_id, $tracking_items, true );
		// If exceed, Skip this item from CSV; means duplicate import
		if ( $check_exceed ) {
			return array();
		}

		$this->save_tracking_items( $order_id, array_values( $tracking_items ) );

		// date_modified update
		$order = new WC_Order( $order_id );
		$order->set_date_modified( current_time( 'mysql' ) );
		$order->save();

		return array_values( $tracking_items );
	}

	/**
	 * Deletes a tracking item from post_meta array
	 *
	 * @param int    $order_id Order ID
	 * @param string $tracking_id Tracking ID
	 *
	 * @return bool True if tracking item is deleted successfully
	 */
	public function delete_tracking_item( $order_id, $tracking_id ) {
		$tracking_items = $this->get_tracking_items( $order_id );

		$is_deleted = false;

		if ( count( $tracking_items ) > 0 ) {
			foreach ( $tracking_items as $key => $item ) {
				if ( $item['tracking_id'] == $tracking_id ) {
					unset( $tracking_items[ $key ] );
					$is_deleted = true;
					break;
				}
			}
			$this->save_tracking_items( $order_id, array_values( $tracking_items ) );
		}

		return $is_deleted;
	}

	/*
	 * Adds a tracking item to the post_meta array, no repeat items
	 *
	 * @param int   $order_id    Order ID
	 * @param array $tracking_items List of tracking item
	 *
	 * @return array Tracking item
	 */
	public function add_tracking_item( $order_id, $args ) {
		$tracking_item                      = array();
		$tracking_item['slug']              = wc_clean( $args['slug'] );
		$tracking_item['tracking_number']   = wc_clean( $args['tracking_number'] );
		$tracking_item['tracking_id']       = md5( "{$tracking_item['slug']}-{$tracking_item['tracking_number']}" );
		$tracking_item['additional_fields'] = array(
			'account_number'      => wc_clean( $args['additional_fields']['account_number'] ),
			'key'                 => wc_clean( $args['additional_fields']['key'] ),
			'postal_code'         => wc_clean( $args['additional_fields']['postal_code'] ),
			'ship_date'           => wc_clean( $args['additional_fields']['ship_date'] ),
			'destination_country' => wc_clean( $args['additional_fields']['destination_country'] ),
			'state'               => wc_clean( $args['additional_fields']['state'] ),
		);
		$tracking_item['metrics']           = array(
			'created_at' => current_time( 'Y-m-d\TH:i:s\Z' ),
			'updated_at' => current_time( 'Y-m-d\TH:i:s\Z' ),
		);
		$tracking_items                     = $this->get_tracking_items( $order_id );
		$exist                              = false;
		foreach ( $tracking_items as $key => $item ) {
			if ( $item['tracking_id'] == $tracking_item['tracking_id'] ) {
				$exist = true;
				if ( isset( $item['metrics'] ) && isset( $item['metrics']['created_at'] ) ) {
					$tracking_item['metrics']['created_at'] = $item['metrics']['created_at'];
				}
				$tracking_items[ $key ] = $tracking_item;
			}
		}
		if ( ! $exist ) {
			$tracking_items[] = $tracking_item;
		}

		$this->save_tracking_items( $order_id, array_values( $tracking_items ) );

		return array_values( $tracking_item );
	}

	/**
	 * Saves the tracking items array to post_meta.
	 *
	 * @param int   $order_id Order ID
	 * @param array $tracking_items List of tracking item
	 */
	public function save_tracking_items( $order_id, $tracking_items ) {
		if ( version_compare( WC_VERSION, '3.0', '<' ) ) {
			update_post_meta( $order_id, '_aftership_tracking_items', $tracking_items );
			update_post_meta( $order_id, '_aftership_tracking_number', $tracking_items[0]['tracking_number'] );
			update_post_meta( $order_id, '_aftership_tracking_provider_name', $tracking_items[0]['slug'] );
		} else {
			$order = new WC_Order( $order_id );
			$order->update_meta_data( '_aftership_tracking_items', $tracking_items );
			// Delete order trackings, $tracking_items may be []
			$order->update_meta_data( '_aftership_tracking_number', isset( $tracking_items[0]['tracking_number'] ) ? $tracking_items[0]['tracking_number'] : '' );
			$order->update_meta_data( '_aftership_tracking_provider_name', isset( $tracking_items[0]['slug'] ) ? $tracking_items[0]['slug'] : '' );
			if ( custom_orders_table_usage_is_enabled() ) {
				$order->save();
			} else {
				$order->save_meta_data();
			}
		}
	}


	/**
	 * Gets a single tracking item from the post_meta array for an order.
	 *
	 * @param int    $order_id Order ID
	 * @param string $tracking_id Tracking ID
	 *
	 * @return null|array Null if not found, otherwise array of tracking item will be returned
	 */
	public function get_tracking_item( $order_id, $tracking_id ) {
		$tracking_items = $this->get_tracking_items( $order_id );

		if ( count( $tracking_items ) ) {
			foreach ( $tracking_items as $item ) {
				if ( $item['tracking_id'] === $tracking_id ) {
					return $item;
				}
			}
		}

		return null;
	}

	/*
	 * Gets all tracking items from the post meta array for an order
	 *
	 * @param int  $order_id  Order ID
	 *
	 * @return array List of tracking items
	 */
	public function get_tracking_items( $order_id ) {

		if ( version_compare( WC_VERSION, '3.0', '<' ) ) {
			$tracking_items = get_post_meta( $order_id, '_aftership_tracking_items', true );
		} else {
			$order          = new WC_Order( $order_id );
			$tracking_items = $order->get_meta( '_aftership_tracking_items', true );
		}

		if ( is_array( $tracking_items ) ) {
			return $tracking_items;
		} else {
			return array();
		}
	}

	/*
	* Gets all tracking items from the post meta array for an order using by restful api
	*
	* @param int  $order_id  Order ID
	*
	* @return array List of tracking items
	*/
	public function get_tracking_items_for_api( $order_id ) {
		// migrate old tracking meta
		$this->convert_old_meta_in_order( $order_id );
		$tracking_items = $this->get_tracking_items( $order_id );
		$order          = new WC_Order( $order_id );
		foreach ( $tracking_items as $key => $tracking_item ) {
			$additional_fields = $tracking_item['additional_fields'];
			if ( isset( $additional_fields['destination_country'] ) ) {
				// Use customer's input first
				if ( $additional_fields['destination_country'] ) {
					$tracking_item['additional_fields']['destination_country'] = convert_country_code( $additional_fields['destination_country'] );
				} else {
					// Use destination_country from shipping address
					$destination_country = $order->get_shipping_country();
					if ( ! $destination_country ) {
						$destination_country = $order->get_billing_country();
					}
					$tracking_item['additional_fields']['destination_country'] = convert_country_code( $destination_country );
				}
			}
			if ( isset( $additional_fields['ship_date'] ) ) {
				if ( $additional_fields['ship_date'] ) {
					$tracking_item['additional_fields']['ship_date'] = date( 'Ymd', strtotime( $tracking_item['additional_fields']['ship_date'] ) );
				}
			}
			$tracking_items[ $key ] = $tracking_item;
		}
		return $tracking_items;
	}

	/**
	 * Convert old meta in a given order ID to new meta structure.
	 *
	 * @param int $order_id Order ID.
	 */
	public function convert_old_meta_in_order( $order_id ) {

		$migrate = get_post_meta( $order_id, '_aftership_migrated', true );
		if ( $migrate === 'ok' ) {
			return;
		}
		update_post_meta( $order_id, '_aftership_migrated', 'ok' );

		$aftership_tracking_provider_name = get_post_meta( $order_id, '_aftership_tracking_provider_name', true );
		$tracking_number                  = get_post_meta( $order_id, '_aftership_tracking_number', true );
		$account_number                   = get_post_meta( $order_id, '_aftership_tracking_account', true );
		$key                              = get_post_meta( $order_id, '_aftership_tracking_key', true );
		$postal_code                      = get_post_meta( $order_id, '_aftership_tracking_postal', true );
		$ship_date                        = get_post_meta( $order_id, '_aftership_tracking_shipdate', true );
		$destination_country              = get_post_meta( $order_id, '_aftership_tracking_destination_country', true );

		if ( ! $tracking_number ) {
			return;
		}

        $tracking_items = $this->get_tracking_items($order_id);
		foreach ($tracking_items as $item) {
			if ($item['tracking_number'] === $tracking_number && $item['slug'] === $aftership_tracking_provider_name) {
				return;
			}
		}

		// 需要判断 _aftership_tracking_provider_name 是否正确，否则 slug 为 空
		$slug = null;
		// 值是正确的slug，直接使用
		if ( in_array( $aftership_tracking_provider_name, array_column( $GLOBALS['AfterShip']->selected_couriers, 'slug' ) ) ) {
			$slug = $aftership_tracking_provider_name;
		}
		// 由于历史版本原因，值可能为courier name，则匹配 name 对应的 slug
		if ( ! $slug ) {
			$couriers_by_name = array();
			foreach ( $GLOBALS['AfterShip']->selected_couriers as $i => $courier ) {
				if ( $courier['name'] === $aftership_tracking_provider_name ) {
					array_push( $couriers_by_name, $courier );
				}
			}
			// 有可能 name 相同的有多条，只有1条时匹配
			if ( count( $couriers_by_name ) === 1 ) {
				$slug = $couriers_by_name[0]['slug'];
			}
		}

		$args = array(
			'slug'              => $slug,
			'tracking_number'   => $tracking_number,
			'additional_fields' => array(
				'account_number'      => $account_number,
				'key'                 => $key,
				'postal_code'         => $postal_code,
				'ship_date'           => $ship_date,
				'destination_country' => $destination_country,
				'state'               => '',
			),
		);

		$this->add_tracking_item( $order_id, $args );
	}

	/*
	* Gets all tracking items from the post meta array for an order
	*
	* @param int  $order_id  Order ID
	*
	* @return array List of tracking items
	*/
	public function get_tracking_items_for_display( $order_id ) {
		$custom_domain          = $GLOBALS['AfterShip']->custom_domain;
		$tracking_items         = $this->get_tracking_items( $order_id );
		$display_tracking_items = array();
		foreach ( $tracking_items as $item ) {
			$display_item                                        = $item;
			$display_item['courier']                             = $this->get_courier_by_slug( $item['slug'] );
			$display_item['custom_domain']                       = $custom_domain;
			$display_item['tracking_number_for_tracking_button'] = $this->get_tracking_number_for_tracking_button( $item );
			$display_tracking_items[]                            = $display_item;
		}
		return $display_tracking_items;
	}

	/**
	 * Map courier required_fields to tracking additional_fields
	 *
	 * @param string $courier_required_field
	 * @return string
	 */
	public function mapping_tracking_additional_fields( $courier_required_field ) {

		$mapping = array(
			'tracking_key'                 => 'key',
			'tracking_account_number'      => 'account_number',
			'tracking_postal_code'         => 'postal_code',
			'tracking_ship_date'           => 'ship_date',
			'tracking_destination_country' => 'destination_country',
			'tracking_state'               => 'state',
		);

		return isset( $mapping[ $courier_required_field ] ) ? $mapping[ $courier_required_field ] : $courier_required_field;
	}


	/**
	 * @param $item array
	 * @param bool       $with_additional_fields
	 * @return string
	 * @todo AfterShip tracking button not support additional_fields yet.
	 */
	public function get_tracking_number_for_tracking_button( $item, $with_additional_fields = false ) {
		$tracking_number = $item['tracking_number'];
		if ( $with_additional_fields ) {
			$tracking_number_with_additional_fields = $tracking_number;
			$courier                                = $this->get_courier_by_slug( $item['slug'] );
			foreach ( $courier['required_fields'] as $field ) {
				$additional_field                        = $this->mapping_tracking_additional_fields( $field );
				$additional_field_value                  = isset( $item['additional_fields'][ $additional_field ] ) ? $item['additional_fields'][ $additional_field ] : '';
				$tracking_number_with_additional_fields .= ':' . $additional_field_value;
			}
			return $tracking_number_with_additional_fields;
		}
		return $tracking_number;
	}

	/**
	 * Add manage_aftership cap for administrator
	 * Add this to allow customers to more finely configure the permissions of the aftership plugin.
	 */
	public function add_permission_cap() {
		global $wp_roles;

		if ( class_exists( 'WP_Roles' ) ) {
			if ( ! isset( $wp_roles ) ) {
				$wp_roles = new WP_Roles();
			}
		}

		if ( is_object( $wp_roles ) ) {
			$wp_roles->add_cap( 'administrator', 'manage_aftership' );
		}
	}

	/**
	 * Display the API key info for a user
	 *
	 * @param WP_User $user
	 */
	public function add_api_key_field( $user ) {

		$this->add_permission_cap();

		if ( ! current_user_can( 'manage_aftership' ) ) {
			return;
		}
		if ( current_user_can( 'edit_user', $user->ID ) ) {
			?>
			<h3>AfterShip</h3>
			<table class="form-table">
				<tbody>
				<tr>
					<th><label
								for="aftership_wp_api_key"><?php _e( 'AfterShip\'s WordPress API Key', 'aftership' ); ?></label>
					</th>
					<td>
						<?php if ( empty( $user->aftership_wp_api_key ) ) : ?>
							<input name="aftership_wp_generate_api_key" type="checkbox"
									id="aftership_wp_generate_api_key" value="0"/>
							<span class="description"><?php _e( 'Generate API Key', 'aftership' ); ?></span>
						<?php else : ?>
							<code id="aftership_wp_api_key"><?php echo $user->aftership_wp_api_key; ?></code>
							<br/>
							<input name="aftership_wp_generate_api_key" type="checkbox"
									id="aftership_wp_generate_api_key" value="0"/>
							<span class="description"><?php _e( 'Revoke API Key', 'aftership' ); ?></span>
						<?php endif; ?>
					</td>
				</tr>
				</tbody>
			</table>
			<?php
		}
	}

	/**
	 * Generate and save (or delete) the API keys for a user
	 *
	 * @param int $user_id
	 */
	public function generate_api_key( $user_id ) {
		if ( current_user_can( 'edit_user', $user_id ) ) {
			$user = get_userdata( $user_id );
			// creating/deleting key
			if ( isset( $_POST['aftership_wp_generate_api_key'] ) ) {
				// consumer key
				if ( empty( $user->aftership_wp_api_key ) ) {
					$api_key = 'ck_' . hash( 'md5', $user->user_login . date( 'U' ) . mt_rand() );
					update_user_meta( $user_id, 'aftership_wp_api_key', $api_key );
				} else {
					delete_user_meta( $user_id, 'aftership_wp_api_key' );
				}
			}
		}
	}

	/**
	 * Add 'modified_after' and 'modified_before' for data query
	 *
	 * @param array           $args
	 * @param WP_REST_Request $request
	 * @return array
	 */
	function add_query( array $args, $request ) {
		$modified_after  = $request->get_param( 'modified_after' );
		$modified_before = $request->get_param( 'modified_before' );
		if ( ! $modified_after || ! $modified_before ) {
			return $args;
		}
		$args['date_query'][] = array(
			'column' => 'post_modified',
			'after'  => $modified_after,
			'before' => $modified_before,
		);
		return $args;
	}

	/**
	 * Add 'modified_after' and 'modified_before' for data query
	 *
	 * @param array           $args
	 * @param WP_REST_Request $request
	 * @return array
	 */
	function add_customer_query( array $args, $request ) {
		$order           = $request->get_param( 'order' );
		$modified_after  = $request->get_param( 'modified_after' );
		$modified_before = $request->get_param( 'modified_before' );
		if ( ! $modified_after || ! $modified_before ) {
			return $args;
		}
		// @notice may overwrite other service's query
		// @notice currently only AfterShip use modified_after & modified_before
		$args['meta_query'] = array(
			'modified' => array(
				'key'     => 'last_update',
				'value'   => array( strtotime( $modified_after ), strtotime( $modified_before ) ),
				'type'    => 'numeric',
				'compare' => 'BETWEEN',
			),
		);
		$args['orderby']    = array(
			'modified' => $order ? $order : 'DESC',
		);
		return $args;
	}

	/**
	 * Add 'modified' to orderby enum
	 *
	 * @param array $params
	 */
	public function add_collection_params( $params ) {
		$enums = $params['orderby']['enum'];
		if ( ! in_array( 'modified', $enums ) ) {
			$params['orderby']['enum'][] = 'modified';
		}
		return $params;
	}

	/**
	 * Revoke AfterShip plugin REST oauth key when user Deactivation | Delete plugin
	 */
	public static function revoke_aftership_key() {
		try {
			global $wpdb;
			// AfterShip Oauth key
			$key_permission         = 'read_write';
			$key_description_prefix = 'AfterShip - API Read/Write';

			$key = $wpdb->get_row(
				$wpdb->prepare(
					"SELECT key_id, user_id, description, permissions, truncated_key, last_access
					FROM {$wpdb->prefix}woocommerce_api_keys
					WHERE permissions = %s
					AND INSTR(description, %s) > 0
					ORDER BY key_id DESC LIMIT 1",
					$key_permission,
					$key_description_prefix
				),
				ARRAY_A
			);

			if ( ! is_null( $key ) && $key['key_id'] ) {
				$wpdb->delete( $wpdb->prefix . 'woocommerce_api_keys', array( 'key_id' => $key['key_id'] ), array( '%d' ) );
			}
		} catch ( Exception $e ) {
			return false;
		}
	}

	/**
	 * Add connection notice if customer not connected
	 */
	public function show_notices() {
		$screen            = get_current_screen()->id;
		$aftership_options = $GLOBALS['AfterShip']->options;

		$pages_with_tip = array(
			'dashboard',
			'update-core',
			'plugins',
			'plugin-install',
			'shop_order',
			'edit-shop_order',
			'woocommerce_page_wc-orders',
		);
		if ( ! in_array( $screen, $pages_with_tip ) ) {
			return;
		}

		$aftership_plugin_is_actived = is_plugin_active( 'aftership-woocommerce-tracking/aftership-woocommerce-tracking.php' );
		$unconnect_aftership         = ! ( isset( $aftership_options['connected'] ) && $aftership_options['connected'] === true );
		?>
		<?php if ( $aftership_plugin_is_actived && $unconnect_aftership ) : ?>
			<div class="updated notice is-dismissible">
				<p>[AfterShip] Connect your Woocommerce store to provide the best post-purchase experience to drive customer loyalty and additional sales. <a href="admin.php?page=automizely-aftership-index"> Let's get started >> </a></p>
			</div>
		<?php endif; ?>

		<?php
	}

	/*
	* Add action button in order list to change order status from completed to delivered
	*/
	public function add_aftership_tracking_actions_button( $actions, $order ) {
		$saved_options = get_option( 'aftership_option_name' ) ? get_option( 'aftership_option_name' ) : array();
		$order_array   = array();

		if ( isset( $saved_options['show_orders_actions'] ) && $saved_options['show_orders_actions'] ) {
			$as_show_orders_actions = explode( ',', $saved_options['show_orders_actions'] );
			foreach ( $as_show_orders_actions as $order_status ) {
				array_push( $order_array, $order_status );
			}
		}

		if ( $order->get_shipping_method() != 'Local pickup' && $order->get_shipping_method() != 'Local Pickup' ) {
			if ( $order->has_status( $order_array ) ) {
				$actions['add_tracking_by_aftership'] = array(
					'url'    => '#order-id-' . $order->get_id(),
					'name'   => 'Add Tracking By AfterShip',
					'action' => 'aftership_add_inline_tracking', // keep "view" class for a clean button CSS
				);
			}
		}

		return $actions;
	}

	/**
	 * Define shipment tracking column in admin orders list.
	 *
	 * @param array $columns Existing columns
	 *
	 * @return array Altered columns
	 */
	public function shop_order_columns( $columns ) {
		$columns['woocommerce-automizely-aftership-tracking'] = 'AfterShip Tracking';
		return $columns;
	}

	/**
	 * Render shipment tracking in custom column.
	 *
	 * @param string $column Current column
	 */
	public function render_shop_order_columns( $column ) {
		global $post;
		if ( 'woocommerce-automizely-aftership-tracking' === $column ) {
			echo wp_kses_post( $this->get_automizely_aftership_tracking_column( $post->ID ) );
		}
	}

	/**
	 * Render AfterShip tracking in custom column on WC Orders page (when using Custom Order Tables).
	 *
	 * @param string    $column_name Identifier for the custom column.
	 * @param \WC_Order $order Current WooCommerce order object.
	 *
	 * @return void
	 * @since 1.8.0
	 */
	public function render_wc_orders_list_columns( $column_name, $order ) {
		if ( 'woocommerce-automizely-aftership-tracking' === $column_name ) {
			echo wp_kses_post( $this->get_automizely_aftership_tracking_column( $order->get_id() ) );
		}
	}

	/**
	 * Get content for shipment tracking column.
	 *
	 * @param int $order_id Order ID
	 *
	 * @return string Column content to render
	 */
    public function get_automizely_aftership_tracking_column( $order_id ) {
        ob_start();

        $tracking_items = [];
        $version = AfterShip_Fulfillment::get_instance()->frontend_version_controller();
        if ( $version === 'v2' ) {
            $fulfilments = AfterShip_Fulfillment::get_instance()->get_fulfillments_by_wc( $order_id );
            foreach ($fulfilments as $fulfilment) {
                if (isset($fulfilment['trackings'])) {
                    $tracking_items = array_merge($tracking_items, $fulfilment['trackings']);
                }
            }
        } else {
            $tracking_items = $this->get_tracking_items( $order_id );
        }

        if ( count( $tracking_items ) > 0 ) {
            echo '<ul class="wcas-tracking-number-list">';
            foreach ( $tracking_items as $tracking_item ) {
                // 根据 slug，匹配显示的 courier name
                $provider_courier = $this->get_courier_by_slug(safeArrayGet($tracking_item, 'slug', ''));
                // 根据规则，生成 tracking link
                $aftership_tracking_link = $this->generate_tracking_page_link( $tracking_item );

                printf(
                    '<li>
                    <div>
                        <b>%s</b>
                    </div>
                    <a href="%s" title="%s" target="_blank" class=ft11>%s</a>
                    <a href="#" class="aftership_inline_tracking_delete" data-tracking-id="%s" data-order-id="%s">
                        <span class="dashicons dashicons-trash"></span>
                    </a>
                </li>',
                    esc_html( safeArrayGet($provider_courier, 'name', safeArrayGet($tracking_item, 'slug', ''))),
                    esc_url( $aftership_tracking_link ),
                    esc_html( safeArrayGet($tracking_item, 'tracking_number', '')),
                    esc_html( safeArrayGet($tracking_item, 'tracking_number', '')),
                    esc_attr( safeArrayGet($tracking_item, 'tracking_id', '')),
                    esc_attr( $order_id )
                );
            }
            echo '</ul>';
        } else {
            echo '–';
        }
        return apply_filters( 'woocommerce_shipment_tracking_get_automizely_aftership_tracking_column', ob_get_clean(), $order_id, $tracking_items );
    }

	/**
	 * Order Tracking Get All Order Items AJAX
	 *
	 * Function for getting all tracking items associated with the order
	 */
	public function get_settings() {
		$this->format_aftership_tracking_output(
			200,
			'success',
			array(
				'couriers'      => $GLOBALS['AfterShip']->selected_couriers,
				'custom_domain' => $GLOBALS['AfterShip']->custom_domain,
			)
		);
	}

	/**
	 * Order Tracking Get All Order Items AJAX
	 *
	 * Function for getting all tracking items associated with the order
	 */
	public function get_order_detail() {
		check_ajax_referer( 'get-tracking-item', 'security', true );

		if ( empty( $_REQUEST['order_id'] ) ) {
			$this->format_aftership_tracking_output( 422, 'missing order_id field' );
		}
		$order_id = wc_clean( $_REQUEST['order_id'] );

		// migrate old tracking data
		$this->convert_old_meta_in_order( $order_id );

		// get order line items
		$order_line_items = $this->get_order_item_data( $order_id );
		// get exist order trackings
		$order_tracking_items = $this->get_tracking_items( $order_id );

		// get some fields form order
		$order = new WC_Order( $order_id );

		$order_trackings = array(
			'line_items' => $order_line_items,
			'trackings'  => $order_tracking_items,
			'number'     => (string) $order->get_order_number(),
		);

		$this->format_aftership_tracking_output( 200, 'success', $order_trackings );
	}

	/**
	 * Order Tracking Save AJAX
	 *
	 * Function for saving tracking items via AJAX
	 */
	public function save_order_tracking() {
		check_ajax_referer( 'create-tracking-item', 'security', true );

		$params          = json_decode( file_get_contents( 'php://input' ), true );
		$order_id        = wc_clean( $params['order_id'] );
		$order_trackings = $params['trackings'];
		// check order trackings fields from front
		$this->check_aftership_tracking_fields( $order_id, $order_trackings );
		// check fulfill item quantity
		$this->check_order_fulfill_items( $order_id, $order_trackings );

		$this->save_tracking_items( $order_id, $order_trackings );
		// date_modified update
		$order = new WC_Order( $order_id );
		$order->set_date_modified( current_time( 'mysql' ) );
		$order->save();

		$this->format_aftership_tracking_output( 200, 'success' );
	}


    private function is_any_fulfillment_from_tracking($fulfillments)
    {
        foreach ($fulfillments as $fulfillment) {
            if ($fulfillment['from_tracking']) {
                return true;
            }
        }
        return false;
    }

	/**
	 * Order Tracking Delete
	 *
	 * Function to delete a tracking item
	 */
	public function delete_order_tracking() {
		check_ajax_referer( 'delete-tracking-item', 'security', true );

		$params      = json_decode( file_get_contents( 'php://input' ), true );
		$order_id    = wc_clean( $params['order_id'] );
		$tracking_id = wc_clean( $params['tracking_id'] );

		if ( empty( $order_id ) || empty( $tracking_id ) ) {
			$this->format_aftership_tracking_output( 422, 'missing required field' );
		}

		$this->delete_tracking_item( $order_id, $tracking_id );

		// date_modified update
		$order = new WC_Order( $order_id );
		$order->set_date_modified( current_time( 'mysql' ) );
		$order->save();

		$this->format_aftership_tracking_output( 200, 'success' );
	}





	/**
	 * Validate required fields
	 */
	private function check_aftership_tracking_fields( $order_id, $trackings ) {
		// check order trackings from front
		if ( empty( $order_id ) || empty( $trackings ) || ! is_array( $trackings ) ) {
			$this->format_aftership_tracking_output( 422, 'missing required field' );
		}

		foreach ( $trackings as $tracking_one ) {
			if ( empty( $tracking_one['tracking_number'] ) || empty( $tracking_one['slug'] ) ) {
				$this->format_aftership_tracking_output( 422, 'missing required field' );
			}
		}
	}



	/**
	 * Check fulfill item quantity
	 */
	private function check_order_fulfill_items( $order_id, $trackings, $only_check = false ) {
		// get order line items
		$order_line_items   = $this->get_order_item_data( $order_id );
		$line_item_quantity = absint( array_sum( array_column( $order_line_items, 'quantity' ) ) );
		$tracking_items     = array_column( $trackings, 'line_items' );

		// line_items 降为二维数组
		$tmp = array();
		foreach ( $tracking_items as $one ) {
			$result = array_merge( $tmp, $one );
			$tmp    = $result;
		}
		$fulfill_items_quantity = absint( array_sum( array_column( $tmp, 'quantity' ) ) );

		if ( $fulfill_items_quantity > $line_item_quantity ) {
			if ( $only_check ) {
				return true;
			}
			$this->format_aftership_tracking_output( 422, 'fulfill item quantity gte order item qiantity' );
		}
	}

	/**
	 * Get order item detail
	 */
	public function get_order_item_data( $order_id ) {
		$order      = wc_get_order( $order_id );
		$line_items = array();
		foreach ( $order->get_items() as  $item_key => $item ) {
			$data           = $item->get_data();
			$format_decimal = array( 'subtotal', 'subtotal_tax', 'total', 'total_tax', 'tax_total', 'shipping_tax_total' );

			// Format decimal values.
			foreach ( $format_decimal as $key ) {
				if ( isset( $data[ $key ] ) ) {
					$data[ $key ] = wc_format_decimal( $data[ $key ], wc_get_price_decimals() );
				}
			}

			// Add SKU and PRICE to products.
			if ( is_callable( array( $item, 'get_product' ) ) ) {
				$data['sku']   = $item->get_product() ? $item->get_product()->get_sku() : null;
				$data['price'] = $item->get_quantity() ? $item->get_total() / $item->get_quantity() : 0;
			}

			// Add parent_name if the product is a variation.
			if ( is_callable( array( $item, 'get_product' ) ) ) {
				$product = $item->get_product();

				if ( is_callable( array( $product, 'get_parent_data' ) ) ) {
					$data['parent_name'] = $product->get_title();
				} else {
					$data['parent_name'] = null;
				}
			}
			$line_items[] = $data;
		}

		return $line_items;
	}

	/**
	 * Format output
	 */
	public function format_aftership_tracking_output( $code, $message, $data = array() ) {
		$response = array(
			'meta' => array(
				'code'    => $code,
				'type'    => $code === 200 ? 'OK' : 'ERROR',
				'message' => $message,
			),
			'data' => $data,
		);
		header( 'Content-Type: application/json' );
		wp_send_json( $response );
		wp_die();
	}

	/**
	 * Handle action from shipstation
	 */
    public function handle_woocommerce_shipstation_shipnotify($order, $tracking) {
		$this->add_tracking_item( $order->get_id(), array( 'tracking_number' => $tracking['tracking_number'] ) );
		$order->set_date_modified( current_time( 'mysql' ) );
		$order->save();
    }

    /*
     * Handle order comment events send by restful api call.
     */
	public function handle_woocommerce_rest_insert_order_note($comment, $request) {
		$order = wc_get_order( (int) $request['order_id'] );
		$tracking = $this->get_tracking_from_note($request['note']);
		if (!$tracking) return;
		$this->add_tracking_item( $order->get_id(), array( 'tracking_number' => $tracking['tracking_number'], 'slug' => $tracking['slug'] ) );
		$order->set_date_modified( current_time( 'mysql' ) );
		$order->save();
		if ($this->save_notes_to_meta_data_enabled()) {
			try {
				$order_id = $request['order_id'];
				$order_notes = $this->get_order_notes($order_id);
				$order = new WC_Order( $order_id );
				$order->update_meta_data( '_aftership_order_notes', $order_notes );
				$order->save_meta_data();
			}catch ( Exception $e) {
				return;
			}
		}
	}

	/*
     * Handle order comment events send by restful api call.
     */
	public function handle_woocommerce_insert_order_note($comment_id, $order) {
		if ($this->save_notes_to_meta_data_enabled()) {
			try {
				$order_id = $order->get_id();
				$order_notes = $this->get_order_notes($order_id);
				$order->update_meta_data( '_aftership_order_notes', $order_notes );
				$order->save_meta_data();
			}catch ( Exception $e) {
				return;
			}
		}
	}

    public function save_notes_to_meta_data_enabled() {
		$options = get_option( 'aftership_option_name' );
		if ( ! $options ) {
			return false;
		}
		$enable = isset( $options['save_notes_to_meta_data'] ) ? $options['save_notes_to_meta_data'] : -1;
		if ( $enable !== 1 ) {
			return false;
		}
        return true;
    }

	/**
	 * Parse tracking from order note.
	 */
	private function get_tracking_from_note ($note) {
		if (!$note) return null;
		$tracking = array(
			'tracking_number' => null,
			'slug' => null
		);
		// set SLUG
		if (strpos($note, "royalmail") !== false || strpos($note, "Royal Mail") !== false) {
			$tracking['slug'] = 'royal-mail';
		}
		// royalmail "Your order has been despatched via Royal Mail Tracked 48 LBT.\n\nYour tracking number is 121212.\n\nYour order can be tracked here: https://www.royalmail.com/portal/rm/track?trackNumber=1121212.";
		if (preg_match('/Your tracking number is (\w+)\./', $note, $matches)) {
			$tracking['tracking_number'] =  $matches[1];
			return $tracking;
		}
		$home = get_home_url();
		if (strpos($home, "99jersey.com") !== false) {
			if (strpos($note, "tracking number") !== false) {
				$html = stripslashes($note);
				$pattern = '/<a[^>]*>(.*?)<\/a>/i';
				preg_match($pattern, $html, $matches);
				if (empty($matches[0])) {
					return null;
				}
				$tracking['tracking_number'] = $matches[0];
				return $tracking;
			}
		}
        return null;
	}

	/**
	 * Get Order Notes
	 *
	 * @param  $order_id string
	 * @return array
	 */
	private function get_order_notes( $order_id ) {
		$args = array(
			'post_id' => $order_id,
			'approve' => 'approve',
			'type'    => 'order_note',
		);

		remove_filter( 'comments_clauses', array( 'WC_Comments', 'exclude_order_comments' ), 10, 1 );
		$notes = get_comments( $args );
		add_filter( 'comments_clauses', array( 'WC_Comments', 'exclude_order_comments' ), 10, 1 );

		$order_notes = array();

		foreach ( $notes as $note ) {
			$order_notes[] = [
				"author" => $note->comment_author,
				"date_created_gmt" => $note->comment_date_gmt,
				"note" => $note->comment_content,
				'customer_note'    => (bool) get_comment_meta( $note->comment_ID, 'is_customer_note', true ),
			];
		}

		return $order_notes;
	}
}
