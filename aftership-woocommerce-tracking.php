<?php
/**
 * Plugin Name: AfterShip Tracking - All-In-One WooCommerce Order Tracking (Free plan available)
 * Plugin URI: http://aftership.com/
 * Description: Track orders in one place. shipment tracking, automated notifications, order lookup, branded tracking page, delivery day prediction
 * Version: 1.16.6
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

define( 'AFTERSHIP_VERSION', '1.16.6' );
define( 'AFTERSHIP_PATH', dirname( __FILE__ ) );
define( 'AFTERSHIP_ASSETS_URL', plugins_url() . '/' . basename( AFTERSHIP_PATH ) );

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
			 * Instance of AfterShip_Import_Csv.
			 *
			 * @var AfterShip_Import_Csv
			 */
			public $import_csv;

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

				$this->options           = get_option( 'aftership_option_name' ) ? get_option( 'aftership_option_name' ) : array();
				$this->couriers          = json_decode( file_get_contents( $this->plugin_dir . '/assets/js/couriers.json' ), true );
				$this->selected_couriers = $this->get_selected_couriers();
				$this->use_track_button  = isset( $this->options['use_track_button'] ) ? $this->options['use_track_button'] : $this->use_track_button;
				$this->custom_domain     = isset( $this->options['custom_domain'] ) ? $this->options['custom_domain'] : $this->custom_domain;

				// Include required files.
				$this->includes();

				// Check if woocommerce active.
				if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true ) ) {
					add_filter( 'woocommerce_rest_api_get_rest_namespaces', array( $this, 'add_rest_api' ) );
				}

				add_action( 'admin_print_styles', array( $this->actions, 'admin_styles' ) );
				add_action( 'admin_enqueue_scripts', array( $this->actions, 'load_orders_page_script' ) );
				add_action( 'admin_enqueue_scripts', array( $this, 'automizely_aftership_add_admin_css' ) );
				// Remove other plugins notice message for setting and landing page
				add_action( 'admin_enqueue_scripts', array( $this, 'as_admin_remove_notice_style' ) );

				add_action( 'add_meta_boxes', array( $this->actions, 'add_meta_box' ) );
				add_action( 'woocommerce_process_shop_order_meta', array( $this->actions, 'save_meta_box' ), 0, 2 );
				// register admin pages for the plugin
				add_action( 'admin_menu', array( $this, 'automizely_aftership_admin_menu' ) );
				add_action( 'admin_menu', array( $this, 'automizely_aftership_connect_page' ) );
				add_action( 'plugins_loaded', array( $this->actions, 'load_plugin_textdomain' ) );
				/**
				 * Admin Initialization calls registration
				 * We need this to send user to plugin's Admin page on activation
				 */
				add_action( 'admin_init', array( $this, 'automizely_aftership_plugin_active' ) );
				add_action( 'admin_footer', array( $this, 'deactivate_modal' ) );

				// View Order Page.
				add_action( 'woocommerce_view_order', array( $this->actions, 'display_tracking_info' ) );
				add_action( 'woocommerce_email_before_order_table', array( $this->actions, 'email_display' ), 0, 4 );

				// Order page metabox actions.
				add_action( 'wp_ajax_aftership_get_item', array( $this->actions, 'get_meta_box_item_ajax' ) );
				add_action( 'wp_ajax_aftership_delete_item', array( $this->actions, 'meta_box_delete_tracking' ) );
				add_action( 'wp_ajax_aftership_save_form', array( $this->actions, 'save_meta_box_ajax' ) );
				add_action( 'wp_ajax_aftership_get_items', array( $this->actions, 'get_meta_box_items_ajax' ) );

				add_action( 'wp_ajax_aftership_delete_order_tracking', array( $this->actions, 'delete_order_tracking' ) );
				add_action( 'wp_ajax_aftership_save_order_tracking', array( $this->actions, 'save_order_tracking' ) );
				add_action( 'wp_ajax_aftership_get_order_trackings', array( $this->actions, 'get_order_detail' ) );
				add_action( 'wp_ajax_aftership_get_settings', array( $this->actions, 'get_settings' ) );

				// Register Add Tracking Action for AfterShip
				add_filter( 'woocommerce_admin_order_actions', array( $this->actions, 'add_aftership_tracking_actions_button' ), 100, 2 );
				// Custom AfterShip Tracking column in admin orders list.
				add_filter( 'manage_shop_order_posts_columns', array( $this->actions, 'shop_order_columns' ), 99 );
				add_action( 'manage_shop_order_posts_custom_column', array( $this->actions, 'render_shop_order_columns' ) );

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
				add_action( 'admin_notices', array( $this->actions, 'show_notices' ) );

				// Add support for woocommerce-shipstation
				if ( in_array( 'woocommerce-shipstation-integration/woocommerce-shipstation.php', (array) get_option( 'active_plugins', array() ) ) ) {
					add_action( 'woocommerce_shipstation_shipnotify', array( $this->actions, 'handle_woocommerce_shipstation_shipnotify' ), 10, 2 );
				}
				// Get tracking number from order notes created by restful api like royalmail.
				add_action( 'woocommerce_rest_insert_order_note', array( $this->actions, 'handle_woocommerce_rest_insert_order_note' ), 10, 2 );

				add_filter( 'rest_shop_order_collection_params', array( $this->actions, 'add_collection_params' ), 10, 1 );
				add_filter( 'rest_shop_coupon_collection_params', array( $this->actions, 'add_collection_params' ), 10, 1 );
				add_filter( 'rest_product_collection_params', array( $this->actions, 'add_collection_params' ), 10, 1 );
				add_filter( 'woocommerce_rest_orders_prepare_object_query', array( $this->actions, 'add_query' ), 10, 2 );
				add_filter( 'woocommerce_rest_product_object_query', array( $this->actions, 'add_query' ), 10, 2 );
				add_filter( 'woocommerce_rest_shop_coupon_object_query', array( $this->actions, 'add_query' ), 10, 2 );
				add_filter( 'woocommerce_rest_customer_query', array( $this->actions, 'add_customer_query' ), 10, 2 );

				register_activation_hook( __FILE__, array( 'AfterShip', 'install' ) );
				register_deactivation_hook( __FILE__, array( 'AfterShip', 'deactivation' ) );
				register_uninstall_hook( __FILE__, array( 'AfterShip', 'deactivation' ) );
				set_transient( 'wc-aftership-plugin' . AFTERSHIP_VERSION, 'alive', 7 * 24 * 3600 );
			}

			/**
			 * Description: Will add the landing page into the Menu System of WordPress
			 * Parameters:  None
			 */
			public function automizely_aftership_admin_menu() {
				add_menu_page(
					'AfterShip Tracking',
					'AfterShip Tracking',
					'manage_options',
					'aftership-setting-admin',
					array( $this, 'aftership_setting_page' ),
					AFTERSHIP_ASSETS_URL . '/assets/images/sidebar-aftership-tracking.svg'
				);
			}

			/**
			 * Description: Will add the landing page into the Menu System of WordPress
			 * Parameters:  None
			 */
			public function automizely_aftership_connect_page() {
				add_menu_page(
					'AfterShip Tracking Connect',
					'AfterShip Tracking Connect',
					'manage_options',
					'automizely-aftership-index',
					array( $this, 'automizely_aftership_index' )
				);
				remove_menu_page( 'automizely-aftership-index' );
			}

			/**
			 * Description: Called via admin_init action in Constructor
			 *              Will redirect to the plugin page if the automizely_aftership_plugin_actived is setup.
			 * Return:      void
			 **/
			function automizely_aftership_plugin_active() {
				if ( get_option( 'automizely_aftership_plugin_actived', false ) ) {
					delete_option( 'automizely_aftership_plugin_actived' );
					exit( wp_redirect( 'admin.php?page=automizely-aftership-index' ) );
				}

				// Set default value for show_orders_actions when upgrade aftership plugin
				call_user_func( array( 'AfterShip_Actions', 'init_aftership_show_orders_actions' ) );
			}

			/**
			 * Description: Will add the backend CSS required for the display of automizely-marketing settings page.
			 * Parameters:  hook | Not used.
			 */
			public function automizely_aftership_add_admin_css() {
				wp_register_style( 'automizely-aftership-admin', plugins_url( 'assets/css/index.css', __FILE__ ), array(), AFTERSHIP_VERSION );
				wp_enqueue_style( 'automizely-aftership-admin' );
				wp_register_style( 'automizely-aftership-admin', plugins_url( 'assets/css/normalize.css', __FILE__ ), array(), AFTERSHIP_VERSION );
				wp_enqueue_style( 'automizely-aftership-admin' );
			}

			/**
			 * Remove other plugins notice message for setting and landing page
			 */
			public function as_admin_remove_notice_style() {
				$page_screen          = get_current_screen()->id;
				$screen_remove_notice = array(
					'toplevel_page_automizely-aftership-index',
					'toplevel_page_aftership-setting-admin',
				);

				if ( current_user_can( 'manage_options' ) && in_array( $page_screen, $screen_remove_notice ) ) {
					echo '<style>.update-nag, .updated, .notice, #wpfooter, .error, .is-dismissible { display: none; }</style>';
				}
			}

			/**
			 * Description:
			 * Parameters:  None
			 */
			public function automizely_aftership_index() {
				if ( isset( $this->options['connected'] ) && $this->options['connected'] === true ) {
					exit( wp_redirect( 'admin.php?page=aftership-setting-admin' ) );
				}
				include_once AFTERSHIP_PATH . '/views/automizely_aftership_on_boarding_view.php';
			}

			/**
			 * Options page callback
			 */
			public function aftership_setting_page() {
				include AFTERSHIP_PATH . '/views/automizely_aftership_setting_view.php';
			}

			public function deactivate_modal() {
				if ( current_user_can( 'manage_options' ) ) {
					global $pagenow;

					if ( 'plugins.php' !== $pagenow ) {
						return;
					}
				}
			}

			/**
			 * Remove settings when plugin deactivation.
			 **/
			public static function deactivation() {
				$legacy_options              = get_option( 'aftership_option_name' ) ? get_option( 'aftership_option_name' ) : array();
				$legacy_options['connected'] = false;
				update_option( 'aftership_option_name', $legacy_options );

				// Revoke AfterShip plugin REST oauth key when user Deactivation | Delete plugin
				call_user_func( array( 'AfterShip_Actions', 'revoke_aftership_key' ) );

				delete_option( 'automizely_aftership_plugin_actived' );
			}

			/**
			 * Register REST API endpoints
			 *
			 * @param array $controllers REST Controllers.
			 * @return array
			 */
			function add_rest_api( $controllers ) {
				$controllers['wc/aftership/v1']['settings'] = 'AM_REST_Settings_Controller';
				return $controllers;
			}

			/**
			 * Add manage_aftership cap for administrator
			 * Add this to allow customers to more finely configure the permissions of the aftership plugin.
			 */
			public static function install() {
				global $wp_roles;

				if ( class_exists( 'WP_Roles' ) ) {
					if ( ! isset( $wp_roles ) ) {
						$wp_roles = new WP_Roles();
					}
				}

				if ( is_object( $wp_roles ) ) {
					$wp_roles->add_cap( 'administrator', 'manage_aftership' );
				}

				add_option( 'automizely_aftership_plugin_actived', true );

				// Set default value for show_orders_actions when active aftership plugin
				call_user_func( array( 'AfterShip_Actions', 'init_aftership_show_orders_actions' ) );
			}


			/**
			 * Get selected couriers
			 *
			 * @return array
			 */
			public function get_selected_couriers() {
				$slugs             = explode( ',', ( isset( $this->options['couriers'] ) ? $this->options['couriers'] : '' ) );
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
				require( $this->plugin_dir . '/includes/class-shipment-tracking-migrator.php' );
				$this->api = new AfterShip_API();
				require_once( $this->plugin_dir . '/includes/class-aftership-settings.php' );
				require_once( $this->plugin_dir . '/includes/api/aftership/v1/class-am-rest-settings-controller.php' );
				// require new files, don't adjust file order
				require_once( $this->plugin_dir . '/includes/define.php' );
				require_once( $this->plugin_dir . '/includes/class-aftership-import-csv.php' );
				$this->import_csv = new AfterShip_Import_Csv($this->actions, $this->couriers);
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
