<?php
namespace YayMail\Page\Source;

if ( \class_exists( 'GTranslate' ) ) {

	class GTranslateAddon {

		public static function get_template_meta_query() {
			$language_query = array();
			$language       = self::get_active_language();
			$direction      = in_array( $language, array( 'ar', 'iw', 'fa' ) ) ? 'rtl' : 'ltr';
			update_option( 'yaymail_direction', $direction );
			$language = 'en' === $language ? null : $language;
			if ( $language ) {
				$language_query = array(
					'key'     => '_yaymail_template_language',
					'value'   => sanitize_text_field( $language ),
					'compare' => '=',
				);
			} else {
				$language_query = array(
					'key'     => '_yaymail_template_language',
					'compare' => 'NOT EXISTS',
					'value'   => '',
				);
			}
			return $language_query;
		}

		public static function get_email_template( $args ) {
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
					self::get_template_meta_query(),
				),
			);
			$posts   = new \WP_Query( $default );

			if ( $posts->have_posts() ) {
				return $posts->post->ID;
			}
			return false;

		}

		public static function get_languages() {
			$gt_lang_array_json = '{"af":"Afrikaans","sq":"Albanian","am":"Amharic","ar":"Arabic","hy":"Armenian","az":"Azerbaijani","eu":"Basque","be":"Belarusian","bn":"Bengali","bs":"Bosnian","bg":"Bulgarian","ca":"Catalan","ceb":"Cebuano","ny":"Chichewa","zh-CN":"Chinese (Simplified)","zh-TW":"Chinese (Traditional)","co":"Corsican","hr":"Croatian","cs":"Czech","da":"Danish","nl":"Dutch","en":"English","eo":"Esperanto","et":"Estonian","tl":"Filipino","fi":"Finnish","fr":"French","fy":"Frisian","gl":"Galician","ka":"Georgian","de":"German","el":"Greek","gu":"Gujarati","ht":"Haitian Creole","ha":"Hausa","haw":"Hawaiian","iw":"Hebrew","hi":"Hindi","hmn":"Hmong","hu":"Hungarian","is":"Icelandic","ig":"Igbo","id":"Indonesian","ga":"Irish","it":"Italian","ja":"Japanese","jw":"Javanese","kn":"Kannada","kk":"Kazakh","km":"Khmer","ko":"Korean","ku":"Kurdish (Kurmanji)","ky":"Kyrgyz","lo":"Lao","la":"Latin","lv":"Latvian","lt":"Lithuanian","lb":"Luxembourgish","mk":"Macedonian","mg":"Malagasy","ms":"Malay","ml":"Malayalam","mt":"Maltese","mi":"Maori","mr":"Marathi","mn":"Mongolian","my":"Myanmar (Burmese)","ne":"Nepali","no":"Norwegian","ps":"Pashto","fa":"Persian","pl":"Polish","pt":"Portuguese","pa":"Punjabi","ro":"Romanian","ru":"Russian","sm":"Samoan","gd":"Scottish Gaelic","sr":"Serbian","st":"Sesotho","sn":"Shona","sd":"Sindhi","si":"Sinhala","sk":"Slovak","sl":"Slovenian","so":"Somali","es":"Spanish","su":"Sundanese","sw":"Swahili","sv":"Swedish","tg":"Tajik","ta":"Tamil","te":"Telugu","th":"Thai","tr":"Turkish","uk":"Ukrainian","ur":"Urdu","uz":"Uzbek","vi":"Vietnamese","cy":"Welsh","xh":"Xhosa","yi":"Yiddish","yo":"Yoruba","zu":"Zulu"}';
			$gt_lang_array      = get_object_vars( json_decode( $gt_lang_array_json ) );
			$data               = get_option( 'GTranslate' );
			\GTranslate::load_defaults( $data );
			$fincl_langs           = isset( $data['fincl_langs'] ) ? $data['fincl_langs'] : array();
			$gtranslate_plugin_url = preg_replace( '/^https?:/i', '', plugins_url() . '/gtranslate' );
			$active_language       = self::get_active_language();
			$list_languages        = array_map(
				function( $lang ) use ( $gt_lang_array, $active_language, $gtranslate_plugin_url ) {
					$flag_path = "{$gtranslate_plugin_url}/flags/svg/";
					if ( 'en-us' === $lang ) {
						$flag = "{$flag_path}en-us.svg";
					} elseif ( 'en-ca' === $lang ) {
						$flag = "{$flag_path}en-ca.svg";
					} elseif ( 'pt-br' === $lang ) {
						$flag = "{$flag_path}pt-br.svg";
					} elseif ( 'es-mx' === $lang ) {
						$flag = "{$flag_path}es-mx.svg";
					} elseif ( 'es-ar' === $lang ) {
						$flag = "{$flag_path}es-ar.svg";
					} elseif ( 'es-co' === $lang ) {
						$flag = "{$flag_path}es-co.svg";
					} elseif ( 'fr-qc' === $lang ) {
						$flag = "{$flag_path}fr-qc.svg";
					} else {
						$flag = "{$flag_path}{$lang}.svg";
					}
					return array(
						'code'   => $lang,
						'name'   => isset( $gt_lang_array[ $lang ] ) ? $gt_lang_array[ $lang ] : 'Unknown',
						'flag'   => $flag,
						'active' => $active_language === $lang,
					);
				},
				$fincl_langs
			);

			return $list_languages;
		}

		public static function get_active_language() {
			if ( isset( $_SERVER['HTTP_X_GT_LANG'] ) ) {
				return sanitize_text_field( $_SERVER['HTTP_X_GT_LANG'] );
			}
			$language = 'en';
			if ( isset( $_COOKIE['googtrans'] ) ) {
				$googtrans = sanitize_text_field( $_COOKIE['googtrans'] );
				$googtrans = explode( '/', $googtrans );
				$language  = $googtrans[ count( $googtrans ) - 1 ];
			}
			if ( is_admin() ) {
				$language = isset( $_COOKIE['gt_language'] ) ? sanitize_text_field( $_COOKIE['gt_language'] ) : $language;
			}
			return $language;
		}

		public static function switch_language( $language ) {
			setcookie( 'gt_language', $language, time() + 86400, defined( 'COOKIEPATH' ) ? COOKIEPATH : '/' );
		}

		public static function update_meta_for_dupplicate_post( $post_id ) {
			if ( isset( $_COOKIE['gt_language'] ) && 'en' !== sanitize_text_field( $_COOKIE['gt_language'] ) ) {
				update_post_meta( $post_id, '_yaymail_template_language', sanitize_text_field( $_COOKIE['gt_language'] ) );
			}
		}

		public static function get_list_template( $posts, $getPostID ) {
			$template_export = array();
			$cur_lang        = isset( $_COOKIE['gt_language'] ) ? sanitize_text_field( $_COOKIE['gt_language'] ) : 'en';
			if ( count( $posts ) > 0 ) {
				$list_use_temp = array();
				foreach ( $posts as $key => $post ) {
					if ( get_post_meta( $post->ID, '_yaymail_template_language', true ) === $cur_lang || ( 'en' === $cur_lang && '' === get_post_meta( $post->ID, '_yaymail_template_language', true ) ) ) {
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
	}
}
