<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>

<?php if ( 'pending' === $order->get_status() ) : ?>
	<p>
	<?php
	/* translators: 1: checkout payment url */
	echo wp_kses_post( sprintf( __( 'To pay for this booking please use the following link: %s', 'woocommerce-bookings' ), '<a href="' . esc_url( $order->get_checkout_payment_url() ) . '">' . __( 'Pay for booking', 'woocommerce-bookings' ) . '</a>' ) );
	?>
	</p>
<?php endif; ?>
