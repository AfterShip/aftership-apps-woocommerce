jQuery(function ($) {

	var aftership_items = {

		// init Class
		init: function () {
			$('#woocommerce-aftership')
				.on('click', 'a.delete-tracking', this.delete_tracking)
				.on('click', 'button.button-show-form', this.show_form)
				.on('click', 'button.button-save-form', this.save_form);
		},

		// When a user enters a new tracking item
		save_form: function () {

			if (!$('input#aftership_tracking_number').val()) {
				return false;
			}

			$('#shipment-tracking-form').block({
				message: null,
				overlayCSS: {
					background: '#fff',
					opacity: 0.6
				}
			});

			var data = {
				action: 'aftership_save_form',
				order_id: woocommerce_admin_meta_boxes.post_id,
				aftership_tracking_slug: $('#aftership-tracking-slug').val(),
				aftership_tracking_number: $('input#aftership_tracking_number').val(),
				aftership_tracking_account_number: $('input#aftership_tracking_account_number').val(),
				aftership_tracking_key: $('input#aftership_tracking_key').val(),
				aftership_tracking_postal_code: $('input#aftership_tracking_postal_code').val(),
				aftership_tracking_ship_date: $('input#aftership_tracking_ship_date').val(),
				aftership_tracking_destination_country: $('input#aftership_tracking_destination_country').val(),
				aftership_tracking_state: $('input#aftership_tracking_state').val(),
				security: $('#aftership_create_nonce').val()
			};


			$.post(woocommerce_admin_meta_boxes.ajax_url, data, function (response) {
				$('#shipment-tracking-form').unblock();
				if (response != '-1') {
					$('#shipment-tracking-form').hide();
					$('#woocommerce-aftership #tracking-items').append(response);
					$('#woocommerce-aftership button.button-show-form').show();
					$('#aftership-tracking-slug').selectedIndex = 0;
					$('input#aftership_tracking_number').val('');
					$('input#aftership_tracking_account_number').val('');
					$('input#aftership_tracking_key').val('');
					$('input#aftership_tracking_postal_code').val('');
					$('input#aftership_tracking_ship_date').val('');
					$('input#aftership_tracking_destination_country').val('');
					$('input#aftership_tracking_state').val('');
				}
			});

			return false;
		},

		// Show the new tracking item form
		show_form: function () {
			$('#shipment-tracking-form').show();
			$('#woocommerce-aftership button.button-show-form').hide();
		},

		// Delete a tracking item
		delete_tracking: function () {

			var tracking_id = $(this).attr('rel');

			$('#tracking-item-' + tracking_id).block({
				message: null,
				overlayCSS: {
					background: '#fff',
					opacity: 0.6
				}
			});

			var data = {
				action: 'aftership_delete_item',
				order_id: woocommerce_admin_meta_boxes.post_id,
				tracking_id: tracking_id,
				security: $('#aftership_delete_nonce').val()
			};

			$.post(woocommerce_admin_meta_boxes.ajax_url, data, function (response) {
				$('#tracking-item-' + tracking_id).unblock();
				if (response != '-1') {
					$('#tracking-item-' + tracking_id).remove();
				}
			});

			return false;
		},

		refresh_items: function () {
			var data = {
				action: 'aftership_get_items',
				order_id: woocommerce_admin_meta_boxes.post_id,
				security: $('#aftership_get_nonce').val()
			};

			$('#woocommerce-aftership').block({
				message: null,
				overlayCSS: {
					background: '#fff',
					opacity: 0.6
				}
			});

			$.post(woocommerce_admin_meta_boxes.ajax_url, data, function (response) {
				$('#woocommerce-aftership').unblock();
				if (response != '-1') {
					$('#woocommerce-aftership #tracking-items').html(response);
				}
			});
		},
	}

	aftership_items.init();

	window.aftership_items_refresh = aftership_items.refresh_items;
});
