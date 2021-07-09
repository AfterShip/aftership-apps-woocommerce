<?php
/**
 * Wc Rest v3 Orders API Helper
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


class Rest_Orders_Helper {

	/**
	 * Return the number of decimals after the decimal point.
	 *
	 * @since  2.3
	 * @return int
	 */
	protected $dp;

	public function __construct() {
		$this->dp = wc_get_price_decimals();
	}

	/**
	 * Merge the `$formatted_meta_data` `display_key` and `display_value` attribute values into the corresponding
	 * {@link WC_Meta_Data}. Returns the merged array.
	 *
	 * @param WC_Meta_Data $meta_item           An object from {@link WC_Order_Item::get_meta_data()}.
	 * @param array        $formatted_meta_data An object result from {@link WC_Order_Item::get_formatted_meta_data}.
	 * The keys are the IDs of {@link WC_Meta_Data}.
	 *
	 * @return array
	 */
	private function merge_meta_item_with_formatted_meta_display_attributes( $meta_item, $formatted_meta_data ) {
		$result = array(
			'id'            => $meta_item->id,
			'key'           => $meta_item->key,
			'value'         => $meta_item->value,
			'display_key'   => $meta_item->key,   // Default to original key, in case a formatted key is not available.
			'display_value' => $meta_item->value, // Default to original value, in case a formatted value is not available.
		);

		if ( array_key_exists( $meta_item->id, $formatted_meta_data ) ) {
			$formatted_meta_item = $formatted_meta_data[ $meta_item->id ];

			$result['display_key']   = wc_clean( $formatted_meta_item->display_key );
			$result['display_value'] = wc_clean( $formatted_meta_item->display_value );
		}

		return $result;
	}

	/**
	 * Expands an order item to get its data.
	 *
	 * @param WC_Order_item $item Order item data.
	 * @return array
	 */
	protected function get_order_item_data( $item ) {
		$data           = $item->get_data();
		$format_decimal = array( 'subtotal', 'subtotal_tax', 'total', 'total_tax', 'tax_total', 'shipping_tax_total' );

		// Format decimal values.
		foreach ( $format_decimal as $key ) {
			if ( isset( $data[ $key ] ) ) {
				$data[ $key ] = wc_format_decimal( $data[ $key ], $this->dp );
			}
		}

		// Add SKU and PRICE to products.
		if ( is_callable( array( $item, 'get_product' ) ) ) {
			$data['sku']   = $item->get_product() ? $item->get_product()->get_sku() : null;
			$data['price'] = $item->get_quantity() ? $item->get_total() / $item->get_quantity() : 0;
		}

		// Add parent_name if the product is a variation.
		if ( is_callable( array( $item, 'get_product' ) ) ) {
			$product = $item->get_product();

			if ( is_callable( array( $product, 'get_parent_data' ) ) ) {
				$data['parent_name'] = $product->get_title();
			} else {
				$data['parent_name'] = null;
			}
		}

		// Format taxes.
		if ( ! empty( $data['taxes']['total'] ) ) {
			$taxes = array();

			foreach ( $data['taxes']['total'] as $tax_rate_id => $tax ) {
				$taxes[] = array(
					'id'       => $tax_rate_id,
					'total'    => $tax,
					'subtotal' => isset( $data['taxes']['subtotal'][ $tax_rate_id ] ) ? $data['taxes']['subtotal'][ $tax_rate_id ] : '',
				);
			}
			$data['taxes'] = $taxes;
		} elseif ( isset( $data['taxes'] ) ) {
			$data['taxes'] = array();
		}

		// Remove names for coupons, taxes and shipping.
		if ( isset( $data['code'] ) || isset( $data['rate_code'] ) || isset( $data['method_title'] ) ) {
			unset( $data['name'] );
		}

		// Remove props we don't want to expose.
		unset( $data['order_id'] );
		unset( $data['type'] );

		// Expand meta_data to include user-friendly values.
		$formatted_meta_data = $item->get_formatted_meta_data( null, true );
		$data['meta_data']   = array_map(
			array( $this, 'merge_meta_item_with_formatted_meta_display_attributes' ),
			$data['meta_data'],
			array_fill( 0, count( $data['meta_data'] ), $formatted_meta_data )
		);

		return $data;
	}

	/**
	 * Get formatted item data.
	 *
	 * @since 3.0.0
	 * @param WC_Order $order WC_Data instance.
	 *
	 * @return array
	 */
	public function get_formatted_item_data( $order ) {
		$data              = $order->get_data();
		$format_decimal    = array( 'discount_total', 'discount_tax', 'shipping_total', 'shipping_tax', 'shipping_total', 'shipping_tax', 'cart_tax', 'total', 'total_tax' );
		$format_date       = array( 'date_created', 'date_modified', 'date_completed', 'date_paid' );
		$format_line_items = array( 'line_items', 'tax_lines', 'shipping_lines', 'fee_lines', 'coupon_lines' );

		// Format decimal values.
		foreach ( $format_decimal as $key ) {
			$data[ $key ] = wc_format_decimal( $data[ $key ], $this->dp );
		}

		// Format date values.
		foreach ( $format_date as $key ) {
			$datetime              = $data[ $key ];
			$data[ $key ]          = wc_rest_prepare_date_response( $datetime, false );
			$data[ $key . '_gmt' ] = wc_rest_prepare_date_response( $datetime );
		}

		// Format the order status.
		$data['status'] = 'wc-' === substr( $data['status'], 0, 3 ) ? substr( $data['status'], 3 ) : $data['status'];

		// Format line items.
		foreach ( $format_line_items as $key ) {
			$data[ $key ] = array_values( array_map( array( $this, 'get_order_item_data' ), $data[ $key ] ) );
		}

		// Refunds.
		$data['refunds'] = array();
		foreach ( $order->get_refunds() as $refund ) {
			$data['refunds'][] = array(
				'id'     => $refund->get_id(),
				'reason' => $refund->get_reason() ? $refund->get_reason() : '',
				'total'  => '-' . wc_format_decimal( $refund->get_amount(), $this->dp ),
			);
		}

		$allowed_fields = array(
			'id',
			'parent_id',
			'number',
			'order_key',
			'created_via',
			'version',
			'status',
			'currency',
			'date_created',
			'date_created_gmt',
			'date_modified',
			'date_modified_gmt',
			'discount_total',
			'discount_tax',
			'shipping_total',
			'shipping_tax',
			'cart_tax',
			'total',
			'total_tax',
			'prices_include_tax',
			'customer_id',
			'customer_ip_address',
			'customer_user_agent',
			'customer_note',
			'billing',
			'shipping',
			'payment_method',
			'payment_method_title',
			'transaction_id',
			'date_paid',
			'date_paid_gmt',
			'date_completed',
			'date_completed_gmt',
			'cart_hash',
			'meta_data',
			'line_items',
			'tax_lines',
			'shipping_lines',
			'fee_lines',
			'coupon_lines',
			'refunds',
		);

		$data = array_intersect_key( $data, array_flip( $allowed_fields ) );

		return $data;
	}

}
