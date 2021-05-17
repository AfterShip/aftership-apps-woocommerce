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
}

class AfterShip_API_V5_Orders extends AfterShip_API_V4_Orders {

	/**
	 * Base router path.
	 *
	 * @var string $base base router path
	 */
	protected $base = '/v5/orders';

	/**
	 * Register the routes for this class
	 *
	 * @param array $routes reg routers.
	 *
	 * @return array
	 */
	public function register_routes( $routes ) {
		$routes[ $this->base . '/ping' ] = array(
			array( array( $this, 'ping' ), AfterShip_API_Server::READABLE ),
		);

		$routes[ $this->base ] = array(
			array( array( $this, 'get_orders' ), AfterShip_API_Server::READABLE ),
		);

		$routes[ $this->base . '/(?P<id>[\d]+)' ] = array(
			array( array( $this, 'get_order' ), AfterShip_API_Server::READABLE ),
		);

		return $routes;
	}

	/**
	 * Get single order by id.
	 *
	 * @param int    $id order id.
	 * @param string $fields order fields.
	 * @return array|int|WP_Error
	 */
	public function get_order( $id, $fields = null ) {
		$tracking_order = parent::get_order( $id, $fields );

		$object = new WC_Order( $id );
		// get order detial like rest v3 api
		$restOrders                 = new Rest_Orders_Helper();
		$rest_raw_order             = $restOrders->get_formatted_item_data( $object );
		$tracking_order['raw_data'] = $rest_raw_order;

		return $tracking_order;
	}

}
