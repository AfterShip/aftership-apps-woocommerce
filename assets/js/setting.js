jQuery(function () {
	var aftership_couriers_select = jQuery('#aftership_couriers_select');
	var aftership_couriers = jQuery('#aftership_couriers');
    function set_aftership_tracking_provider(selected_couriers) {
        var couriers = sort_couriers(get_couriers());
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
});