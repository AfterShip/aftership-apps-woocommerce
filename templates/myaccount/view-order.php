<?php
/**
 * Display Tracking Info On Order View Page
 *
 * @package AfterShip
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $tracking_items ) : ?>
	<div id="as-root"></div><script>(function(e,t,n){var r,i=e.getElementsByTagName(t)[0];if(e.getElementById(n))return;r=e.createElement(t);r.id=n;r.src="https://button.aftership.com/all.js";i.parentNode.insertBefore(r,i)})(document,"script","aftership-jssdk")</script>
	<h2><?php esc_html_e( 'Tracking Information' ); ?></h2>

	<table class="shop_table shop_table_responsive my_account_tracking">
		<thead>
			<tr>
				<th class="slug"><span class="nobr"><?php esc_html_e( 'Courier', 'aftership' ); ?></span></th>
				<th class="tracking-number"><span class="nobr"><?php esc_html_e( 'Tracking Number', 'aftership' ); ?></span></th>
				<?php if ( $use_track_button ) { ?>
					<th class="order-actions"><?php esc_html_e( 'Actions', 'aftership' ); ?></th>
				<?php } ?>

			</tr>
		</thead>
		<tbody>
		<?php
		foreach ( $tracking_items as $tracking_item ) {
			?>
				<tr class="tracking">
					<td class="slug" data-title="<?php esc_html_e( 'Courier', 'aftership' ); ?>">
						<?php echo esc_html( $tracking_item['courier']['name'] ); ?>
					</td>
					<td class="tracking-number" data-title="<?php esc_html_e( 'Tracking Number', 'aftership' ); ?>">
						<?php echo esc_html( $tracking_item['tracking_number'] ); ?>
					</td>
					<?php if ( $use_track_button ) { ?>
						<td class="order-actions" style="text-align: center;">
							<div class="as-track-button"
								 data-slug="<?php echo esc_html( $tracking_item['slug'] ); ?>"
								 data-domain="<?php echo esc_html( parse_url( $tracking_item['custom_domain'], PHP_URL_HOST ) ? parse_url( $tracking_item['custom_domain'], PHP_URL_HOST ) : $tracking_item['custom_domain'] ); ?>"
								 data-tracking-number="<?php echo esc_html( $tracking_item['tracking_number_for_tracking_button'] ); ?>"
								 data-size="normal"
								 data-hide-tracking-number="true">
							</div>
						</td>
					<?php } ?>
				</tr>
				<?php
		}
		?>
		</tbody>
	</table>

	<?php
endif;
