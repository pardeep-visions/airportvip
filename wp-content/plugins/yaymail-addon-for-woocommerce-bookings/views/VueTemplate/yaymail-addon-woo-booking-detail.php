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
				<?php
					$booking = get_wc_booking( $booking_id );
				?>
					<table cellspacing="0" cellpadding="6" style="width: 100%;color: inherit;border-collapse: separate;border-style: solid;" :style="{'border-color': emailContent.settingRow.borderColor}" border="1">
						<tbody>
							<tr :style="{'color': emailContent.settingRow.textColor}">
								<th scope="row" style="padding: 12px;text-align:left;border-style: solid;" :style="{'border-color': emailContent.settingRow.borderColor}">{{emailContent.settingRow.titleBookedProduct}}</th>
								<?php if ( 'booking_reminder' !== $yaymail_template && 'booking_confirmed' !== $yaymail_template && 'booking_notification' !== $yaymail_template && 'booking_pending_confirmation' !== $yaymail_template ) : ?>
								<td style="padding: 12px;text-align:left;border-style: solid;" :style="{'border-color': emailContent.settingRow.borderColor}">
									<?php
										$booking_order = $booking->get_order();
										$plain_text    = false;
									if ( ! empty( $booking_order ) ) {
										?>
											<div class="wc-booking-summary" style="margin-top: 1em">
												<?php
												foreach ( $booking_order->get_items() as $item_id => $item ) {
													if ( $item_id !== $booking->get_order_item_id() ) {
														continue;
													}


													// Product name.
													echo wp_kses_post( apply_filters( 'woocommerce_order_item_name', $item->get_name(), $item, false ) );

													// allow other plugins to add additional product information here.
													do_action( 'woocommerce_order_item_meta_start', $item_id, $item, $order, $plain_text );

													wc_display_item_meta(
														$item,
														array(
															'label_before' => '<strong class="wc-item-meta-label" style="float: left; margin-left: .25em; clear: both">',
														)
													);
													if ( 'booking_cancelled' === $yaymail_template || 'admin_booking_cancelled' === $yaymail_template ) :
														?>
														<strong class="wc-booking-summary-number">
															<?php
															/* translators: 1: booking id */
															printf( esc_html__( 'Booking #%s', 'woocommerce-bookings' ), (string) $booking->get_id() );
															?>
															<span class="status-<?php echo esc_attr( $booking->get_status() ); ?>">
																<?php echo esc_html( wc_bookings_get_status_label( $booking->get_status() ) ); ?>
															</span>
														</strong>

														<?php
														wc_bookings_get_summary_list( $booking, true );
													endif;
												}
												?>
												<div class="wc-booking-summary-actions">
												<?php if ( in_array( $booking->get_status(), array( 'pending-confirmation' ) ) ) : ?>
														<a :style="{'color': emailTextLinkColor}" href="<?php echo esc_url( admin_url( 'post.php?post=' . absint( $booking_id ) . '&action=edit&confirm=true' ) ); ?>"><?php esc_html_e( 'Confirm booking', 'woocommerce-bookings' ); ?></a>
													<?php endif; ?>

												<?php if ( $booking_id && $order->get_customer_id() ) : ?>
														<a :style="{'color': emailTextLinkColor}" href="<?php echo esc_url( admin_url( 'post.php?post=' . absint( $booking_id ) . '&action=edit' ) ); ?>"><?php esc_html_e( 'View booking &rarr;', 'woocommerce-bookings' ); ?></a>
													<?php endif; ?>
												</div>
											</div>

									<?php } ?>
								</td>
								<?php else : ?>
									<td style="padding: 12px;text-align:left;border-style: solid;" :style="{'border-color': emailContent.settingRow.borderColor}"><?php echo esc_html( $booking->get_product()->get_title() ); ?></td>
								<?php endif; ?>

							</tr>
							<tr :style="{'color': emailContent.settingRow.textColor}">
								<th style="padding: 12px;text-align:left;border-style: solid;" :style="{'border-color': emailContent.settingRow.borderColor}" scope="row">{{emailContent.settingRow.titleID}}</th>
								<td style="padding: 12px;text-align:left;border-style: solid;" :style="{'border-color': emailContent.settingRow.borderColor}"><?php echo esc_html( $booking->get_id() ); ?></td>
							</tr>
						<?php

						if ( isset( $booking ) ) {
							if ( method_exists( $booking, 'get_resource' ) ) {

								$resource = $booking->get_resource();
							}

							if ( method_exists( $booking, 'get_product' )
								&& null !== $booking->get_product()
								&& method_exists( $booking->get_product(), 'get_resource_label' ) ) {

									$resource_label = $booking->get_product()->get_resource_label();
							}
						}

						if ( $booking->has_resources() && $resource ) :
							?>
								<tr :style="{'color': emailContent.settingRow.textColor}">
									<th style="padding: 12px;text-align:left;border-style: solid;" :style="{'border-color': emailContent.settingRow.borderColor}" scope="row"><?php echo ( '' != $resource_label ) ? esc_html( $resource_label ) : esc_html__( 'Booking Type', 'woocommerce-bookings' ); ?></th>
									<td style="padding: 12px;text-align:left;border-style: solid;" :style="{'border-color': emailContent.settingRow.borderColor}"><?php echo esc_html( $resource->post_title ); ?></td>
								</tr>
							<?php endif; ?>
							<tr :style="{'color': emailContent.settingRow.textColor}">
								<th style="padding: 12px;text-align:left;border-style: solid;" :style="{'border-color': emailContent.settingRow.borderColor}" scope="row">{{emailContent.settingRow.titleStartDate}}</th>
								<td style="padding: 12px;text-align:left;border-style: solid;" :style="{'border-color': emailContent.settingRow.borderColor}"><?php echo esc_html( $booking->get_start_date( null, null, wc_should_convert_timezone( $booking ) ) ); ?></td>
							</tr>
							<tr :style="{'color': emailContent.settingRow.textColor}">
								<th style="padding: 12px;text-align:left;border-style: solid;" :style="{'border-color': emailContent.settingRow.borderColor}" scope="row">{{emailContent.settingRow.titleEndDate}}</th>
								<td style="padding: 12px;text-align:left;border-style: solid;" :style="{'border-color': emailContent.settingRow.borderColor}"><?php echo esc_html( $booking->get_end_date( null, null, wc_should_convert_timezone( $booking ) ) ); ?></td>
							</tr>
							<?php if ( wc_should_convert_timezone( $booking ) ) : ?>
							<tr :style="{'color': emailContent.settingRow.textColor}">
								<th style="padding: 12px;text-align:left;border-style: solid;" :style="{'border-color': emailContent.settingRow.borderColor}" scope="row">{{emailContent.settingRow.titleTimeZone}}</th>
								<td style="padding: 12px;text-align:left;border-style: solid;" :style="{'border-color': emailContent.settingRow.borderColor}" ><?php echo esc_html( str_replace( '_', ' ', $booking->get_local_timezone() ) ); ?></td>
							</tr>
							<?php endif; ?>
							<?php if ( $booking->has_persons() ) : ?>
								<?php
								foreach ( $booking->get_persons() as $id => $qty ) :
									if ( 0 === $qty ) {
										continue;
									}

									$person_type = ( 0 < $id ) ? get_the_title( $id ) : __( 'Person(s)', 'woocommerce-bookings' );
									?>
									<tr :style="{'color': emailContent.settingRow.textColor}">
										<th style="padding: 12px;text-align:left;border-style: solid;" :style="{'border-color': emailContent.settingRow.borderColor}" scope="row"><?php echo esc_html( $person_type ); ?></th>
										<td style="padding: 12px;text-align:left;border-style: solid;" :style="{'border-color': emailContent.settingRow.borderColor}"><?php echo esc_html( $qty ); ?></td>
									</tr>
								<?php endforeach; ?>
							<?php endif; ?>
							<?php if ( 'new_booking' === $yaymail_template ) : ?>
							<tr :style="{'color': emailContent.settingRow.textColor}">
								<th style="padding: 12px;text-align:left;border-style: solid;" :style="{'border-color': emailContent.settingRow.borderColor}" scope="row">{{emailContent.settingRow.titleCustomerInformation}}</th>
								<td style="padding: 12px;text-align:left;border-style: solid;" :style="{'border-color': emailContent.settingRow.borderColor}">
									<?php echo wp_kses( $order->get_formatted_billing_address() ? $order->get_formatted_billing_address() : __( 'No billing address set.', 'woocommerce-bookings' ), array( 'br' => array() ) ); ?><br/>
									<?php echo esc_html( $order->get_billing_phone() ? $order->get_billing_phone() : $order->billing_phone ); ?><br/>
									<a :style="{'color': emailTextLinkColor}" href="<?php echo esc_url( $order->get_billing_email() ? $order->get_billing_email() : $order->billing_email ); ?>"><?php echo esc_url( $order->get_billing_email() ? $order->get_billing_email() : $order->billing_email ); ?></a>
								</td>
							</tr>
							<?php endif; ?>
						</tbody>
					</table>
					<?php if ( 'new_booking' == $yaymail_template && wc_booking_order_requires_confirmation( $booking->get_order() ) && $booking->get_status() === 'pending-confirmation' ) : ?>
					<p><?php esc_html_e( 'This booking is awaiting your approval. Please check it and inform the customer if the date is available or not.', 'woocommerce-bookings' ); ?></p>
					<?php endif; ?>
						<?php if ( 'new_booking' == $yaymail_template || 'admin_booking_cancelled' == $yaymail_template ) : ?>
						<p>
							<span> <?php esc_html_e( 'You can view and edit this booking in the dashboard here:', 'woocommerce-bookings' ); ?></span>
							<a :style="{'color': emailTextLinkColor}" href="#"><?php echo esc_url( admin_url( 'post.php?post=' . $booking->get_id() . '&action=edit' ) ); ?></a>
						</p>
						<?php endif; ?>

				</div>
			</td>
		</tr>
	</tbody>
</table>
