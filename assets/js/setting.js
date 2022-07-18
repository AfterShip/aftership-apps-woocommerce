jQuery(function () {
    // Couriers selection
	var aftership_couriers_select = jQuery('#aftership_couriers_select');
	var aftership_couriers = jQuery('#aftership_couriers');
    function set_aftership_tracking_provider(selected_couriers) {
        var couriers = sort_couriers(get_aftership_couriers());
        jQuery.each(couriers, function (key, courier) {
            var str = '<option ';
            str += 'value="' + courier['slug'] + '" ';
            if (selected_couriers.hasOwnProperty(courier['slug'])) {
                str += 'selected="selected"';
            }
            str += '>' + courier['name'] + '</option>';
			aftership_couriers_select.append(str);
        });

		aftership_couriers_select.val(selected_couriers);
		aftership_couriers_select.chosen();
		aftership_couriers_select.trigger('chosen:updated');
    }

	aftership_couriers_select.change(function () {
        var couriers_select = aftership_couriers_select.val();
        var value = (couriers_select) ? couriers_select.join(',') : '';
		aftership_couriers.val(value);
    });

    if (aftership_couriers) {
        var couriers_select = aftership_couriers.val();
        var couriers_select_array = (couriers_select) ? couriers_select.split(',') : [];
        set_aftership_tracking_provider(couriers_select_array);
    }

    // Add Tracking Order action selection
    var aftership_show_order_actions_select = jQuery('#aftership_show_order_actions_select');
    var aftership_show_order_actions = jQuery('#aftership_show_order_actions');
    function set_aftership_show_order_actions(selected_status) {
        var show_order_status = get_aftership_show_order_status();
        jQuery.each(show_order_status, function (key, status) {
            var str = '<option ';
            str += 'value="' + status['status'] + '" ';
            if (selected_status.hasOwnProperty(status['status'])) {
                str += 'selected="selected"';
            }
            str += '>' + status['name'] + '</option>';
            aftership_show_order_actions_select.append(str);
        });

        aftership_show_order_actions_select.val(selected_status);
        aftership_show_order_actions_select.chosen();
        aftership_show_order_actions_select.trigger('chosen:updated');
    }

    aftership_show_order_actions_select.change(function () {
        var order_actions_select = aftership_show_order_actions_select.val();
        var value = (order_actions_select) ? order_actions_select.join(',') : '';
        aftership_show_order_actions.val(value);
    });

    if (aftership_show_order_actions) {
        var order_actions_select = aftership_show_order_actions.val();
        var order_actions_select_array = (order_actions_select) ? order_actions_select.split(',') : [];
        set_aftership_show_order_actions(order_actions_select_array);
    }
});
