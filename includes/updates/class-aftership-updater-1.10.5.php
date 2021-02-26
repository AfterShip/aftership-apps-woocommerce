<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Update post meta to support multi tracking
 */
class AfterShip_Updater_1_10_5 extends WC_Shipment_Tracking_Updater {

	/**
	 * {@inheritdoc}
	 */
	public function update() {
		$this->log_debug( 'Performing AfterShip update routine to support multi tracking.' );

		$order_ids = $this->get_order_ids_with_legacy_meta();

		$this->log_debug( sprintf( 'Found %s orders to update.', count( $order_ids ) ) );

		foreach ( $order_ids as $order_id ) {
			$this->convert_old_meta_in_order( $order_id );
		}

		return true;
	}

	/**
	 * Convert old meta in a given order ID to new meta structure.
	 *
	 * @param int $order_id Order ID.
	 */
	private function convert_old_meta_in_order( $order_id ) {
		$this->log_debug( sprintf( 'Updating legacy meta in order #%s.', $order_id ) );

		$migrate = get_post_meta( $order_id, '_aftership_migrated', true );
		if ( $migrate ) {
			$this->log_debug( sprintf( 'Legacy meta in order #%s already migrated.', $order_id ) );
			return;
		}

		$slug                = get_post_meta( $order_id, '_aftership_tracking_provider_name', true );
		$tracking_number     = get_post_meta( $order_id, '_aftership_tracking_number', true );
		$account_number      = get_post_meta( $order_id, '_aftership_tracking_account', true );
		$key                 = get_post_meta( $order_id, '_aftership_tracking_key', true );
		$postal_code         = get_post_meta( $order_id, '_aftership_tracking_postal', true );
		$ship_date           = get_post_meta( $order_id, '_aftership_tracking_shipdate', true );
		$destination_country = get_post_meta( $order_id, '_aftership_tracking_destination_country', true );

		if ( ! $tracking_number ) {
			return;
		}

		aftership_add_tracking_number(
			$order_id,
			$tracking_number,
			$slug,
			$account_number,
			$key,
			$postal_code,
			$ship_date,
			$destination_country
		);

		add_post_meta( $order_id, '_aftership_migrated', true );
	}

	/**
	 * Get order IDs with legacy meta.
	 *
	 * @return array Order IDs.
	 */
	private function get_order_ids_with_legacy_meta() {
		global $wpdb;

		return $wpdb->get_col(
			"
			SELECT DISTINCT( m.post_id ) FROM {$wpdb->postmeta} m
			LEFT JOIN {$wpdb->posts} p ON m.post_id = p.ID
			WHERE
				m.meta_key = '_aftership_tracking_number' AND
				m.meta_value != '' AND
				p.post_type = 'shop_order'
			ORDER BY p.ID DESC;
			"
		);
	}
}
