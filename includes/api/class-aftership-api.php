<?php
/**
 * AfterShip API
 *
 * Handles AfterShip-API endpoint requests
 *
 * @author      AfterShip
 * @category    API
 * @package     AfterShip
 * @since       1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

define( 'AFTERSHIP_LATEST_API_VERSION', 'v5' );

class AfterShip_API {


	/** This is the major version for the REST API and takes
	 * first-order position in endpoint URLs
	 */
	const VERSION = 1;

	/** @var WC_API_Server the REST API server */
	public $server;

	/**
	 * Setup class
	 *
	 * @access public
	 * @since 2.0
	 */
	public function __construct() {
		if ( ! WP_DEBUG ) {
			error_reporting( 0 );
		}

		// add query vars.
		add_filter( 'query_vars', array( $this, 'add_query_vars' ), 0 );

		// register API endpoints.
		add_action( 'init', array( $this, 'add_endpoint' ), 0 );

		// handle REST/legacy API request.
		add_action( 'parse_request', array( $this, 'handle_api_requests' ), 0 );
	}

	/**
	 * add_query_vars function.
	 *
	 * @access public
	 * @since 2.0
	 * @param $vars
	 * @return array
	 */
	public function add_query_vars( $vars ) {
		$vars[] = 'aftership-api';
		$vars[] = 'aftership-api-route';
		return $vars;
	}

	/**
	 * add_endpoint function.
	 *
	 * @access public
	 * @since 2.0
	 * @return void
	 */
	public function add_endpoint() {
		// REST API
		add_rewrite_rule( '^aftership-api\/v' . self::VERSION . '/?$', 'index.php?aftership-api-route=/', 'top' );
		add_rewrite_rule( '^aftership-api\/v' . self::VERSION . '(.*)?', 'index.php?aftership-api-route=$matches[1]', 'top' );

		// legacy API for payment gateway IPNs
		add_rewrite_endpoint( 'aftership-api', EP_ALL );
	}


	/**
	 * API request - Trigger any API requests
	 *
	 * @access public
	 * @since 2.0
	 * @return void
	 */
	public function handle_api_requests() {
		 global $wp;

		if ( ! empty( $_GET['aftership-api'] ) ) {
			$wp->query_vars['aftership-api'] = $_GET['aftership-api'];
		}

		if ( ! empty( $_GET['aftership-api-route'] ) ) {
			$wp->query_vars['aftership-api-route'] = $_GET['aftership-api-route'];
		}

		// REST API request
		if ( ! empty( $wp->query_vars['aftership-api-route'] ) ) {

			define( 'AFTERSHIP_API_REQUEST', true );

			// load required files
			$this->includes();

			$this->server = new AfterShip_API_Server( $wp->query_vars['aftership-api-route'] );

			// load API resource classes
			$this->register_resources( $this->server );

			// Fire off the request
			$this->server->serve_request();

			exit;
		}

		// legacy API requests
		if ( ! empty( $wp->query_vars['aftership-api'] ) ) {

			// Buffer, we won't want any output here
			ob_start();

			// Get API trigger
			$api = strtolower( esc_attr( $wp->query_vars['aftership-api'] ) );

			// Load class if exists
			if ( class_exists( $api ) ) {
				$api_class = new $api();
			}

			// Trigger actions
			do_action( 'woocommerce_api_' . $api );

			// Done, clear buffer and exit
			ob_end_clean();
			die( '1' );
		}
	}


	/**
	 * Include required files for REST API request
	 *
	 * @since 2.1
	 */
	private function includes() {
		// API server / response handlers.
		include_once( 'class-aftership-api-server.php' );
		include_once( 'interface-aftership-api-handler.php' );
		include_once( 'class-aftership-api-json-handler.php' );
		include_once( 'class-aftership-api-common-json-handler.php' );

		// authentication.
		include_once( 'class-aftership-api-authentication.php' );
		$this->authentication = new AfterShip_API_Authentication();

		include_once( 'class-aftership-api-resource.php' );

		// self api.
		include_once( 'class-aftership-api-orders.php' );
		include_once( 'v3/class-aftership-api-orders.php' );
		include_once( 'v4/class-aftership-api-orders.php' );
		include_once( 'v4/class-aftership-api-settings.php' );
		include_once( 'v5/class-aftership-api-orders.php' );
		include_once( 'v5/class-rest-orders-helper.php' );
		include_once( 'v5/class-aftership-api-settings.php' );

	}

	/**
	 * Register available API resources
	 *
	 * @since 2.1
	 * @param object $server the REST server.
	 */
	public function register_resources( $server ) {

		$api_classes = apply_filters(
			'aftership_api_classes',
			array(
				'AfterShip_API_Orders',
				'AfterShip_API_V3_Orders',
				'AfterShip_API_V4_Orders',
				'AfterShip_API_V4_Settings',
				'AfterShip_API_V5_Orders',
				'AfterShip_API_V5_Settings',
			)
		);

		foreach ( $api_classes as $api_class ) {
			$this->$api_class = new $api_class( $server );
		}
	}

}
