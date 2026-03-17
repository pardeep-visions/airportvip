<?php

namespace YayMailWooBooking\Core;

defined( 'ABSPATH' ) || exit;

use YayMail\Helper\Helper;

class YayMailAddonElementRender {
	protected static $instance = null;
	private $template_email_id = null;
	public static function get_instance( $template_email_id ) {
		if ( null == self::$instance ) {
			self::$instance = new self();
			self::$instance->do_hooks( $template_email_id );
		}

		return self::$instance;
	}

	private function do_hooks( $template_email_id ) {
		$this->template_email_id = $template_email_id;
		add_filter( 'yaymail_plugins', array( $this, 'yaymail_plugins' ), 10, 1 );
		add_filter( 'yaymail_addon_templates', array( $this, 'yaymail_addon_templates' ), 100, 3 );
		$this->do_hook_vue_render();
		$this->do_hook_element_render();
	}

	public function yaymail_plugins( $plugins ) {
		$plugins[] = array(
			// TODO cases different
			'plugin_name'      => 'WC_Bookings',
			'addon_components' => array(
				'WooBookingDetail',
			),
			'template_name'    => $this->template_email_id,
		);
		return $plugins;
	}

	// Filter to add template to Vuex
	public static function yaymail_addon_templates( $addon_templates, $order, $post_id ) {
		if ( class_exists( 'WC_Bookings' ) ) {
			$components = apply_filters( 'yaymail_plugins', array() );
			$position   = '';
			foreach ( $components as $key => $component ) {
				if ( 'WC_Bookings' === $component['plugin_name'] ) {
					$position = $key;
					break;
				}
			}
			foreach ( $components[ $position ]['addon_components'] as $key => $component ) {
				ob_start();
				do_action( 'YaymailAddon' . $component . 'Vue', $order, $post_id );
				$html = ob_get_contents();
				ob_end_clean();
				$addon_templates['woo_bookings'] = array_merge( isset( $addon_templates['woo_bookings'] ) ? $addon_templates['woo_bookings'] : array(), array( $component . 'Vue' => $html ) );
			};
		}
		return $addon_templates;
	}

	// Create HTML with Vue syntax to display in Vue
	// CHANGE HERE => Name of action follow : YaymailAddon + main-name + Vue
	// CHANGE SOURCE VUE TOO
	// TODO Change this
	private function do_hook_vue_render() {
		add_action( 'YaymailAddonWooBookingDetailVue', array( $this, 'woo_booking_detail_vue' ), 100, 2 );
	}

	// Create HTML to display when send mail
	// CHANGE HERE => Name of action follow: YaymailAddon + main-name
	private function do_hook_element_render() {
		add_action( 'YaymailAddonWooBookingDetail', array( $this, 'yaymail_addon_woo_booking_detail' ), 100, 5 );
	}

	//-------------- Vue Element Render -----------//

	public function woo_booking_detail_vue( $order, $post_id = '' ) {
		if ( class_exists( 'WC_Bookings' ) ) {
			if ( '' === $order ) {
				ob_start();
				include YAYMAIL_ADDON_WOO_BOOKING_PLUGIN_PATH . '/views/VueTemplate/yaymail-addon-woo-booking-detail-default.php';
				$html = ob_get_contents();
				ob_end_clean();
			} else {
				$bookings = \WC_Booking_Data_Store::get_booking_ids_from_order_id( $order->id );
				ob_start();
				if ( count( $bookings ) ) {
					$booking_id = $bookings[0];
					include YAYMAIL_ADDON_WOO_BOOKING_PLUGIN_PATH . '/views/VueTemplate/yaymail-addon-woo-booking-detail.php';
				} else {
					include YAYMAIL_ADDON_WOO_BOOKING_PLUGIN_PATH . '/views/VueTemplate/yaymail-addon-woo-booking-detail-default.php';
				}
				$html = ob_get_contents();
				ob_end_clean();
				if ( '' === $html ) {
					$html = '<div></div>';
				}
			}
			echo $html;
		}
	}

	//-------------- Element Render -----------//

	public function yaymail_addon_woo_booking_detail( $args = array(), $attrs = array(), $general_attrs = array(), $id = '', $post_id = '' ) {
		if ( class_exists( 'WC_Bookings' ) ) {
			if ( isset( $args['booking'] ) && false != $args['booking'] ) {
				$order = wc_get_order( $args['booking']->data['order_id'] );
				ob_start();
				$booking = $args['booking'];
				if ( isset( $booking ) ) {
					include YAYMAIL_ADDON_WOO_BOOKING_PLUGIN_PATH . '/views/Template/yaymail-addon-woo-booking-detail.php';
				};
				$html = ob_get_contents();
				ob_end_clean();
				$html = do_shortcode( $html );
				echo wp_kses_post( $html );
			} else {
				echo wp_kses_post( '' );
			}
		}
	}
}
