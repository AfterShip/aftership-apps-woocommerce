<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * AfterShip API settings
 */
class AfterShip_API_V5_Settings extends AfterShip_API_V4_Settings {

	/**
	 * Base router.
	 *
	 * @var string $base base router.
	 */
	protected $base = '/v5/settings';

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
}
