<?php
/**
 * Functions used by plugins
 */
if ( ! class_exists( 'AfterShip_Dependencies' ) )
	require_once 'class-aftership-dependencies.php';

/**
 * WC Detection
 */
if ( ! function_exists( 'is_woocommerce_active' ) ) {
	function is_woocommerce_active() {
		return AfterShip_Dependencies::woocommerce_active_check();
	}
}
