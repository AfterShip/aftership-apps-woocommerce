<?php
/**
 * Functions used by plugins
 */
if ( ! class_exists( 'WC_Dependencies' ) )
	require_once 'class-wc-dependencies.php';

/**
 * WC Detection
 */
if ( ! function_exists( 'is_woocommerce_active' ) ) {
	function is_woocommerce_active() {
		return WC_Dependencies::woocommerce_active_check();
	}
}

if ( ! function_exists( 'get_order_id' ) ) {
    function get_order_id($order) {
        return (method_exists($order, 'get_id'))? $order->get_id() : $order->id;
    }
}

if ( ! function_exists( 'order_post_meta_getter' ) ) {
    function order_post_meta_getter($order, $attr) {
        $meta = get_post_meta(get_order_id($order), '_'. $attr, true);
        return $meta;
    }
}
