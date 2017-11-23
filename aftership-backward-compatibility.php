<?php
/**
 * Get woo order ID
 */
if ( ! function_exists( 'get_order_id' ) ) {
	function get_order_id($order) {
		return (method_exists($order, 'get_id'))? $order->get_id() : $order->id;
	}
}

/**
 * @see https://docs.woocommerce.com/wc-apidocs/source-class-WC_Abstract_Legacy_Order.html#406
 * Get attribute from WC_Order
 *
 */
if ( ! function_exists( 'order_post_meta_getter' ) ) {
	function order_post_meta_getter($order, $attr) {
		$meta = get_post_meta(get_order_id($order), '_'. $attr, true);
		return $meta;
	}
}
