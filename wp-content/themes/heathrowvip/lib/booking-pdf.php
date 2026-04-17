<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

final class HVIP_Booking_Functionality {
	const M_GREETER_NAME = '_hvip_greeter_name';
	const M_GREETER_CONTACT = '_hvip_greeter_contact';
	const M_CHAUFFEUR_NAME = '_hvip_chauffeur_name';
	const M_CHAUFFEUR_EMAIL = '_hvip_chauffeur_email';
	const M_CHAUFFEUR_CONTACT = '_hvip_chauffeur_contact';
	const M_PDF_PATH = '_hvip_booking_pdf_path';
	const M_PDF_DONE = '_hvip_booking_pdf_generated';
	const M_PRIMARY_BOOKING_ID = '_hvip_primary_booking_id';
	const NONCE_FIELD = 'hvip_booking_pdf_nonce';
	const NONCE_ACTION = 'hvip_booking_pdf_save';

	public static function init() {
		self::load_mpdf();
		add_action( 'add_meta_boxes_wc_booking', [ __CLASS__, 'register_box' ] );
		add_action( 'save_post_wc_booking', [ __CLASS__, 'save_booking_box' ], 20, 3 );
		add_action( 'woocommerce_checkout_order_processed', [ __CLASS__, 'on_checkout' ], 30, 3 );
		add_action( 'woocommerce_checkout_order_processed', [ __CLASS__, 'on_checkout_generate_pdf' ], 100, 3 );
		add_action( 'woocommerce_store_api_checkout_order_processed', [ __CLASS__, 'on_store_checkout_generate_pdf' ], 100, 1 );
		add_action( 'woocommerce_new_booking', [ __CLASS__, 'on_new_booking' ], 30, 1 );
		add_filter( 'woocommerce_email_attachments', [ __CLASS__, 'attach_pdf_to_wc_emails' ], 10, 4 );
		add_action( 'admin_post_hvip_resend_booking_emails', [ __CLASS__, 'resend_action' ] );
		add_action( 'admin_post_hvip_preview_booking_emails', [ __CLASS__, 'preview_action' ] );
		add_action( 'admin_post_hvip_download_booking_pdf', [ __CLASS__, 'download_pdf_action' ] );
	}

	private static function load_mpdf() {
		$autoload = get_stylesheet_directory() . '/lib/mpdf/vendor/autoload.php';
		if ( file_exists( $autoload ) ) {
			require_once $autoload;
		}
	}

	private static function mpdf_ok() { return class_exists( '\Mpdf\Mpdf' ); }

	private static function mpdf_temp_dir() {
		$candidates = [];
		$sys_tmp = (string) sys_get_temp_dir();
		if ( $sys_tmp ) {
			$candidates[] = $sys_tmp;
		}
		$upload = wp_upload_dir();
		if ( ! empty( $upload['basedir'] ) ) {
			$candidates[] = trailingslashit( $upload['basedir'] ) . 'tmp';
		}

		foreach ( $candidates as $dir ) {
			$dir = untrailingslashit( (string) $dir );
			if ( ! $dir ) {
				continue;
			}
			if ( ! is_dir( $dir ) ) {
				wp_mkdir_p( $dir );
			}
			if ( is_dir( $dir ) && is_writable( $dir ) ) {
				return $dir;
			}
		}

		return '';
	}

	private static function booking_order( $booking_id ) {
		$order_id = 0;
		if ( function_exists( 'get_wc_booking' ) ) {
			$b = get_wc_booking( $booking_id );
			if ( $b && method_exists( $b, 'get_order_id' ) ) { $order_id = (int) $b->get_order_id(); }
		}
		if ( ! $order_id ) { $order_id = absint( get_post_meta( $booking_id, '_booking_order_id', true ) ); }
		return $order_id ? wc_get_order( $order_id ) : null;
	}

	private static function primary_booking_id_for_order( WC_Order $order ) {
		$stored = absint( $order->get_meta( self::M_PRIMARY_BOOKING_ID ) );
		if ( $stored > 0 ) {
			return $stored;
		}
		// Bookings are linked to orders via post_parent (see WC_Booking_Data_Store), not _booking_order_id meta.
		if ( class_exists( 'WC_Booking_Data_Store' ) ) {
			$ids = WC_Booking_Data_Store::get_booking_ids_from_order_id( $order->get_id() );
			if ( ! empty( $ids ) ) {
				rsort( $ids, SORT_NUMERIC );
				return (int) $ids[0];
			}
		}
		// Legacy admin/meta fallback (some setups may still store this key).
		$q = new WP_Query( [
			'post_type' => 'wc_booking',
			'post_status' => 'any',
			'posts_per_page' => 1,
			'fields' => 'ids',
			'orderby' => 'ID',
			'order' => 'DESC',
			'meta_query' => [
				[
					'key' => '_booking_order_id',
					'value' => (string) $order->get_id(),
					'compare' => '=',
				],
			],
		] );
		if ( ! empty( $q->posts ) ) {
			return (int) $q->posts[0];
		}
		return 0;
	}

	public static function on_new_booking( $booking_arg ) {
		$booking = null;
		if ( $booking_arg instanceof WC_Booking ) {
			$booking = $booking_arg;
		} elseif ( function_exists( 'get_wc_booking' ) ) {
			$booking = get_wc_booking( absint( $booking_arg ) );
		}
		if ( ! $booking || ! ( $booking instanceof WC_Booking ) ) {
			return;
		}

		$order_id = (int) $booking->get_order_id();
		if ( $order_id <= 0 ) {
			return;
		}
		$order = wc_get_order( $order_id );
		if ( ! $order ) {
			return;
		}

		$order->update_meta_data( self::M_PRIMARY_BOOKING_ID, (int) $booking->get_id() );
		$pdf = self::generate_pdf( $order, true, (int) $booking->get_id() );
		if ( $pdf ) {
			$order->update_meta_data( self::M_PDF_DONE, 'yes' );
		}
		$order->save();
	}

	private static function resolve_booking_for_order( WC_Order $order, $booking_id = 0 ) {
		// 1) Explicit booking id always wins.
		if ( $booking_id && function_exists( 'get_wc_booking' ) ) {
			try {
				$b = get_wc_booking( (int) $booking_id );
				if ( $b instanceof WC_Booking ) {
					return $b;
				}
			} catch ( \Throwable $e ) {}
		}

		// 2) Data store: bookings linked by post_parent = order ID.
		if ( class_exists( 'WC_Booking_Data_Store' ) && function_exists( 'get_wc_booking' ) ) {
			$ids = WC_Booking_Data_Store::get_booking_ids_from_order_id( $order->get_id() );
			if ( ! empty( $ids ) ) {
				rsort( $ids, SORT_NUMERIC );
				foreach ( $ids as $bid ) {
					try {
						$b = get_wc_booking( (int) $bid );
						if ( $b instanceof WC_Booking ) {
							return $b;
						}
					} catch ( \Throwable $e ) {}
				}
			}
		}

		// 3) Resolve from order-item relation used by WooCommerce Bookings.
		$item_ids = array_keys( $order->get_items() );
		foreach ( $item_ids as $item_id ) {
			$q = new WP_Query( [
				'post_type' => 'wc_booking',
				'post_status' => 'any',
				'posts_per_page' => 1,
				'fields' => 'ids',
				'orderby' => 'ID',
				'order' => 'DESC',
				'meta_query' => [
					[
						'key' => '_booking_order_item_id',
						'value' => (string) $item_id,
						'compare' => '=',
					],
				],
			] );
			if ( ! empty( $q->posts ) && function_exists( 'get_wc_booking' ) ) {
				try {
					$b = get_wc_booking( (int) $q->posts[0] );
					if ( $b instanceof WC_Booking ) {
						return $b;
					}
				} catch ( \Throwable $e ) {}
			}
		}

		// 4) Final fallback by order relation.
		$fallback_booking_id = self::primary_booking_id_for_order( $order );
		if ( $fallback_booking_id && function_exists( 'get_wc_booking' ) ) {
			try {
				$b = get_wc_booking( (int) $fallback_booking_id );
				if ( $b instanceof WC_Booking ) {
					return $b;
				}
			} catch ( \Throwable $e ) {}
		}

		return null;
	}

	private static function booking_for_order_item( $order_item_id ) {
		$order_item_id = absint( $order_item_id );
		if ( $order_item_id <= 0 || ! function_exists( 'get_wc_booking' ) ) {
			return null;
		}
		$q = new WP_Query( [
			'post_type' => 'wc_booking',
			'post_status' => 'any',
			'posts_per_page' => 1,
			'fields' => 'ids',
			'orderby' => 'ID',
			'order' => 'DESC',
			'meta_query' => [
				[
					'key' => '_booking_order_item_id',
					'value' => (string) $order_item_id,
					'compare' => '=',
				],
			],
		] );
		if ( empty( $q->posts ) ) {
			return null;
		}
		try {
			$b = get_wc_booking( (int) $q->posts[0] );
			return ( $b instanceof WC_Booking ) ? $b : null;
		} catch ( \Throwable $e ) {}
		return null;
	}

	private static function booking_product_id( $booking ) {
		if ( ! $booking || ! ( $booking instanceof WC_Booking ) ) {
			return 0;
		}
		$pid = 0;
		if ( method_exists( $booking, 'get_product_id' ) ) {
			$pid = (int) $booking->get_product_id();
		}
		if ( $pid <= 0 && method_exists( $booking, 'get_product' ) ) {
			$p = $booking->get_product();
			if ( $p ) {
				$pid = (int) $p->get_id();
			}
		}
		return $pid > 0 ? $pid : 0;
	}

	private static function booking_map_for_order_items( WC_Order $order ) {
		$items = $order->get_items();
		$item_ids = [];
		foreach ( $items as $it ) {
			$item_ids[ (int) $it->get_id() ] = true;
		}
		$map = [];
		$pool = [];
		if ( class_exists( 'WC_Booking_Data_Store' ) && function_exists( 'get_wc_booking' ) ) {
			$booking_ids = WC_Booking_Data_Store::get_booking_ids_from_order_id( $order->get_id() );
			if ( is_array( $booking_ids ) && ! empty( $booking_ids ) ) {
				sort( $booking_ids, SORT_NUMERIC );
				foreach ( $booking_ids as $booking_id ) {
					try {
						$booking = get_wc_booking( (int) $booking_id );
						if ( ! ( $booking instanceof WC_Booking ) ) {
							continue;
						}
						$linked_item_id = (int) get_post_meta( (int) $booking_id, '_booking_order_item_id', true );
						if ( $linked_item_id > 0 && isset( $item_ids[ $linked_item_id ] ) && ! isset( $map[ $linked_item_id ] ) ) {
							$map[ $linked_item_id ] = $booking;
							continue;
						}
						$pool[] = $booking;
					} catch ( \Throwable $e ) {}
				}
			}
		}
		if ( empty( $pool ) ) {
			return $map;
		}
		$pool_by_product = [];
		foreach ( $pool as $booking ) {
			$product_id = self::booking_product_id( $booking );
			if ( ! isset( $pool_by_product[ $product_id ] ) ) {
				$pool_by_product[ $product_id ] = [];
			}
			$pool_by_product[ $product_id ][] = $booking;
		}
		foreach ( $items as $item ) {
			$item_id = (int) $item->get_id();
			if ( isset( $map[ $item_id ] ) ) {
				continue;
			}
			$product_id = (int) $item->get_product_id();
			if ( isset( $pool_by_product[ $product_id ] ) && ! empty( $pool_by_product[ $product_id ] ) ) {
				$map[ $item_id ] = array_shift( $pool_by_product[ $product_id ] );
				continue;
			}
			foreach ( $pool_by_product as $pid => $bucket ) {
				if ( ! empty( $bucket ) ) {
					$map[ $item_id ] = array_shift( $pool_by_product[ $pid ] );
					break;
				}
			}
		}
		return $map;
	}

	public static function register_box( $post ) {
		$order = self::booking_order( $post->ID ?? 0 );
		if ( ! $order || ! self::is_arrival_departure_gold_booking( $order ) ) {
			return;
		}
		add_meta_box( 'hvip-booking-pdf-box', __( 'Greeter Details', 'heathrowvip' ), [ __CLASS__, 'render_box' ], 'wc_booking', 'normal', 'default' );
	}

	public static function render_box( $post ) {
		$order = self::booking_order( $post->ID );
		if ( ! $order ) { echo '<p><em>No linked order found.</em></p>'; return; }
		$show_chauffeur_fields = self::is_arrival_departure_gold_booking( $order );
		wp_nonce_field( self::NONCE_ACTION, self::NONCE_FIELD );
		$gname = (string) $order->get_meta( self::M_GREETER_NAME );
		$gcon = (string) $order->get_meta( self::M_GREETER_CONTACT );
		$cname = (string) $order->get_meta( self::M_CHAUFFEUR_NAME );
		$cemail = (string) $order->get_meta( self::M_CHAUFFEUR_EMAIL );
		$ccon = (string) $order->get_meta( self::M_CHAUFFEUR_CONTACT );
		if ( $show_chauffeur_fields ) {
		echo '<p><label>Greeter Name</label><input type="text" class="widefat" name="hvip_greeter_name" value="' . esc_attr( $gname ) . '"></p>';
		echo '<p><label>Greeter Contact</label><input type="text" class="widefat" name="hvip_greeter_contact" value="' . esc_attr( $gcon ) . '"></p>';
		
			echo '<hr><p><label>Chauffeur Name</label><input type="text" class="widefat" name="hvip_chauffeur_name" value="' . esc_attr( $cname ) . '"></p>';
			echo '<p><label>Chauffeur Email</label><input type="email" class="widefat" name="hvip_chauffeur_email" value="' . esc_attr( $cemail ) . '"></p>';
			echo '<p><label>Chauffeur Contact</label><input type="text" class="widefat" name="hvip_chauffeur_contact" value="' . esc_attr( $ccon ) . '"></p>';
		}
		echo '<p>';
		echo '<button type="submit" class="button button-primary" name="hvip_resend_after_save" value="1">Save & Resend Email (PDF)</button> ';
		// echo '<a class="button" href="' . esc_url( wp_nonce_url( add_query_arg( [ 'action' => 'hvip_resend_booking_emails', 'booking_id' => $post->ID ], admin_url( 'admin-post.php' ) ), 'hvip_resend_booking_emails_' . $post->ID ) ) . '">Resend Email (PDF)</a> ';
		// echo '<a class="button" href="' . esc_url( wp_nonce_url( add_query_arg( [ 'action' => 'hvip_preview_booking_emails', 'booking_id' => $post->ID ], admin_url( 'admin-post.php' ) ), 'hvip_preview_booking_emails_' . $post->ID ) ) . '">Preview Emails (Local)</a>';
		echo '</p>';
	}

	public static function save_booking_box( $post_id, $post, $update ) {
		if ( 'wc_booking' !== get_post_type( $post_id ) || ! current_user_can( 'edit_wc_booking', $post_id ) ) { return; }
		// WordPress may fire multiple save passes (autosave/revisions/REST updates). Never email in those.
		if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || wp_is_post_autosave( $post_id ) || wp_is_post_revision( $post_id ) ) {
			return;
		}
		$nonce = isset( $_POST[ self::NONCE_FIELD ] ) ? sanitize_text_field( wp_unslash( $_POST[ self::NONCE_FIELD ] ) ) : '';
		if ( ! $nonce || ! wp_verify_nonce( $nonce, self::NONCE_ACTION ) ) { return; }
		$order = self::booking_order( $post_id ); if ( ! $order ) { return; }
		$show_chauffeur_fields = self::is_arrival_departure_gold_booking( $order );
		$order->update_meta_data( self::M_GREETER_NAME, sanitize_text_field( wp_unslash( $_POST['hvip_greeter_name'] ?? '' ) ) );
		$order->update_meta_data( self::M_GREETER_CONTACT, sanitize_text_field( wp_unslash( $_POST['hvip_greeter_contact'] ?? '' ) ) );
		if ( $show_chauffeur_fields ) {
			$order->update_meta_data( self::M_CHAUFFEUR_NAME, sanitize_text_field( wp_unslash( $_POST['hvip_chauffeur_name'] ?? '' ) ) );
			$order->update_meta_data( self::M_CHAUFFEUR_EMAIL, sanitize_email( wp_unslash( $_POST['hvip_chauffeur_email'] ?? '' ) ) );
			$order->update_meta_data( self::M_CHAUFFEUR_CONTACT, sanitize_text_field( wp_unslash( $_POST['hvip_chauffeur_contact'] ?? '' ) ) );
		} else {
			$order->delete_meta_data( self::M_CHAUFFEUR_NAME );
			$order->delete_meta_data( self::M_CHAUFFEUR_EMAIL );
			$order->delete_meta_data( self::M_CHAUFFEUR_CONTACT );
		}
		$order->save();
		if ( isset( $_POST['hvip_resend_after_save'] ) && '1' === (string) $_POST['hvip_resend_after_save'] ) {
			// Prevent duplicates when this hook runs multiple times for the same click.
			$lock_key = 'hvip_resend_after_save_lock_' . absint( $post_id ) . '_' . absint( $order->get_id() );
			if ( ! get_transient( $lock_key ) ) {
				set_transient( $lock_key, 1, 60 ); // 60s is enough to cover multiple save passes.
				self::regen_and_send( $order, 'admin_resend_after_save', (int) $post_id );
			}
		}
	}

	public static function on_checkout( $order_id, $posted, $order ) {
		// Keep default WooCommerce customer emails on order creation.
		// Do not finalize PDF here because booking relation may not be ready yet.
		// Attachment hook below regenerates at send-time with final booking data.
		if ( ! $order instanceof WC_Order ) { $order = wc_get_order( $order_id ); }
		if ( ! $order ) { return; }
	}

	/**
	 * After checkout, the booking is linked to the order (post_parent). Generate PDF so it exists under uploads/airportvip-pdfs.
	 * Runs late so line items and booking order_id are set before we resolve the booking.
	 */
	public static function on_checkout_generate_pdf( $order_id, $posted_data, $order ) {
		if ( ! $order instanceof WC_Order ) {
			$order = wc_get_order( $order_id );
		}
		if ( ! $order || 'checkout-draft' === $order->get_status() ) {
			return;
		}
		self::ensure_pdf_for_order( $order );
	}

	public static function on_store_checkout_generate_pdf( $order ) {
		if ( ! $order instanceof WC_Order ) {
			return;
		}
		if ( 'checkout-draft' === $order->get_status() ) {
			return;
		}
		self::ensure_pdf_for_order( $order );
	}

	private static function ensure_pdf_for_order( WC_Order $order ) {
		$booking_id = self::primary_booking_id_for_order( $order );
		if ( ! $booking_id ) {
			$b = self::resolve_booking_for_order( $order, 0 );
			if ( $b instanceof WC_Booking ) {
				$booking_id = (int) $b->get_id();
			}
		}
		if ( ! $booking_id ) {
			return;
		}
		$order->update_meta_data( self::M_PRIMARY_BOOKING_ID, $booking_id );
		$pdf = self::generate_pdf( $order, true, $booking_id );
		if ( $pdf ) {
			$order->update_meta_data( self::M_PDF_DONE, 'yes' );
		}
		$order->save();
	}

	public static function attach_pdf_to_wc_emails( $attachments, $email_id, $order, $email ) {
		if ( ! $order instanceof WC_Order ) {
			return $attachments;
		}
		// Only customer-facing order emails.
		$allowed = [ 'customer_processing_order', 'customer_on_hold_order', 'customer_completed_order', 'customer_invoice' ];
		if ( ! in_array( $email_id, $allowed, true ) ) {
			return $attachments;
		}
		$booking_id = self::primary_booking_id_for_order( $order );
		if ( ! $booking_id ) {
			$b = self::resolve_booking_for_order( $order, 0 );
			if ( $b instanceof WC_Booking ) {
				$booking_id = (int) $b->get_id();
				$order->update_meta_data( self::M_PRIMARY_BOOKING_ID, $booking_id );
				$order->save();
			}
		}
		// Always regenerate at send-time with resolved booking so fields match admin resend.
		$pdf = $booking_id ? self::generate_pdf( $order, true, $booking_id ) : null;
		if ( ! $pdf ) {
			$existing = (string) $order->get_meta( self::M_PDF_PATH );
			if ( $existing && file_exists( $existing ) ) {
				$pdf = $existing;
			}
		}
		if ( $pdf && file_exists( $pdf ) ) {
			$attachments[] = $pdf;
		}
		return $attachments;
	}

	private static function is_local_mode() {
		$env = function_exists( 'wp_get_environment_type' ) ? wp_get_environment_type() : '';
		$site = (string) home_url();
		return 'local' === $env || str_contains( $site, 'localhost' ) || str_contains( $site, '127.0.0.1' ) || str_contains( $site, '.local' );
	}

	private static function show_chauffeur( WC_Order $order ) {
		if ( ! self::is_arrival_departure_gold_booking( $order ) ) {
			return false;
		}
		return self::has_chauffeur_details( $order );
	}

	private static function has_chauffeur_details( WC_Order $order ) {
		$manual_name  = trim( (string) $order->get_meta( self::M_CHAUFFEUR_NAME ) );
		$manual_email = trim( (string) $order->get_meta( self::M_CHAUFFEUR_EMAIL ) );
		$manual_phone = trim( (string) $order->get_meta( self::M_CHAUFFEUR_CONTACT ) );
		return ( $manual_name !== '' || $manual_email !== '' || $manual_phone !== '' );
	}

	private static function is_arrival_departure_gold_booking( WC_Order $order ) {
		foreach ( $order->get_items() as $item ) {
			$p = $item->get_product();
			$slug = '';
			if ( $p ) {
				$slug = sanitize_title( (string) get_post_field( 'post_name', $p->get_id() ) );
			}
			if ( '' === $slug ) {
				$slug = sanitize_title( (string) $item->get_name() );
			}
			if (
				$slug &&
				str_contains( $slug, 'gold' ) &&
				( str_contains( $slug, 'arrival' ) || str_contains( $slug, 'departure' ) )
			) {
				return true;
			}
		}
		return false;
	}

	private static function plain( $v ) { $s = is_scalar( $v ) ? (string) $v : ''; $s = html_entity_decode( $s, ENT_QUOTES, 'UTF-8' ); $s = wp_strip_all_tags( $s ); return trim( preg_replace( '/\s+/', ' ', $s ) ); }
	private static function airport_code( $s ) {
		$s = trim( $s );
		if ( preg_match( '/\(\s*([A-Z]{3})\s*\)/', strtoupper( $s ), $m ) ) return $m[1];
		if ( preg_match( '/\[\s*([A-Z]{3})\s*\]/', strtoupper( $s ), $m ) ) return $m[1];
		if ( preg_match( '/^([A-Z]{3})\b/', strtoupper( $s ), $m ) ) return $m[1];
		return $s;
	}

	/** Strip trailing pipe-delimited coordinates (e.g. address|lat|lng) for PDF display. */
	private static function display_address_line( $s ) {
		$s = trim( (string) $s );
		if ( '' === $s ) {
			return '';
		}
		if ( str_contains( $s, '|' ) ) {
			$parts = explode( '|', $s, 2 );
			$s = trim( (string) ( $parts[0] ?? '' ) );
		}
		return $s;
	}

	private static function context( WC_Order $order, $booking_id = 0 ) {
		$names = []; $bags = ''; $flight_no = ''; $from = ''; $to = ''; $date = ''; $time = ''; $class = ''; $requests = []; $meta_l = []; $items_full = []; $adults = 0;
		$reservation_rows = []; $journey_rows = []; $booking_rows = [];
		$service_type = ''; $service_date = ''; $service_end_date = ''; $service_time = ''; $service_end_time = '';
		$booking_obj = null; $booking_number = ''; $booking_datetime = ''; $booking_type = ''; $booking_adults = ''; $booking_children = '';
		$booking_obj = self::resolve_booking_for_order( $order, $booking_id );
		if ( $booking_obj instanceof WC_Booking ) {
			// Match admin booking card format.
			$service_date = trim( (string) $booking_obj->get_start_date( 'F j, Y', '', true ) );
			$service_time = trim( str_replace( ',', '', (string) $booking_obj->get_start_date( '', 'g:i a', true ) ) );
			$service_end_date = trim( (string) $booking_obj->get_end_date( 'F j, Y', '', true ) );
			$service_end_time = trim( str_replace( ',', '', (string) $booking_obj->get_end_date( '', 'g:i a', true ) ) );
		}
		$item_booking_map = self::booking_map_for_order_items( $order );
		foreach ( $order->get_items() as $item ) {
			$service_type = $service_type ?: $item->get_name();
			$row_meta = [];
			$row_meta_l = [];
			$row_names = [];
			$row_requests = [];
			$row_bags = '';
			$row_adults = 0;
			foreach ( $item->get_meta_data() as $m ) {
				$k = (string) $m->key; $v = self::plain( $m->value );
				if ( $k && $v ) {
					$row_meta[] = [ 'key' => $k, 'value' => $v ];
					$row_meta_l[ strtolower( trim( $k ) ) ] = $v;
					$meta_l[ strtolower( trim( $k ) ) ] = $v;
				}
				if ( '' === $bags && 0 === strcasecmp( $k, 'Number of Bags' ) ) $bags = $v;
				if ( '' === $class && preg_match( '/class/i', $k ) ) $class = $v;
				if (
					'' === $flight_no &&
					( preg_match( '/flight\s*number/i', $k ) || preg_match( '/^(inbound|outbound)\s+flight\s*number$/i', trim( $k ) ) )
				) {
					$flight_no = $v;
				}
				// Keep flight info strict to flight-specific fields to avoid wrong values.
				if ( '' === $date && preg_match( '/flight\s*date|arrival\s*date|departure\s*date/i', $k ) ) $date = $v;
				if ( '' === $time && preg_match( '/flight\s*arrival\s*time|arrival\s*time/i', $k ) ) $time = $v;
				if ( preg_match( '/passenger|traveller|traveler/i', $k ) ) $names[] = $v;
				if ( '' === $row_bags && 0 === strcasecmp( $k, 'Number of Bags' ) ) $row_bags = $v;
				if ( preg_match( '/passenger|traveller|traveler/i', $k ) ) $row_names[] = $v;
				if ( 0 === $adults && preg_match( '/adult|number of passengers|passengers/i', $k ) ) { $n = intval( preg_replace('/[^\d]/','',$v) ); if ( $n > 0 ) $adults = $n; }
				if ( 0 === $row_adults && preg_match( '/adult|number of passengers|passengers/i', $k ) ) { $n = intval( preg_replace('/[^\d]/','',$v) ); if ( $n > 0 ) $row_adults = $n; }
				if ( preg_match( '/request|note|special/i', $k ) ) $requests[] = $v;
				if ( preg_match( '/request|note|special/i', $k ) ) $row_requests[] = $v;
			}
			$items_full[] = [ 'product_name' => $item->get_name(), 'quantity' => (int) $item->get_quantity(), 'line_total' => wc_price( (float) $item->get_total(), [ 'currency' => $order->get_currency() ] ), 'meta' => $row_meta ];
			$row_item_id = (int) $item->get_id();
			$row_booking = $item_booking_map[ $row_item_id ] ?? self::booking_for_order_item( $row_item_id );
			$row_service_date = '';
			$row_service_end_date = '';
			$row_service_time = '';
			$row_service_end_time = '';
			$row_booking_persons_total = 0;
			$row_booking_adults_total = 0;
			if ( $row_booking instanceof WC_Booking ) {
				$row_service_date = trim( (string) $row_booking->get_start_date( 'F j, Y', '', true ) );
				$row_service_time = trim( str_replace( ',', '', (string) $row_booking->get_start_date( '', 'g:i a', true ) ) );
				$row_service_end_date = trim( (string) $row_booking->get_end_date( 'F j, Y', '', true ) );
				$row_service_end_time = trim( str_replace( ',', '', (string) $row_booking->get_end_date( '', 'g:i a', true ) ) );
				$row_booking_persons_total = (int) $row_booking->get_persons_total();
				if ( $row_booking_persons_total > 0 ) {
					$row_booking_adults_total = $row_booking_persons_total;
					$persons = $row_booking->get_persons();
					$children_total = 0;
					if ( is_array( $persons ) && class_exists( 'WC_Product_Booking_Person_Type' ) ) {
						foreach ( $persons as $person_type_id => $qty ) {
							$qty = (int) $qty;
							if ( $qty <= 0 ) {
								continue;
							}
							try {
								$ptype = new WC_Product_Booking_Person_Type( $person_type_id );
								$pname = strtolower( trim( (string) $ptype->get_name() ) );
								if ( $pname && ( str_contains( $pname, 'child' ) || str_contains( $pname, 'kid' ) || str_contains( $pname, 'infant' ) ) ) {
									$children_total += $qty;
								}
							} catch ( \Throwable $e ) {}
						}
					}
					$possible_adults = $row_booking_persons_total - $children_total;
					if ( $possible_adults > 0 ) {
						$row_booking_adults_total = $possible_adults;
					}
				}
			}
			$row_date_raw = (string) (
				$row_meta_l['flight date'] ??
				$row_meta_l['arrival date'] ??
				$row_meta_l['departure date'] ??
				$row_meta_l['booking date'] ??
				$row_meta_l['date'] ??
				''
			);
			$row_end_date_raw = (string) ( $row_meta_l['end date'] ?? '' );
			$row_start_time_raw = (string) (
				$row_meta_l['start time'] ??
				$row_meta_l['flight arrival time'] ??
				$row_meta_l['arrival time'] ??
				$row_meta_l['time'] ??
				''
			);
			$row_end_time_raw = (string) (
				$row_meta_l['end time'] ??
				$row_meta_l['flight departure time'] ??
				$row_meta_l['departure time'] ??
				''
			);
			if ( '' === $row_service_date && '' !== $row_date_raw ) {
				$ts = strtotime( $row_date_raw );
				$row_service_date = $ts ? date_i18n( 'F j, Y', $ts ) : $row_date_raw;
			}
			if ( '' === $row_service_end_date && '' !== $row_end_date_raw ) {
				$ts = strtotime( $row_end_date_raw );
				$row_service_end_date = $ts ? date_i18n( 'F j, Y', $ts ) : $row_end_date_raw;
			}
			if ( '' === $row_service_end_date ) {
				$row_service_end_date = $row_service_date;
			}
			if ( '' === $row_service_time && '' !== $row_start_time_raw ) {
				$ts = strtotime( '1970-01-01 ' . $row_start_time_raw );
				$row_service_time = $ts ? date_i18n( 'g:i a', $ts ) : $row_start_time_raw;
			}
			if ( '' === $row_service_end_time && '' !== $row_end_time_raw ) {
				$ts = strtotime( '1970-01-01 ' . $row_end_time_raw );
				$row_service_end_time = $ts ? date_i18n( 'g:i a', $ts ) : $row_end_time_raw;
			}
			if ( '' === $row_service_end_time ) {
				$row_service_end_time = $row_service_time;
			}

			$row_names = array_values( array_unique( array_filter( array_map( 'trim', $row_names ) ) ) );
			$row_full_name = trim( (string) ( $row_meta_l['first name'] ?? '' ) . ' ' . (string) ( $row_meta_l['last name'] ?? '' ) );
			if ( '' !== $row_full_name ) {
				array_unshift( $row_names, $row_full_name );
			}
			$row_names = array_values( array_unique( array_filter( array_map( 'trim', $row_names ) ) ) );
			$row_from = self::display_address_line(
				(string) (
					$row_meta_l['airport of departure'] ??
					$row_meta_l['from address'] ??
					$row_meta_l['station of departure'] ??
					''
				)
			);
			$row_to = trim(
				(string) (
					$row_meta_l['inbound flight number'] ??
					$row_meta_l['inbound flight'] ??
					$row_meta_l['arrival airport'] ??
					$row_meta_l['airport of arrival'] ??
					$row_meta_l['to address'] ??
					''
				)
			);
			$row_date = (string) ( $row_date_raw ?: $row_service_date );
			$row_journey_date = '';
			if ( $row_date ) {
				$ts = strtotime( $row_date );
				$row_journey_date = $ts ? date_i18n( 'F j, Y', $ts ) : $row_date;
			}
			$row_start_time = (string) ( $row_start_time_raw ?: $row_service_time );
			$row_end_time = (string) ( $row_end_time_raw ?: $row_service_end_time );
			$row_passenger_count = $row_booking_adults_total > 0
				? $row_booking_adults_total
				: ( $row_adults > 0 ? $row_adults : ( ! empty( $row_names ) ? count( $row_names ) : (int) $item->get_quantity() ) );
			$reservation_rows[] = [
				'service_type' => (string) $item->get_name(),
				'service_date' => (string) ( $row_service_date ?: '—' ),
				'service_end_date' => (string) ( $row_service_end_date ?: '—' ),
				'service_time' => (string) ( $row_service_time ?: '—' ),
				'service_end_time' => (string) ( $row_service_end_time ?: '—' ),
				'reservation' => '#' . $order->get_order_number(),
			];
			$journey_rows[] = [
				'name' => (string) ( $row_names[0] ?? '' ),
				'passenger_count' => $row_passenger_count > 0 ? (string) $row_passenger_count : '',
				'bags' => (string) $row_bags,
				'journey_date' => (string) $row_journey_date,
				'journey_from' => (string) $row_from,
				'journey_to' => (string) $row_to,
				'start_time' => (string) $row_start_time,
				'end_time' => (string) $row_end_time,
			];
			$booking_rows[] = [
				'booking_number' => '',
				'booking_datetime' => '',
				'booking_type' => (string) $item->get_name(),
				'booking_adults' => $row_passenger_count > 0 ? (string) $row_passenger_count : '1',
				'booking_children' => '0',
			];
		}
		$fname = $meta_l['first name'] ?? ''; $lname = $meta_l['last name'] ?? ''; $full = trim( $fname . ' ' . $lname ); if ( $full ) $names[] = $full;
		$names = array_values( array_unique( array_filter( array_map( 'trim', $names ) ) ) );
		$count = $adults > 0 ? $adults : ( ! empty( $names ) ? count( $names ) : 1 );
		$flight_no = $flight_no ?: ( $meta_l['inbound flight number'] ?? ( $meta_l['outbound flight number'] ?? '' ) );
		$from = $from ?: (
			$meta_l['from address'] ??
			$meta_l['airport of departure'] ??
			$meta_l['station of departure'] ??
			''
		);
		$to = $to ?: (
			$meta_l['arrival airport'] ??
			$meta_l['airport of arrival'] ??
			$meta_l['destination airport'] ??
			$meta_l['airport destination'] ??
			$meta_l['to airport'] ??
			$meta_l['station of arrival'] ??
			$meta_l['arrival station'] ??
			$meta_l['to address'] ??
			$meta_l['dropoff'] ??
			$meta_l['drop off'] ??
			''
		);
		// Final fallback: for departure products, destination is often the departure airport itself.
		if ( '' === $to && ! empty( $from ) ) {
			$to = $from;
		}
		$from = self::display_address_line( $from );
		$from = self::airport_code( $from );
		$to = self::display_address_line( $to );
		$date = $date ?: ( $meta_l['flight date'] ?? ( $meta_l['arrival date'] ?? ( $meta_l['departure date'] ?? '' ) ) );
		$time = $time ?: ( $meta_l['flight arrival time'] ?? ( $meta_l['arrival time'] ?? '' ) );
		$meta_start_time = $meta_l['start time'] ?? '';
		$meta_end_time   = $meta_l['end time'] ?? '';
		$meta_end_date   = $meta_l['end date'] ?? '';
		// Fallback to booking start date/time when flight-specific values are unavailable.
		$date = $date ?: ( $meta_l['booking date'] ?? $service_date );
		$time = $time ?: $service_time;
		if ( ! $date && $order->get_date_created() ) $date = $order->get_date_created()->date_i18n( 'Y-m-d' );
		if ( ! $time && $order->get_date_created() ) $time = $order->get_date_created()->date_i18n( 'H:i' );

		// Ensure "Service Date/Time" in PDF always shows booking date/time.
		if ( ! $service_date ) {
			$service_date = $date ?: ( $meta_l['date'] ?? '' );
			if ( $service_date ) {
				$ts = strtotime( (string) $service_date );
				if ( $ts ) {
					$service_date = date_i18n( 'F j, Y', $ts );
				}
			}
		}
		if ( ! $service_time ) {
			$service_time = $meta_start_time ?: ( $time ?: ( $meta_l['time'] ?? '' ) );
			if ( $service_time ) {
				$ts = strtotime( '1970-01-01 ' . (string) $service_time );
				if ( $ts ) {
					$service_time = date_i18n( 'g:i a', $ts );
				}
			}
		}
		if ( ! $service_end_date ) {
			$service_end_date = $meta_end_date ?: $service_date;
			if ( $service_end_date ) {
				$ts = strtotime( (string) $service_end_date );
				if ( $ts ) {
					$service_end_date = date_i18n( 'F j, Y', $ts );
				}
			}
		}
		if ( ! $service_end_time ) {
			$service_end_time = $meta_end_time;
			if ( $service_end_time ) {
				$ts = strtotime( '1970-01-01 ' . (string) $service_end_time );
				if ( $ts ) {
					$service_end_time = date_i18n( 'g:i a', $ts );
				}
			}
		}

		if ( $booking_obj instanceof WC_Booking ) {
			$booking_number = '#' . $booking_obj->get_id();
			$booking_datetime = (string) $booking_obj->get_start_date( 'F j, Y', ', g:i a', true );
			$booking_datetime = trim( str_replace( ', ,', ',', $booking_datetime ) );
			$booking_datetime = trim( str_replace( '  ', ' ', $booking_datetime ) );
			$booking_resource = $booking_obj->get_resource();
			if ( $booking_resource && ! empty( $booking_resource->post_title ) ) {
				$booking_type = (string) $booking_resource->post_title;
			}
			$booking_product = $booking_obj->get_product();
			if ( ! $booking_type && $booking_product ) {
				$booking_type = (string) $booking_product->get_name();
			}
			$persons_total = (int) $booking_obj->get_persons_total();
			if ( $persons_total > 0 ) {
				$booking_adults = (string) $persons_total;
			}
			$adults_total = 0;
			$children_total = 0;
			$persons = $booking_obj->get_persons();
			if ( is_array( $persons ) ) {
				foreach ( $persons as $person_type_id => $qty ) {
					$qty = (int) $qty;
					if ( $qty <= 0 ) {
						continue;
					}
					$is_child = false;
					if ( class_exists( 'WC_Product_Booking_Person_Type' ) ) {
						try {
							$ptype = new WC_Product_Booking_Person_Type( $person_type_id );
							$pname = strtolower( trim( (string) $ptype->get_name() ) );
							if ( $pname && ( str_contains( $pname, 'child' ) || str_contains( $pname, 'kid' ) || str_contains( $pname, 'infant' ) ) ) {
								$is_child = true;
							}
						} catch ( \Throwable $e ) {}
					}
					if ( $is_child ) {
						$children_total += $qty;
					} else {
						$adults_total += $qty;
					}
				}
			}
			if ( $adults_total > 0 ) {
				$booking_adults = (string) $adults_total;
			}
			if ( $children_total > 0 ) {
				$booking_children = (string) $children_total;
			}
		}
		if ( '' === $booking_number && $booking_id ) {
			$booking_number = '#' . absint( $booking_id );
		}
		if ( '' === $booking_type ) {
			$booking_type = (string) ( $service_type ?: '—' );
		}
		if ( '' === $booking_adults ) {
			$booking_adults = (string) ( $adults > 0 ? $adults : 1 );
		}
		$total_persons = (int) $booking_adults + (int) $booking_children;
		if ( $total_persons > 0 ) {
			$count = $total_persons;
		}
		if ( ! empty( $booking_rows ) && '' !== $booking_number ) {
			$booking_rows[0]['booking_number'] = $booking_number;
			$booking_rows[0]['booking_datetime'] = $booking_datetime;
		}

		$note = trim( (string) $order->get_customer_note() ); if ( $note ) $requests[] = $note;
		$requests = array_values( array_unique( array_filter( array_map( 'trim', $requests ) ) ) );
		// Build billing address lines for the PDF.
		// Note: WooCommerce returns the country as a 2-letter code (e.g. "GB"),
		// but your PDF design only needs the address + contact details.
		$billing_lines = array_values( array_filter( [ $order->get_formatted_billing_full_name(), $order->get_billing_company(), $order->get_billing_address_1(), $order->get_billing_address_2(), trim( $order->get_billing_city() . ' ' . $order->get_billing_postcode() ), $order->get_billing_phone(), $order->get_billing_email() ] ) );
		$show_chauffeur = self::show_chauffeur( $order );
		$journey_date = '';
		if ( $date ) {
			$ts = strtotime( (string) $date );
			$journey_date = $ts ? date_i18n( 'F j, Y', $ts ) : $date;
		} elseif ( $service_date ) {
			$journey_date = $service_date;
		}
		// Journey information PDF: From = Airport of Departure; To = Inbound flight (number).
		$journey_from = self::display_address_line( trim( (string) ( $meta_l['airport of departure'] ?? '' ) ) );
		$journey_to = trim( (string) ( $meta_l['inbound flight number'] ?? ( $meta_l['inbound flight'] ?? '' ) ) );
		return [
			'order' => $order, 'order_number' => $order->get_order_number(), 'order_date' => $order->get_date_created() ? $order->get_date_created()->date_i18n( 'Y-m-d H:i' ) : '',
			'service_type' => $service_type, 'service_date' => $service_date, 'service_end_date' => $service_end_date, 'service_time' => $service_time, 'service_end_time' => $service_end_time,
			'reservation_rows' => $reservation_rows,
			'passenger_names' => $names, 'passenger_count' => $count, 'bags' => $bags, 'class_of_travel' => $class, 'special_requests' => $requests,
			'flight_number' => $flight_no, 'flight_date' => $date, 'journey_date' => $journey_date, 'flight_from' => $from, 'flight_to' => $to, 'flight_time' => $time,
			'journey_from' => $journey_from, 'journey_to' => $journey_to,
			'journey_rows' => $journey_rows,
			'booking_number' => $booking_number,
			'booking_datetime' => $booking_datetime,
			'booking_type' => $booking_type,
			'booking_adults' => $booking_adults,
			'booking_children' => $booking_children,
			'booking_rows' => $booking_rows,
			'greeter_name' => (string) $order->get_meta( self::M_GREETER_NAME ), 'greeter_contact' => (string) $order->get_meta( self::M_GREETER_CONTACT ),
			'show_greeter' => $show_chauffeur,
			'show_chauffeur' => $show_chauffeur, 'chauffeur_name' => (string) $order->get_meta( self::M_CHAUFFEUR_NAME ), 'chauffeur_email' => (string) $order->get_meta( self::M_CHAUFFEUR_EMAIL ), 'chauffeur_contact' => (string) $order->get_meta( self::M_CHAUFFEUR_CONTACT ),
			'order_items_full' => $items_full, 'order_date_plain' => $order->get_date_created() ? $order->get_date_created()->date_i18n( 'F j, Y' ) : '', 'order_email' => $order->get_billing_email(), 'order_payment_method' => $order->get_payment_method_title(), 'order_subtotal' => wc_price( (float) $order->get_subtotal(), [ 'currency' => $order->get_currency() ] ), 'order_tax' => wc_price( (float) $order->get_total_tax(), [ 'currency' => $order->get_currency() ] ), 'order_total' => wc_price( (float) $order->get_total(), [ 'currency' => $order->get_currency() ] ), 'billing_address_lines' => $billing_lines,
			// 'company_phone' => get_option( 'hvip_booking_company_phone', '+1 2321 2353 432' ), 'company_email' => get_option( 'hvip_booking_company_email', 'loremipsum@mail.com' ), 'company_address' => get_option( 'hvip_booking_company_address', 'dolor sit amet, consectetur vel rhoncus augue nunc nec turpis.' ), 'terms_title' => get_option( 'hvip_booking_terms_title', 'TERMS AND CONDITIONS' ), 'terms_text' => get_option( 'hvip_booking_terms_text', 'Please refer to our official terms and conditions on the website.' ),
		];
	}

	public static function generate_pdf( WC_Order $order, $force = false, $booking_id = 0 ) {
		if ( ! self::mpdf_ok() ) return null;
		$existing = (string) $order->get_meta( self::M_PDF_PATH ); if ( ! $force && $existing && file_exists( $existing ) ) return $existing;
		$upload = wp_upload_dir(); $dir = trailingslashit( $upload['basedir'] ) . 'airportvip-pdfs'; if ( ! wp_mkdir_p( $dir ) ) return null;
		$path = trailingslashit( $dir ) . 'booking-confirmation-' . $order->get_id() . '.pdf';
		$tmp_dir = self::mpdf_temp_dir();
		if ( '' === $tmp_dir ) return null;
		$ctx = self::context( $order, $booking_id );
		ob_start(); include get_stylesheet_directory() . '/templates/booking-pdf/confirmation.php'; $html = (string) ob_get_clean();
		try {
			$mpdf = new \Mpdf\Mpdf(
				[
					'format' => 'A4',
					'orientation' => 'P',
					'tempDir' => $tmp_dir,
				]
			);
			$mpdf->WriteHTML( $html );
			$mpdf->Output( $path, \Mpdf\Output\Destination::FILE );
		} catch ( \Throwable $e ) { return null; }
		if ( file_exists( $path ) ) { $order->update_meta_data( self::M_PDF_PATH, $path ); $order->save(); return $path; }
		return null;
	}

	private static function preview_store( $order_id, $payload ) {
		$key = 'hvip_booking_email_preview_' . $order_id; $arr = get_transient( $key ); if ( ! is_array( $arr ) ) $arr = []; $payload['created_at'] = current_time( 'mysql' ); $arr[] = $payload; set_transient( $key, $arr, 2 * HOUR_IN_SECONDS );
	}

	private static function customer_html( $order, $booking_id = 0 ) {
		// Render using WooCommerce's native New Order email template so layout
		// matches the standard WC table-based order email style.
		$email = null;
		if ( function_exists( 'WC' ) && WC() && method_exists( WC(), 'mailer' ) ) {
			$mailer = WC()->mailer();
			if ( $mailer && method_exists( $mailer, 'get_emails' ) ) {
				$emails = $mailer->get_emails();
				if ( isset( $emails['WC_Email_New_Order'] ) ) {
					$email = $emails['WC_Email_New_Order'];
				}
			}
		}

		if ( function_exists( 'wc_get_template_html' ) && $email ) {
			$email_heading = sprintf( 'New order: #%s', $order->get_order_number() );
			return wc_get_template_html(
				'emails/admin-new-order.php',
				[
					'order'              => $order,
					'email_heading'      => $email_heading,
					'additional_content' => '',
					'sent_to_admin'      => false,
					'plain_text'         => false,
					'email'              => $email,
				]
			);
		}

		$ctx = self::context( $order, $booking_id );
		$file = get_stylesheet_directory() . '/templates/booking-email/customer-confirmation.php';
		if ( file_exists( $file ) ) {
			ob_start();
			include $file;
			return (string) ob_get_clean();
		}
		return '<p>Your booking confirmation PDF is attached.</p>';
	}
	private static function chauffeur_html( $order, $booking_id = 0 ) {
		$ctx = self::context( $order, $booking_id );
		$file = get_stylesheet_directory() . '/templates/booking-email/chauffeur-details.php';
		if ( file_exists( $file ) ) {
			ob_start();
			include $file;
			return (string) ob_get_clean();
		}
		return '<p>Booking details are attached.</p>';
	}

	private static function wrap_wc_email( $subject, $body_html ) {
		if ( ! function_exists( 'WC' ) || ! WC() || ! method_exists( WC(), 'mailer' ) ) {
			return (string) $body_html;
		}
		$mailer = WC()->mailer();
		if ( ! $mailer ) {
			return (string) $body_html;
		}
		$wrapped = method_exists( $mailer, 'wrap_message' ) ? $mailer->wrap_message( (string) $subject, (string) $body_html ) : (string) $body_html;
		return method_exists( $mailer, 'style_inline' ) ? $mailer->style_inline( $wrapped ) : $wrapped;
	}

	private static function send_customer( WC_Order $order, $pdf, $reason, $booking_id = 0 ) {
		$to = $order->get_billing_email(); if ( ! $to || ! is_email( $to ) ) return;
		$sub = 'Booking Confirmation #' . $order->get_order_number(); $body = self::customer_html( $order, $booking_id ); $att = ( $pdf && file_exists( $pdf ) ) ? [ $pdf ] : [];
		if ( self::is_local_mode() ) { self::preview_store( $order->get_id(), [ 'type' => 'customer', 'to' => $to, 'subject' => $sub, 'body' => $body, 'attachments' => $att, 'reason' => $reason ] ); return; }
		wp_mail( $to, $sub, $body, [ 'Content-Type: text/html; charset=UTF-8' ], $att );
	}

	private static function send_chauffeur( WC_Order $order, $pdf, $reason, $booking_id = 0 ) {
		if ( ! self::show_chauffeur( $order ) ) return;
		$to = sanitize_email( (string) $order->get_meta( self::M_CHAUFFEUR_EMAIL ) ); if ( ! $to || ! is_email( $to ) ) return;
		$sub = 'Chauffeur Booking Details #' . $order->get_order_number(); $body = self::chauffeur_html( $order, $booking_id ); $final_body = self::wrap_wc_email( $sub, $body ); $att = ( $pdf && file_exists( $pdf ) ) ? [ $pdf ] : [];
		if ( self::is_local_mode() ) { self::preview_store( $order->get_id(), [ 'type' => 'chauffeur', 'to' => $to, 'subject' => $sub, 'body' => $final_body, 'attachments' => $att, 'reason' => $reason ] ); return; }
		wp_mail( $to, $sub, $final_body, [ 'Content-Type: text/html; charset=UTF-8' ], $att );
	}

	private static function regen_and_send( WC_Order $order, $reason, $booking_id = 0 ) { $pdf = self::generate_pdf( $order, true, $booking_id ); self::send_customer( $order, $pdf, $reason, $booking_id ); self::send_chauffeur( $order, $pdf, $reason, $booking_id ); }

	public static function resend_action() {
		$booking_id = absint( $_GET['booking_id'] ?? 0 ); $order = $booking_id ? self::booking_order( $booking_id ) : null; if ( ! $order ) wp_die( 'Missing order_id.' );
		if ( ! current_user_can( 'edit_wc_booking', $booking_id ) ) wp_die( 'Not allowed.' );
		check_admin_referer( 'hvip_resend_booking_emails_' . $booking_id );
		self::regen_and_send( $order, 'admin_resend', $booking_id );
		if ( self::is_local_mode() ) {
			$url = add_query_arg( [ 'action' => 'hvip_preview_booking_emails', 'booking_id' => $booking_id, 'order_id' => $order->get_id(), '_wpnonce' => wp_create_nonce( 'hvip_preview_booking_emails_' . $booking_id ) ], admin_url( 'admin-post.php' ) );
			wp_safe_redirect( $url ); exit;
		}
		wp_safe_redirect( admin_url( 'post.php?post=' . $booking_id . '&action=edit' ) ); exit;
	}

	public static function preview_action() {
		$booking_id = absint( $_GET['booking_id'] ?? 0 ); $order = $booking_id ? self::booking_order( $booking_id ) : null; if ( ! $order ) wp_die( 'Missing order_id.' );
		if ( ! current_user_can( 'edit_wc_booking', $booking_id ) ) wp_die( 'Not allowed.' );
		check_admin_referer( 'hvip_preview_booking_emails_' . $booking_id );
		$pdf = self::generate_pdf( $order, false, $booking_id );
		$durl = wp_nonce_url( add_query_arg( [ 'action' => 'hvip_download_booking_pdf', 'booking_id' => $booking_id, 'order_id' => $order->get_id() ], admin_url( 'admin-post.php' ) ), 'hvip_download_booking_pdf_' . $booking_id );
		$arr = get_transient( 'hvip_booking_email_preview_' . $order->get_id() ); if ( ! is_array( $arr ) ) $arr = [];
		echo '<div class="wrap"><h1>Booking Email Preview #' . esc_html( $order->get_order_number() ) . '</h1><p><a class="button button-primary" href="' . esc_url( $durl ) . '">Download PDF</a></p>';
		if ( empty( $arr ) ) { echo '<p>No preview payload yet. Click Resend first.</p>'; } else { foreach ( array_reverse( $arr ) as $p ) { echo '<h2>' . esc_html( strtoupper( (string) ( $p['type'] ?? 'email' ) ) ) . '</h2><p><strong>To:</strong> ' . esc_html( (string) ( $p['to'] ?? '' ) ) . '<br><strong>Subject:</strong> ' . esc_html( (string) ( $p['subject'] ?? '' ) ) . '</p><div style="border:1px solid #ccd0d4;background:#fff;padding:12px;">' . (string) ( $p['body'] ?? '' ) . '</div><hr>'; } }
		echo '</div>'; exit;
	}

	public static function download_pdf_action() {
		$booking_id = absint( $_GET['booking_id'] ?? 0 ); $order = $booking_id ? self::booking_order( $booking_id ) : null; if ( ! $order ) wp_die( 'Missing order_id.' );
		if ( ! current_user_can( 'edit_wc_booking', $booking_id ) ) wp_die( 'Not allowed.' );
		check_admin_referer( 'hvip_download_booking_pdf_' . $booking_id );
		$pdf = self::generate_pdf( $order, false, $booking_id ); if ( ! $pdf || ! file_exists( $pdf ) ) wp_die( 'PDF not found.' );
		nocache_headers(); header( 'Content-Type: application/pdf' ); header( 'Content-Disposition: attachment; filename="booking-confirmation-' . $order->get_id() . '.pdf"' ); header( 'Content-Length: ' . filesize( $pdf ) ); readfile( $pdf ); exit;
	}
}

add_action( 'init', [ 'HVIP_Booking_Functionality', 'init' ] );

