<?php

/**
 * Add Slider Above Menu
 */

 add_action('storefront_before_site', 'print_slider_above_menu_woocommerce_before_main_content', 1);
 function print_slider_above_menu_woocommerce_before_main_content () { ?>
 
    <?php if ( is_page_template( 'page_templates/template-fullwidth-slider-above-menu.php' ) ) { ?>
        <div class="header-slider">
            <div class="header-slider-inner">
                <?php $images = get_field('gallery'); if( $images ): ?>
                    <div id="slider" class="flexslider">
                        <ul class="slides">
                            <?php if (is_array($images) || is_object($images)) { foreach($images as $image): ?>
                                <li style="min-height:500px;background-image: url(<?php echo $image['sizes']['large']; ?>);" data-thumb="<?php echo $image['sizes']['thumbnail']; ?>">
                                <div class="header-text">
                                    <div class="header-text-background">
                                        <div class="header-text-max-width">
                                            <div class="header-text-inner">
                                                <?php the_field('gallery-text'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <?php endforeach; } ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php } ?>

 <?php }