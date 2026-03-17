<?php

namespace YayMailWooBooking\TemplateDefault;

defined( 'ABSPATH' ) || exit;

class DefaultWooBooking {

	protected static $instance = null;

	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public static function get_templates( $custom_order, $email_heading ) {
		/*
		@@@ Html default send email.
		@@@ Note: Add characters '\' before special characters in a string.
		@@@ Example: font-family: \'Helvetica Neue\'...
		*/

		$email_title      = __( $email_heading, 'woocommerce' );
		$email_text       = '';
		$email_text2      = '';
		$pay_booking_text = esc_html( do_shortcode( '[yaymail_addon_booking_pay_for_booking]' ) );
		$hello_text       = esc_html__( 'Hello ', 'woocommerce-bookings' ) . esc_html( do_shortcode( '[yaymail_billing_first_name]' ) );
		if ( 'new_booking' == $custom_order ) {
			$email_text = esc_html__( 'A new booking has been made by ', 'woocommerce-bookings' ) . esc_html( do_shortcode( '[yaymail_billing_first_name] [yaymail_billing_last_name]' ) ) . esc_html__( '. The details of this booking are as follows:', 'woocommerce-bookings' );
		}
		if ( 'booking_reminder' == $custom_order ) {
			$email_text = esc_html__( 'This is a reminder that your booking will take place on ', 'woocommerce-bookings' ) . esc_html( do_shortcode( '[yaymail_addon_booking_start_date]' ) );
		}
		if ( 'booking_confirmed' == $custom_order ) {
			$email_text = esc_html__( 'Your booking has been confirmed. The details of your booking are shown below.', 'woocommerce-bookings' );
		}
		if ( 'booking_pending_confirmation' == $custom_order ) {
			$email_text = esc_html__( 'Your booking has been received and it\'s pending confirmation. The details of your booking are shown below.', 'woocommerce-bookings' );
		}
		if ( 'booking_notification' == $custom_order ) {
			$email_title = esc_html( do_shortcode( '[yaymail_addon_woo_booking_notification_email_subject]' ) );

			$email_text = esc_html( do_shortcode( '[yaymail_addon_booking_notification_text]' ) );
		}
		if ( 'booking_cancelled' == $custom_order ) {
			$email_text  = esc_html__( 'We are sorry to say that your booking could not be confirmed and has been cancelled. The details of the cancelled booking can be found below.', 'woocommerce-bookings' );
			$email_text2 = esc_html__( 'Please contact us if you have any questions or concerns.', 'woocommerce-bookings' );
		}
		if ( 'admin_booking_cancelled' == $custom_order ) {
			$email_text = esc_html__( 'The following booking has been cancelled. The details of the cancelled booking can be found below.', 'woocommerce-bookings' );
		}

		/*
		@@@ Elements default when reset template.
		@@@ Note 1: Add characters '\' before special characters in a string.
		@@@ example 1: "family": "\'Helvetica Neue\',Helvetica,Roboto,Arial,sans-serif",

		@@@ Note 2: Add characters '\' before special characters in a string.
		@@@ example 2: "<h1 style=\"font-family: \'Helvetica Neue\',...."
		*/

		// Elements
		$elements =
		'[{
			"id": "8ffa62b5-7258-42cc-ba53-7ae69638c1fe",
			"type": "Logo",
			"nameElement": "Logo",
			"settingRow": {
				"backgroundColor": "#ECECEC",
				"align": "center",
				"pathImg": "",
				"paddingTop": "15",
				"paddingRight": "50",
				"paddingBottom": "15",
				"paddingLeft": "50",
				"width": "172",
				"url": "#"
			}
		},{
			"id": "b035d1f1-0cfe-41c5-b79c-0478f144ef5f",
			"type": "ElementText",
			"nameElement": "Email Heading",
			"settingRow": {
				"content": "<h1 style=\"font-size: 30px; font-weight: 300; line-height: normal; margin: 0; color: inherit;\">' . $email_title . '</h1>",
				"backgroundColor": "#7F54B3",
				"textColor": "#ffffff",
				"family": "Helvetica,Roboto,Arial,sans-serif",
				"paddingTop": "36",
				"paddingRight": "48",
				"paddingBottom": "36",
				"paddingLeft": "48"
			}
		},';
		if ( 'booking_reminder' == $custom_order || 'booking_confirmed' == $custom_order || 'booking_cancelled' == $custom_order || 'booking_pending_confirmation' == $custom_order ) {
			$elements .= '{
				"id": "802bfe24-7af8-48af-ac5e-6560a81345b3",
				"type": "ElementText",
				"nameElement": "Text",
				"settingRow": {
					"content": "<p style=\"margin: 0px;\"><span style=\"font-size: 14px;\">' . $hello_text . '</span><br/><br/><span style=\"font-size: 14px;\">' . $email_text . '</span></p>",
					"backgroundColor": "#fff",
					"textColor": "#636363",
					"family": "Helvetica,Roboto,Arial,sans-serif",
					"paddingTop": "47",
					"paddingRight": "50",
					"paddingBottom": "0",
					"paddingLeft": "50"
				}
			},';
		} else {
			$elements .= '{
				"id": "802bfe24-7af8-48af-ac5e-6560a81345b3",
				"type": "ElementText",
				"nameElement": "Text",
				"settingRow": {
					"content": "<p style=\"margin: 0px;\"><span style=\"font-size: 14px;\">' . $email_text . '</span></p>",
					"backgroundColor": "#fff",
					"textColor": "#636363",
					"family": "Helvetica,Roboto,Arial,sans-serif",
					"paddingTop": "47",
					"paddingRight": "50",
					"paddingBottom": "0",
					"paddingLeft": "50"
				}
			},';
		}

		$elements .= '{
			"id": "yi422370-f762-4a26-92de-c4cf3878h0oiyt",
			"type": "AddonWooBookingDetail",
			"nameElement": "WooCommerce Booking Detail",
			"settingRow": {
				"content" :"This is content",
				"contentTitle": "WooCommerce Booking Detail",
				"backgroundColor" : "#fff",
				"titleColor" : "#7F54B3",
				"textColor" : "#636363",
				"borderColor" : "#e5e5e5",
				"family" : "Helvetica,Roboto,Arial,sans-serif",
				"paddingTop" : "15",
				"paddingRight" : "50",
				"paddingBottom" : "30",
				"paddingLeft" : "50",
				"titleBookedProduct" : "Booked Product",
				"titleID" : "Booking ID",
				"titleStartDate" : "Booking Start Date",
				"titleEndDate" : "Booking End Date",
				"titleTimeZone" : "Time Zone",
				"titleCustomerInformation" : "Customer Information"
			}
		},';
		if ( 'booking_confirmed' == $custom_order ) {
			$elements .= '{
				"id": "ad422370-f762-4a26-92de-c4cf3878h0oi-pay-link",
				"type": "ElementText",
				"nameElement": "Text",
				"settingRow": {
					"content": "<p style=\"margin: 0px;\"><span style=\"font-size: 14px;\">' . $pay_booking_text . '</span></p>",
					"backgroundColor": "#fff",
					"textColor": "#636363",
					"family": "Helvetica,Roboto,Arial,sans-serif",
					"paddingTop": "0",
					"paddingRight": "50",
					"paddingBottom": "10",
					"paddingLeft": "50"
				}
			},{
				"id": "ad422370-f762-4a26-92de-c4cf3878h0oi",
				"type": "OrderItem",
				"nameElement": "Order Item",
				"settingRow": {
					"contentBefore": "[yaymail_items_border_before]",
					"contentAfter": "[yaymail_items_border_after]",
					"contentTitle": "[yaymail_items_border_title]",
					"content": "[yaymail_items_border_content]",
					"backgroundColor": "#fff",
					"titleColor" : "#7F54B3",
					"textColor": "#636363",
					"borderColor": "#e5e5e5",
					"family": "Helvetica,Roboto,Arial,sans-serif",
					"paddingTop": "0",
					"paddingRight": "50",
					"paddingBottom": "15",
					"paddingLeft": "50"
				}
			},{
				"id": "802bfe24-7af8-48af-ac5e-6560a81345b3-hook",
				"type": "Hook",
				"nameElement": "Hook",
				"settingRow": {
					"content": "[woocommerce_email_after_order_table]",
					"backgroundColor": "#fff",
					"textColor": "#636363",
					"family": "Helvetica,Roboto,Arial,sans-serif",
					"paddingTop": "15",
					"paddingRight": "50",
					"paddingBottom": "0",
					"paddingLeft": "50"
				}
			},';
		}
		if ( 'booking_cancelled' == $custom_order ) {
			$elements .= '{
				"id": "802bfe24-7af8-48af-ac5e-6560a81345b3-text",
				"type": "ElementText",
				"nameElement": "Text",
				"settingRow": {
					"content": "<p style=\"margin: 0px;\"><span style=\"font-size: 14px;\">' . $email_text2 . '</span></p>",
					"backgroundColor": "#fff",
					"textColor": "#636363",
					"family": "Helvetica,Roboto,Arial,sans-serif",
					"paddingTop": "10",
					"paddingRight": "50",
					"paddingBottom": "20",
					"paddingLeft": "50"
				}
			},';
		}
		$elements .= '{
			"id": "b39bf2e6-8c1a-4384-a5ec-37663da27c8ds",
			"type": "ElementText",
			"nameElement": "Footer",
			"settingRow": {
				"content": "<p style=\"font-size: 14px;margin: 0px 0px 16px; text-align: center;\">[yaymail_site_name]&nbsp;- Built with <a style=\"color: #7F54B3; font-weight: normal; text-decoration: underline;\" href=\"https://woocommerce.com\" target=\"_blank\" rel=\"noopener\">WooCommerce</a></p>",
				"backgroundColor": "#ececec",
				"textColor": "#8a8a8a",
				"family": "Helvetica,Roboto,Arial,sans-serif",
				"paddingTop": "15",
				"paddingRight": "50",
				"paddingBottom": "15",
				"paddingLeft": "50"
			}
		}]';

			// Templates YITH Multi Vendor Commissions
			$templates = array(
				$custom_order => array(),
			);

			$templates[ $custom_order ]['elements'] = $elements;
			return $templates;
	}
}
