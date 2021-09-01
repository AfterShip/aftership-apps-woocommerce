<?php
/**
 * Plugin Name: AfterShip Tracking - All-In-One WooCommerce Order Tracking (Free plan available)
 * Plugin URI: http://aftership.com/
 * Description: Track orders in one place. shipment tracking, automated notifications, order lookup, branded tracking page, delivery day prediction
 * Version: 1.12.15
 * Author: AfterShip
 * Author URI: http://aftership.com
 *
 * Copyright: © AfterShip
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Required functions
 */

require_once( 'woo-includes/woo-functions.php' );

define( 'AFTERSHIP_VERSION', '1.12.15' );

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
				$this->couriers          = json_decode( file_get_contents( $this->plugin_dir . '/assets/js/couriers.json' ), true );
				$this->selected_couriers = $this->get_selected_couriers();
				$this->use_track_button  = isset( $this->options['use_track_button'] ) ? $this->options['use_track_button'] : $this->use_track_button;
				$this->custom_domain     = isset( $this->options['custom_domain'] ) ? $this->options['custom_domain'] : $this->custom_domain;

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
				add_action( 'wp_ajax_aftership_get_item', array( $this->actions, 'get_meta_box_item_ajax' ) );
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

				// Add api key config on user profile.
				add_action( 'show_user_profile', array( $this->actions, 'add_api_key_field' ) );
				add_action( 'edit_user_profile', array( $this->actions, 'add_api_key_field' ) );
				add_action( 'personal_options_update', array( $this->actions, 'generate_api_key' ) );
				add_action( 'edit_user_profile_update', array( $this->actions, 'generate_api_key' ) );

				register_activation_hook( __FILE__, array( $this, 'install' ) );
			}

			/**
			 * Add manage_aftership cap for administrator
			 * Add this to allow customers to more finely configure the permissions of the aftership plugin.
			 */
			public function install() {
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
			 * Get selected couriers
			 *
			 * @return array
			 */
			public function get_selected_couriers() {
				$slugs             = explode( ',', $this->options['couriers'] );
				$selected_couriers = array();
				foreach ( $this->couriers as $courier ) {
					if ( in_array( $courier['slug'], $slugs, true ) ) {
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
} // End if().
