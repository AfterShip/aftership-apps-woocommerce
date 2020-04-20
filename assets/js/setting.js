jQuery(function () {
    function set_aftership_tracking_provider(selected_couriers) {
        var couriers = sort_couriers(get_couriers());

//		console.log(couriers);

        jQuery.each(couriers, function (key, courier) {
//			console.log(courier.name);
            var str = '<option ';
            str += 'value="' + courier['slug'] + '" ';
            if (selected_couriers.hasOwnProperty(courier['slug'])) {
                str += 'selected="selected"';
            }
            str += '>' + courier['name'] + '</option>';
            jQuery('#couriers_select').append(str);
        });

        jQuery('#couriers_select').val(selected_couriers);
        jQuery('#couriers_select').chosen();
	    jQuery('#couriers_select').trigger('chosen:updated');
    }

    function set_track_message_demo(){
        jQuery('#track_message_demo_1').html(
            '<H2 style="FONT-SIZE: 18px; FONT-FAMILY: \'Helvetica Neue\', Helvetica, Roboto, Arial, sans-serif; FONT-WEIGHT: bold; COLOR: #557da1; TEXT-ALIGN: left; MARGIN: 0px 0px 18px; DISPLAY: block; LINE-HEIGHT: 130%">Tracking Information</H2>' +
            '<section><table class="shop_table shop_table_responsive yqtrack_tracking" style="width: 100%; border-collapse: collapse;">' +
            '<thead><tr><th style="text-align: center; font-family: \'Helvetica Neue\', Helvetica, Roboto, Arial, sans-serif; font-size: px; color: #737373; border: 1px solid #e4e4e4; padding: 12px;">' +
            jQuery('#track_message_1').val() + '</th><th style="text-align: center; font-family: \'Helvetica Neue\', Helvetica, Roboto, Arial, sans-serif; font-size: px; color: #737373; border: 1px solid #e4e4e4; padding: 12px;">' +
            jQuery('#track_message_2').val() + '</th><th style="text-align: center; font-family: \'Helvetica Neue\', Helvetica, Roboto, Arial, sans-serif; font-size: px; color: #737373; border: 1px solid #e4e4e4; padding: 12px;">' +
            '</th></tr></thead><tbody><tr><td style="font-family: \'Helvetica Neue\', Helvetica, Roboto, Arial, sans-serif; font-size: px; color: #737373; border: 1px solid #e4e4e4; padding: 12px; text-align: center;">' +
            'UPS' + '</td><td style="font-family: \'Helvetica Neue\', Helvetica, Roboto, Arial, sans-serif; font-size: px; color: #737373; border: 1px solid #e4e4e4; padding: 12px; text-align: center;">' +
            '123123123123' + '</td><td style="font-family: \'Helvetica Neue\', Helvetica, Roboto, Arial, sans-serif; font-size: px; color: #737373; border: 1px solid #e4e4e4; padding: 12px; text-align: center;">' +
            '<a href="'+jQuery('#custom_domain').val()+'/'+'123123123123'+'" target="_blank" class="button" style="color: #557da1; font-weight: normal; text-decoration: underline;">Track on Aftership</a><br>or<br>' +
            '<a href="https://t.17track.net#nums='+'123123123123'+'&amp;fc=09061" target="_blank" class="button" style="color: #557da1; font-weight: normal; text-decoration: underline;">Track on 17Track</a></td></tr></tbody></table></section><br>'+
        );
    }

    jQuery('#couriers_select').change(function () {
        var couriers_select = jQuery('#couriers_select').val();
        var value = (couriers_select) ? couriers_select.join(',') : '';
        jQuery('#couriers').val(value);
    });

    jQuery('#plugin').change(function () {
        if (jQuery(this).val() == 'aftership') {
            jQuery('#couriers').parent().parent().show();
            jQuery('#track_message_demo_1').parent().parent().show();
        } else {
            jQuery('#couriers').parent().parent().hide();
            jQuery('#track_message_demo_1').parent().parent().hide();
        }
    });

    if (jQuery('#couriers')) {
        var couriers_select = jQuery('#couriers').val();
        var couriers_select_array = (couriers_select) ? couriers_select.split(',') : [];
        set_aftership_tracking_provider(couriers_select_array);

        if (jQuery('#plugin').val() != 'aftership') {
            jQuery('#couriers').parent().parent().hide();
        }
    }

    if (jQuery('#track_message_demo_1')) {
        set_track_message_demo();

        if (jQuery('#plugin').val() != 'aftership') {
            jQuery('#track_message_demo_1').parent().parent().hide();
        }
    }

    jQuery('#track_message_1').keyup(function () {
        set_track_message_demo();
    });

    jQuery('#track_message_2').keyup(function () {
        set_track_message_demo();
    });
});
