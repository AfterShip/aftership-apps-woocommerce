<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AFTERSHIP_ORDERS_TRACKING_DATA {

	/**
	 * Escaping for HTML attributes.
	 *
	 * @param $name
	 * @param bool   $set_name
	 * @param string $prefix
	 * @return string|void
	 */
	public static function set( $name, $set_name = false, $prefix = 'aftership-orders-tracking-' ) {
		if ( is_array( $name ) ) {
			return implode( ' ', array_map( array( 'AFTERSHIP_ORDERS_TRACKING_DATA', 'set' ), $name ) );
		} else {
			if ( $set_name ) {
				return esc_attr( str_replace( '-', '_', $prefix . $name ) );

			} else {
				return esc_attr( $prefix . $name );

			}
		}
	}
}
