<?php
/**
 * Plain Email Template
 *
 * @package AfterShip
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $tracking_items ) :

	esc_attr_e( 'TRACKING INFORMATION' );

		echo "\n";

	foreach ( $tracking_items as $tracking_item ) {
		echo esc_html( $tracking_item['courier']['name'] ) . "\n";
		echo esc_html( $tracking_item['tracking_number'] ) . "\n";
	}

	echo "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= \n\n";

endif;


