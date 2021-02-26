<?php
/*
	Plugin Name: Ecommerce Order Tracking and Shipment Notifications - AfterShip
	Plugin URI: http://aftership.com/
	Description: Effortless order tracking synced from all shipping providers for your ecommerce customers. Include a branded tracking page and automated delivery notifications.
	Version: 1.10.5
	Author: AfterShip
	Author URI: http://aftership.com

	Copyright: © AfterShip
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Required functions
 */

require_once( 'woo-includes/woo-functions.php' );

define( 'AFTERSHIP_VERSION', '1.10.5' );

if ( is_woocommerce_active() ) {

	/**
	 * AfterShip class
	 */
	if ( ! class_exists( 'AfterShip' ) ) {

		/**
		 * Plugin's main class.
		 */
		class AfterShip {


			/**
			 * Instance of AfterShip_Actions.
			 *
			 * @var AfterShip_Actions
			 */
			public $actions;

			/**
			 * Instance of AfterShip_API.
			 *
			 * @var AfterShip_API
			 */
			public $api;

			/**
			 * Plugin file.
			 *
			 * @var string
			 */
			public $plugin_file;

			/**
			 * Plugin dir.
			 *
			 * @var string
			 */
			public $plugin_dir;

			/**
			 * Plugin URL.
			 *
			 * @var string
			 */
			public $plugin_url;


			/**
			 * Setting options
			 *
			 * @var array
			 */
			public $options = array();


			/**
			 * Couriers
			 *
			 * @var array
			 */
			public $couriers = array();

			/**
			 * Can change it on setting page
			 *
			 * @var bool
			 */
			public $use_track_button = false;


			/**
			 * Can change it on setting page
			 *
			 * @var bool
			 */
			public $custom_domain = 'track.aftership.com';


			/**
			 * Selected couriers
			 *
			 * @var array
			 */
			public $selected_couriers = array();

			/**
			 * Constructor
			 */
			public function __construct() {
				$this->plugin_file = __FILE__;
				$this->plugin_dir  = untrailingslashit( plugin_dir_path( __FILE__ ) );
				$this->plugin_url  = untrailingslashit( plugin_dir_url( __FILE__ ) );

				$this->options           = get_option( 'aftership_option_name' );
				$this->couriers          = json_decode( file_get_contents( $this->plugin_url . '/assets/js/couriers.json' ), true );
				$this->selected_couriers = $this->get_selected_couriers();
				$this->use_track_button  = $this->options['use_track_button'];
				$this->custom_domain     = $this->options['custom_domain'] ? $this->options['custom_domain'] : $this->custom_domain;

				// Include required files.
				$this->includes();

				add_action( 'admin_print_styles', array( $this->actions, 'admin_styles' ) );
				add_action( 'add_meta_boxes', array( $this->actions, 'add_meta_box' ) );
				add_action( 'woocommerce_process_shop_order_meta', array( $this->actions, 'save_meta_box' ), 0, 2 );
				add_action( 'plugins_loaded', array( $this->actions, 'load_plugin_textdomain' ) );

				// View Order Page.
				add_action( 'woocommerce_view_order', array( $this->actions, 'display_tracking_info' ) );
				add_action( 'woocommerce_email_before_order_table', array( $this->actions, 'email_display' ), 0, 4 );

				// Order page metabox actions.
				add_action( 'wp_ajax_aftership_delete_item', array( $this->actions, 'meta_box_delete_tracking' ) );
				add_action( 'wp_ajax_aftership_save_form', array( $this->actions, 'save_meta_box_ajax' ) );
				add_action( 'wp_ajax_aftership_get_items', array( $this->actions, 'get_meta_box_items_ajax' ) );

				$subs_version = class_exists( 'WC_Subscriptions' ) && ! empty( WC_Subscriptions::$version ) ? WC_Subscriptions::$version : null;

				// Prevent data being copied to subscriptions.
				if ( null !== $subs_version && version_compare( $subs_version, '2.0.0', '>=' ) ) {
					add_filter( 'wcs_renewal_order_meta_query', array( $this->actions, 'woocommerce_subscriptions_renewal_order_meta_query' ), 10, 4 );
				} else {
					add_filter( 'woocommerce_subscriptions_renewal_order_meta_query', array( $this->actions, 'woocommerce_subscriptions_renewal_order_meta_query' ), 10, 4 );
				}

				// Check for updates.
				add_action( 'init', array( 'AfterShip_Updates', 'check_updates' ) );

				// Add api key config on user profile
				add_action( 'show_user_profile', array( $this->actions, 'add_api_key_field' ) );
				add_action( 'edit_user_profile', array( $this->actions, 'add_api_key_field' ) );
				add_action( 'personal_options_update', array( $this->actions, 'generate_api_key' ) );
				add_action( 'edit_user_profile_update', array( $this->actions, 'generate_api_key' ) );
			}


			/**
			 * Get selected couriers
			 *
			 * @return array
			 */
			public function get_selected_couriers() {
				$slugs             = explode( ',', $this->options['couriers'] );
				$selected_couriers = array();
				foreach ( $this->couriers as $courier ) {
					if ( in_array( $courier['slug'], $slugs ) ) {
						$selected_couriers[] = $courier;
					}
				}
				return $selected_couriers;
			}

			/**
			 * Include required files.
			 *
			 * @since 1.4.0
			 */
			private function includes() {
				require( $this->plugin_dir . '/includes/class-aftership-actions.php' );
				$this->actions = AfterShip_Actions::get_instance();
				require( $this->plugin_dir . '/includes/api/class-aftership-api.php' );
				$this->api = new AfterShip_API();

				require_once( $this->plugin_dir . '/includes/class-aftership-updates.php' );
				require_once( $this->plugin_dir . '/includes/class-aftership-settings.php' );
			}

			/**
			 * Gets the absolute plugin path without a trailing slash, e.g.
			 * /path/to/wp-content/plugins/plugin-directory.
			 *
			 * @return string plugin path
			 */
			public function get_plugin_path() {
				if ( isset( $this->plugin_path ) ) {
					return $this->plugin_path;
				}

				$this->plugin_path = untrailingslashit( plugin_dir_path( __FILE__ ) );

				return $this->plugin_path;
			}
		}

	} // End if().

	/**
	 * Returns an instance of AfterShip.
	 *
	 * @return AfterShip
	 */
	function aftership() {
		static $instance;

		if ( ! isset( $instance ) ) {
			$instance = new AfterShip();
		}

		return $instance;
	}

	/**
	 * Register this class globally.
	 *
	 * Backward compatibility.
	 */
	$GLOBALS['AfterShip'] = aftership();

	/**
	 * Adds a tracking number to an order.
	 *
	 * @param int    $order_id The order id of the order you want to
	 *                                        attach this tracking number to.
	 * @param string $tracking_number The tracking number.
	 * @param string $slug The tracking provider. If you use one
	 *                                     from `AfterShip_Actions::get_providers()`,
	 *                                     the tracking url will be taken case of.
	 * @param string $account_number
	 * @param string $key
	 * @param string $postal_code
	 * @param string $ship_date
	 * @param string $destination_country
	 * @param string $state
	 */
	function aftership_add_tracking_number( $order_id, $tracking_number, $slug, $account_number = null, $key = null, $postal_code = null, $ship_date = null, $destination_country = null, $state = null ) {
		$actions = AfterShip_Actions::get_instance();
		$args    = array(
			'slug'              => $slug,
			'tracking_number'   => $tracking_number,
			'additional_fields' => array(
				'account_number'      => $account_number,
				'key'                 => $key,
				'postal_code'         => $postal_code,
				'ship_date'           => $ship_date,
				'destination_country' => $destination_country,
				'state'               => $state,
			),
		);

		$actions->add_tracking_item( $order_id, $args );
	}

	/**
	 * Deletes tracking information based on tracking_number relating to an order.
	 *
	 * @param int    $order_id Order ID.
	 * @param string $tracking_number The tracking number to be deleted.
	 * @param bool   $slug You can filter the delete by specifying a
	 *                            slug. This is optional.
	 * @return bool
	 */
	function aftership_delete_tracking_number( $order_id, $tracking_number, $slug = false ) {
		$actions = AfterShip_Actions::get_instance();

		$tracking_items = $actions->get_tracking_items( $order_id );

		if ( count( $tracking_items ) > 0 ) {
			foreach ( $tracking_items as $item ) {
				if ( ! $slug ) {
					if ( $item['tracking_number'] == $tracking_number ) {
						$actions->delete_tracking_item( $order_id, $item['tracking_id'] );
						return true;
					}
				} else {
					if ( $item['tracking_number'] === $tracking_number && ( sanitize_title( $slug ) === $item['slug'] ) ) {
						$actions->delete_tracking_item( $order_id, $item['tracking_id'] );
						return true;
					}
				}
			}
		}
		return false;
	}
} // End if().
