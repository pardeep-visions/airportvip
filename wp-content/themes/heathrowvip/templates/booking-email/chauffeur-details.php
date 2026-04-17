<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>
<p><?php esc_html_e( 'Booking details PDF is attached.', 'heathrowvip' ); ?></p>
<h2><?php echo esc_html( sprintf( __( 'Chauffeur Booking #%s', 'heathrowvip' ), (string) $ctx['order_number'] ) ); ?></h2>
<p>
	<strong><?php esc_html_e( 'Name:', 'heathrowvip' ); ?></strong> <?php echo esc_html( (string) ( $ctx['chauffeur_name'] ?? '—' ) ); ?><br>
	<strong><?php esc_html_e( 'Contact:', 'heathrowvip' ); ?></strong> <?php echo esc_html( (string) ( $ctx['chauffeur_contact'] ?? '—' ) ); ?><br>
	<strong><?php esc_html_e( 'Email:', 'heathrowvip' ); ?></strong> <?php echo esc_html( (string) ( $ctx['chauffeur_email'] ?? '—' ) ); ?>
</p>

