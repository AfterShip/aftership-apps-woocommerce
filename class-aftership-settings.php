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

if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Required functions
 */
if (!class_exists('AfterShip_Dependencies'))
    require_once 'class-aftership-dependencies.php';

class AfterShip_Settings
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    private $plugins;

    /**
     * Start up
     */
    public function __construct()
    {
        $this->plugins[] = array(
            'value' => 'aftership',
            'label' => 'AfterShip',
            'path' => 'aftership-woocommerce-tracking/aftership.php'
        );
        $this->plugins[] = array(
            'value' => 'wc-shipment-tracking',
            'label' => 'WooCommerce Shipment Tracking',
            'path' => 'woocommerce-shipment-tracking/shipment-tracking.php'
        );

        add_action('admin_menu', array($this, 'add_plugin_page'));
        add_action('admin_init', array($this, 'page_init'));
        add_action('admin_print_styles', array($this, 'admin_styles'));
        add_action('admin_print_scripts', array(&$this, 'library_scripts'));
    }


    public function admin_styles()
    {
        wp_enqueue_style('aftership_styles_chosen', plugins_url(basename(dirname(__FILE__))) . '/assets/plugin/chosen/chosen.min.css');
        wp_enqueue_style('aftership_styles', plugins_url(basename(dirname(__FILE__))) . '/assets/css/admin.css');
    }

    public function library_scripts()
    {
        wp_enqueue_script('aftership_styles_chosen_jquery', plugins_url(basename(dirname(__FILE__))) . '/assets/plugin/chosen/chosen.jquery.min.js');
        wp_enqueue_script('aftership_styles_chosen_proto', plugins_url(basename(dirname(__FILE__))) . '/assets/plugin/chosen/chosen.proto.min.js');
        wp_enqueue_script('aftership_script_util', plugins_url(basename(dirname(__FILE__))) . '/assets/js/util.js');
        wp_enqueue_script('aftership_script_couriers', plugins_url(basename(dirname(__FILE__))) . '/assets/js/couriers.js');
        wp_enqueue_script('aftership_script_setting', plugins_url(basename(dirname(__FILE__))) . '/assets/js/setting.js');
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'AfterShip Settings Admin',
            'AfterShip',
            'manage_options',
            'aftership-setting-admin',
            array($this, 'create_admin_page')
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option('aftership_option_name');
        ?>
        <div class="wrap">
            <?php screen_icon(); ?>
            <h2>AfterShip Settings</h2>

            <form method="post" action="options.php">
                <?php
                // This prints out all hidden setting fields
                settings_fields('aftership_option_group');
                do_settings_sections('aftership-setting-admin');
                submit_button();
                ?>
            </form>
        </div>
    <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {
        register_setting(
            'aftership_option_group', // Option group
            'aftership_option_name', // Option name
            array($this, 'sanitize') // Sanitize
        );

        add_settings_section(
            'aftership_setting_section_id', // ID
            '', // Title
            array($this, 'print_section_info'), // Callback
            'aftership-setting-admin' // Page
        );

        add_settings_field(
            'plugin',
            'Plugin',
            array($this, 'plugin_callback'),
            'aftership-setting-admin',
            'aftership_setting_section_id'
        );

        add_settings_field(
            'couriers',
            'Couriers',
            array($this, 'couriers_callback'),
            'aftership-setting-admin',
            'aftership_setting_section_id'
        );

        add_settings_field(
            'use_track_button',
            'Display Track Button at Order History Page',
            array($this, 'track_button_callback'),
            'aftership-setting-admin',
            'aftership_setting_section_id'
        );

        add_settings_field(
            'track_message',
            'Content',
            array($this, 'track_message_callback'),
            'aftership-setting-admin',
            'aftership_setting_section_id'
        );
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize($input)
    {
        $new_input = array();

        if (isset($input['couriers'])) {
            $new_input['couriers'] = sanitize_text_field($input['couriers']);
        }

        if (isset($input['plugin'])) {
            $new_input['plugin'] = sanitize_text_field($input['plugin']);
        }

        if (isset($input['track_message_1'])) {
            $postfix = '';
            if (substr($input['track_message_1'], -1) == ' ') {
                $postfix = ' ';
            }
            $new_input['track_message_1'] = sanitize_text_field($input['track_message_1']) . $postfix;
        }

        if (isset($input['track_message_2'])) {
            $postfix = '';
            if (substr($input['track_message_2'], -1) == ' ') {
                $postfix = ' ';
            }
            $new_input['track_message_2'] = sanitize_text_field($input['track_message_2']) . $postfix;
        }

        if (isset($input['use_track_button'])) {
            $new_input['use_track_button'] = true;
        }

        return $new_input;
    }

    /**
     * Print the Section text
     */
    public function print_section_info()
    {
        //print 'Enter your settings below:';
    }

    public function couriers_callback()
    {

        $couriers = array();
        if (isset($this->options['couriers'])) {
            $couriers = explode(',', $this->options['couriers']);
        }

//		print_r($couriers);
        echo '<select data-placeholder="Please select couriers" id="couriers_select" class="chosen-select " multiple style="width:100%">';
        echo '</select>';
//		echo '<br><a href="https://www.aftership.com/settings/courier" target="_blank">Update carrier list</a>';
        echo '<input type="hidden" id="couriers" name="aftership_option_name[couriers]" value="' . implode(",", $couriers) . '"/>';

    }

    public function plugin_callback()
    {

        $options = "";
        foreach ($this->plugins as $plugin) {
            //print_r($plugin);
            if (AfterShip_Dependencies::plugin_active_check($plugin['path'])) {
                $option = '<option value="' . $plugin['value'] . '"';

                if (isset($this->options['plugin']) && esc_attr($this->options['plugin']) == $plugin['value']) {
                    $option .= ' selected="selected"';
                }

                $option .= '>' . $plugin['label'] . '</option>';
                $options .= $option;
            }
        }

        printf(
            '<select id="plugin" name="aftership_option_name[plugin]" class="aftership_dropdown">' . $options . '</select>'
        );
    }

    public function track_message_callback()
    {
        printf(
            '<input type="text" id="track_message_1" name="aftership_option_name[track_message_1]" value="%s" style="width:100%%">',
            isset($this->options['track_message_1']) ? $this->options['track_message_1'] : 'Your order was shipped via '
        );
        printf('<br/>');
        printf(
            '<input type="text" id="track_message_2" name="aftership_option_name[track_message_2]" value="%s" style="width:100%%">',
            isset($this->options['track_message_2']) ? $this->options['track_message_2'] : 'Tracking number is '
        );
        printf('<br/>');
        printf('<br/>');
        printf('<b>Demo:</b>');
        printf(
            '<div id="track_message_demo_1" style="width:100%%"></div>'
        );
    }

    public function track_button_callback()
    {
        printf(
            '<label><input type="checkbox" id="use_track_button" name="aftership_option_name[use_track_button]" %s>Use Track Button</label>',
            (isset($this->options['use_track_button']) && $this->options['use_track_button'] === true) ? 'checked="checked"' : ''
        );
    }
}


if (is_admin())
    $aftership_settings = new AfterShip_Settings();