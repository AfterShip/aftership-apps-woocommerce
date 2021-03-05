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

			self::$instance = new self;
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
	 * Load admin styles.
	 */
	public function admin_styles() {
		$plugin_url = $GLOBALS['AfterShip']->plugin_url;
		wp_enqueue_style( 'aftership_styles', $plugin_url . '/assets/css/admin.css' );
	}

	/**
	 * Add the meta box for shipment info on the order page
	 */
	public function add_meta_box() {
		add_meta_box( 'woocommerce-aftership', __( 'AfterShip', 'aftership' ), array( $this, 'meta_box' ), 'shop_order', 'side', 'high' );
	}

	/**
	 * Returns a HTML node for a tracking item for the admin meta box
	 *
	 * @param $order_id string
	 * @param $item array
	 */
	public function display_html_tracking_item_for_meta_box( $order_id, $item ) {
		$courier = $this->get_courier_by_slug( $item['slug'] );
		$link    = $this->generate_tracking_page_link( $item );
		?>
		<div class="tracking-item" id="tracking-item-<?php echo esc_attr( $item['tracking_id'] ); ?>">
			<p class="tracking-content">
				<strong><?php echo esc_html( $courier['name'] ); ?></strong>
				<br/>
				<em><a target="_blank" href="<?php echo esc_html( $link ); ?>"><?php echo esc_html( $item['tracking_number'] ); ?></a></em>
			</p>
			<p class="meta">
				<a href="#" class="edit-tracking"
				   rel="<?php echo esc_attr( $item['tracking_id'] ); ?>"><?php _e( 'Edit', 'aftership' ); ?></a>
				<a href="#" class="delete-tracking"
				   rel="<?php echo esc_attr( $item['tracking_id'] ); ?>"><?php _e( 'Delete', 'aftership' ); ?></a>
			</p>
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
		$custom_domain  = $GLOBALS['AfterShip']->custom_domain;
		$contains_http  = strpos( $custom_domain, 'http://' );
		$contains_https = strpos( $custom_domain, 'https://' );
		if ( $contains_http !== false || $contains_https !== false ) {
			return $custom_domain . "/${item['slug']}/${item['tracking_number']}";
		}
		return 'https://' . $custom_domain . "/${item['slug']}/${item['tracking_number']}";
	}

	/**
	 * Show the meta box for shipment info on the order page
	 */
	public function meta_box() {
		global $post;

		$tracking_items = $this->get_tracking_items( $post->ID );

		echo '<div id="tracking-items">';

		if ( count( $tracking_items ) > 0 ) {
			foreach ( $tracking_items as $tracking_item ) {
				$this->display_html_tracking_item_for_meta_box( $post->ID, $tracking_item );
			}
		}

		echo '</div>';

		echo '<button class="button button-show-form" type="button">' . __( 'Add Tracking Number', 'aftership' ) . '</button>';
		echo '<div id="aftership-tracking-form">';

		echo '<p class="form-field aftership_tracking_slug_field"><label for="aftership_tracking_slug">' . __( 'Courier:', 'aftership' ) . '</label><br/><select id="aftership_tracking_slug" name="aftership_tracking_slug" class="chosen_select" style="width:100%;">';

		foreach ( $GLOBALS['AfterShip']->selected_couriers as $courier ) {
			echo '<option value="' . esc_attr( sanitize_title( $courier['slug'] ) ) . '">' . esc_html( $courier['name'] ) . '</option>';
		}

		echo '</select></p>';

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

		woocommerce_wp_hidden_input(
			array(
				'id'    => 'aftership_tracking_id',
				'value' => '',
			)
		);

		woocommerce_wp_text_input(
			array(
				'id'          => 'aftership_tracking_number',
				'label'       => __( 'Tracking number:', 'aftership' ),
				'placeholder' => '',
				'description' => '',
				'value'       => '',
			)
		);

		woocommerce_wp_text_input(
			array(
				'id'          => 'aftership_tracking_account_number',
				'label'       => __( 'Account number:', 'aftership' ),
				'placeholder' => '',
				'description' => '',
				'value'       => '',
			)
		);

		woocommerce_wp_text_input(
			array(
				'id'          => 'aftership_tracking_key',
				'label'       => __( 'Account key:', 'aftership' ),
				'placeholder' => '',
				'description' => '',
				'value'       => '',
			)
		);

		woocommerce_wp_text_input(
			array(
				'id'          => 'aftership_tracking_postal_code',
				'label'       => __( 'Postal code:', 'aftership' ),
				'placeholder' => '',
				'description' => '',
				'value'       => '',
			)
		);

		woocommerce_wp_text_input(
			array(
				'id'          => 'aftership_tracking_ship_date',
				'label'       => __( 'Date shipped:', 'aftership' ),
				'placeholder' => date_i18n( __( 'Y-m-d', 'aftership' ), time() ),
				'description' => '',
				'class'       => 'date-picker-field',
				'value'       => date_i18n( __( 'Y-m-d', 'aftership' ), current_time( 'timestamp' ) ),
			)
		);

		woocommerce_wp_text_input(
			array(
				'id'          => 'aftership_tracking_destination_country',
				'label'       => __( 'Ship Destination Country (ISO3):', 'aftership' ),
				'placeholder' => '',
				'description' => '',
				'value'       => '',
			)
		);

		woocommerce_wp_text_input(
			array(
				'id'          => 'aftership_tracking_state',
				'label'       => __( 'Ship State:', 'aftership' ),
				'placeholder' => '',
				'description' => '',
				'value'       => '',
			)
		);

		echo '<button class="button button-primary button-save-form">' . __( 'Save Tracking', 'aftership' ) . '</button>';

		echo '</div>';

		$js = "
            $('p.aftership_tracking_key_field').hide();
            $('p.aftership_tracking_account_number_field').hide();
            $('p.aftership_tracking_postal_code_field').hide();
            $('p.aftership_tracking_ship_date_field').hide();
            $('p.aftership_tracking_destination_country_field').hide();
            $('p.aftership_tracking_state_field').hide();
			jQuery( '#aftership_tracking_slug').change( function() {
			    $('p.aftership_tracking_key_field').hide();
                $('p.aftership_tracking_account_number_field').hide();
                $('p.aftership_tracking_postal_code_field').hide();
                $('p.aftership_tracking_ship_date_field').hide();
                $('p.aftership_tracking_destination_country_field').hide();
                $('p.aftership_tracking_state_field').hide();
                var required_fields_mapping = {
                    tracking_key: 'aftership_tracking_key',
                    tracking_account_number: 'aftership_tracking_account_number',
                    tracking_postal_code: 'aftership_tracking_postal_code',
                    tracking_ship_date: 'aftership_tracking_ship_date',
                    tracking_destination_country: 'aftership_tracking_destination_country',
                    tracking_state: 'aftership_tracking_state',
                };
				var slug  = jQuery( '#aftership_tracking_slug' ).val();
				if (!slug) return;
				var couriers = JSON.parse( decodeURIComponent( '" . rawurlencode( wp_json_encode( $GLOBALS['AfterShip']->selected_couriers ) ) . "' ) );
				var courier = couriers.find(item => item.slug === slug);
				var required_fields = courier.required_fields;
		        for (var field of required_fields) {
                    var field_name = required_fields_mapping[field];
                    $('p.' + field_name + '_field').show();
		        }

			} ).change();";

		if ( function_exists( 'wc_enqueue_js' ) ) {
			wc_enqueue_js( $js );
		} else {
			WC()->add_inline_js( $js );
		}

		wp_enqueue_script( 'aftership-js', $GLOBALS['AfterShip']->plugin_url . '/assets/js/meta-box.js' );

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

		foreach ( $tracking_items as $tracking_item ) {
			$this->display_html_tracking_item_for_meta_box( $order_id, $tracking_item );
		}

		die();
	}

	/**
	 * Order Tracking Save AJAX
	 *
	 * Function for saving tracking items via AJAX
	 *
	 * @todo 需要检测是否有必须字段没有填写
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

			$this->display_html_tracking_item_for_meta_box( $order_id, $tracking_item );
		}

		die();
	}

	/**
	 * Order Tracking Delete
	 *
	 * Function to delete a tracking item
	 */
	public function meta_box_delete_tracking() {
		check_ajax_referer( 'delete-tracking-item', 'security', true );

		$order_id    = wc_clean( $_POST['order_id'] );
		$tracking_id = wc_clean( $_POST['tracking_id'] );

		$this->delete_tracking_item( $order_id, $tracking_id );
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
				'domain'           => $GLOBALS['AfterShip']->custom_domain,
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

		$order_id = is_callable( array( $order, 'get_id' ) ) ? $order->get_id() : $order->id;
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
			$this->save_tracking_items( $order_id, $tracking_items );
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
		$tracking_items                     = $this->get_tracking_items( $order_id );
		$exist                              = false;
		foreach ( $tracking_items as $key => $item ) {
			if ( $item['tracking_id'] == $tracking_item['tracking_id'] ) {
				$exist                  = true;
				$tracking_items[ $key ] = $tracking_item;
			}
		}
		if ( ! $exist ) {
			$tracking_items[] = $tracking_item;
		}

		$this->save_tracking_items( $order_id, $tracking_items );

		return $tracking_item;
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
		} else {
			$order = new WC_Order( $order_id );
			$order->update_meta_data( '_aftership_tracking_items', $tracking_items );
			$order->save_meta_data();
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

		$slug                = get_post_meta( $order_id, '_aftership_tracking_provider_name', true );
		$tracking_number     = get_post_meta( $order_id, '_aftership_tracking_number', true );
		$account_number      = get_post_meta( $order_id, '_aftership_tracking_account', true );
		$key                 = get_post_meta( $order_id, '_aftership_tracking_key', true );
		$postal_code         = get_post_meta( $order_id, '_aftership_tracking_postal', true );
		$ship_date           = get_post_meta( $order_id, '_aftership_tracking_shipdate', true );
		$destination_country = get_post_meta( $order_id, '_aftership_tracking_destination_country', true );

		if ( ! $tracking_number ) {
			return;
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
	 * Display the API key info for a user
	 *
	 * @param WP_User $user
	 */
	public function add_api_key_field( $user ) {
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
}
