<?php
/**
 * Plugin Name: YayMail Premium Addon for WooCommerce Bookings
 * Plugin URI: https://yaycommerce.com/yaymail-woocommerce-email-customizer/
 * Description: Customize WooCommerce Bookings email templates with YayMail - WooCommerce Email Customizer
 * Version: 2.0
 * Author: YayCommerce
 * Author URI: https://yaycommerce.com
 * Text Domain: yaymail
 * WC requires at least: 3.0.0
 * WC tested up to: 7.8.2
 * Domain Path: /i18n/languages/
 */

namespace YayMailWooBooking;

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'YAYMAIL_ADDON_WOO_BOOKING_NAME' ) ) {
	define( 'YAYMAIL_ADDON_WOO_BOOKING_NAME', 'YayMail Premium Addon for WooCommerce Bookings' );
}

if ( ! defined( 'YAYMAIL_ADDON_WOO_BOOKING' ) ) {
	define( 'YAYMAIL_ADDON_WOO_BOOKING', 'woo_bookings' );
}

if ( ! defined( 'YAYMAIL_ADDON_WOO_BOOKING_PLUGIN_PATH' ) ) {
	define( 'YAYMAIL_ADDON_WOO_BOOKING_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'YAYMAIL_ADDON_WOO_BOOKING_PLUGIN_BASENAME' ) ) {
	define( 'YAYMAIL_ADDON_WOO_BOOKING_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
}

if ( ! defined( 'YAYMAIL_ADDON_WOO_BOOKING_PLUGIN_DATA' ) ) {
	if ( ! function_exists( 'get_plugin_data' ) ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
	}
	define( 'YAYMAIL_ADDON_WOO_BOOKING_PLUGIN_DATA', get_plugin_data( __FILE__ ) );
}

if ( ! defined( 'YAYMAIL_ADDON_WOO_BOOKING_LINK_URL' ) ) {
	define( 'YAYMAIL_ADDON_WOO_BOOKING_LINK_URL', 'https://yaycommerce.com/yaymail-addons/yaymail-premium-addon-for-woocommerce-bookings' );
}

if ( ! defined( 'YAYMAIL_ADDON_WOO_BOOKING_PLUGIN_URL' ) ) {
	define( 'YAYMAIL_ADDON_WOO_BOOKING_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'YAYMAIL_ADDON_WOO_BOOKING_VERSION' ) ) {
	// TODO Change version
	define( 'YAYMAIL_ADDON_WOO_BOOKING_VERSION', '2.0' );
}

spl_autoload_register(
	function ( $class ) {
		$prefix   = __NAMESPACE__;
		$base_dir = __DIR__ . '/includes';

		$len = strlen( $prefix );
		if ( strncmp( $prefix, $class, $len ) !== 0 ) {
			return;
		}

		$relative_class_name = substr( $class, $len );

		$file = $base_dir . str_replace( '\\', '/', $relative_class_name ) . '.php';

		if ( file_exists( $file ) ) {
			require $file;
		}
	}
);

function init() {

	Core\YayMailAddonLicense::initialize();
	if ( ! defined( 'YAYMAIL_THIRD_PARTY_WOO_BOOKING_IS_ACTIVE' ) ) {
		$is_active = class_exists( 'WC_Bookings' );
		define( 'YAYMAIL_THIRD_PARTY_WOO_BOOKING_IS_ACTIVE', $is_active );
	}

	if ( ! YAYMAIL_THIRD_PARTY_WOO_BOOKING_IS_ACTIVE || ! function_exists( 'YayMail\\init' ) ) {
		Backend\Notices::initialize();
	}

	if ( YAYMAIL_THIRD_PARTY_WOO_BOOKING_IS_ACTIVE && function_exists( 'YayMail\\init' ) ) {
		Backend\Enqueue::initialize();
		Backend\Actions::initialize();
		Core\YayMailAddonController::get_instance();
		Core\YayMailAddonShortcodeHandle::get_instance();
	}
}

add_action( 'plugins_loaded', 'YayMailWooBooking\\init' );










