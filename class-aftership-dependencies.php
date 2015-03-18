<?php
class AfterShip_Dependencies {

	private static $active_plugins;

	public static function init() {

		self::$active_plugins = (array) get_option( 'active_plugins', array() );

		if ( is_multisite() )
			self::$active_plugins = array_merge( self::$active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );
	}

	public static function plugin_active_check($plugin){
		if ( ! self::$active_plugins ) self::init();
		return in_array( $plugin, self::$active_plugins ) || array_key_exists( $plugin, self::$active_plugins );
	}

	public static function woocommerce_active_check() {
		return self::plugin_active_check('woocommerce/woocommerce.php');
	}

}


