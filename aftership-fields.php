<?php
/**
 * Created by PhpStorm.
 * User: Sunny Chow
 * Date: 4/2/15
 * Time: 6:08 PM
 */

$aftership_fields = array(
    'aftership_tracking_provider_name' => array(
        'id' => 'aftership_tracking_provider_name',
        'type' => 'text',
        'label' => '',
        'placeholder' => '',
        'description' => '',
        'class' => 'hidden'
    ),

    'aftership_tracking_required_fields' => array(
        'id' => 'aftership_tracking_required_fields',
        'type' => 'text',
        'label' => '',
        'placeholder' => '',
        'description' => '',
        'class' => 'hidden'
    ),

    'aftership_tracking_number' => array(
        'id' => 'aftership_tracking_number',
        'type' => 'text',
        'label' => 'Tracking number',
        'placeholder' => '',
        'description' => '',
        'class' => ''
    ),

    'aftership_tracking_shipdate' => array(
        'key' => 'tracking_ship_date',
        'id' => 'aftership_tracking_shipdate',
        'type' => 'date',
        'label' => 'Date shipped',
        'placeholder' => 'YYYY-MM-DD',
        'description' => '',
        'class' => 'date-picker-field hidden-field'
    ),

    'aftership_tracking_postal' => array(
        'key' => 'tracking_postal_code',
        'id' => 'aftership_tracking_postal',
        'type' => 'text',
        'label' => 'Postal Code',
        'placeholder' => '',
        'description' => '',
        'class' => 'hidden-field'
    ),

    'aftership_tracking_account' => array(
        'key' => 'tracking_account_number',
        'id' => 'aftership_tracking_account',
        'type' => 'text',
        'label' => 'Account name',
        'placeholder' => '',
        'description' => '',
        'class' => 'hidden-field'
    ),

    'aftership_tracking_key' => array(
        'key' => 'tracking_key',
        'id' => 'aftership_tracking_key',
        'type' => 'text',
        'label' => 'Tracking key',
        'placeholder' => '',
        'description' => '',
        'class' => 'hidden-field'
    ),

    'aftership_tracking_destination_country' => array(
        'key' => 'tracking_destination_country',
        'id' => 'aftership_tracking_destination_country',
        'type' => 'text',
        'label' => 'Destination Country',
        'placeholder' => '',
        'description' => '',
        'class' => 'hidden-field'
    )
);
