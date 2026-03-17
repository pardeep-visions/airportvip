<?php

namespace YayMailWooBooking\Backend;

defined( 'ABSPATH' ) || exit;

class Enqueue {
	public static function initialize() {
		add_action( 'yaymail_before_enqueue_dependence', array( __CLASS__, 'yaymail_dependence' ) );
	}

	public static function yaymail_dependence() {
		wp_enqueue_script( 'yaymail-addon' . YAYMAIL_ADDON_WOO_BOOKING, YAYMAIL_ADDON_WOO_BOOKING_PLUGIN_URL . 'assets/dist/js/app.js', array(), YAYMAIL_ADDON_WOO_BOOKING_VERSION, true );
		wp_enqueue_style( 'yaymail-addon' . YAYMAIL_ADDON_WOO_BOOKING, YAYMAIL_ADDON_WOO_BOOKING_PLUGIN_URL . 'assets/dist/css/app.css', array(), YAYMAIL_ADDON_WOO_BOOKING_VERSION );
	}
}
