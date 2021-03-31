jQuery(function ($) {

	var aftership_items = {

		// init Class
		init: function () {
			$('#woocommerce-aftership')
				.on('click', 'a.delete-tracking', this.delete_tracking)
				.on('click', 'a.edit-tracking', this.edit_tracking)
				.on('click', 'button.button-show-form', this.show_form)
				.on('click', 'button.button-save-form', this.save_form)
				.on('click', 'button.button-cancel', this.cancel_form)
				.on('input','p input:visible', this.handle_input_change)
				.on('change', 'select', this.handle_input_change)
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
				// convert to string
				// unexpected： data-tracking="123" => typeof data('tracking') output number
				if ($(this).data('tracking')+'' === tracking_number && $(this).data('slug')+'' === slug ) {
					exist = true;
					return false;
				}
			});

			if (exist) {
				aftership_items.show_error()
				return false;
			}

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
					$('#woocommerce-aftership .show-form-btn-container').show();
					aftership_items.reset_form();
					aftership_items.refresh_items();
				}
			});

			return false;
		},

		// Show the new tracking item form
		show_form: function () {
			$('#aftership-tracking-form').show();
			$('#woocommerce-aftership .show-form-btn-container').hide();
		},

		cancel_form: function(e) {
			e.preventDefault();
			$('#aftership-tracking-form').hide();
			$('#woocommerce-aftership .show-form-btn-container').show();
			aftership_items.reset_form();
			aftership_items.refresh_items();
			aftership_items.reset_error();
		},

		// Delete a tracking item
		edit_tracking: function () {

			// if form is open, alert user will reset current form
			if($("#aftership-tracking-form").is(':visible')) {
				if(window.confirm('If you edit this shipment, all unsaved changes will be lost. Are you sure you want to continue?')) {
					aftership_items.refresh_items();
					aftership_items.reset_form();
				} else {
					return false;
				}
			}

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
				$('#woocommerce-aftership .show-form-btn-container').hide();
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
				aftership_items.handle_input_change();
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

		reset_form: function() {
			$('#aftership_tracking_slug').prop('selectedIndex', 0).change();
			$('input#aftership_tracking_number').val('');
			$('input#aftership_tracking_id').val('');
			$('input#aftership_tracking_account_number').val('');
			$('input#aftership_tracking_key').val('');
			$('input#aftership_tracking_postal_code').val('');
			$('input#aftership_tracking_ship_date').val('');
			$('input#aftership_tracking_destination_country').val('');
			$('input#aftership_tracking_state').val('');
			$("#aftership_tracking_slug").trigger("chosen:updated");
			return false;
		},

		handle_input_change() {
			let disable_btn = false;
			if(!$('#woocommerce-aftership select').val()) {
				disable_btn = true;
			}
			$('#woocommerce-aftership input:visible').each((index,item) => {
				if(!$(item).val()) {
					disable_btn = true;
				}
			})
			if(disable_btn) {
				$('#woocommerce-aftership button.button-save-form').attr('disabled','disabled')
			} else {
				$('#woocommerce-aftership button.button-save-form').removeAttr('disabled')
			}
			aftership_items.reset_error();
		},

		show_error() {
			let input = $('input#aftership_tracking_number').get(0);
			if(input.checkValidity() === true) {
				input.setCustomValidity('This shipment has already been added.');
				$(input).after($('<div>This shipment has already been added.</div>'));
			}
			// input.reportValidity();
		},

		reset_error() {
			let input = $('input#aftership_tracking_number').get(0);
			if(input.checkValidity() === false) {
				input.setCustomValidity('');
				$(input).next().remove();
			}
		}
	}

	aftership_items.init();

	window.aftership_items_refresh = aftership_items.refresh_items;
});
