<?php
/**
 * Updater base class.
 *
 * @package WC_Shipment_Tracking
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Base class for version updater to implement.
 *
 * Real version updater lives in the same directory.
 *
 * @since 1.6.5
 * @version 1.6.5
 */
abstract class AfterShip_Updater {
	/**
	 * Logger instance.
	 *
	 * @since 1.6.5
	 * @version 1.6.5
	 *
	 * @var WC_Logger
	 */
	private $logger;

	/**
	 * Performs update.
	 *
	 * @since 1.6.5
	 * @version 1.6.5
	 *
	 * @return bool Returns true if succeed.
	 */
	abstract public function update();

	/**
	 * Log debug message.
	 *
	 * @since 1.6.5
	 * @version 1.6.5
	 *
	 * @param string $message Message to log.
	 */
	protected function log_debug( $message ) {
		if ( empty( $this->logger ) ) {
			$this->logger = new WC_Logger();
		}

		$this->logger->add( 'aftership-woocommerce-tracking-updater', $message );
	}
}
