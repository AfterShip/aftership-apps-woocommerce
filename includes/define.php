<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$plugin_url = plugins_url( '', __FILE__ );
$plugin_url = str_replace( '/includes', '/assets', $plugin_url );
define( 'AFTERSHIP_TRACKING_IMPORT_CSS', $plugin_url . '/css/import/' );
define( 'AFTERSHIP_TRACKING_IMPORT_JS', $plugin_url . '/js/import/' );
define( 'AFTERSHIP_TRACKING_JS', $plugin_url . '/js/' );

define( 'AFTERSHIP_TRACKING_DIR', WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . 'aftership-woocommerce-tracking' . DIRECTORY_SEPARATOR );
define( 'AFTERSHIP_TRACKING_INCLUDES', AFTERSHIP_TRACKING_DIR . 'includes' . DIRECTORY_SEPARATOR );
define( 'AFTERSHIP_TRACKING_INCLUDES_IMPORT', AFTERSHIP_TRACKING_DIR . 'includes/import/' );
/*Use the same cache folder as free version*/
define( 'AFTERSHIP_TRACKING_CACHE', WP_CONTENT_DIR . '/cache/aftership-woocommerce-tracking/' );

if ( is_file( AFTERSHIP_TRACKING_INCLUDES_IMPORT . 'functions.php' ) ) {
	require_once AFTERSHIP_TRACKING_INCLUDES_IMPORT . 'functions.php';
}
if ( is_file( AFTERSHIP_TRACKING_INCLUDES_IMPORT . 'data.php' ) ) {
	require_once AFTERSHIP_TRACKING_INCLUDES_IMPORT . 'data.php';
}
if ( is_file( AFTERSHIP_TRACKING_INCLUDES_IMPORT . 'log.php' ) ) {
	require_once AFTERSHIP_TRACKING_INCLUDES_IMPORT . 'log.php';
}
if ( is_file( AFTERSHIP_TRACKING_INCLUDES . 'class-aftership-actions.php' ) ) {
	require_once AFTERSHIP_TRACKING_INCLUDES . 'class-aftership-actions.php';
}
