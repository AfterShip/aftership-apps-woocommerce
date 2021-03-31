<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * View Order: Tracking information
 *
 * Shows tracking numbers view order page
 *
 * @author  AfterShip
 * @package AfterShip Tracking/templates/email
 */

if ( $tracking_items ) : ?>
	<h2><?php echo apply_filters( 'aftership_tracking_my_orders_title', __( 'Tracking Information', 'aftership' ) ); ?></h2>

	<table class="td" cellspacing="0" cellpadding="6" style="width: 100%;" border="1">
		<thead>
		<tr>
			<th class="slug" scope="col" class="td" style="text-align: left; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; color: #737373; border: 1px solid #e4e4e4; padding: 12px;"><?php _e( 'Courier', 'aftership' ); ?></th>
			<th class="tracking-number" scope="col" class="td" style="text-align: left; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; color: #737373; border: 1px solid #e4e4e4; padding: 12px;"><?php _e( 'Tracking Number', 'aftership' ); ?></th>
		</tr>
		</thead>
		<tbody>
		<?php
		foreach ( $tracking_items as $tracking_item ) {
			?>
			<tr class="tracking">
				<td class="slug" data-title="<?php _e( 'Courier', 'aftership' ); ?>" style="text-align: left; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; color: #737373; border: 1px solid #e4e4e4; padding: 12px;">
					<?php echo esc_html( $tracking_item['courier']['name'] ); ?>
				</td>
				<td class="tracking-number" data-title="<?php _e( 'Tracking Number', 'aftership' ); ?>" style="text-align: left; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; color: #737373; border: 1px solid #e4e4e4; padding: 12px;">
					<?php echo esc_html( $tracking_item['tracking_number'] ); ?>
				</td>
			</tr>
			<?php
		}
		?>
		</tbody>
	</table>

	<?php
endif;
