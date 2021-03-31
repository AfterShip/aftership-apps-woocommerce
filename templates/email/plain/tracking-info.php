<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * AfterShip
 *
 * Shows tracking information in the plain text order email
 *
 * @author  AfterShip
 * @package AfterShip Tracking/templates/email
 */

if ( $tracking_items ) :

	echo apply_filters( 'aftership_tracking_my_orders_title', __( 'TRACKING INFORMATION', 'aftership' ) );

		echo  "\n";

	foreach ( $tracking_items as $tracking_item ) {
		echo esc_html( $tracking_item['courier']['name'] ) . "\n";
		echo esc_html( $tracking_item['tracking_number'] ) . "\n";
	}

	echo "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= \n\n";

endif;


