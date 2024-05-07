<?php
/**
 * Shipment Tracking Plugin Migrator
 *
 * Uses WC_Queue to migrate tracking number from Shipment Tracking plugin.
 *
 * @package AfterShip
 */

defined( 'ABSPATH' ) || exit;

/**
 * AfterShip ShipmentTracking Updater
 */
class AfterShip_ShipmentTracking_Migrator {

	/**
	 * Get the interval.
	 *
	 * @return bool
	 */
	public static function get_interval() {
		$options = get_option( 'aftership_option_name' );
		if ( ! $options ) {
			return 0;
		}
		$interval = isset( $options['shipment_tracking_migrate_interval'] ) ? $options['shipment_tracking_migrate_interval'] : -1;
		if ( ! $interval || $interval <= 0 ) {
			return 0;
		}
		return $interval;
	}

	/**
	 * Check if the migration is enabled.
	 *
	 * @return bool
	 */
	public static function is_enabled() {
		if ( ! self::get_interval() ) {
			return false;
		}
		return true;
	}

	/**
	 * Setup.
	 */
	public static function load() {
		if ( ! self::is_enabled() ) {
			return;
		}
		add_action( 'init', array( __CLASS__, 'schedule' ) );
		add_action( 'aftership_migrate_from_shipment_tracking', array( __CLASS__, 'migrate_from_shipment_tracking' ) );
	}

	/**
	 * Schedule events and hook appropriate actions.
	 */
	public static function schedule() {
		$queue = WC()->queue();
		$next  = $queue->get_next( 'aftership_migrate_from_shipment_tracking' );
		if ( ! $next ) {
			$queue->schedule_recurring( time(), DAY_IN_SECONDS, 'aftership_migrate_from_shipment_tracking' );
		}
	}

	/**
	 * Migrate tracking number from shipment tracking.
	 */
	public static function migrate_from_shipment_tracking() {
		if ( ! self::is_enabled() ) {
			return;
		}
		$interval = self::get_interval();
		$orders   = wc_get_orders(
			array(
				'date_created' => gmdate( 'Y-m-d', time() - $interval ) . '...' . gmdate( 'Y-m-d' ),
				'limit'        => -1,
				// 'meta_key'     => '_aftership_tracking_items',
				// 'meta_compare' => 'NOT EXISTS',
			)
		);
		foreach ( $orders as $order ) {
			$tracking_items = $order->get_meta( '_wc_shipment_tracking_items' );
			if ( empty( $tracking_items ) ) {
				continue;
			}
			$aftership_tracking_items = $order->get_meta( '_aftership_tracking_items' );
			if ( empty( $aftership_tracking_items ) ) {
				$aftership_tracking_items = array();
			}
			$tracking_numbers           = array_column( $tracking_items, 'tracking_number' );
			$aftership_tracking_numbers = array_column( $aftership_tracking_items, 'tracking_number' );
			$migrated                   = false;
			foreach ( $tracking_numbers as $tracking_number ) {
				if ( in_array( $tracking_number, $aftership_tracking_numbers, true ) ) {
					continue;
				}
				$migrated = true;
				aftership()->actions->add_tracking_item( $order->get_id(), array( 'tracking_number' => $tracking_number ) );
			}
			if ( ! $migrated ) {
				continue;
			}
			$order->set_date_modified( current_time( 'mysql' ) );
			$order->save();
		}
	}
}

AfterShip_ShipmentTracking_Migrator::load();
