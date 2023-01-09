<?php
/**
 * OnBoarding landing page.
 *
 * @package AfterShip
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! current_user_can( 'manage_options' ) ) {
	wp_die( 'You do not have sufficient permissions to access this page.' );
}

$store_url = get_home_url();

$query = array(
	'shop'       => $store_url,
	'utm_source' => 'wordpress_plugin',
	'utm_medium' => 'landingpage',
);

$go_to_dashboard_url = 'https://accounts.aftership.com/oauth-session?callbackUrl=' . rawurlencode( 'https://accounts.aftership.com/oauth/woocommerce-automizely-aftership?signature=' . base64_encode( wp_json_encode( $query ) ) );
?>

<!-- Main wrapper -->
<div class="auto-as-index-container">
	<div class="auto-as-index-header">
	<div class="auto-as-index-logo">
		<img
		src="<?php echo esc_html( AFTERSHIP_ASSETS_URL ) . '/assets/images/wordpress-aftership-logo.svg'; ?>"
		alt=""
		/>
	</div>
	<div class="auto-as-index-header-title">Connect with AfterShip</div>
	<div class="auto-as-index-header-desc">
		Track your WooCommerce orders and get delivery updates from 800+
		carriers like UPS, USPS, FedEx, and DHL all in one place.
	</div>
	<button class="auto-as-index-header-button" onclick="window.open('<?php echo esc_html( $go_to_dashboard_url ); ?>')">
		Connect now
	</button>
	</div>
	<div class="auto-as-index-content">
	<img
		style="
		width: 766px;
		height: 486px;
		display: block;
		margin: 80px auto 0px;
		"
		src="<?php echo esc_html( AFTERSHIP_ASSETS_URL ) . '/assets/images/tracking-page.png'; ?>"
		alt=""
	/>
	</div>
</div>
