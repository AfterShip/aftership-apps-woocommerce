jQuery(function ($) {

	var aftership_items = {

		// init Class
		init: function () {
			$('#woocommerce-aftership')
				.on('click', 'a.delete-tracking', this.delete_tracking)
				.on('click', 'a.edit-tracking', this.edit_tracking)
				.on('click', 'button.button-show-form', this.show_form)
				.on('click', 'button.button-save-form', this.save_form);
		},

		// When a user enters a new tracking item
		save_form: function () {

			if (!$('input#aftership_tracking_number').val()) {
				return false;
			}

			if ($('#woocommerce-aftership div.tracking-item').length > 999) {
				$('#aftership-tracking-form').block({
					message: "Tracking items more than 999 !",
					overlayCSS: {
						background: '#fff',
						opacity: 0.6,
					}
				});
				setTimeout($('#aftership-tracking-form').unblock(), 2000);
				return false;
			}
			var exist = false;

			$('#woocommerce-aftership div.tracking-item').each(function () {
				var slug = $('#aftership_tracking_slug').val();
				var tracking_number = $('input#aftership_tracking_number').val();
				if ($(this).data('tracking') === tracking_number && $(this).data('slug') === slug ) {
					exist = true;
				}
			});

			if (exist) {
				$('#aftership-tracking-form').block({
					message: "Tracking already added !",
					overlayCSS: {
						background: '#fff',
						opacity: 0.6,
					}
				});
				setTimeout($('#aftership-tracking-form').unblock(), 2000);
				return false;
			}

			$('#aftership-tracking-form').block({
				message: null,
				overlayCSS: {
					background: '#fff',
					opacity: 0.6
				}
			});

			var data = {
				action: 'aftership_save_form',
				order_id: woocommerce_admin_meta_boxes.post_id,
				aftership_tracking_slug: $('#aftership_tracking_slug').val(),
				aftership_tracking_number: $('input#aftership_tracking_number').val(),
				aftership_tracking_id: $('input#aftership_tracking_id').val(),
				aftership_tracking_account_number: $('input#aftership_tracking_account_number').val(),
				aftership_tracking_key: $('input#aftership_tracking_key').val(),
				aftership_tracking_postal_code: $('input#aftership_tracking_postal_code').val(),
				aftership_tracking_ship_date: $('input#aftership_tracking_ship_date').val(),
				aftership_tracking_destination_country: $('input#aftership_tracking_destination_country').val(),
				aftership_tracking_state: $('input#aftership_tracking_state').val(),
				security: $('#aftership_create_nonce').val()
			};


			$.post(woocommerce_admin_meta_boxes.ajax_url, data, function (response) {
				$('#aftership-tracking-form').unblock();
				if (response != '-1') {
					$('#aftership-tracking-form').hide();
					$('#woocommerce-aftership #tracking-items').append(response);
					$('#woocommerce-aftership button.button-show-form').show();
					$('#aftership_tracking_slug').selectedIndex = 0;
					$('input#aftership_tracking_number').val('');
					$('input#aftership_tracking_id').val('');
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
			$('#aftership-tracking-form').show();
			$('#woocommerce-aftership button.button-show-form').hide();
		},

		// Delete a tracking item
		edit_tracking: function () {

			var tracking_id = $(this).attr('rel');

			$('#woocommerce-aftership').block({
				message: null,
				overlayCSS: {
					background: '#fff',
					opacity: 0.6
				}
			});

			var data = {
				action: 'aftership_get_item',
				order_id: woocommerce_admin_meta_boxes.post_id,
				tracking_id: tracking_id,
				security: $('#aftership_get_nonce').val()
			};

			$.post(woocommerce_admin_meta_boxes.ajax_url, data, function (response) {
				$('#woocommerce-aftership').unblock();
				$('#tracking-item-' + tracking_id).remove();
				$('#woocommerce-aftership button.button-show-form').hide();
				$('#aftership-tracking-form').show();
				if(!response.tracking_id) return;
				$('p.aftership_tracking_key_field').hide();
				$('p.aftership_tracking_account_number_field').hide();
				$('p.aftership_tracking_postal_code_field').hide();
				$('p.aftership_tracking_ship_date_field').hide();
				$('p.aftership_tracking_destination_country_field').hide();
				$('p.aftership_tracking_state_field').hide();
				var required_fields_mapping = {
					tracking_key: 'aftership_tracking_key',
					tracking_account_number: 'aftership_tracking_account_number',
					tracking_postal_code: 'aftership_tracking_postal_code',
					tracking_ship_date: 'aftership_tracking_ship_date',
					tracking_destination_country: 'aftership_tracking_destination_country',
					tracking_state: 'aftership_tracking_state',
				};
				var additional_fields_mapping = {
					tracking_key: 'key',
					tracking_account_number: 'account_number',
					tracking_postal_code: 'postal_code',
					tracking_ship_date: 'ship_date',
					tracking_destination_country: 'destination_country',
					tracking_state: 'state',
				};
				$('#aftership_tracking_slug').val(response.slug).change();
				$('input#aftership_tracking_number').val(response.tracking_number);
				$('input#aftership_tracking_id').val(tracking_id);
				var required_fields = response.courier.required_fields;
				for (var field of required_fields) {
					var field_name = required_fields_mapping[field];
					$('p.' + field_name + '_field').show();
					var additional_field_name = additional_fields_mapping[field];
					var field_value = response.additional_fields[additional_field_name];
					$('input#' + field_name).val(field_value);
				}
			});

			return false;
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
