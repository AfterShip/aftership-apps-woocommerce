<?php

if ( ! class_exists( 'AM_REST_Settings_Controller' ) ) {

	include AFTERSHIP_PATH . '/includes/api/class-am-rest-controller.php';

	/**
	 * Class AM_REST_Settings_Controller
	 */
	class AM_REST_Settings_Controller extends AM_REST_Controller {


		/**
		 * API endpoint always wc/aftership/v1.
		 *
		 * @var string
		 */
		protected $namespace = 'wc/aftership/v1';
		/**
		 * API resource is settings.
		 *
		 * @var string
		 */
		protected $rest_base = 'settings';

		/**
		 * AfterShip option name.
		 *
		 * @var string
		 */
		private $option_name = 'aftership_option_name';

		/**
		 * AM_REST_Settings_Controller constructor.
		 */
		public function __construct() {}

		/**
		 * GET AfterShip Settings
		 *
		 * @return array
		 */
		public function get_settings() {
			$settings                = get_option( $this->option_name );
			$settings['currency']    = get_woocommerce_currency();
			$settings['weight_unit'] = get_option( 'woocommerce_weight_unit' );
			$settings['locale']      = get_locale();
			$settings['version']     = array(
				'wordpress'   => get_bloginfo( 'version' ),
				'woocommerce' => WC()->version,
				'aftership'   => AFTERSHIP_VERSION,
			);
			return array( 'settings' => $settings );
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
		 * Seek option value by key
		 *
		 * @param array  $options Options array.
		 * @param string $key String key.
		 * @return string
		 */
		public function seek_option_value( $options, $key ) {
			return isset( $options[ $key ] ) ? $options[ $key ] : '';
		}

		/**
		 * Create or update settings
		 *
		 * @param  WP_REST_Request $data Request object.
		 * @return array
		 */
		public function create_or_update_settings( WP_REST_Request $data ) {
			$options = get_option( $this->option_name );

			if ( isset( $data['custom_domain'] ) && $data['custom_domain'] ) {
				if ( 'track.aftership.com' === $this->seek_option_value( $options, 'custom_domain' ) || '' === $this->seek_option_value( $options, 'custom_domain' ) ) {
					$options['custom_domain'] = $this->normalize_custom_domain( $data['custom_domain'] );
				}
			}

			if ( isset( $data['couriers'] ) && $data['couriers'] ) {
				if ( '' === $this->seek_option_value( $options, 'couriers' ) ) {
					$options['couriers'] = $data['couriers'];
				}
			}

			if ( isset( $data['shipment_tracking_migrate_interval'] ) ) {
				$options['shipment_tracking_migrate_interval'] = $data['shipment_tracking_migrate_interval'];
			}

			// check for import csv, value: 1 or -1
			if ( isset( $data['enable_import_tracking'] ) && $data['enable_import_tracking'] ) {
				$options['enable_import_tracking'] = $data['enable_import_tracking'];
			}

            if ( isset( $data['enable_fulfillment_tracking'] ) && $data['enable_fulfillment_tracking'] ) {
                $options['enable_fulfillment_tracking'] = $data['enable_fulfillment_tracking'];
            }

			// save notes to meta, value: 1 or -1
			if ( isset( $data['save_notes_to_meta_data'] ) && $data['save_notes_to_meta_data'] ) {
				$options['save_notes_to_meta_data'] = $data['save_notes_to_meta_data'];
			}

			if ( isset( $data['show_orders_actions'] ) && $data['show_orders_actions'] ) {
				if ( '' === $this->seek_option_value( $options, 'show_orders_actions' ) ) {
					$options['show_orders_actions'] = $data['show_orders_actions'];
				}
			}

			if ( isset( $data['connected'] ) && in_array( $data['connected'], array( true, false ), true ) ) {
				$options['connected'] = $data['connected'];
			}

			if ( isset( $data['use_track_button'] ) && in_array( $data['use_track_button'], array( true, false ), true ) ) {
				if ( '' === $this->seek_option_value( $options, 'use_track_button' ) ) {
					$options['use_track_button'] = $data['use_track_button'];
				}
			}
			update_option( $this->option_name, $options );
			return $this->get_settings();
		}

		/**
		 * Register router.
		 */
		public function register_routes() {
			register_rest_route(
				$this->namespace,
				'/' . $this->rest_base,
				array(
					array(
						'methods'             => WP_REST_Server::READABLE,
						'callback'            => array( $this, 'get_settings' ),
						'permission_callback' => array( $this, 'get_items_permissions_check' ),
						'args'                => array(),
					),
					array(
						'methods'             => WP_REST_Server::CREATABLE,
						'callback'            => array( $this, 'create_or_update_settings' ),
						'permission_callback' => array( $this, 'create_item_permissions_check' ),
						'args'                => array(),
					),
				)
			);
		}
	}
}
