<?php
/**
 * AfterShip API
 *
 * Handles parsing JSON request bodies and generating JSON responses
 *
 * @package     AfterShip/API
 * @since       1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Common JSON Handler.
 */
class AfterShip_API_Common_JSON_Handler implements AfterShip_API_Handler {

	/**
	 * Get the content type for the response
	 *
	 * @return string
	 * @since 2.1
	 */
	public function get_content_type() {
		return 'application/json; charset=' . get_option( 'blog_charset' );
	}

	/**
	 * Parse the raw request body entity
	 *
	 * @param string $body the raw request body.
	 *
	 * @return array|mixed
	 * @since 2.1
	 */
	public function parse_body( $body ) {
		return json_decode( $body, true );
	}

	/**
	 * Generate a JSON response given an array of data
	 *
	 * @param array $data the response data.
	 *
	 * @return string
	 * @since 2.1
	 */
	public function generate_response( $data ) {
		// phpcs:ignore.
		$nonce = isset( $_GET['undefined_nonce'] ) ? wc_clean( wp_unslash( $_GET['undefined_nonce'] ) ) : null;
		// phpcs:ignore.
		$verify = wp_verify_nonce( $nonce );
		if ( isset( $_GET['_jsonp'] ) ) {

			/**
			 *  JSONP enabled by default.
			 *
			 *  @since 2.1
			 */
			if ( ! apply_filters( 'aftership_api_jsonp_enabled', true ) ) {

				WC()->api->server->send_status( 400 );

				$data = array(
					array(
						'code'    => 'aftership_api_jsonp_disabled',
						'message' => __( 'JSONP support is disabled on this site', 'aftership' ),
					),
				);
			}

			// Check for invalid characters (only alphanumeric allowed).
			// phpcs:ignore.
			$jsonp = isset( $_GET['_jsonp'] ) ? wc_clean( wp_unslash( $_GET['_jsonp'] ) ) : '';
			if ( preg_match( '/\W/', $jsonp ) ) {

				WC()->api->server->send_status( 400 );

				$data = array(
					array(
						'code' => 'aftership_api_jsonp_callback_invalid',
						__( 'The JSONP callback function is invalid', 'aftership' ),
					),
				);
			}

			return $jsonp . '(' . wp_json_encode( $data ) . ')';
		}

		$ok = array(
			'meta' => array(
				'code'    => 20000,
				'type'    => 'OK',
				'message' => 'Everything worked as expected',
			),
			'data' => $data,
		);

		if ( isset( $data['errors'] ) ) {
			$error = array(
				'meta' => array(
					'code'    => $this->map_error_code( $data['errors'][0]['code'] ),
					'type'    => $data['errors'][0]['code'],
					'message' => $data['errors'][0]['message'],

				),
				'data' => '{}',
			);
			return wp_json_encode( $error );
		}

		return wp_json_encode( $ok );
	}

	/**
	 * Get error code by error message
	 *
	 * @param string $code_text code text.
	 * @return int
	 */
	private function map_error_code( $code_text ) {
		$code = 40010;
		switch ( $code_text ) {
			case 'aftership_api_disabled':
				$code = 400011;
				break;
			default:
				break;
		}

		return $code;
	}
}
