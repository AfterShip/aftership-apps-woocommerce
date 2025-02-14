<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * AfterShip Settings
 */
class AfterShip_Settings {

	/**
	 * Holds the values to be used in the fields callbacks
	 *
	 * @var array $options aftership options.
	 */
	private $options;

	/**
	 * DOM id for courier select element.
	 *
	 * @var string $dom_id_courier_select
	 */
	private $dom_id_courier_select = 'aftership_couriers_select';
	/**
	 * DOM id for hidden input couriers.
	 *
	 * @var string $dom_id_couriers
	 */
	private $dom_id_couriers = 'aftership_couriers';

	/**
	 * DOM id for hidden aftership connected.
	 *
	 * @var string $dom_aftership_connected
	 */
	private $dom_aftership_connected = 'aftership_connected';

	/**
	 * DOM id for hidden aftership connected.
	 *
	 * @var string $dom_aftership_enable_import_tracking
	 */
	private $dom_aftership_enable_import_tracking = 'aftership_enable_import_tracking';

	/**
	 * show order actions when selected order status.
	 *
	 * @var string $dom_aftership_show_order_actions
	 */
	private $dom_id_show_order_actions_select = 'aftership_show_order_actions_select';

	/**
	 * show order actions when selected order status.
	 *
	 * @var string $dom_aftership_show_order_actions
	 */
	private $dom_id_show_order_actions = 'aftership_show_order_actions';

	/**
	 * Start up
	 */
	public function __construct() {
		add_action( 'admin_init', array( $this, 'page_init' ) );
		add_action( 'admin_print_styles', array( $this, 'admin_styles' ) );
		add_action( 'admin_print_scripts', array( &$this, 'library_scripts' ) );
	}


	/**
	 * Inject css
	 */
	public function admin_styles() {
		wp_enqueue_style( 'aftership_styles_chosen', aftership()->plugin_url . '/assets/plugin/chosen/chosen.min.css', array(), AFTERSHIP_VERSION );
	}

	/**
	 * Inject javascripts
	 */
	public function library_scripts() {
		$plugin_url = aftership()->plugin_url;
		wp_enqueue_script( 'aftership_styles_chosen_jquery', $plugin_url . '/assets/plugin/chosen/chosen.jquery.min.js', array(), AFTERSHIP_VERSION );
		wp_enqueue_script( 'aftership_styles_chosen_proto', $plugin_url . '/assets/plugin/chosen/chosen.proto.min.js', array(), AFTERSHIP_VERSION );
		wp_enqueue_script( 'aftership_script_util', $plugin_url . '/assets/js/util.js', array(), AFTERSHIP_VERSION );
		wp_enqueue_script( 'aftership_script_couriers', $plugin_url . '/assets/js/couriers.js', array(), AFTERSHIP_VERSION );
		wp_enqueue_script( 'aftership_script_show_order_actions', $plugin_url . '/assets/js/order-status.js', array(), AFTERSHIP_VERSION );
		wp_enqueue_script( 'aftership_script_setting', $plugin_url . '/assets/js/setting.js', array(), AFTERSHIP_VERSION );
	}

	/**
	 * Register and add settings
	 */
	public function page_init() {
		$this->options = get_option( 'aftership_option_name' );

		register_setting(
			'aftership_option_group',
			'aftership_option_name',
			array( $this, 'sanitize' )
		);

		add_settings_section(
			'aftership_setting_section_id',
			'',
			array( $this, 'print_section_info' ),
			'aftership-setting-admin'
		);

		add_settings_field(
			$this->dom_id_couriers,
			'',
			array( $this, 'couriers_callback' ),
			'aftership-setting-admin',
			'aftership_setting_section_id'
		);

		add_settings_field(
			'use_track_button',
			'',
			array( $this, 'track_button_callback' ),
			'aftership-setting-admin',
			'aftership_setting_section_id'
		);

		add_settings_field(
			'custom_domain',
			'',
			array( $this, 'custom_domain_callback' ),
			'aftership-setting-admin',
			'aftership_setting_section_id'
		);

		add_settings_field(
			'enable_import_tracking',
			'',
			array( $this, 'enable_import_tracking_callback' ),
			'aftership-setting-admin',
			'aftership_setting_section_id'
		);

		//  CNT-34475 下掉相关的选项
		// add_settings_field(
		// 	'save_notes_to_meta_data',
		// 	'',
		// 	array( $this, 'save_notes_to_meta_data_callback' ),
		// 	'aftership-setting-admin',
		// 	'aftership_setting_section_id'
		// );

		add_settings_field(
			$this->dom_id_show_order_actions,
			'',
			array( $this, 'show_order_actions_callback' ),
			'aftership-setting-admin',
			'aftership_setting_section_id'
		);
	}

	/**
	 * Sanitize each setting field as needed
	 *
	 * @param array $input Contains all settings fields as array keys.
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

		if ( isset( $input['connected'] ) ) {
			$new_input['connected'] = boolval( $input['connected'] );
		}

		if ( isset( $input['enable_import_tracking'] ) ) {
			if ($input['enable_import_tracking'] == 'on' || $input['enable_import_tracking'] === true || intval($input['enable_import_tracking']) === 1 ) {
				$new_input['enable_import_tracking'] = 1;
			}
		}

		if ( isset( $input['save_notes_to_meta_data'] ) ) {
			if ($input['save_notes_to_meta_data'] == 'on' || $input['save_notes_to_meta_data'] === true || intval($input['save_notes_to_meta_data']) === 1 ) {
				$new_input['save_notes_to_meta_data'] = 1;
			}
		}

		if ( isset( $input['show_orders_actions'] ) ) {
			$new_input['show_orders_actions'] = sanitize_text_field( $input['show_orders_actions'] );
		}

		return $new_input;
	}

	/**
	 * Print the Section text
	 */
	public function print_section_info() {
		// print 'Enter your settings below:';.
	}

	/**
	 * Normalize custom domain.
	 *
	 * @param string $url input url.
	 * @return string
	 */
	public function normalize_custom_domain( $url ) {
		if ( filter_var( $url, FILTER_VALIDATE_URL ) === false ) {
			return $url;

		}
		$domain = parse_url( $url, PHP_URL_HOST );
		return $domain;
	}

	/**
	 * Call this func before shown on pages.
	 */
	public function couriers_callback() {

		$couriers = array();
		if ( isset( $this->options['couriers'] ) ) {
			$couriers = explode( ',', $this->options['couriers'] );
		}
		echo '<div class="auto-as-admin-select-title">Courier</div>';
		echo '<select data-placeholder="Please select couriers" id="' . $this->dom_id_courier_select . '" multiple style="width:100%">';
		echo '</select>';
		echo '<input type="hidden" id="' . $this->dom_id_couriers . '" name="aftership_option_name[couriers]" value="' . implode( ',', $couriers ) . '"/>';
		if ( isset( $this->options['connected'] ) ) {
			echo '<input type="hidden" id="' . $this->dom_aftership_connected . '" name="aftership_option_name[connected]" value="' . $this->options['connected'] . '" />';
		}
	}

	/**
	 * Call this func before shown on pages.
	 */
	public function custom_domain_callback() {
		printf(
			'<div class="auto-as-admin-input-title">Display Tracking Information at Custom Domain</div><input type="text" class="auto-as-admin-input-content" id="custom_domain" name="aftership_option_name[custom_domain]" value="%s" style="width:100%%">',
			isset( $this->options['custom_domain'] ) ? $this->normalize_custom_domain( $this->options['custom_domain'] ) : 'track.aftership.com'
		);
	}

	/**
	 * Call this func before shown on pages.
	 */
	public function enable_import_tracking_callback() {
		printf(
			'<div class="auto-as-admin-checkbox-title">Enable CSV Tracking Import</div><label><input type="checkbox" id="enable_import_tracking" name="aftership_option_name[enable_import_tracking]" %s>Enable</label>',
			( isset( $this->options['enable_import_tracking'] ) && 1 === $this->options['enable_import_tracking'] ) ? 'checked="checked"' : ''
		);
	}

	/**
	 * Call this func before shown on pages.
	 */
	public function save_notes_to_meta_data_callback() {
		printf(
			'<div class="auto-as-admin-checkbox-title">Parse tracking from order notes</div><label><input type="checkbox" id="save_notes_to_meta_data" name="aftership_option_name[save_notes_to_meta_data]" %s>Enable</label>',
			( isset( $this->options['save_notes_to_meta_data'] ) && 1 === $this->options['save_notes_to_meta_data'] ) ? 'checked="checked"' : ''
		);
	}

	/**
	 * Call this func before shown on pages.
	 */
	public function track_button_callback() {
		printf(
			'<div class="auto-as-admin-checkbox-title">Display Track Button at Order History Page</div><label><input type="checkbox" id="use_track_button" name="aftership_option_name[use_track_button]" %s>Use Track Button</label>',
			( isset( $this->options['use_track_button'] ) && true === $this->options['use_track_button'] ) ? 'checked="checked"' : ''
		);
	}

	/**
	 * Call this func before shown on pages.
	 */
	public function show_order_actions_callback() {

		$show_orders_actions = array();
		if ( isset( $this->options['show_orders_actions'] ) ) {
			$show_orders_actions = explode( ',', $this->options['show_orders_actions'] );
		}
		echo '<div class="auto-as-admin-select-title">Add Tracking Order action</div>';
		echo '<select data-placeholder="Please select order status" id="' . $this->dom_id_show_order_actions_select . '" multiple style="width:100%">';
		echo '</select>';
		echo '<input type="hidden" id="' . $this->dom_id_show_order_actions . '" name="aftership_option_name[show_orders_actions]" value="' . implode( ',', $show_orders_actions ) . '"/>';
	}
}


if ( is_admin() ) {
	$aftership_settings = new AfterShip_Settings();
}
