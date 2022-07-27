<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * AfterShip API settings
 */
class AfterShip_API_V4_Settings extends AfterShip_API_Resource {

	/**
	 * Base router.
	 *
	 * @var string $base base router.
	 */
	protected $base = '/v4/settings';

	/**
	 * Register the routes for this class
	 *
	 * @param array $routes routes list.
	 *
	 * @return array
	 */
	public function register_routes( $routes ) {

		$routes[ $this->base ] = array(
			// GET list API.
			array( array( $this, 'get_list' ), AfterShip_API_Server::READABLE ),
			// PUT or POST API.
			array( array( $this, 'update' ), AfterShip_API_Server::METHOD_POST | AfterShip_API_Server::METHOD_PUT | AfterShip_API_Server::ACCEPT_DATA ),
		);

		return $routes;
	}

	/**
	 * GET all settings.
	 *
	 * @return array
	 */
	public function get_list() {
		$settings            = get_option( 'aftership_option_name' );
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
	 * Update plugin settings.
	 *
	 * @param array $data JSON data from post request.
	 * @return array|WP_Error
	 */
	public function update( $data ) {
		$options             = get_option( 'aftership_option_name' );
		$custom_domain       = isset( $options['custom_domain'] ) ? $options['custom_domain'] : '';
		$couriers            = isset( $options['couriers'] ) ? $options['couriers'] : '';
		$use_tracking_button = isset( $options['use_track_button'] ) ? $options['use_track_button'] : '';
		$show_orders_actions = isset( $options['show_orders_actions'] ) ? $options['show_orders_actions'] : '';

		if ( isset( $data['custom_domain'] ) && $data['custom_domain'] ) {
			if ( 'track.aftership.com' === $custom_domain || '' === $custom_domain ) {
				$options['custom_domain'] = $this->normalize_custom_domain( $data['custom_domain'] );
			}
		}

		if ( isset( $data['couriers'] ) && $data['couriers'] ) {
			if ( '' === $couriers ) {
				$options['couriers'] = $data['couriers'];
			}
		}

		if ( isset( $data['show_orders_actions'] ) && $data['show_orders_actions'] ) {
			if ( '' === $show_orders_actions ) {
				$options['show_orders_actions'] = $data['show_orders_actions'];
			}
		}

		// Notice: true -> '1', false -> ''
		if ( isset( $data['connected'] ) && in_array( $data['connected'], array( '1', '' ) ) && in_array( boolval( $data['connected'] ), array( true, false ), true ) ) {
			$options['connected'] = boolval( $data['connected'] );
		}

		if ( isset( $data['use_track_button'] ) && in_array( $data['use_track_button'], array( true, false ), true ) ) {
			if ( '' === $use_tracking_button ) {
				$options['use_track_button'] = $data['use_track_button'];
			}
		}
		update_option( 'aftership_option_name', $options );
		return array( 'settings' => $options );
	}

}
