<?php
/**
 * AfterShip API Orders Class
 *
 * Handles requests to the /orders endpoint
 *
 * @author      AfterShip
 * @category    API
 * @package     AfterShip/API
 * @since       1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

define('AFTERSHIP_OPTION_NAME', 'aftership_option_name');

class AfterShip_API_V4_Settings extends AfterShip_API_Resource {


	/** @var string $base the route base */
	protected $base = '/v4/settings';

	/**
	 * Register the routes for this class
	 *
	 * GET /settings
	 *
	 * @param array $routes
	 *
	 * @return array
	 * @since 2.1
	 */
	public function register_routes( $routes ) {
		// GET /settings/ping
		$routes[ $this->base . '/ping' ] = array(
			array( array( $this, 'ping' ), AfterShip_API_Server::READABLE ),
		);

        // PUT /settings
        $routes[ $this->base] = [
            [[$this, 'update_aftership_setting'], AfterShip_API_Server::METHOD_PUT | AfterShip_API_Server::ACCEPT_DATA]
        ];

        // POST /settings
        $routes[ $this->base] = [
            [[$this, 'update_aftership_setting'], AfterShip_API_Server::METHOD_POST | AfterShip_API_Server::ACCEPT_DATA]
        ];

		return $routes;
	}

	/**
	 * heath checkendpoint for WordPress url validation
	 *
	 * @return string
	 * @since 2.1
	 */
	public function ping() {
		return 'pong';
	}

    /**
     * Create a aftership setting record on wp_options
     * @param WP_REST_Request $request
     *   {
     *      "couriers": "17postservice,360lion,dhl,ups",
     *      "custom_domain": "tracks.aftership.com",
     *      "use_track_button": true
     *   }
     * @return array|WP_Error
     */
    public function update_aftership_setting($data)
    {
        // Check if exist aftership option
        $options = get_option(AFTERSHIP_OPTION_NAME);
        if ( $options && !$options['custom_domain'] ) {
            $custom_domain = $data->get_param('custom_domain');
            if (!$custom_domain) {
                return new WP_Error( 'woocommerce_rest_invalid_aftership_option', __( 'Aftership option invalid.', 'woocommerce' ), array( 'status' => 400 ) );
            }
            $options = [
                'couriers' => $options['couriers'],
                'custom_domain' => $custom_domain,
                'use_track_button' => $options['use_track_button'],
            ];
            update_option(AFTERSHIP_OPTION_NAME, $options);
        }
        return array('settings' => array( AFTERSHIP_OPTION_NAME => $options));
    }

}
