<?php

if ( ! class_exists( 'AM_REST_Controller' ) ) {

	class AM_REST_Controller extends WP_REST_Controller {

		public function filter_consumer_key( $option ) {
			$script_tag = $option;
			if ( isset( $script_tag['consumer_key'] ) ) {
				unset( $script_tag['consumer_key'] );
			}
			return $script_tag;
		}

		public function get_consumer_key() {
			$consumer_key = $this->get_consumer_key_from_basic_authentication();

			if ( $consumer_key ) {
				return $consumer_key;
			}

			return $this->get_consumer_key_from_oauth_authentication();
		}

		private function get_consumer_key_from_basic_authentication() {
			$consumer_key    = '';
			$consumer_secret = '';

			// If the $_GET parameters are present, use those first.
			if ( ! empty( $_GET['consumer_key'] ) && ! empty( $_GET['consumer_secret'] ) ) { // WPCS: CSRF ok.
				$consumer_key    = $_GET['consumer_key']; // WPCS: CSRF ok, sanitization ok.
				$consumer_secret = $_GET['consumer_secret']; // WPCS: CSRF ok, sanitization ok.
			}

			// If the above is not present, we will do full basic auth.
			if ( ! $consumer_key && ! empty( $_SERVER['PHP_AUTH_USER'] ) && ! empty( $_SERVER['PHP_AUTH_PW'] ) ) {
				$consumer_key    = $_SERVER['PHP_AUTH_USER']; // WPCS: CSRF ok, sanitization ok.
				$consumer_secret = $_SERVER['PHP_AUTH_PW']; // WPCS: CSRF ok, sanitization ok.
			}

			// Stop if don't have any key.
			if ( ! $consumer_key || ! $consumer_secret ) {
				return false;
			}

			return $consumer_key;
		}

		private function get_consumer_key_from_oauth_authentication() {
			$params = array_merge( $_GET, $_POST ); // WPCS: CSRF ok.
			$params = wp_unslash( $params );
			$header = $this->get_authorization_header();

			if ( ! empty( $header ) ) {
				// Trim leading spaces.
				$header        = trim( $header );
				$header_params = $this->parse_header( $header );

				if ( ! empty( $header_params ) ) {
					$params = array_merge( $params, $header_params );
				}
			}

			return isset( $params['oauth_consumer_key'] ) ? $params['oauth_consumer_key'] : null;
		}

		private function get_authorization_header() {
			if ( ! empty( $_SERVER['HTTP_AUTHORIZATION'] ) ) {
				return wp_unslash( $_SERVER['HTTP_AUTHORIZATION'] ); // WPCS: sanitization ok.
			}

			if ( function_exists( 'getallheaders' ) ) {
				$headers = getallheaders();
				// Check for the authoization header case-insensitively.
				foreach ( $headers as $key => $value ) {
					if ( 'authorization' === strtolower( $key ) ) {
						return $value;
					}
				}
			}

			return '';
		}

		private function parse_header( $header ) {
			if ( 'OAuth ' !== substr( $header, 0, 6 ) ) {
				return array();
			}

			// From OAuth PHP library, used under MIT license.
			$params = array();
			if ( preg_match_all( '/(oauth_[a-z_-]*)=(:?"([^"]*)"|([^,]*))/', $header, $matches ) ) {
				foreach ( $matches[1] as $i => $h ) {
					$params[ $h ] = urldecode( empty( $matches[3][ $i ] ) ? $matches[4][ $i ] : $matches[3][ $i ] );
				}
				if ( isset( $params['realm'] ) ) {
					unset( $params['realm'] );
				}
			}

			return $params;
		}

		/**
		 * Check whether a given request has permission to read tax classes.
		 *
		 * @param  WP_REST_Request $request Full details about the request.
		 * @return WP_Error|boolean
		 */
		public function get_items_permissions_check( $request ) {
			if ( ! wc_rest_check_manager_permissions( 'settings', 'read' ) ) {
				return new WP_Error( 'woocommerce_rest_cannot_view', __( 'Sorry, you cannot list resources.', 'woocommerce' ), array( 'status' => rest_authorization_required_code() ) );
			}

			return true;
		}

		/**
		 * Check if a given request has access create tax classes.
		 *
		 * @param WP_REST_Request $request Full details about the request.
		 *
		 * @return bool|WP_Error
		 */
		public function create_item_permissions_check( $request ) {
			if ( ! wc_rest_check_manager_permissions( 'settings', 'create' ) ) {
				return new WP_Error( 'woocommerce_rest_cannot_create', __( 'Sorry, you are not allowed to create resources.', 'woocommerce' ), array( 'status' => rest_authorization_required_code() ) );
			}

			return true;
		}

		/**
		 * Check if a given request has access delete a tax.
		 *
		 * @param WP_REST_Request $request Full details about the request.
		 *
		 * @return bool|WP_Error
		 */
		public function delete_item_permissions_check( $request ) {
			if ( ! wc_rest_check_manager_permissions( 'settings', 'delete' ) ) {
				return new WP_Error( 'woocommerce_rest_cannot_delete', __( 'Sorry, you are not allowed to delete this resource.', 'woocommerce' ), array( 'status' => rest_authorization_required_code() ) );
			}

			return true;
		}
	}
}
