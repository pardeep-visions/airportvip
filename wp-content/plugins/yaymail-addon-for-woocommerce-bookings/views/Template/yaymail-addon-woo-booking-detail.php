<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$text_link_color            = get_post_meta( $post_id, '_yaymail_email_textLinkColor_settings', true ) ? get_post_meta( $post_id, '_yaymail_email_textLinkColor_settings', true ) : '#7F54B3';
$border_color               = isset( $attrs['borderColor'] ) && $attrs['borderColor'] ? 'border-color:' . html_entity_decode( $attrs['borderColor'], ENT_QUOTES, 'UTF-8' ) : 'border-color:inherit';
$text_color                 = isset( $attrs['textColor'] ) && $attrs['textColor'] ? 'color:' . html_entity_decode( $attrs['textColor'], ENT_QUOTES, 'UTF-8' ) : 'color:inherit';
$title_booked_product       = isset( $attrs['titleBookedProduct'] ) ? $attrs['titleBookedProduct'] : 'Booked Product';
$title_id                   = isset( $attrs['titleID'] ) ? $attrs['titleID'] : 'Booking ID';
$title_start_date           = isset( $attrs['titleStartDate'] ) ? $attrs['titleStartDate'] : 'Booking Start Date';
$title_end_date             = isset( $attrs['titleEndDate'] ) ? $attrs['titleEndDate'] : 'Booking End Date';
$title_time_zone            = isset( $attrs['titleTimeZone'] ) ? $attrs['titleTimeZone'] : 'Time Zone';
$title_customer_information = isset( $attrs['titleCustomerInformation'] ) ? $attrs['titleCustomerInformation'] : 'Customer Information';
$booking_order              = $booking->get_order();
$booking_id                 = $booking->get_id();
$plain_text                 = false;
?> 

<table
	width="<?php esc_attr_e( $general_attrs['tableWidth'], 'woocommerce' ); ?>"
	cellspacing="0"
	cellpadding="0"
	border="0"
	align="center"
	style="display: table;
	<?php echo esc_attr( 'background-color: ' . $attrs['backgroundColor'] ); ?>;
	<?php echo esc_attr( 'min-width: ' . $general_attrs['tableWidth'] . 'px' ); ?>;
	"
	class="web-main-row"
	:id="'web' + emailContent.id"
  >
	<tbody>
		<tr>
			<td
			:id="'web-' + emailContent.id + '-order-item'"
			class="web-order-item"
			align="left"
			style='font-size: 13px; line-height: 22px; word-break: break-word;
			<?php echo esc_attr( 'padding: ' . $attrs['paddingTop'] . 'px ' . $attrs['paddingRight'] . 'px ' . $attrs['paddingBottom'] . 'px ' . $attrs['paddingLeft'] . 'px' ); ?>;
			<?php echo wp_kses_post( 'font-family: ' . $attrs['family'] ); ?>;
			'
			>
				<div class="yaymail-items-subscript-border"	style="min-height: 10px; <?php echo esc_attr( $text_color ); ?>;	<?php echo esc_attr( $border_color ); ?>;">
				
					<table cellspacing="0" cellpadding="6" style="width: 100%;color: inherit;border-collapse: separate;border-style: solid;font-size: 13px;<?php echo esc_attr( $border_color ); ?>" border="1">
						<tbody>
							<tr style="<?php echo esc_attr( $text_color ); ?>">
								<th scope="row" style="padding: 12px;text-align:left;border-style: solid;<?php echo esc_attr( $border_color ); ?>"><?php esc_html_e( $title_booked_product, 'woocommerce-bookings' ); ?></th>
								<?php if ( 'booking_reminder' !== $args['email']->id && 'booking_confirmed' !== $args['email']->id && 'booking_notification' !== $args['email']->id && 'booking_pending_confirmation' !== $args['email']->id ) : ?>
									<td style="padding: 12px;text-align:left;border-style: solid;<?php echo esc_attr( $border_color ); ?>">
										<?php
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
														if ( 'booking_cancelled' === $args['email']->id || 'admin_booking_cancelled' === $args['email']->id ) :
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
															<a style="color:<?php echo esc_attr( $text_link_color ); ?>" href="<?php echo esc_url( admin_url( 'post.php?post=' . absint( $booking_id ) . '&action=edit&confirm=true' ) ); ?>"><?php esc_html_e( 'Confirm booking', 'woocommerce-bookings' ); ?></a>
														<?php endif; ?>

														<?php if ( $booking_id && $booking_order->get_customer_id() ) : ?>
															<a style="color:<?php echo esc_attr( $text_link_color ); ?>" href="<?php echo esc_url( admin_url( 'post.php?post=' . absint( $booking_id ) . '&action=edit' ) ); ?>"><?php esc_html_e( 'View booking &rarr;', 'woocommerce-bookings' ); ?></a>
														<?php endif; ?>
													</div>
												</div>

										<?php } ?>	
									</td>
								<?php else : ?>
									<td style="padding: 12px;text-align:left;border-style: solid;<?php echo esc_attr( $border_color ); ?>"><?php echo esc_html( $booking->get_product()->get_title() ); ?></td>
								<?php endif; ?>
							</tr>
							<tr style="<?php echo esc_attr( $text_color ); ?>">
								<th style="padding: 12px;text-align:left;border-style: solid;<?php echo esc_attr( $border_color ); ?>" scope="row"><?php esc_html_e( $title_id, 'woocommerce-bookings' ); ?></th>
								<td style="padding: 12px;text-align:left;border-style: solid;<?php echo esc_attr( $border_color ); ?>"><?php echo esc_html( $booking->get_id() ); ?></td>
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
								<tr style="<?php echo esc_attr( $text_color ); ?>">
									<th style="padding: 12px;text-align:left;border-style: solid;<?php echo esc_attr( $border_color ); ?>" scope="row"><?php echo ( '' != $resource_label ) ? esc_html( $resource_label ) : esc_html__( 'Booking Type', 'woocommerce-bookings' ); ?></th>
									<td style="padding: 12px;text-align:left;border-style: solid;<?php echo esc_attr( $border_color ); ?>"><?php echo esc_html( $resource->post_title ); ?></td>
								</tr>
							<?php endif; ?>
							<tr style="<?php echo esc_attr( $text_color ); ?>">
								<th style="padding: 12px;text-align:left;border-style: solid;<?php echo esc_attr( $border_color ); ?>" scope="row"><?php esc_html_e( $title_start_date, 'woocommerce-bookings' ); ?></th>
								<td style="padding: 12px;text-align:left;border-style: solid;<?php echo esc_attr( $border_color ); ?>"><?php echo esc_html( $booking->get_start_date( null, null, wc_should_convert_timezone( $booking ) ) ); ?></td>
							</tr>
							<tr style="<?php echo esc_attr( $text_color ); ?>">
								<th style="padding: 12px;text-align:left;border-style: solid;<?php echo esc_attr( $border_color ); ?>" scope="row"><?php esc_html_e( $title_end_date, 'woocommerce-bookings' ); ?></th>
								<td style="padding: 12px;text-align:left;border-style: solid;<?php echo esc_attr( $border_color ); ?>"><?php echo esc_html( $booking->get_end_date( null, null, wc_should_convert_timezone( $booking ) ) ); ?></td>
							</tr>
							<?php if ( wc_should_convert_timezone( $booking ) ) : ?>
							<tr style="<?php echo esc_attr( $text_color ); ?>">
								<th style="padding: 12px;text-align:left;border-style: solid;<?php echo esc_attr( $border_color ); ?>" scope="row"><?php esc_html_e( $title_time_zone, 'woocommerce-bookings' ); ?></th>
								<td style="padding: 12px;text-align:left;border-style: solid;<?php echo esc_attr( $border_color ); ?>"><?php echo esc_html( str_replace( '_', ' ', $booking->get_local_timezone() ) ); ?></td>
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
									<tr style="<?php echo esc_attr( $text_color ); ?>">
										<th style="padding: 12px;text-align:left;border-style: solid;<?php echo esc_attr( $border_color ); ?>" scope="row"><?php echo esc_html( $person_type ); ?></th>
										<td style="padding: 12px;text-align:left;border-style: solid;<?php echo esc_attr( $border_color ); ?>"><?php echo esc_html( $qty ); ?></td>
									</tr>
								<?php endforeach; ?>
							<?php endif; ?>
							<?php if ( 'new_booking' === $args['email']->id ) : ?>
							<tr style="<?php echo esc_attr( $text_color ); ?>">
								<th style="padding: 12px;text-align:left;border-style: solid;<?php echo esc_attr( $border_color ); ?>" scope="row"><?php esc_html_e( $title_customer_information, 'woocommerce-bookings' ); ?></th>
								<td style="padding: 12px;text-align:left;border-style: solid;<?php echo esc_attr( $border_color ); ?>">
									<?php echo wp_kses( $booking_order->get_formatted_billing_address() ? $booking_order->get_formatted_billing_address() : __( 'No billing address set.', 'woocommerce-bookings' ), array( 'br' => array() ) ); ?><br/>
									<?php echo esc_html( $booking_order->get_billing_phone() ? $booking_order->get_billing_phone() : $booking_order->billing_phone ); ?><br/>
									<?php echo wp_kses_post( make_clickable( sanitize_email( $booking_order->get_billing_email() ? $booking_order->get_billing_email() : $booking_order->billing_email ) ) ); ?>
								</td>
							</tr>
							<?php endif; ?>
						</tbody>
					</table>
					<?php if ( 'new_booking' == $args['email']->id && wc_booking_order_requires_confirmation( $booking->get_order() ) && $booking->get_status() === 'pending-confirmation' ) : ?>
					<p><?php esc_html_e( 'This booking is awaiting your approval. Please check it and inform the customer if the date is available or not.', 'woocommerce-bookings' ); ?></p>
					<?php endif; ?>
					<?php if ( 'new_booking' == $args['email']->id || 'admin_booking_cancelled' == $args['email']->id ) : ?>
					<p>
						<?php
						/* translators: 1: a href to booking */
						echo wp_kses_post( make_clickable( sprintf( __( 'You can view and edit this booking in the dashboard here: %s', 'woocommerce-bookings' ), admin_url( 'post.php?post=' . $booking->get_id() . '&action=edit' ) ) ) );
						?>
					</p>
					<?php endif; ?>

				</div>
			</td>
		</tr>
	</tbody>
</table>
