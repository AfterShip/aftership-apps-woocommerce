<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * AfterShip Protection
 */
class AfterShip_Protection {


	/**
	 * Instance of this class.
	 *
	 * @var object Class Instance
	 */
	private static $instance;

	/**
	 * Get the class instance
	 *
	 * @return AfterShip_Protection
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {

			self::$instance = new self;
		}

		return self::$instance;
	}

	private function __construct()
	{
		// Get cart details.
		add_action( 'wp_ajax_nopriv_aftership_get_cart_details', array($this, 'get_cart_details_ajax_handler') );
		add_action( 'wp_ajax_aftership_get_cart_details', array($this, 'get_cart_details_ajax_handler') );
		// Set insurance fee.
		add_action( 'wp_ajax_nopriv_aftership_set_insurance_fee', array($this, 'set_insurance_fee_ajax_handler') );
		add_action( 'wp_ajax_aftership_set_insurance_fee', array($this, 'set_insurance_fee_ajax_handler') );
		// Remove insurance fee.
		add_action( 'wp_ajax_nopriv_aftership_remove_insurance_fee', array($this, 'remove_insurance_fee_ajax_handler') );
		add_action( 'wp_ajax_aftership_remove_insurance_fee', array($this, 'remove_insurance_fee_ajax_handler') );
		// Re calculate & empty cart
		add_action('woocommerce_cart_calculate_fees', array($this, 'apply_aftership_shipping_insurance_fee'), 20, 1);
		add_action( 'woocommerce_cart_emptied', array( $this, 'handle_woocommerce_cart_emptied' ) );
	}

	/**
	 * Clear AfterShip shipping insurance fee.
	 */
	function handle_woocommerce_cart_emptied() {
		WC()->session->set( 'aftership_shipping_insurance_fee', null);
	}

	/**
	 * Apply AfterShip shipping insurance fee.
	 */
	function apply_aftership_shipping_insurance_fee() {
		$amount = WC()->session->get( 'aftership_shipping_insurance_fee', '-');
		if ($amount !== '-') {
			WC()->cart->add_fee(AFTERSHIP_PROTECTION_LABEL, $amount, false, "");
		}
	}

	/**
	 * Ajax handler to set insurance fee.
	 */
	function set_insurance_fee_ajax_handler() {
		$amount = wc_clean( $_REQUEST['amount'] );
		WC()->session->set( 'aftership_shipping_insurance_fee' ,  $amount);
		$this->get_cart_details_ajax_handler();
	}
	/**
	 * Ajax handler to remove insurance fee.
	 */
	function remove_insurance_fee_ajax_handler () {
		WC()->session->set( 'aftership_shipping_insurance_fee' ,  '-');
		$this->get_cart_details_ajax_handler();
	}

	/**
	 * Ajax handler to get cart info.
	 */
	function get_cart_details_ajax_handler() {
		WC()->cart->calculate_totals();
		$wc_cart = WC()->cart;
		$cart = $wc_cart->get_cart();
		foreach ( $cart as $cart_item_key => $cart_item ) {
			if (isset($cart_item['variation_id']) && isset($cart_item['variation'])) {
				$variation    = new WC_Product_Variation( $cart_item['variation_id'] );
				$cart[$cart_item_key]['variation'] = array_merge($cart_item['variation'], $variation->get_data());
			}
			$product = wc_get_product( $cart_item['product_id'] );
			$cart[$cart_item_key]['product'] = $product->get_data();
		}
		wp_send_json_success( array(
			'cart'=> $cart,
			'fees'=> $wc_cart->fees_api()->get_fees(),
			'totals'=> $wc_cart->get_totals(),
			'currency'=> get_woocommerce_currency(),
		));
	}
}
