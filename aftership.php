<?php
/*
	Plugin Name: AfterShip - WooCommerce Tracking
	Plugin URI: http://aftership.com/
	Description: Add tracking number and carrier name to WooCommerce, display tracking info at order history page, auto import tracking numbers to AfterShip.
	Version: 1.4.1
	Author: AfterShip
	Author URI: http://aftership.com

	Copyright: © AfterShip
*/

/**
 * Security Note
 */
defined('ABSPATH') or die("No script kiddies please!");

/**
 * Required functions
 */
if (!function_exists('is_woocommerce_active'))
    require_once('aftership-functions.php');


/**
 * Plugin updates
 */

if (is_woocommerce_active()) {

    /**
     * AfterShip class
     */
    if (!class_exists('AfterShip')) {

        final class AfterShip
        {

            protected static $_instance = null;

            public static function instance()
            {
                if (is_null(self::$_instance)) {
                    self::$_instance = new self();
                }
                return self::$_instance;
            }


            /**
             * Constructor
             */
            public function __construct()
            {
                $this->includes();

                $this->api = new AfterShip_API();

                $options = get_option('aftership_option_name');
                if ($options) {

                    if (isset($options['plugin'])) {
                        $plugin = $options['plugin'];
                        if ($plugin == 'aftership') {
                            add_action('admin_print_scripts', array(&$this, 'library_scripts'));
                            add_action('admin_print_styles', array(&$this, 'admin_styles'));
                            add_action('add_meta_boxes', array(&$this, 'add_meta_box'));
                            add_action('woocommerce_process_shop_order_meta', array(&$this, 'save_meta_box'), 0, 2);
                            add_action('plugins_loaded', array($this, 'load_plugin_textdomain'));

                            $this->couriers = $options['couriers'];
                        }

                        // View Order Page
                        $this->plugin = $plugin;
                    } else {
                        $this->plugin = '';
                    }

                    if (isset($options['use_track_button'])) {
                        $this->use_track_button = $options['use_track_button'];
                    } else {
                        $this->use_track_button = false;
                    }

                    add_action('woocommerce_view_order', array(&$this, 'display_tracking_info'));
                    add_action('woocommerce_email_before_order_table', array(&$this, 'email_display'));

                }

                // user profile api key
                add_action('show_user_profile', array($this, 'add_api_key_field'));
                add_action('edit_user_profile', array($this, 'add_api_key_field'));
                add_action('personal_options_update', array($this, 'generate_api_key'));
                add_action('edit_user_profile_update', array($this, 'generate_api_key'));

                register_activation_hook(__FILE__, array($this, 'install'));
            }

            public function install()
            {
                global $wp_roles;

                if (class_exists('WP_Roles')) {
                    if (!isset($wp_roles)) {
                        $wp_roles = new WP_Roles();
                    }
                }

                if (is_object($wp_roles)) {
                    $wp_roles->add_cap('administrator', 'manage_aftership');
                }
            }

            private function includes()
            {
                include_once('aftership-fields.php');
                $this->aftership_fields = $aftership_fields;

                include_once('class-aftership-api.php');
                include_once('class-aftership-settings.php');
            }

            /**
             * Localisation
             */
            public function load_plugin_textdomain()
            {
                load_plugin_textdomain('aftership', false, dirname(plugin_basename(__FILE__)) . '/languages/');
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
                wp_enqueue_script('aftership_script_admin', plugins_url(basename(dirname(__FILE__))) . '/assets/js/admin.js');
                wp_enqueue_script('aftership_script_footer', plugins_url(basename(dirname(__FILE__))) . '/assets/js/footer.js', true);
            }

            /**
             * Add the meta box for shipment info on the order page
             *
             * @access public
             */
            public function add_meta_box()
            {
                add_meta_box('woocommerce-aftership', __('AfterShip', 'wc_aftership'), array(&$this, 'meta_box'), 'shop_order', 'side', 'high');
            }

            /**
             * Show the meta box for shipment info on the order page
             *
             * @access public
             */
            public function meta_box()
            {

                // just draw the layout, no data
                global $post;

                $selected_provider = get_post_meta($post->ID, '_aftership_tracking_provider', true);

                echo '<div id="aftership_wrapper">';

                echo '<p class="form-field"><label for="aftership_tracking_provider">' . __('Carrier:', 'wc_aftership') . '</label><br/><select id="aftership_tracking_provider" name="aftership_tracking_provider" class="chosen_select" style="width:100%">';
                if ($selected_provider == '') {
                    $selected_text = 'selected="selected"';
                } else {
                    $selected_text = '';
                }
                echo '<option disabled ' . $selected_text . ' value="">Please Select</option>';
                echo '</select>';
                echo '<br><a href="options-general.php?page=aftership-setting-admin">Update carrier list</a>';
                echo '<input type="hidden" id="aftership_tracking_provider_hidden" value="' . $selected_provider . '"/>';
                echo '<input type="hidden" id="aftership_couriers_selected" value="' . $this->couriers . '"/>';

                foreach ($this->aftership_fields as $field) {
                    if ($field['type'] == 'date') {
                        woocommerce_wp_text_input(array(
                            'id' => $field['id'],
                            'label' => __($field['label'], 'wc_aftership'),
                            'placeholder' => $field['placeholder'],
                            'description' => $field['description'],
                            'class' => $field['class'],
                            'value' => ($date = get_post_meta($post->ID, '_' . $field['id'], true)) ? date('Y-m-d', $date) : ''
                        ));
                    } else {
                        woocommerce_wp_text_input(array(
                            'id' => $field['id'],
                            'label' => __($field['label'], 'wc_aftership'),
                            'placeholder' => $field['placeholder'],
                            'description' => $field['description'],
                            'class' => $field['class'],
                            'value' => get_post_meta($post->ID, '_' . $field['id'], true),
                        ));
                    }
                }

//
//				woocommerce_wp_text_input(array(
//					'id' => 'aftership_tracking_provider_name',
//					'label' => __('', 'wc_aftership'),
//					'placeholder' => '',
//					'description' => '',
//					'class' => 'hidden',
//					'value' => get_post_meta($post->ID, '_aftership_tracking_provider_name', true),
//				));
//
//				woocommerce_wp_text_input(array(
//					'id' => 'aftership_tracking_required_fields',
//					'label' => __('', 'wc_aftership'),
//					'placeholder' => '',
//					'description' => '',
//					'class' => 'hidden',
//					'value' => get_post_meta($post->ID, '_aftership_tracking_required_fields', true),
//				));
//
//				woocommerce_wp_text_input(array(
//					'id' => 'aftership_tracking_number',
//					'label' => __('Tracking number:', 'wc_aftership'),
//					'placeholder' => '',
//					'description' => '',
//					'value' => get_post_meta($post->ID, '_aftership_tracking_number', true),
//				));
//
//				woocommerce_wp_text_input(array(
//					'id' => 'aftership_tracking_shipdate',
//					'label' => __('Date shipped:', 'wc_aftership'),
//					'placeholder' => 'YYYY-MM-DD',
//					'description' => '',
//					'class' => 'date-picker-field hidden-field',
//					'value' => ($date = get_post_meta($post->ID, '_aftership_tracking_shipdate', true)) ? date('Y-m-d', $date) : ''
//				));
//
//				woocommerce_wp_text_input(array(
//					'id' => 'aftership_tracking_postal',
//					'label' => __('Postal Code:', 'wc_aftership'),
//					'placeholder' => '',
//					'description' => '',
//					'class' => 'hidden-field',
//					'value' => get_post_meta($post->ID, '_aftership_tracking_postal', true),
//				));
//
//				woocommerce_wp_text_input(array(
//					'id' => 'aftership_tracking_account',
//					'label' => __('Account name:', 'wc_aftership'),
//					'placeholder' => '',
//					'description' => '',
//					'class' => 'hidden-field',
//					'value' => get_post_meta($post->ID, '_aftership_tracking_account', true),
//				));
//
//                woocommerce_wp_text_input(array(
//                    'id' => 'aftership_tracking_key',
//                    'label' => __('Tracking key:', 'wc_aftership'),
//                    'placeholder' => '',
//                    'description' => '',
//                    'class' => 'hidden-field',
//                    'value' => get_post_meta($post->ID, '_aftership_tracking_key', true),
//                ));
//
//                woocommerce_wp_text_input(array(
//                    'id' => 'aftership_tracking_destination_country',
//                    'label' => __('Destination Country:', 'wc_aftership'),
//                    'placeholder' => '',
//                    'description' => '',
//                    'class' => 'hidden-field',
//                    'value' => get_post_meta($post->ID, '_aftership_tracking_destination_country', true),
//                ));
                echo '</div>';
            }

            /**
             * Order Downloads Save
             *
             * Function for processing and storing all order downloads.
             */
            public function save_meta_box($post_id, $post)
            {
                if (isset($_POST['aftership_tracking_number'])) {
//
//                    // Download data
                    $tracking_provider = woocommerce_clean($_POST['aftership_tracking_provider']);
//                    $tracking_number = woocommerce_clean($_POST['aftership_tracking_number']);
//                    $tracking_provider_name = woocommerce_clean($_POST['aftership_tracking_provider_name']);
//                    $tracking_required_fields = woocommerce_clean($_POST['aftership_tracking_required_fields']);
//                    $shipdate = woocommerce_clean(strtotime($_POST['aftership_tracking_shipdate']));
//                    $postal = woocommerce_clean($_POST['aftership_tracking_postal']);
//                    $account = woocommerce_clean($_POST['aftership_tracking_account']);
//                    $tracking_key = woocommerce_clean($_POST['aftership_tracking_key']);
//                    $tracking_destination_country = woocommerce_clean($_POST['aftership_tracking_destination_country']);
//
//                    // Update order data
                    update_post_meta($post_id, '_aftership_tracking_provider', $tracking_provider);
//                    update_post_meta($post_id, '_aftership_tracking_number', $tracking_number);
//                    update_post_meta($post_id, '_aftership_tracking_provider_name', $tracking_provider_name);
//                    update_post_meta($post_id, '_aftership_tracking_required_fields', $tracking_required_fields);
//                    update_post_meta($post_id, '_aftership_tracking_shipdate', $shipdate);
//                    update_post_meta($post_id, '_aftership_tracking_postal', $postal);
//                    update_post_meta($post_id, '_aftership_tracking_account', $account);
//                    update_post_meta($post_id, '_aftership_tracking_key', $tracking_key);
//                    update_post_meta($post_id, '_aftership_tracking_destination_country', $tracking_destination_country);


                    foreach ($this->aftership_fields as $field) {
                        if ($field['type'] == 'date') {
                            update_post_meta($post_id, '_' . $field['id'], woocommerce_clean(strtotime($_POST[$field['id']])));
                        } else {
                            update_post_meta($post_id, '_' . $field['id'], woocommerce_clean($_POST[$field['id']]));
                        }
                    }
                }
            }

            /**
             * Display the API key info for a user
             *
             * @since 2.1
             * @param WP_User $user
             */
            public function add_api_key_field($user)
            {

                if (!current_user_can('manage_aftership'))
                    return;

                if (current_user_can('edit_user', $user->ID)) {
                    ?>
                    <h3>AfterShip</h3>
                    <table class="form-table">
                        <tbody>
                        <tr>
                            <th><label
                                    for="aftership_wp_api_key"><?php _e('AfterShip\'s WordPress API Key', 'aftership'); ?></label>
                            </th>
                            <td>
                                <?php if (empty($user->aftership_wp_api_key)) : ?>
                                    <input name="aftership_wp_generate_api_key" type="checkbox"
                                           id="aftership_wp_generate_api_key" value="0"/>
                                    <span class="description"><?php _e('Generate API Key', 'aftership'); ?></span>
                                <?php else : ?>
                                    <code id="aftership_wp_api_key"><?php echo $user->aftership_wp_api_key ?></code>
                                    <br/>
                                    <input name="aftership_wp_generate_api_key" type="checkbox"
                                           id="aftership_wp_generate_api_key" value="0"/>
                                    <span class="description"><?php _e('Revoke API Key', 'aftership'); ?></span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                <?php
                }
            }

            /**
             * Generate and save (or delete) the API keys for a user
             *
             * @since 2.1
             * @param int $user_id
             */
            public function generate_api_key($user_id)
            {

                if (current_user_can('edit_user', $user_id)) {

                    $user = get_userdata($user_id);

                    // creating/deleting key
                    if (isset($_POST['aftership_wp_generate_api_key'])) {

                        // consumer key
                        if (empty($user->aftership_wp_api_key)) {

                            $api_key = 'ck_' . hash('md5', $user->user_login . date('U') . mt_rand());

                            update_user_meta($user_id, 'aftership_wp_api_key', $api_key);

                        } else {

                            delete_user_meta($user_id, 'aftership_wp_api_key');
                        }

                    }
                }
            }

            /**
             * Display Shipment info in the frontend (order view/tracking page).
             *
             * @access public
             */
            function display_tracking_info($order_id, $for_email = false)
            {
                if ($this->plugin == 'aftership') {
                    $this->display_order_aftership($order_id, $for_email);
                } else if ($this->plugin == 'wc-shipment-tracking') { //$49
                    $this->display_order_wc_shipment_tracking($order_id, $for_email);
                }
            }

            private function display_order_aftership($order_id, $for_email)
            {

//                print_r($this->aftership_fields);
                $values = array();
                foreach ($this->aftership_fields as $field) {
                    $values[$field['id']] = get_post_meta($order_id, '_' . $field['id'], true);
                    if ($field['type'] == 'date' && $values[$field['id']]) {
                        $values[$field['id']] = date_i18n(__('l jS F Y', 'wc_shipment_tracking'), $values[$field['id']]);
                    }
                }
                $values['aftership_tracking_provider'] = get_post_meta($order_id, '_aftership_tracking_provider', true);

                if (!$values['aftership_tracking_provider'])
                    return;

                if (!$values['aftership_tracking_number'])
                    return;


                $options = get_option('aftership_option_name');
                if (array_key_exists('track_message_1', $options) && array_key_exists('track_message_2', $options)) {
                    $track_message_1 = $options['track_message_1'];
                    $track_message_2 = $options['track_message_2'];
                } else {
                    $track_message_1 = 'Your order was shipped via ';
                    $track_message_2 = 'Tracking number is ';
                }

                $required_fields_values = array();
                $provider_required_fields = explode(",", $values['aftership_tracking_required_fields']);
                foreach ($provider_required_fields as $field) {
                    foreach ($this->aftership_fields as $aftership_field) {
                        if (array_key_exists('key', $aftership_field) && $field == $aftership_field['key']) {
                            array_push($required_fields_values, $values[$aftership_field['id']]);
                        }
                    }
                }

                if (count($required_fields_values)) {
                    $required_fields_msg = ' (' . join(', ', $required_fields_values) . ')';
                } else {
                    $required_fields_msg = '';
                }


                echo $track_message_1 . $values['aftership_tracking_provider_name'] . '<br/>' . $track_message_2 . $values['aftership_tracking_number'] . $required_fields_msg;

                if (!$for_email && $this->use_track_button) {
                    $this->display_track_button($values['aftership_tracking_provider'], $values['aftership_tracking_number']);
                }

                //-------------------------------------------------------------------------------------
                /*
                                $tracking_provider = get_post_meta($order_id, '_aftership_tracking_provider', true);
                                $tracking_number = get_post_meta($order_id, '_aftership_tracking_number', true);
                                $tracking_provider_name = get_post_meta($order_id, '_aftership_tracking_provider_name', true);
                                $tracking_required_fields = get_post_meta($order_id, '_aftership_tracking_required_fields', true);
                                $date_shipped = get_post_meta($order_id, '_aftership_tracking_shipdate', true);
                                $postcode = get_post_meta($order_id, '_aftership_tracking_postal', true);
                                $account = get_post_meta($order_id, '_aftership_tracking_account', true);

                                if (!$tracking_provider)
                                    return;

                                if (!$tracking_number)
                                    return;

                                $provider_name = $tracking_provider_name;
                                $provider_required_fields = explode(",", $tracking_required_fields);

                                $date_shipped_str = '';
                                $postcode_str = '';
                                $account_str = '';

                                foreach ($provider_required_fields as $field) {
                                    if ($field == 'tracking_ship_date') {
                                        if ($date_shipped) {
                                            $date_shipped_str = '&nbsp;' . sprintf(__('on %s', 'wc_shipment_tracking'), date_i18n(__('l jS F Y', 'wc_shipment_tracking'), $date_shipped));
                                        }
                                    } else if ($field == 'tracking_postal_code') {
                                        if ($postcode) {
                                            $postcode_str = '&nbsp;' . sprintf('The postal code is %s.', $postcode);
                                        }
                                    } else if ($field == 'tracking_account_number') {
                                        if ($account) {
                                            $account_str = '&nbsp;' . sprintf('The account is %s.', $account);
                                        }
                                    }
                                }

                                $provider_name = '&nbsp;' . __('via', 'wc_shipment_tracking') . ' <strong>' . $provider_name . '</strong>';

                                echo wpautop(sprintf(__('Your order was shipped%s%s. Tracking number is %s.%s%s', 'wc_shipment_tracking'), $date_shipped_str, $provider_name, $tracking_number, $postcode_str, $account_str));

                                if (!$for_email && $this->use_track_button) {
                                    $this->display_track_button($tracking_provider, $tracking_number);
                                }
                */

            }

            private function display_order_wc_shipment_tracking($order_id, $for_email)
            {
                if ($for_email || !$this->use_track_button) {
                    return;
                }

                $tracking = get_post_meta($order_id, '_tracking_number', true);
                $sharp = strpos($tracking, '#');
                $colon = strpos($tracking, ':');
                if ($sharp && $colon && $sharp >= $colon) {
                    return;
                } else if (!$sharp && $colon) {
                    return;
                } else if ($sharp) {
                    $tracking_provider = substr($tracking, 0, $sharp);
                    if ($colon) {
                        $tracking_number = substr($tracking, $sharp + 1, $colon - $sharp - 1);
                    } else {
                        $tracking_number = substr($tracking, $sharp + 1, strlen($tracking));
                    }
                } else {
                    $tracking_provider = '';
                    $tracking_number = $tracking;
                }
                if ($tracking_number) {
                    $this->display_track_button($tracking_provider, $tracking_number);
                }
            }

            /**
             * Display shipment info in customer emails.
             *
             * @access public
             * @return void
             */
            function email_display($order)
            {
                $this->display_tracking_info($order->id, true);
            }

            private function display_track_button($tracking_provider, $tracking_number)
            {

                $js = '(function(e,t,n){var r,i=e.getElementsByTagName(t)[0];if(e.getElementById(n))return;r=e.createElement(t);r.id=n;r.src="//apps.aftership.com/all.js";i.parentNode.insertBefore(r,i)})(document,"script","aftership-jssdk")';
                if (function_exists('wc_enqueue_js')) {
                    wc_enqueue_js($js);
                } else {
                    global $woocommerce;
                    $woocommerce->add_inline_js($js);
                }

                $track_button = '<div id="as-root"></div><div class="as-track-button" data-slug="' . $tracking_provider . '" data-tracking-number="' . $tracking_number . '" data-support="true" data-width="400" data-size="normal" data-hide-tracking-number="true"></div>';
                echo wpautop(sprintf('%s', $track_button));
                echo "<br><br>";
            }
        }

        if (!function_exists('getAfterShipInstance')) {
            function getAfterShipInstance()
            {
                return AfterShip::Instance();
            }
        }
    }

    /**
     * Register this class globally
     */
    $GLOBALS['aftership'] = getAfterShipInstance();

}
