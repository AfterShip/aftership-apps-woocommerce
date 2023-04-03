jQuery(document).ready( function ($) {
    'use strict';

    let $progress = $('.aftership-orders-tracking-import-progress');
    // Notice: check first
    let step = 'check';
    let total = 0;
    let ftell = 0;
    let start = parseInt(aftership_orders_tracking_import_params.custom_start) - 1;
    if (start < 1) {
        start = 1;
    }
    let orders_per_request = parseInt(aftership_orders_tracking_import_params.orders_per_request);
    let order_status = aftership_orders_tracking_import_params.order_status;
    let vi_at_index = aftership_orders_tracking_import_params.vi_at_index;
    let $import_icon = $('.aftership-orders-tracking-import-icon');
    if (aftership_orders_tracking_import_params.step === 'import') {
        $progress.progress('set percent', 0);
        $import_icon.addClass('aftership-orders-tracking-updating');
        $.ajax({
            url: aftership_orders_tracking_import_params.url,
            type: 'POST',
            dataType: 'JSON',
            data: {
                action: 'aftership_orders_tracking_import',
                nonce: aftership_orders_tracking_import_params.nonce,
                file_url: aftership_orders_tracking_import_params.file_url,
                vi_at_index: vi_at_index,
                orders_per_request: orders_per_request,
                order_status: order_status,
                step: step,
                start: start,
            },
            success: function (response) {
                if (response.status === 'success') {
                    total = parseInt(response.total);
                    step = 'import';
                    vi_at_import();
                } else {
                    $progress.progress('set error');
                    $import_icon.removeClass('aftership-orders-tracking-updating');
                    if (response.hasOwnProperty('message')) {
                        $progress.progress('set label', 'Error: ' + response.message);
                    }
                }
            },
            error: function (err) {
                $progress.progress('set error');
                $progress.progress('set label', err.statusText);
                $import_icon.removeClass('aftership-orders-tracking-updating');
            },
        });
    }

    function vi_at_import() {
        $.ajax({
            url: aftership_orders_tracking_import_params.url,
            type: 'POST',
            dataType: 'JSON',
            data: {
                action: 'aftership_orders_tracking_import',
                nonce: aftership_orders_tracking_import_params.nonce,
                file_url: aftership_orders_tracking_import_params.file_url,
                orders_per_request: orders_per_request,
                order_status: order_status,
                vi_at_index: vi_at_index,
                step: step,
                ftell: ftell,
                start: start,
                total: total,
            },
            success: function (response) {
                let percent = response.percent;
                switch (response.status) {
                    case 'success':
                        ftell = response.ftell;
                        start = response.start;
                        $progress.progress('set percent', percent);
                        vi_at_import();
                        break;
                    case 'finish':
                        $import_icon.removeClass('aftership-orders-tracking-updating');
                        $progress.progress('complete');
                        let message = 'Import completed.';
                        alert(message);
                        break;
                    case 'error':
                        $progress.progress('set error');
                        $progress.progress('set label', response.message);
                        break;
                    default:
                }
            },
            error: function (err) {
                $import_icon.removeClass('aftership-orders-tracking-updating');
                $progress.progress('set error');
                $progress.progress('set label', 'Error');
            },
        });
    }
});
