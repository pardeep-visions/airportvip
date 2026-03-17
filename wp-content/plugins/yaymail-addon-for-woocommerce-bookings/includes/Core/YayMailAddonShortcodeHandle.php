<?php

namespace YayMailWooBooking\Core;

defined( 'ABSPATH' ) || exit;

use YayMailWooBooking\Helper\YayMailAddonShortcodeTemplateRenderer;

class YayMailAddonShortcodeHandle {
	protected static $instance = null;

	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new self();
			self::$instance->do_hooks();
		}

		return self::$instance;
	}

	private function do_hooks() {
		add_filter( 'yaymail_shortcodes', array( $this, 'yaymail_shortcodes' ), 10, 1 );
		add_filter( 'yaymail_do_shortcode', array( $this, 'yaymail_do_shortcode' ), 10, 3 );
		add_filter( 'yaymail_list_shortcodes', array( $this, 'yaymail_list_shortcodes' ), 10, 1 );
	}

	public function yaymail_shortcodes( $shortcode_list ) {
		if ( class_exists( 'WC_Bookings' ) ) {
			$shortcode_list[] = 'yaymail_addon_vendor_id';
			$shortcode_list[] = 'yaymail_addon_vendor_store_name';
			$shortcode_list[] = 'yaymail_addon_vendor_first_name';
			$shortcode_list[] = 'yaymail_addon_vendor_last_name';
			$shortcode_list[] = 'yaymail_addon_vendor_email';
			$shortcode_list[] = 'yaymail_addon_vendor_social';
			$shortcode_list[] = 'yaymail_addon_vendor_phone';
			$shortcode_list[] = 'yaymail_addon_vendor_address';
			$shortcode_list[] = 'yaymail_addon_vendor_location';
			$shortcode_list[] = 'yaymail_addon_vendor_banner';
			$shortcode_list[] = 'yaymail_addon_vendor_gravatar';
			$shortcode_list[] = 'yaymail_addon_booking_location';
			$shortcode_list[] = 'yaymail_addon_booking_start_date';
			$shortcode_list[] = 'yaymail_addon_booking_start_time';
			$shortcode_list[] = 'yaymail_addon_booking_end_date';
			$shortcode_list[] = 'yaymail_addon_booking_end_time';
			$shortcode_list[] = 'yaymail_addon_booking_pay_for_booking';
			$shortcode_list[] = 'yaymail_addon_booking_notification_text';
			$shortcode_list[] = 'yaymail_addon_booking_id';
			$shortcode_list[] = 'yaymail_addon_woo_booking_notification_email_subject';
			$shortcode_list[] = 'yaymail_addon_woo_booking_link';
		}
		return $shortcode_list;
	}

	public function yaymail_do_shortcode( $shortcode_list, $yaymail_informations, $args = array() ) {
		if ( class_exists( 'WC_Bookings' ) ) {
			$shortcode_template_renderer = new YayMailAddonShortcodeTemplateRenderer( $yaymail_informations, $args );

			$shortcode_list['[yaymail_addon_vendor_id]'] = $shortcode_template_renderer->yaymail_addon_vendor_inforation( 'id' );

			$shortcode_list['[yaymail_addon_vendor_store_name]'] = $shortcode_template_renderer->yaymail_addon_vendor_inforation( 'store_name' );

			$shortcode_list['[yaymail_addon_vendor_first_name]'] = $shortcode_template_renderer->yaymail_addon_vendor_inforation( 'first_name' );

			$shortcode_list['[yaymail_addon_vendor_last_name]'] = $shortcode_template_renderer->yaymail_addon_vendor_inforation( 'last_name' );

			$shortcode_list['[yaymail_addon_vendor_email]'] = $shortcode_template_renderer->yaymail_addon_vendor_inforation( 'email' );

			$shortcode_list['[yaymail_addon_vendor_social]'] = $shortcode_template_renderer->yaymail_addon_vendor_inforation( 'social' );

			$shortcode_list['[yaymail_addon_vendor_phone]'] = $shortcode_template_renderer->yaymail_addon_vendor_inforation( 'phone' );

			$shortcode_list['[yaymail_addon_vendor_address]'] = $shortcode_template_renderer->yaymail_addon_vendor_inforation( 'address' );

			$shortcode_list['[yaymail_addon_vendor_location]'] = $shortcode_template_renderer->yaymail_addon_vendor_inforation( 'location' );

			$shortcode_list['[yaymail_addon_vendor_banner]'] = $shortcode_template_renderer->yaymail_addon_vendor_inforation( 'banner' );

			$shortcode_list['[yaymail_addon_vendor_gravatar]'] = $shortcode_template_renderer->yaymail_addon_vendor_inforation( 'gravatar' );

			$shortcode_list['[yaymail_addon_booking_location]'] = $shortcode_template_renderer->yaymail_addon_booking_location();

			$shortcode_list['[yaymail_addon_booking_start_date]'] = $shortcode_template_renderer->yaymail_addon_booking_start_date();

			$shortcode_list['[yaymail_addon_booking_start_time]'] = $shortcode_template_renderer->yaymail_addon_booking_start_time();

			$shortcode_list['[yaymail_addon_booking_end_date]'] = $shortcode_template_renderer->yaymail_addon_booking_end_date();

			$shortcode_list['[yaymail_addon_booking_end_time]'] = $shortcode_template_renderer->yaymail_addon_booking_end_time();

			$shortcode_list['[yaymail_addon_booking_pay_for_booking]'] = $shortcode_template_renderer->yaymail_addon_booking_pay_for_booking();

			$shortcode_list['[yaymail_addon_booking_notification_text]'] = $shortcode_template_renderer->yaymail_addon_booking_notification_text();

			$shortcode_list['[yaymail_addon_booking_id]'] = $shortcode_template_renderer->yaymail_addon_booking_id();

			$shortcode_list['[yaymail_addon_woo_booking_notification_email_subject]'] = $shortcode_template_renderer->yaymail_addon_woo_booking_notification_email_subject();

			$shortcode_list['[yaymail_addon_woo_booking_link]'] = $shortcode_template_renderer->yaymail_addon_woo_booking_link();

		}
		return $shortcode_list;
	}

	public function yaymail_list_shortcodes( $shortcode_list ) {
		$shortcode_list[] = array(
			'plugin'    => 'WooCommerce Bookings',
			'shortcode' => array(
				array( '[yaymail_addon_vendor_id]', 'Vendor ID' ),
				array( '[yaymail_addon_vendor_store_name]', 'Vendor Store Name' ),
				array( '[yaymail_addon_vendor_first_name]', 'Vendor First Name' ),
				array( '[yaymail_addon_vendor_last_name]', 'Vendor Last Name' ),
				array( '[yaymail_addon_vendor_email]', 'Vendor Email' ),
				array( '[yaymail_addon_vendor_social]', 'Vendor Social' ),
				array( '[yaymail_addon_vendor_phone]', 'Vendor Phone' ),
				array( '[yaymail_addon_vendor_address]', 'Vendor Address' ),
				array( '[yaymail_addon_vendor_location]', 'Vendor Location' ),
				array( '[yaymail_addon_vendor_banner]', 'Vendor Banner' ),
				array( '[yaymail_addon_vendor_gravatar]', 'Vendor Gravatar' ),
				array( '[yaymail_addon_booking_location]', 'Booking Location' ),
				array( '[yaymail_addon_booking_start_date]', 'Booking Start Date' ),
				array( '[yaymail_addon_booking_start_time]', 'Booking Start Time' ),
				array( '[yaymail_addon_booking_end_date]', 'Booking End Date' ),
				array( '[yaymail_addon_booking_end_time]', 'Booking End Time' ),
				array( '[yaymail_addon_booking_pay_for_booking]', 'Pay for Booking' ),
				array( '[yaymail_addon_booking_notification_text]', 'Notification Text' ),
				array( '[yaymail_addon_booking_id]', 'Booking ID' ),
				array( '[yaymail_addon_woo_booking_notification_email_subject]', 'Email Subject' ),
				array( '[yaymail_addon_woo_booking_link]', 'Booking link' ),
			),
		);

		return $shortcode_list;
	}

}
