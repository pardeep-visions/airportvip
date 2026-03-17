<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>


<p>
<?php
/* translators: 1: checkout payment url */
echo wp_kses_post( sprintf( __( 'To pay for this booking please use the following link: %s', 'woocommerce-bookings' ), '<a href="' . esc_url( '#' ) . '">' . __( 'Pay for booking', 'woocommerce-bookings' ) . '</a>' ) );
?>
</p>
