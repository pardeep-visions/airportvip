<?php
function cart_cross_sells() {

    global $woocommerce;


    if(!isset($woocommerce->cart)) {
        return;
    }

    //Hold cart item IDs
    $cart_item_ids = [];

    //Store cart item IDs
    foreach( $woocommerce->cart->get_cart() as $cart_item ){
        $product_id = $cart_item['product_id'];
        $cart_item_ids[] = $product_id;
    }

    //Hold related item IDs
    $related_product_ids = [];

    //Fetch and store related item IDs
    foreach($cart_item_ids as $cart_item_id) {
        $cross_sell_ids   =   get_post_meta($cart_item_id, '_crosssell_ids' );
        if(isset($cross_sell_ids[0])) {
            $cross_sell_ids    =   $cross_sell_ids[0];
            foreach($cross_sell_ids as $id) {
                $related_product_ids[] = $id;
            }
        }
    }

    //Remove duplicates
    $related_product_ids = array_unique($related_product_ids);

    //Remove itmems already in the cart
    $related_product_ids = array_diff($related_product_ids, $cart_item_ids);

    ob_start(); ?>

<?php //Output HTML ?>


<script>
    jQuery(document.body).on('added_to_cart', function (a, b, c, d) {

        //Get ID of product added to cart
        var product_id = d.data('product_id');

        //Remmove product from related product CTA slider
        jQuery('.related-products-slider.slick-slider').slick('slickRemove', jQuery('[data-product-id="' +
            product_id + '"]').attr('data-slick-index'));

        //Refresh slider 
        jQuery('.related-products-slider.slick-slider').slick('refresh');

        //Check slide count
        var count = jQuery('.related-products-slider.slick-slider').slick("getSlick").slideCount;

        if (count == 0) {
            jQuery('.slick-related-products-title').hide();
        } else {
            jQuery('.slick-related-products-title').show();
        }

    });

    jQuery(document.body).on('removed_from_cart', function (a, b, c, d) {
        var product_id = d.data('product_id');
        console.log('Removed product :' + product_id)
    });
</script>

<?php if($related_product_ids && !empty($related_product_ids)) : ?>

    <h2 class="slick-related-products-title">Goes well with</h2>

    <div class="related-products-slider slick-slider" data-slick='{"slidesToShow": 1, "slidesToScroll": 1}'>

        <?php foreach($related_product_ids as $post_id) : ?>

            <div class="slick-slide" data-product-id="<?php echo $post_id; ?>">

                <?php $product = new WC_Product($post_id); ?>

                <div class="related-products-slide-inner">

                    <div class="related-products-slide-image">
                        <?php echo $product->get_image('shop_thumbnail' ); ?>
                    </div>

                    <div class="related-products-slide-text-area">
                        <p class="product-name" data-title="Product">
                            <a href="<?php echo get_the_permalink($post_id); ?>">
                                <?php echo get_the_title($post_id); ?>
                            </a>
                        </p>
                        <p class="related-products-slide-product-price" data-title="Price"><?php echo $product->get_price_html(); ?></p>

                    </div>

                    <div class="related-products-slide-add-to-cart-wrapper">

                        <?php echo do_shortcode('[add_to_cart id="'.$post_id.'"]'); ?>

                    </div>

                </div>

            </div>

        <?php endforeach; ?>

    </div>

<?php endif; ?>

<?php

    return ob_get_clean();
}

add_shortcode( 'cart-cross-sells', 'cart_cross_sells' );
