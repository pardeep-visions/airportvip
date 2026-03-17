<?php
namespace YayMail\Page\Source;

defined( 'ABSPATH' ) || exit;
/**
 * Plugin activate/deactivate logic
 */
class TRPHandler {

	public static function trp_get_template_meta_query( $order = null ) {
		global $pagenow;
		$language_query = array();
		global $TRP_LANGUAGE;
		$trp_settings = get_option( 'trp_settings', false );
		if ( ! empty( $trp_settings ) ) {
			$trp_default_language = $trp_settings['default-language'];
		} else {
			$trp_default_language = 'en_US';
		}
		if ( isset( $_POST['nonce'] ) && wp_verify_nonce( sanitize_text_field( $_POST['nonce'] ), 'email-nonce' ) ) {
			$current_order_language = isset( $_COOKIE['pll_language'] ) ? sanitize_text_field( $_COOKIE['pll_language'] ) : 'en';
		} elseif ( null !== $order ) {
			$order_id               = $order->get_id();
			$current_order_language = get_post_meta( $order_id, 'trp_language', true );
		} else {
			$current_order_language = $TRP_LANGUAGE;
		}

		if ( 'he' == $current_order_language ) {
			update_option( 'yaymail_direction', 'rtl' );
		} else {
			update_option( 'yaymail_direction', 'ltr' );
		}

		if ( false !== strpos( sanitize_text_field( $current_order_language ), 'en' ) ) {
			$language_query = array(
				'key'     => '_yaymail_template_language',
				'compare' => 'NOT EXISTS',
				'value'   => '',
			);
		} else {
			$language_query = array(
				'key'     => '_yaymail_template_language',
				'value'   => sanitize_text_field( $current_order_language ),
				'compare' => '=',
			);
		}

		return $language_query;
	}

	public static function trp_get_email_template( $args, $order = null ) {
		$default = array(
			'post_type'   => 'yaymail_template',
			'post_status' => array( 'publish', 'pending', 'future' ),
			'meta_query'  => array(
				'relation' => 'AND',
				array(
					'key'     => '_yaymail_template',
					'value'   => $args['email_template'],
					'compare' => '=',
				),
				self::trp_get_template_meta_query( $order ),
			),
		);
		$posts   = new \WP_Query( $default );

		if ( $posts->have_posts() ) {
			return $posts->post->ID;
		}
		return false;

	}

	public static function trp_switch_language( $language ) {
		$cookie_name = 'pll_language';
		setcookie( $cookie_name, $language, time() + 86400, defined( 'COOKIEPATH' ) ? COOKIEPATH : '/' );   }

	public static function trp_update_meta_for_dupplicate( $post_id ) {
		$trp_settings = get_option( 'trp_settings', false );
		if ( ! empty( $trp_settings ) ) {
			$trp_default_language = $trp_settings['default-language'];
		} else {
			$trp_default_language = 'en_US';
		}
		if ( isset( $_COOKIE['pll_language'] ) && sanitize_text_field( $_COOKIE['pll_language'] ) !== $trp_default_language ) {
			update_post_meta( $post_id, '_yaymail_template_language', sanitize_text_field( $_COOKIE['pll_language'] ) );
		}
	}

	public static function trp_get_list_template( $posts, $getPostID ) {
		$template_export = array();
		$trp_settings    = get_option( 'trp_settings', false );
		if ( ! empty( $trp_settings ) ) {
			$trp_default_language = $trp_settings['default-language'];
		} else {
			$trp_default_language = 'en_US';
		}
		$cur_lang = isset( $_COOKIE['pll_language'] ) ? sanitize_text_field( $_COOKIE['pll_language'] ) : $trp_default_language;
		if ( count( $posts ) > 0 ) {
			$list_use_temp = array();
			foreach ( $posts as $key => $post ) {
				if ( get_post_meta( $post->ID, '_yaymail_template_language', true ) === $cur_lang || ( $trp_default_language === $cur_lang && '' === get_post_meta( $post->ID, '_yaymail_template_language', true ) ) ) {
					$template          = get_post_meta( $post->ID, '_yaymail_template', true );
					$template_language = get_post_meta( $post->ID, '_yaymail_template_language', true );
					if ( isset( $list_use_temp[ $template ][ $template_language ] )
					&& isset( $list_use_temp[ $template ][ $template_language ]['prev_id'] ) ) {
						wp_delete_post( $post->ID );
					} else {
						$list_use_temp[ $template ][ $template_language ]['prev_id'] = $post->ID;
						if ( $getPostID ) {
							$template_export[ $template ]['post_id']         = $post->ID;
							$template_export[ $template ]['_yaymail_status'] = get_post_meta( $post->ID, '_yaymail_status', true );
						} else {
							$template_export[ $template ] = get_post_meta( $post->ID, '_yaymail_status', true );
						}
					}
				}
			}
		}
		return $template_export;
	}

	public static function polylang_turn_off_dupplicate_post_type() {
		$polylang_options = get_option( 'polylang' );
		if ( isset( $polylang_options['post_types'] ) ) {
			$yaymail_template_position = array_search( 'yaymail_template', $polylang_options['post_types'] );
			if ( false !== $yaymail_template_position ) {
				$polylang_options['post_types'] = array_splice( $polylang_options['post_types'], $yaymail_template_position + 1, 1 );
				update_option( 'polylang', $polylang_options );
			}
		}
	}

}
