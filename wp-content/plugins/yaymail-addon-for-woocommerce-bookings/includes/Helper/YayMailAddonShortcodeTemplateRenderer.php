<?php

namespace YayMailWooBooking\Helper;

defined( 'ABSPATH' ) || exit;

class YayMailAddonShortcodeTemplateRenderer {
	private $yaymail_informations = null;
	private $args                 = array();

	// const SHORTCODE_LOCATION = '/views/Shortcode';

	public function __construct( $yaymail_informations, $args ) {
		$this->yaymail_informations = $yaymail_informations;
		$this->args                 = $args;
	}

	public function yaymail_addon_booking_start_date() {
		if ( isset( $this->args['booking'] ) ) {
			return $this->args['booking']->get_start_date( null, null, wc_should_convert_timezone( $this->args['booking'] ) );
		}
		return esc_html( 'March 17, 2021' );
	}

	public function yaymail_addon_booking_start_time() {
		if ( isset( $this->args['booking'] ) ) {
			return $this->args['booking']->get_start_date( wc_bookings_time_format(), null, wc_should_convert_timezone( $this->args['booking'] ) );
		}
		return esc_html( '3:00 am' );
	}

	public function yaymail_addon_booking_end_date() {
		if ( isset( $this->args['booking'] ) ) {
			return $this->args['booking']->get_end_date( null, null, wc_should_convert_timezone( $this->args['booking'] ) );
		}
		return esc_html( 'March 17, 2021' );
	}

	public function yaymail_addon_booking_end_time() {
		if ( isset( $this->args['booking'] ) ) {
			return $this->args['booking']->get_end_date( wc_bookings_time_format(), null, wc_should_convert_timezone( $this->args['booking'] ) );
		}
		return esc_html( '4:00 am' );
	}

	public function yaymail_addon_booking_id() {
		if ( isset( $this->yaymail_informations['order'] ) && is_object($this->yaymail_informations['order']) ) {
			$order_id = method_exists( $this->yaymail_informations['order'], 'get_id' ) ? $this->yaymail_informations['order']->get_id() : '';
			if ( !empty($order_id) ) {
				$bookings = \WC_Booking_Data_Store::get_booking_ids_from_order_id( $order_id );
				if ( ! empty( $bookings ) ) {
					return '<strong>' . esc_html( $bookings[0] ) . '</strong>';
				}
			}
		}

		if ( isset( $this->args['booking'] ) && false != $this->args['booking'] ) {
			$booking = $this->args['booking'];

			if ( isset( $booking ) ) {
				return '<strong>' . esc_html( $booking->get_id() ) . '</strong>';
			}
		}

		return '<strong>1208</strong>';
	}

	public function yaymail_addon_booking_notification_text() {
		if ( isset( $this->args['booking'] ) && isset( $this->args['notification_message'] ) ) {
			return esc_html( wptexturize( $this->args['notification_message'] ) );
		} else {
			return esc_html__( 'This is a placeholder notification text.', 'woocommerce-bookings' );
		}
	}

	public function yaymail_addon_booking_pay_for_booking() {
		if ( isset( $this->args['booking'] ) ) {
			$order = $this->args['booking']->get_order();
			if ( $order ) {
				ob_start();
				include YAYMAIL_ADDON_WOO_BOOKING_PLUGIN_PATH . '/views/Template/yaymail-addon-booking-pay-for-booking.php';
				$html = ob_get_contents();
				ob_end_clean();
				return $html;
			}
		} else {
			ob_start();
			include YAYMAIL_ADDON_WOO_BOOKING_PLUGIN_PATH . '/views/Shortcode/yaymail-addon-booking-pay-for-booking.php';
			$html = ob_get_contents();
			ob_end_clean();
			return $html;
		}
	}

	public function yaymail_addon_vendor_inforation( $var_name ) {
		if ( isset( $this->args['booking'] ) ) {
			if ( ! function_exists( 'dokan_get_vendor_by_product' ) ) {
				return '';
			}
			$vendor       = dokan_get_vendor_by_product( $this->args['booking']->get_product() );
			$vendor_infor = $vendor->to_array();
			if ( isset( $vendor_infor[ $var_name ] ) ) {
				return $vendor_infor[ $var_name ];
			}
			return '';
		} else {
			return 'vendor_' . $var_name;
		}
	}

	public function yaymail_addon_booking_location() {
		if ( isset( $this->args['booking'] ) ) {

			if ( isset( $this->args['booking'] ) && method_exists( $this->args['booking'], 'get_resource' ) ) {
				$resource = $this->args['booking']->get_resource();
			}

			if ( method_exists( $this->args['booking'], 'get_product' )
				&& null !== $this->args['booking']->get_product()
				&& method_exists( $this->args['booking']->get_product(), 'get_resource_label' ) ) {

				$resource_label = $this->args['booking']->get_product()->get_resource_label();
			}

			if ( $this->args['booking']->has_resources() && $resource ) {
				if ( 'Location' === $resource_label ) {
					return $resource->post_title;
				} else {
					return '';
				}
			} else {
				return '';
			}
		}
		return '[yaymail_addon_booking_location]';
	}

	public function yaymail_addon_woo_booking_notification_email_subject() {
		if ( ! empty( $this->args['email_heading'] ) ) {
			return '<div>' . $this->args['email_heading'] . '</div>';
		}

		return '<div>Email Subject</div>';
	}

	public function yaymail_addon_woo_booking_link() {
		if ( isset( $this->args['booking'] ) ) {
			$order = $this->args['booking']->get_order();
			if ( $order ) {

				if ( 'pending' !== $order->get_status() ) {
					return '';
				}
				return $order->get_checkout_payment_url();
			}
		} else {
			return '[yaymail_addon_woo_booking_link]';
		}
	}

}


