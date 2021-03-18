<?php
/**
 * AfterShip Admin
 *
 * Handles AfterShip-Admin endpoint requests
 *
 * @author      AfterShip
 * @category    Admin
 * @package     AfterShip
 * @since       1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class AfterShip_Settings {

	/**
	 * Holds the values to be used in the fields callbacks
	 */
	private $options;

	/**
	 * Start up
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'page_init' ) );
		add_action( 'admin_print_styles', array( $this, 'admin_styles' ) );
		add_action( 'admin_print_scripts', array( &$this, 'library_scripts' ) );
	}


	public function admin_styles() {
		wp_enqueue_style( 'aftership_styles_chosen', aftership()->plugin_url . '/assets/plugin/chosen/chosen.min.css' );
	}

	public function library_scripts() {
		$plugin_url = aftership()->plugin_url;
		wp_enqueue_script( 'aftership_styles_chosen_jquery', $plugin_url . '/assets/plugin/chosen/chosen.jquery.min.js' );
		wp_enqueue_script( 'aftership_styles_chosen_proto', $plugin_url . '/assets/plugin/chosen/chosen.proto.min.js' );
		wp_enqueue_script( 'aftership_script_util', $plugin_url . '/assets/js/util.js' );
		wp_enqueue_script( 'aftership_script_couriers', $plugin_url . '/assets/js/couriers.js' );
		wp_enqueue_script( 'aftership_script_setting', $plugin_url . '/assets/js/setting.js' );
	}

	/**
	 * Add options page
	 */
	public function add_plugin_page() {
		// This page will be under "Settings"
		add_options_page(
			'AfterShip Settings Admin',
			'AfterShip',
			'manage_options',
			'aftership-setting-admin',
			array( $this, 'create_admin_page' )
		);
	}

	/**
	 * Options page callback
	 */
	public function create_admin_page() {
		// Set class property
		$this->options = get_option( 'aftership_option_name' );
		?>
		<div class="wrap">
			<h2>AfterShip Settings</h2>

			<form method="post" action="options.php">
				<?php
				// This prints out all hidden setting fields
				settings_fields( 'aftership_option_group' );
				do_settings_sections( 'aftership-setting-admin' );
				submit_button();
				?>
			</form>
		</div>
		<?php
	}

	/**
	 * Register and add settings
	 */
	public function page_init() {
		register_setting(
			'aftership_option_group', // Option group
			'aftership_option_name', // Option name
			array( $this, 'sanitize' ) // Sanitize
		);

		add_settings_section(
			'aftership_setting_section_id', // ID
			'', // Title
			array( $this, 'print_section_info' ), // Callback
			'aftership-setting-admin' // Page
		);

		add_settings_field(
			'couriers',
			'Couriers',
			array( $this, 'couriers_callback' ),
			'aftership-setting-admin',
			'aftership_setting_section_id'
		);

		add_settings_field(
			'use_track_button',
			'Display Track Button at Order History Page',
			array( $this, 'track_button_callback' ),
			'aftership-setting-admin',
			'aftership_setting_section_id'
		);

		add_settings_field(
			'custom_domain',
			'Display Tracking Information at Custom Domain',
			array( $this, 'custom_domain_callback' ),
			'aftership-setting-admin',
			'aftership_setting_section_id'
		);
	}

	/**
	 * Sanitize each setting field as needed
	 *
	 * @param array $input Contains all settings fields as array keys
	 * @return array
	 */
	public function sanitize( $input ) {
		$new_input = array();

		if ( isset( $input['couriers'] ) ) {
			$new_input['couriers'] = sanitize_text_field( $input['couriers'] );
		}

		if ( isset( $input['custom_domain'] ) ) {
			$new_input['custom_domain'] = sanitize_text_field( $input['custom_domain'] );
		}

		if ( isset( $input['use_track_button'] ) ) {
			$new_input['use_track_button'] = true;
		}

		return $new_input;
	}

	/**
	 * Print the Section text
	 */
	public function print_section_info() {
		// print 'Enter your settings below:';
	}

	public function couriers_callback() {

		$couriers = array();
		if ( isset( $this->options['couriers'] ) ) {
			$couriers = explode( ',', $this->options['couriers'] );
		}
		echo '<select data-placeholder="Please select couriers" id="couriers_select" multiple style="width:100%">';
		echo '</select>';
		echo '<input type="hidden" id="couriers" name="aftership_option_name[couriers]" value="' . implode( ',', $couriers ) . '"/>';

	}

	public function custom_domain_callback() {
		printf(
			'<input type="text" id="custom_domain" name="aftership_option_name[custom_domain]" value="%s" style="width:100%%">',
			isset( $this->options['custom_domain'] ) ? $this->options['custom_domain'] : 'track.aftership.com'
		);
	}

	public function track_button_callback() {
		printf(
			'<label><input type="checkbox" id="use_track_button" name="aftership_option_name[use_track_button]" %s>Use Track Button</label>',
			( isset( $this->options['use_track_button'] ) && $this->options['use_track_button'] === true ) ? 'checked="checked"' : ''
		);
	}
}


if ( is_admin() ) {
	$aftership_settings = new AfterShip_Settings();
}
