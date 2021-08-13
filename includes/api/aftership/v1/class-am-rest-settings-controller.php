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
		 * @param  WP_REST_Request $request Request object.
		 * @return array
		 */
		public function get_settings( WP_REST_Request $request ) {
			$settings            = get_option( $this->option_name );
			$settings['version'] = AFTERSHIP_VERSION;
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
			$options            = get_option( $this->option_name );
			$options['version'] = AFTERSHIP_VERSION;

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
			if ( isset( $data['connected'] ) && in_array( $data['connected'], array( true, false ), true ) ) {
				$options['connected'] = $data['connected'];
			}

			if ( isset( $data['use_track_button'] ) && in_array( $data['use_track_button'], array( true, false ), true ) ) {
				if ( '' === $this->seek_option_value( $options, 'use_track_button' ) ) {
					$options['use_track_button'] = $data['use_track_button'];
				}
			}
			update_option( $this->option_name, $options );
			return array( 'settings' => $options );
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
