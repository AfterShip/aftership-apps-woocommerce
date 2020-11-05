<?php
/**
 * AfterShip API
 *
 * Handles parsing JSON request bodies and generating JSON responses
 *
 * @author      AfterShip
 * @category    API
 * @package     AfterShip/API
 * @since       1.0
 */

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

class AfterShip_API_Common_JSON_Handler implements AfterShip_API_Handler
{
    /**
     * Get the content type for the response
     *
     * @return string
     * @since 2.1
     */
    public function get_content_type()
    {
        return 'application/json; charset=' . get_option('blog_charset');
    }

    /**
     * Parse the raw request body entity
     *
     * @param string $body the raw request body
     *
     * @return array|mixed
     * @since 2.1
     *
     */
    public function parse_body($body)
    {
        return json_decode($body, true);
    }

    /**
     * Generate a JSON response given an array of data
     *
     * @param array $data the response data
     *
     * @return string
     * @since 2.1
     *
     */
    public function generate_response($data)
    {
        if (isset($_GET['_jsonp'])) {
            // JSONP enabled by default
            if (!apply_filters('aftership_api_jsonp_enabled', true)) {

                WC()->api->server->send_status(400);

                $data = [
                    [
                        'code' => 'aftership_api_jsonp_disabled',
                        'message' => __('JSONP support is disabled on this site', 'aftership')
                    ]
                ];
            }

            // Check for invalid characters (only alphanumeric allowed)
            if (preg_match('/\W/', $_GET['_jsonp'])) {

                WC()->api->server->send_status(400);

                $data = [
                    [
                        'code' => 'aftership_api_jsonp_callback_invalid',
                        __('The JSONP callback function is invalid', 'aftership')
                    ]
                ];
            }

            return $_GET['_jsonp'] . '(' . json_encode($data) . ')';
        }

        $ok = [
            'meta' => [
                'code' => 20000,
                'type' => 'OK',
                'message' => 'Everything worked as expected'
            ],
            'data' => $data
        ];

        if (isset($data['errors'])) {
            $error = [
                'meta' => [
                    'code' => $this->map_error_code($data['errors'][0]['code']),
                    'type' => $data['errors'][0]['code'],
                    'message' => $data['errors'][0]['message'],

                ],
                'data' => '{}'
            ];
            return json_encode($error);
        }


        return json_encode($ok);
    }

    /**
     * get error code by error message
     * @param $code_text
     * @return int
     */
    private function map_error_code($code_text)
    {
        $code = 40010;
        switch ($code_text) {
            case 'aftership_api_disabled':
                $code = 400011;
                break;
            default:
                break;
        }

        return $code;
    }
}
