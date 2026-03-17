<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$yaymail_template = get_post_meta( $post_id, '_yaymail_template', true );
?>
<table
	:width="tableWidth"
	cellspacing="0"
	cellpadding="0"
	border="0"
	align="center"
	style="display: table;width: 100%;"
	:style="{
	  backgroundColor: emailContent.settingRow.backgroundColor,
	  width: tableWidth
	}"
	class="web-main-row"
	:id="'web' + emailContent.id"
  >
	<tbody>
		<tr>
			<td
			:id="'web-' + emailContent.id + '-order-item'"
			class="web-order-item"
			align="left"
			style="font-size: 13px; line-height: 22px; word-break: break-word;"
			:style="{
				fontFamily: emailContent.settingRow.family,
				paddingTop: emailContent.settingRow.paddingTop + 'px',
				paddingBottom: emailContent.settingRow.paddingBottom + 'px',
				paddingRight: emailContent.settingRow.paddingRight + 'px',
				paddingLeft: emailContent.settingRow.paddingLeft + 'px'
			}"
			>
			<div
			class="yaymail-items-subscript-border"
				style="min-height: 10px"
				:style="{
				color: emailContent.settingRow.textColor,
				borderColor: emailContent.settingRow.borderColor,
				}"
			>
				<table cellspacing="0" cellpadding="6" style="width: 100%;color: inherit;border-collapse: separate;border-style: solid;" :style="{'border-color': emailContent.settingRow.borderColor}" border="1">
					<tbody>
						<tr :style="{'color': emailContent.settingRow.textColor}">
							<th scope="row" style="padding: 12px;text-align:left;border-style: solid;" :style="{'border-color': emailContent.settingRow.borderColor}">{{emailContent.settingRow.titleBookedProduct}}</th>
							<td style="padding: 12px;text-align:left;border-style: solid;" :style="{'border-color': emailContent.settingRow.borderColor}">
								<div class="wc-booking-summary"><?php esc_html_e( 'Virtual Product', 'yaymail' ); ?>
								<?php
								if ( 'booking_cancelled' === $yaymail_template || 'admin_booking_cancelled' === $yaymail_template ) :
									?>
									<strong class="wc-booking-summary-number">
										<?php
										/* translators: 1: booking id */
										printf( esc_html__( 'Booking #%s', 'woocommerce-bookings' ), 1 );
										?>
										<span class="status-<?php echo esc_attr( 'paid' ); ?>">
											<?php echo esc_html( 'Paid' ); ?>
										</span>
									</strong>
									<ul class="wc-booking-summary-list">
										<li>
											<?php
											echo esc_html( 'March 17, 2021' );
											?>
										</li>
									</ul>
								<?php endif; ?>
								
								<?php if ( 'booking_reminder' !== $yaymail_template && 'booking_confirmed' !== $yaymail_template && 'booking_notification' !== $yaymail_template && 'booking_pending_confirmation' !== $yaymail_template ) : ?>
								<div class="wc-booking-summary-actions">
									<a :style="{'color': emailTextLinkColor}" href="<?php echo esc_url( admin_url( 'post.php?post=0&action=edit' ) ); ?>"><?php esc_html_e( 'View booking &rarr;', 'woocommerce-bookings' ); ?></a>
								</div>
								<?php endif; ?>
								</div>
							</td>
						</tr>
						<tr :style="{'color': emailContent.settingRow.textColor}">
							<th style="padding: 12px;text-align:left;border-style: solid;" :style="{'border-color': emailContent.settingRow.borderColor}" scope="row">{{emailContent.settingRow.titleID}}</th>
							<td style="padding: 12px;text-align:left;border-style: solid;" :style="{'border-color': emailContent.settingRow.borderColor}"><?php echo esc_html( '1208' ); ?></td>
						</tr>
						<tr :style="{'color': emailContent.settingRow.textColor}">
							<th style="padding: 12px;text-align:left;border-style: solid;" :style="{'border-color': emailContent.settingRow.borderColor}" scope="row">{{emailContent.settingRow.titleStartDate}}</th>
							<td style="padding: 12px;text-align:left;border-style: solid;" :style="{'border-color': emailContent.settingRow.borderColor}"><?php echo esc_html( 'March 17, 2021, 3:00 am' ); ?></td>
						</tr>
						<tr :style="{'color': emailContent.settingRow.textColor}">
							<th style="padding: 12px;text-align:left;border-style: solid;" :style="{'border-color': emailContent.settingRow.borderColor}" scope="row">{{emailContent.settingRow.titleEndDate}}</th>
							<td style="padding: 12px;text-align:left;border-style: solid;" :style="{'border-color': emailContent.settingRow.borderColor}"><?php echo esc_html( 'March 17, 2021, 4:00 am' ); ?></td>
						</tr>
						<?php if ( 'new_booking' === $yaymail_template ) : ?>
						<tr :style="{'color': emailContent.settingRow.textColor}">
							<th style="padding: 12px;text-align:left;border-style: solid;" :style="{'border-color': emailContent.settingRow.borderColor}" scope="row">{{emailContent.settingRow.titleCustomerInformation}}</th>
							<td style="padding: 12px;text-align:left;border-style: solid;" :style="{'border-color': emailContent.settingRow.borderColor}">
								<div>John Doe</div>
								<div>7400 Edwards Rd</div>
								<div><a style="font-weight: normal; text-decoration: underline;" :style="{'color': emailTextLinkColor}" href="#" >yaycommerce@example.com</a></div>
							</td>
						</tr>
						<?php endif; ?>
					</tbody>
				</table>
				<?php if ( 'new_booking' == $yaymail_template || 'admin_booking_cancelled' == $yaymail_template ) : ?>
					<p>
						<span> <?php esc_html_e( 'You can view and edit this booking in the dashboard here:', 'woocommerce-bookings' ); ?></span>
						<a :style="{'color': emailTextLinkColor}" href="#"><?php echo esc_url( admin_url( 'post.php?post=0&action=edit' ) ); ?></a>
					</p>
					<?php endif; ?>
			</div>
			</td>
		</tr>
	</tbody>
</table>
