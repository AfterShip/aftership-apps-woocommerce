<?php
// Prevent direct file access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! current_user_can( 'manage_options' ) ) {
	wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
}

$this->options      = get_option( 'aftership_option_name' );
$is_display_connect = $this->options['connected'] && $this->options['connected'] === true;

$store_url = get_home_url();

$query = array(
	'shop'       => $store_url,
	'utm_source' => 'wordpress_plugin',
	'utm_medium' => 'landingpage',
);

$debug = isset( $_GET['debug'] ) ? $_GET['debug'] : 'no';

$go_to_dashboard_url = 'https://accounts.aftership.com/oauth-session?callbackUrl=' . urlencode( 'https://accounts.aftership.com/oauth/woocommerce-automizely-aftership?signature=' . base64_encode( json_encode( $query ) ) );

if ( $debug === 'yes' ) {
	$go_to_dashboard_url = 'https://accounts.aftership.io/oauth-session?callbackUrl=' . urlencode( 'https://accounts.aftership.io/oauth/woocommerce-automizely-aftership?signature=' . base64_encode( json_encode( $query ) ) );
}

?>

<!-- Main wrapper -->
<div class="auto-as-admin-container">
	<div class="auto-as-admin-header" style="<?php echo $is_display_connect ? 'display:none;' : ''; ?>">
		<div class="auto-as-admin-logo">
			<img
				src="https://assets.aftership.com/img/wordpress-aftership-logo.svg"
				alt=""
			/>
		</div>
		<div class="auto-as-admin-header-title">Connect with AfterShip</div>
		<div class="auto-as-admin-header-desc">
			Track your WooCommerce orders and get delivery updates from 800+
			carriers like UPS, USPS, FedEx, and DHL all in one place.
		</div>
		<button class="auto-as-admin-header-button" onclick="window.open('<?php echo $go_to_dashboard_url; ?>')">
			Connect now
		</button>
	</div>

	<div class="wrap">
		<h2>Settings</h2>

		<form method="post" action="options.php">
			<?php
			// This prints out all hidden setting fields.
			settings_fields( 'aftership_option_group' );
			do_settings_sections( 'aftership-setting-admin' );
			submit_button();
			?>
		</form>
		<script>
		</script>
	</div>
	<div class="auto-as-admin-link">
		<div class="auto-as-admin-link-content">
			<span class="auto-as-admin-text-bold">Loving AfterShip? Rate us on the </span><a href="https://wordpress.org/plugins/aftership-woocommerce-tracking/#reviews">WordPress Plugin Directory</a>
		</div>
	</div>
	<div class="auto-as-admin-recommand">
		<div class="auto-as-admin-recommand-title">Recommand for you</div>
		<div class="auto-as-admin-recommand-list">
			<!-- postmen -->
			<a href="/wp-admin/plugin-install.php?tab=plugin-information&plugin=postmen-woo-shipping" target="_blank">
				<div class="auto-as-admin-recommand-list-item">
					<img style="width: 64px; height: 64px" src="https://assets.aftership.com/img/postmen-product.svg" alt="" />
					<div class="auto-as-admin-recommand-list-item-detail">
					<span>
					<strong>Postmen </strong>
					</span>
					<span>
					Delight customers with the best returns experience
					</span>
					</div>
				</div>
			</a>

			<!-- marketing -->
			<a href="/wp-admin/plugin-install.php?tab=plugin-information&plugin=automizely-marketing" target="_blank">
				<div class="auto-as-admin-recommand-list-item">
					<img
							style="width: 64px; height: 64px"
							src="https://assets.aftership.com/img/marketing-product.svg"
							alt=""
					/>
					<div class="auto-as-admin-recommand-list-item-detail">
					<span>
					<strong>Marketing</strong>
					</span>
					<span>
					Delight customers with the best returns experience
					</span>
					</div>
				</div>
			</a>
		</div>
	</div>
</div>
