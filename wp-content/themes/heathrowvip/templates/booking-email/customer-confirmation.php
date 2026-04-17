<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>
<p><?php esc_html_e( 'Your booking confirmation PDF is attached.', 'heathrowvip' ); ?></p>
<h2><?php echo esc_html( sprintf( __( 'Booking Confirmation #%s', 'heathrowvip' ), (string) $ctx['order_number'] ) ); ?></h2>
<p>
	<strong><?php esc_html_e( 'Service:', 'heathrowvip' ); ?></strong> <?php echo esc_html( (string) ( $ctx['service_type'] ?? '—' ) ); ?><br>
	<strong><?php esc_html_e( 'Date:', 'heathrowvip' ); ?></strong> <?php echo esc_html( (string) ( $ctx['service_date'] ?? '—' ) ); ?><br>
	<strong><?php esc_html_e( 'Time:', 'heathrowvip' ); ?></strong> <?php echo esc_html( (string) ( $ctx['service_time'] ?? '—' ) ); ?>
</p>

