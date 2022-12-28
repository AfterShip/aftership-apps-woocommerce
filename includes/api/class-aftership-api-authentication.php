<?php
/**
 * AfterShip API Authentication Class
 *
 * @package     AfterShip/API
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! function_exists( 'getallheaders' ) ) {
	/**
	 * Get all http headers.
	 *
	 * @return string
	 */
	function getallheaders() {
		$headers = '';
		foreach ( $_SERVER as $name => $value ) {
			if ( substr( $name, 0, 5 ) === 'HTTP_' ) {
				$headers[ str_replace( ' ', '-', ucwords( strtolower( str_replace( '_', ' ', substr( $name, 5 ) ) ) ) ) ] = $value;
			}
		}
		return $headers;
	}
}

/**
 * Authentication Class for API.
 */
class AfterShip_API_Authentication {


	/**
	 * Setup class
	 */
	public function __construct() {
		// to disable authentication, hook into this filter at a later priority and return a valid WP_User.
		add_filter( 'aftership_api_check_authentication', array( $this, 'authenticate' ), 0 );
	}

	/**
	 * Authenticate the request. The authentication method varies based on whether the request was made over SSL or not.
	 *
	 * @since 2.1
	 * @param WP_User $user WordPress user.
	 * @return null|WP_Error|WP_User
	 */
	public function authenticate( $user ) {

		// allow access to the index by default.
		if ( '/' === aftership()->api->server->path ) {
			return new WP_User( 0 );
		}

		try {
			$user = $this->perform_authentication();

		} catch ( Exception $e ) {

			$user = new WP_Error( 'aftership_api_authentication_error', $e->getMessage(), array( 'status' => $e->getCode() ) );
		}

		return $user;
	}

	/**
	 * Perform Authentication.
	 *
	 * @return WP_User
	 * @throws Exception Throw exceptions.
	 */
	private function perform_authentication() {
		$headers = getallheaders();
		$headers = json_decode( wp_json_encode( $headers ), true );

		// it dues to different kind of server configuration.
		$key  = 'AFTERSHIP_WP_KEY';
		$key1 = str_replace( ' ', '-', ucwords( strtolower( str_replace( '_', ' ', $key ) ) ) );
		$key2 = 'AFTERSHIP-WP-KEY';
        // phpcs:ignore.
		$qskey = isset( $_GET['key'] ) ? wc_clean( wp_unslash( $_GET['key'] ) ) : null;

		// get aftership wp key.
		if ( ! empty( $headers[ $key ] ) ) {
			$api_key = $headers[ $key ];
		} elseif ( ! empty( $headers[ $key1 ] ) ) {
			$api_key = $headers[ $key1 ];
		} elseif ( ! empty( $headers[ $key2 ] ) ) {
			$api_key = $headers[ $key2 ];
		} elseif ( ! empty( $qskey ) ) {
			$api_key = $qskey;
		} else {
			throw new Exception( __( 'AfterShip\'s WordPress Key is missing', 'aftership' ), 404 );
		}

		return $this->get_user_by_api_key( $api_key );

	}

	/**
	 * Return the user for the given consumer key
	 *
	 * @since 2.1
	 * @param string $api_key 'aftership_wp_api_key'.
	 * @return WP_User
	 * @throws Exception 'will send an 401 error'.
	 */
	private function get_user_by_api_key( $api_key ) {
		// @see https:// github.com/AfterShip/aftership-apps-woocommerce/pull/115
		add_action(
			'pre_get_users',
			function( $query ) {
				$query->query_vars['role__not_in'] = array();
			},
			999
		);
		$user_query = new WP_User_Query(
			array(
				'meta_key'   => 'aftership_wp_api_key',
				'meta_value' => $api_key,
			)
		);

		$users = $user_query->get_results();

		if ( empty( $users[0] ) ) {
			throw new Exception( __( 'AfterShip\'s WordPress API Key is invalid', 'aftership' ), 401 );
		}

		return $users[0];

	}

}
