<?php
add_action('vc_before_init', 'custom_carosel_cars');
function custom_carosel_cars()
{
    vc_map(
        array(
            "name" => __("Carosel Gallery Cars", "my-text-domain"),
            "base" => "customcaroselcar",
            "class" => "",
            "category" => __("Content", "my-text-domain"),
            "params" => array(
               
            )
        )
    );
}

add_shortcode('customcaroselcar', 'bartag_func_custom_carosel_cars');
function bartag_func_custom_carosel_cars($atts, $content = null, $servicetitle)
{
    extract(shortcode_atts(array(
        'serviceimage' => 'serviceimage',
    ), $atts));

    $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

    $serviceimage = explode(',', $serviceimage);

    ob_start(); ?>

    <?php if (have_rows('car_repeater', 'option')) : ?>
        <div class="slick-slider-carousel"  data-slick='{"slidesToShow": 3, "slidesToScroll": 1}'>      
            <?php while (have_rows('car_repeater', 'option')) :
                the_row();
                $title = get_sub_field('car_title');
                $link = get_sub_field('car_link');
                $imageid = get_sub_field('car_image');
                $image_url = wp_get_attachment_image_url ($imageid, 'medium');
            ?>
                <a class="info-block-link" href="<?php echo $link ?>">
                    <div class="info-block">
                        <div class="info-block-background" style="background: url(<?php echo $image_url ?>);"></div>
                        <div class="info-block-text">
                            <h2 class="info-block-title"><?php echo $title ?></h2>
                        </div>
                    </div>
                </a>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>

    <?php return ob_get_clean();
}
