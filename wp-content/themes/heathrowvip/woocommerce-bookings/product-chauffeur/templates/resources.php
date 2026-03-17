<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

global $post, $product;

$class   = $field['class'];
$label   = $field['label'];
$name    = $field['name'];
$options = $field['options'];
?>
<div class="form-field form-field-wide <?php echo esc_attr( implode( ' ', $class ) ); ?>">
    <label for="<?php echo esc_attr( $name ); ?>"><?php echo esc_html( $label ); ?>:</label>
    <input type="hidden" name="<?php echo esc_attr( $name ); ?>" id="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr(array_key_first($options)); ?>">
    <div class="grid grid-cols-3 new-chauffeur">
    <?php
        foreach ( $options as $key => $value ) :
            $resource = new WC_Product_Booking_Resource( $key, $post->ID ); 
 
            $max_bags = get_post_meta($key, 'max_bags', true) ?: '4'; // Replace 'default_value' with your actual default value
            ?> 
            <div class="car" style="cursor: pointer; position: relative;" data-bags="<?php echo $max_bags  ; ?>" data-value="<?php echo esc_attr( $key ); ?>">
            <div class="car-selected">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                </svg>
            </div>
            <?php if (has_post_thumbnail($key)): ?>
                <div class="car-image" style="background: url(<?php echo get_the_post_thumbnail_url($key); ?>);">
                </div>
            <?php else: ?>
                <img src="<?php echo get_theme_file_uri('/lib/product-chauffeur/assets/images/no-image.png'); ?>" alt="">
            <?php endif; ?>
            <div class="car-caption">
                <div class='car-caption--title'>
                    <?php echo esc_html( $value ); ?>
                </div>
                <div class='car-caption--meta'>
                    <?php
                    if ($price_per_mile = get_post_meta($key, 'price_per_mile', true)) {
                        echo "<div class='car-caption--line car-caption--price-per-mile'><strong>Price: </strong><span>".wc_price($price_per_mile)."/mile</span></div>";
                    }
                    if ($london_price_per_mile = get_post_meta($key, 'london_price_per_mile', true)) {
                        echo "<div class='car-caption--line car-caption--price-per-mile'><strong>London Price: </strong><span>".wc_price($london_price_per_mile)."/mile</span></div>";
                    }
                    if ($airport_fee = get_post_meta($key, 'airport_fee', true)) {
                        echo "<div class='car-caption--line car-caption--price-per-mile'><strong>Airport Fee: </strong><span>".wc_price($airport_fee)."</span></div>";
                    }
                    if ($max_passengers = get_post_meta($key, 'max_passengers', true)) {
                        echo "<div class='car-caption--line car-caption--price-per-mile'><strong>Max Passengers: </strong><span>".$max_passengers."</span></div>";
                    }
                    if ($max_bags = get_post_meta($key, 'max_bags', true)) {
                        echo "<div class='car-caption--line car-caption--price-per-mile'><strong>Max Bags: </strong><span>".$max_bags."</span></div>";
                    }
                    $duration      = $product->get_duration();
                    $duration_unit = $product->get_duration_unit();
                    $cost          = $resource->get_block_cost();

                    if ( 'minute' === $duration_unit ) {
                        if ($duration <= 60) {
                            $duration_ratio = 60 / $duration;
                            $duration_unit = _n( 'hour', 'hours', 1, 'woocommerce-bookings' );
                            $duration = 1;
							$cost = $cost * $duration_ratio;
                        } else {
                            $duration_unit = _n( 'minute', 'minutes', $duration, 'woocommerce-bookings' );
                        }
                    } elseif ( 'hour' === $duration_unit ) {
                        $duration_unit = _n( 'hour', 'hours', $duration, 'woocommerce-bookings' );
                    } elseif ( 'day' === $duration_unit ) {
                        $duration_unit = _n( 'day', 'days', $duration, 'woocommerce-bookings' );
                    } elseif ( 'month' === $duration_unit ) {
                        $duration_unit = _n( 'month', 'months', $duration, 'woocommerce-bookings' );
                    } else {
                        $duration_unit = _n( 'block', 'blocks', $duration, 'woocommerce-bookings' );
                    }

                    // Check for singular display.
                    if ( 1 == $duration ) {
                        $duration_display = sprintf( '%s', $duration_unit );
                    } else {
                        // Plural.
                        $duration_display = sprintf( '%d %s', $duration, $duration_unit );
                    }
                    if ($resource->get_base_cost()) {
						echo "<div class='car-caption--line car-caption--price-per-mile'><strong>Model Charge/Fee: </strong><span>" . wp_strip_all_tags(wc_price($resource->get_base_cost())) . "</span></div>";
					}
                    echo sprintf( __( "<div class='car-caption--line car-caption--duration'><strong>Duration Price: </strong>+%1$1s/%2$2s</div>", 'woocommerce-bookings' ), wp_strip_all_tags( wc_price( $cost ) ), $duration_display );
                    ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    </div>
</div>