<?php

namespace YayMailWooBooking\Core;

defined( 'ABSPATH' ) || exit;

use YayMailWooBooking\TemplateDefault\DefaultWooBooking;

class YayMailAddonController {
	protected static $instance = null;
	private $template_email_id = null;

	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new self();
			self::$instance->do_hooks();
		}

		return self::$instance;
	}

	private function do_hooks() {
		$this->template_email_id = array(
			'admin_booking_cancelled',
			'booking_cancelled',
			'booking_confirmed',
			'booking_notification',
			'booking_pending_confirmation',
			'booking_reminder',
			'new_booking',
		);

		YayMailAddonElementRender::get_instance( $this->template_email_id );
		add_filter( 'yaymail_addon_get_updated_elements', array( $this, 'yaymail_addon_get_updated_elements' ), 10, 1 );
		add_filter( 'YaymailNewTempalteDefault', array( $this, 'yaymail_new_template_default' ), 100, 3 );
		add_filter( 'yaymail_addon_defined_shorcode', array( $this, 'yaymail_addon_defined_shorcode' ) );
		add_filter( 'yaymail_addon_defined_template', array( $this, 'yaymail_addon_defined_template' ), 100, 2 );
	}

	public function yaymail_addon_defined_template( $result, $template ) {
		$template_email_id = $this->template_email_id;
		if ( in_array( $template, $template_email_id ) ) {
			return true;
		}
		return $result;
	}

	/*
	Action to defined shortcode
	$arrData[0] : $custom_shortcode
	$arrData[1] : $args
	$arrData[2] : $templateName
	*/
	public function yaymail_addon_defined_shorcode( $arrData ) {
		$template_email_id = $this->template_email_id;
		if ( in_array( $arrData[2], $template_email_id ) ) {
			$arrData[0]->setOrderId( isset( $arrData[1]['booking']->get_data()['order_id'] ) ? $arrData[1]['booking']->get_data()['order_id'] : 0, 'new_booking' === $arrData[2] ? true : $arrData[1]['sent_to_admin'], $arrData[1] );
			$arrData[0]->shortCodesOrderDefined( isset( $arrData[1]['sent_to_admin'] ) ? $arrData[1]['sent_to_admin'] : false, $arrData[1], 'not_order' );
		}
	}

	public function yaymail_new_template_default( $array, $key, $value ) {
		$get_heading = isset( $value->heading ) ? $value->heading : '';
		$valid_keys  = array(
			'WC_Email_Admin_Booking_Cancelled',
			'WC_Email_Booking_Cancelled',
			'WC_Email_Booking_Confirmed',
			'WC_Email_Booking_Notification',
			'WC_Email_New_Booking',
			'WC_Email_Booking_Pending_Confirmation',
			'WC_Email_Booking_Reminder',
		);

		if ( in_array( $key, $valid_keys ) ) {
			$default_booking                        = DefaultWooBooking::get_templates( $value->id, $get_heading );
			$default_booking[ $value->id ]['title'] = __( $value->title, 'woocommerce' );
			return $default_booking;
		}
		return $array;
	}

	public static function yaymail_addon_get_updated_elements( $element ) {
		$result = array_merge( $element, array() );
		return $result;
	}
}
