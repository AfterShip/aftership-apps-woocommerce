<?php

if ( ! class_exists( 'AfterShip_API_Script_Tags' ) ) {

	include __DIR__ . '/class-am-rest-controller.php';

	class AfterShip_API_Script_Tags extends AM_REST_Controller {


		protected $namespace = 'wc/v3';

		protected $rest_base = 'script_tags';

		private $consumer_key = 'default';

		const TRUST_HOSTS = array(
			'aftership.com',
			'aftership.io',
			'aftership.net',
			'aftership.us',
			'aftershipdemo.com',
			'am-usercontent.com',
			'am-usercontent.us',
			'automizely.com',
			'automizely.dev',
			'automizely.io',
			'automizely.me',
			'automizely.net',
			'automizely.org',
			'automizely.us',
			'automizelydemo.com',
			'automizelydemo.io',
			'postmen.com',
			'postmen.io',
			'returnscenter.com',
			'returnscenter.io',
		);

		protected $allow_display_scope = array( 'all', 'checkout', 'cart' );

		public function __construct() {
			$this->consumer_key = $this->get_consumer_key();
		}

		/**
		 * GET script tags of current app by id
		 *
		 * @param  WP_REST_Request $request
		 * @return array|WP_Error
		 */
		public function get_script_tag( WP_REST_Request $request ) {
			$id      = $request->get_param( 'id' );
			$options = get_option( AFTERSHIP_SCRIPT_TAGS, array() );
			if ( ! array_key_exists( $id, $options ) ) {
				return new WP_Error( 'woocommerce_rest_script_tags_invalid_id', __( 'Invalid script_tags ID.', 'woocommerce' ), array( 'status' => 404 ) );
			}
			$option = $options[ $id ];
			if ( $option['consumer_key'] != $this->consumer_key ) {
				return new WP_Error( 'woocommerce_rest_script_tags_invalid_id', __( 'Invalid script_tags ID.', 'woocommerce' ), array( 'status' => 404 ) );
			}
			return array( 'script_tag' => $this->filter_consumer_key( $option ) );
		}

		/**
		 * GET all script tags of current app
		 *
		 * @param  WP_REST_Request $request
		 * @return array
		 */
		public function get_script_tags( WP_REST_Request $request ) {
			$force       = $request->get_param( 'force' );
			$options     = get_option( AFTERSHIP_SCRIPT_TAGS, array() );
			$script_tags = array();
			foreach ( $options as $id => $item ) {
				if ( ! $force && $item['consumer_key'] != $this->consumer_key ) {
					continue;
				}
				$script_tags[] = $this->filter_consumer_key( $item );
			}
			return array( 'script_tags' => $script_tags );
		}

		/**
		 * Create a script tag record on wp_options
		 *
		 * @param  WP_REST_Request $request
		 * @return array|WP_Error
		 */
		public function create_script_tag( WP_REST_Request $request ) {
			$src           = $request->get_param( 'src' );
			$display_scope = $request->get_param( 'display_scope' );
			$options = get_option( AFTERSHIP_SCRIPT_TAGS, array() );
			if ( count( $options ) >= 10 ) {
				return new WP_Error( 'woocommerce_rest_script_tags_reach_size_limit', __( 'Script tags size reach limit.', 'woocommerce' ), array( 'status' => 400 ) );
			}
			if ( ! $this->is_script_tag_valid( $src ) ) {
				return new WP_Error( 'woocommerce_rest_script_tags_invalid_src', __( 'Script tags src invalid.', 'woocommerce' ), array( 'status' => 400 ) );
			}
			if ( ! $this->is_script_tag_exist( $options, $src ) ) {
				$id            = str_replace( '-', '', wp_generate_uuid4() );
				$date          = current_time( 'Y-m-d\TH:i:s\Z', true );
				$script_fields = array(
					'id'           => $id,
					'src'          => $src,
					'consumer_key' => $this->consumer_key,
					'created_at'   => $date,
					'updated_at'   => $date,
				);

				// Enqueue script on specific page
				if ( ! empty( $display_scope ) ) {
					if ( in_array( $display_scope, $this->allow_display_scope, true ) ) {
						$script_fields['display_scope'] = $display_scope;
					} else {
						return new WP_Error( 'woocommerce_rest_script_tags_invalid_display_scope', __( 'Script tags display_scope invalid.', 'woocommerce' ), array( 'status' => 400 ) );
					}
				}

				$options[ $id ] = $script_fields;
				update_option( AFTERSHIP_SCRIPT_TAGS, $options );
			}
			return array( 'script_tag' => $this->filter_consumer_key( $this->get_option_by_src( $options, $src ) ) );
		}

		/**
		 * Delete a script tags record by id
		 *
		 * @param  WP_REST_Request $request
		 * @return array|WP_Error
		 */
		public function delete_script_tag( WP_REST_Request $request ) {
			$id      = $request->get_param( 'id' );
			$force   = $request->get_param( 'force' );
			$options = get_option( AFTERSHIP_SCRIPT_TAGS, array() );
			if ( ! array_key_exists( $id, $options ) ) {
				return new WP_Error( 'woocommerce_rest_script_tags_invalid_id', __( 'Invalid script_tags ID.', 'woocommerce' ), array( 'status' => 404 ) );
			}
			$option = $options[ $id ];
			if ( $option['consumer_key'] != $this->consumer_key ) {
				if ( ! $force ) {
					return new WP_Error( 'woocommerce_rest_script_tags_invalid_id', __( 'Invalid script_tags ID.', 'woocommerce' ), array( 'status' => 404 ) );
				}
			}
			unset( $options[ $id ] );
			update_option( AFTERSHIP_SCRIPT_TAGS, $options );
			return array( 'script_tag' => $this->filter_consumer_key( $option ) );
		}

		/**
		 * Edit a script tag by ID
		 *
		 * @param  WP_REST_Request $request
		 * @return array|WP_Error
		 */
		public function edit_script_tag( WP_REST_Request $request ) {
			$id            = $request->get_param( 'id' );
			$src           = $request->get_param( 'src' );
			$display_scope = $request->get_param( 'display_scope' );
			if ( ! $this->is_script_tag_valid( $src ) ) {
				return new WP_Error( 'woocommerce_rest_script_tags_invalid_src', __( 'Script tags src invalid.', 'woocommerce' ), array( 'status' => 400 ) );
			}
			$options = get_option( AFTERSHIP_SCRIPT_TAGS, array() );
			if ( ! array_key_exists( $id, $options ) ) {
				return new WP_Error( 'woocommerce_rest_script_tags_invalid_id', __( 'Invalid script_tags ID.', 'woocommerce' ), array( 'status' => 404 ) );
			}
			$option = $options[ $id ];
			if ( $option['consumer_key'] != $this->consumer_key ) {
				return new WP_Error( 'woocommerce_rest_script_tags_invalid_id', __( 'Invalid script_tags ID.', 'woocommerce' ), array( 'status' => 404 ) );
			}
			if ( ! empty( $display_scope ) ) {
				if ( in_array( $display_scope, $this->allow_display_scope, true ) ) {
					$option['display_scope'] = $display_scope;
				} else {
					return new WP_Error( 'woocommerce_rest_script_tags_invalid_display_scope', __( 'invalid display_scope.', 'woocommerce' ), array( 'status' => 400 ) );
				}
			}
			$option['src']        = $src;
			$option['updated_at'] = current_time( 'Y-m-d\TH:i:s\Z', true );
			$options[ $id ]       = $option;
			update_option( AFTERSHIP_SCRIPT_TAGS, $options );
			return array( 'script_tag' => $this->filter_consumer_key( $option ) );
		}

		/**
		 * Get option by src
		 *
		 * @param  $options
		 * @param  $src
		 * @return array
		 */
		private function get_option_by_src( $options, $src ) {
			$option = array();
			foreach ( $options as $id => $item ) {
				if ( $item['src'] === $src ) {
					$option = $item;
				}
			}
			return $option;
		}

		/**
		 * Check if script tags src exist
		 *
		 * @param  $options
		 * @param  $src
		 * @return bool
		 */
		private function is_script_tag_exist( $options, $src ) {
			$exist = false;
			foreach ( $options as $id => $item ) {
				if ( $item['src'] === $src ) {
					$exist = true;
				}
			}
			return $exist;
		}

		/**
		 * Check if script tags src valid
		 *
		 * @param  $src
		 * @return bool
		 */
		private function is_script_tag_valid( $src ) {
			$valid = true;
			if ( ! $src ) {
				$valid = false;
			}
			$parts = parse_url( $src );
			if ( ! $parts ) {
				$valid = false;
			}
			if ( ! $parts['host'] ) {
				$valid = false;
			}
			$hosts = explode( '.', $parts['host'] );
			if ( count( $hosts ) < 2 ) {
				$valid = false;
			}
			$root_domain = $hosts[ count( $hosts ) - 2 ] . '.' . $hosts[ count( $hosts ) - 1 ];
			if ( ! in_array( $root_domain, self::TRUST_HOSTS ) ) {
				$valid = false;
			}
			return $valid;
		}

		public function get_query_args() {
			$args          = parent::get_collection_params();
			$args['force'] = array(
				'required'    => false,
				'default'     => false,
				'description' => __( 'Force get all script_tags.', 'woocommerce' ),
				'type'        => 'boolean',
			);
			return $args;
		}


		public function register_routes() {
			register_rest_route(
				$this->namespace,
				'/' . $this->rest_base,
				array(
					array(
						'methods'             => WP_REST_Server::READABLE,
						'callback'            => array( $this, 'get_script_tags' ),
						'permission_callback' => array( $this, 'get_items_permissions_check' ),
						'args'                => $this->get_query_args(),
					),
					array(
						'methods'             => WP_REST_Server::CREATABLE,
						'callback'            => array( $this, 'create_script_tag' ),
						'permission_callback' => array( $this, 'create_item_permissions_check' ),
						'args'                => array(
							'src' => array(
								'required'    => true,
								'description' => __( 'Script source link.', 'woocommerce' ),
								'type'        => 'string',
								'format'      => 'uri',
							),
						),

					),
				)
			);

			register_rest_route(
				$this->namespace,
				'/' . $this->rest_base . '/(?P<id>[\w]+)',
				array(
					'args' => array(
						'id' => array(
							'description' => __( 'Unique identifier for the resource.', 'woocommerce' ),
							'type'        => 'string',
						),
					),
					array(
						'methods'             => WP_REST_Server::READABLE,
						'callback'            => array( $this, 'get_script_tag' ),
						'permission_callback' => array( $this, 'get_items_permissions_check' ),
					),
					array(
						'methods'             => WP_REST_Server::EDITABLE,
						'callback'            => array( $this, 'edit_script_tag' ),
						'permission_callback' => array( $this, 'create_item_permissions_check' ),
						'args'                => array(
							'src' => array(
								'required'    => true,
								'description' => __( 'Script source link.', 'woocommerce' ),
								'type'        => 'string',
								'format'      => 'uri',
							),
						),
					),
					array(
						'methods'             => WP_REST_Server::DELETABLE,
						'callback'            => array( $this, 'delete_script_tag' ),
						'permission_callback' => array( $this, 'delete_item_permissions_check' ),
						'args'                => array(
							'force' => array(
								'required'    => false,
								'default'     => false,
								'description' => __( 'Force delete script_tags.', 'woocommerce' ),
								'type'        => 'boolean',
							),
						),
					),
				)
			);
		}
	}
}
