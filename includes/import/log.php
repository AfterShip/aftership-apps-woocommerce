<?php

/**
 * Class AFTERSHIP_ORDERS_TRACKING_IMPORT_LOG
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AFTERSHIP_ORDERS_TRACKING_IMPORT_LOG {
	public static function log( $logs_content, $file_name = 'import_tracking.txt', $max = 2000 ) {
		$log_file     = AFTERSHIP_TRACKING_CACHE . "{$file_name}";
		$logs_content = '[' . date( 'Y-m-d H:i:s' ) . '] ' . $logs_content;
		if ( is_file( $log_file ) ) {
			// Remove Empty Spaces
			$file = array_filter( array_map( 'trim', file( $log_file ) ) );
			// Make Sure you always have maximum number of lines
			$file = array_slice( $file, 0, $max );
			// Remove any extra line from beginning
			count( $file ) >= $max and array_shift( $file );
			// Add new Line
			array_push( $file, $logs_content );
			// Save Result
			file_put_contents( $log_file, implode( PHP_EOL, array_filter( $file ) ) );
		} else {
			file_put_contents( $log_file, $logs_content );
		}
	}

	public static function create_plugin_cache_folder() {
		if ( ! is_dir( AFTERSHIP_TRACKING_CACHE ) ) {
			wp_mkdir_p( AFTERSHIP_TRACKING_CACHE );
			file_put_contents(
				AFTERSHIP_TRACKING_CACHE . '.htaccess',
				'<IfModule !mod_authz_core.c>
Order deny,allow
Deny from all
</IfModule>
<IfModule mod_authz_core.c>
  <RequireAll>
    Require all denied
  </RequireAll>
</IfModule>
'
			);
		}
	}
}
