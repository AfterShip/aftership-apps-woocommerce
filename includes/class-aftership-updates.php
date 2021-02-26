<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * AfterShip Updates.
 *
 * This class performs the update of a given version. If a particular version
 * needs update routine (e.g. DB migration) then the updater should be defined
 * in `self::get_updaters()`.
 */
class AfterShip_Updates {
	/**
	 * List of updaters from version-to-version.
	 *
	 * @see self::get_updaters()
	 *
	 * @var array
	 */
	protected static $updaters;

	/**
	 * Get list of version updaters.
	 *
	 * @return array Array of updaters where key is the version and value is
	 *               updater array.
	 */
	protected static function get_updaters() {
		if ( ! empty( self::$updaters ) ) {
			return self::$updaters;
		}

		self::$updaters = array(
			'1.10.5' => array(
				'path'  => self::get_updater_base_dir() . 'class-aftership-updater-1.10.5.php',
				'class' => 'AfterShip_Updater_1_10_5',
			),
		);

		return self::$updaters;
	}

	/**
	 * Check for update based on current plugin's version versus installed
	 * version. Perform update routine if version mismatches.
	 *
	 * Hooked into `init` so that it's checked on every request.
	 */
	public static function check_updates() {
		$installed_version = get_option( 'aftership_version' );
		if ( AFTERSHIP_VERSION !== $installed_version ) {
			self::update_version();
			self::maybe_perform_update( $installed_version );
		}
	}

	/**
	 * Update version that's stored in DB to the latest version.
	 */
	protected static function update_version() {
		delete_option( 'aftership_version' );
		add_option( 'aftership_version', AFTERSHIP_VERSION );
	}

	/**
	 * Maybe perform update if there's an udpate routine for a given version.
	 *
	 * @param string $installed_version Installed version found in DB.
	 */
	protected static function maybe_perform_update( $installed_version ) {
		require_once( self::get_updater_base_dir() . 'abstract-aftership-updater.php' );

		foreach ( self::get_updaters() as $version => $updater ) {
			if ( version_compare( $installed_version, $version, '>=' ) ) {
				continue;
			}

			self::maybe_updater_runs_update( $updater );
		}
	}

	/**
	 * Maybe the updater will run `updates` routine.
	 *
	 * @param array $updater Updater array.
	 */
	protected static function maybe_updater_runs_update( array $updater ) {
		require_once( $updater['path'] );

		$updater_instance = new $updater['class']();
		if ( ! is_a( $updater_instance, 'AfterShip_Updater' ) ) {
			return;
		}

		return $updater_instance->update();
	}

	/**
	 * Get updater base dir.
	 *
	 * @return string Updater base dir.
	 */
	protected static function get_updater_base_dir() {
		return aftership()->plugin_dir . '/includes/updates/';
	}
}
