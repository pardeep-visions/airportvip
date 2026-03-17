<?php
add_action('vc_before_init', 'custom_carosel_services');
function custom_carosel_services()
{
    vc_map(
        array(
            "name" => __("Carosel Gallery Services", "my-text-domain"),
            "base" => "customcaroselservices",
            "class" => "",
            "category" => __("Content", "my-text-domain"),
            "params" => array(
               
            )
        )
    );
}

add_shortcode('customcaroselservices', 'bartag_func_custom_carosel_services');
function bartag_func_custom_carosel_services($atts, $content = null, $servicetitle)
{
    extract(shortcode_atts(array(
        'serviceimage' => 'serviceimage',
    ), $atts));

    $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

    $serviceimage = explode(',', $serviceimage);

    ob_start(); ?>

    <?php if (have_rows('service_repeater', 'option')) : ?>
        <div class="slick-slider-carousel"  data-slick='{"slidesToShow": 2, "slidesToScroll": 1}'>      
            <?php while (have_rows('service_repeater', 'option')) :
                the_row();
                $title = get_sub_field('service_title');
                $titlebottom = get_sub_field('service_bottom_title');
                $link = get_sub_field('service_link');
                $imageid = get_sub_field('service_image');
                $image_url = wp_get_attachment_image_url ($imageid, 'medium');
            ?>
               <div>
				   
			

                <a class="service-card-two-link" href="<?php echo $link; ?>">
                    <div class="service-card-two">
                        <?php if ($image_url) { ?>
                            <div class="service-card-two-image">
                                <div class="service-card-two-background" style="background: url(<?php echo $image_url; ?>);"></div>
                            </div>
                        <?php } ?>
                        <div class="service-card-two-text" >
                            <?php if ($titlebottom) { ?>
                                <p class="service-card-two-desc"><?php echo $titlebottom; ?></p>
                            <?php } ?>

                            <?php if ($title) { ?>
                                <h2 class="service-card-two-title"><?php echo $title; ?></h1>
                            <?php } ?>
                            
                            
                        </div>
                    </div>
                </a>
				   </div>


            <?php endwhile; ?>
        </div>
    <?php endif; ?>

    <?php return ob_get_clean();
}
