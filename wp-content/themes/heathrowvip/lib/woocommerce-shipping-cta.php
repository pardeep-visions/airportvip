<?php
function display_cart_shipping_cta() {

    ob_start();
    global $woocommerce;

    //Free shipping threshold
    $limit = 60;

    //Cart total
    $amount = $woocommerce->cart->cart_contents_total+$woocommerce->cart->tax_total;

    //Calculate remaining percentage
    $percentage = ($amount/$limit) * 100;
    $percentage = intval($percentage);

    if($percentage > 100) {
        $percentage = 100;
    }

    $amount_remaining = $limit - $amount;
    if($amount_remaining < 0) {
        $amount_remaining = 0;
    }
    $amount_remaining = number_format($amount_remaining, 2);

    ?>
    
    <div class="progress-bar-wrapper cart-free-shipping-progress" data-cart-total="<?php echo $amount; ?>">
        <p class="free-shipping-qualified" <?php if($percentage < 100) { echo 'style="display: none;"';} ?>>Free shipping</p>
        <p class="free-shipping-not-qualified"<?php if($percentage >= 100) { echo 'style="display: none;"';} ?>>Add £<span class="amount-remaining"><?php echo $amount_remaining; ?></span> more to get FREE delivery</p>
        <div class="progress">
            <div class="progress-bar" role="progressbar" style="width: <?php echo $percentage; ?>%; transition: width 1s;" aria-valuenow="<?php echo $percentage; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $percentage; ?>%</div>
        </div>
    </div>

    <script>
    //Store limit variable
    var limit = <?php echo $limit; ?>;

    //Listen for cart update event
    jQuery( function($){
        $(document.body).on('updated_cart_totals', function () {

            // Get the formatted cart total
            var total = $('div.cart_totals tr.order-total span.woocommerce-Price-amount').text();

            //If not on cart page, use value in progress bar attr
            if(!total) {
                total = $('.progress-bar-wrapper cart-free-shipping-progress').attr('data-cart-total');
                if(isNaN(total)) {
                    total = 0;
                }
            } else {
                total = total.replace('£','');
            }
            total = parseFloat(total).toFixed(2);

            //Cart updated. Calculate percentage.
            var percentage = (total/limit) * 100;
            if(percentage > 100) {
                percentage = 100;
            } 
            percentage = parseInt(percentage);

            //Calculate remaining amount
            var remaining = limit - total;
            if(remaining < 0) {
                remaining = 0;
            }
            remaining = parseFloat(remaining).toFixed(2);

            //Update progress bar values
            $('.cart-free-shipping-progress .amount-remaining').text(remaining);
            $('.cart-free-shipping-progress .progress-bar').attr('aria-valuenow', percentage).text(percentage+'%').css('width', percentage+'%');

            //Show/hide relevant message
            if(percentage == 100) {
                $('.cart-free-shipping-progress .free-shipping-qualified').show();
                $('.cart-free-shipping-progress .free-shipping-not-qualified').hide();
            } else {
                $('.cart-free-shipping-progress .free-shipping-qualified').hide();
                $('.cart-free-shipping-progress .free-shipping-not-qualified').show();
            }
      
        });
    });
    </script>

    <?php
    return ob_get_clean();
}

add_shortcode( 'free-shipping-cta', 'display_cart_shipping_cta' );

