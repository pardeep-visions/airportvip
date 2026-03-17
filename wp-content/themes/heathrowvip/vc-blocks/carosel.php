<?php
add_action('vc_before_init', 'custom_carosel');
function custom_carosel()
{
    vc_map(
        array(
            "name" => __("Carosel Gallery", "my-text-domain"),
            "base" => "customcarosel",
            "class" => "",
            "category" => __("Content", "my-text-domain"),
            "params" => array(
                array(
                    "type" => "attach_images",
                    "heading" => __("Image", "my-text-domain"),
                    "param_name" => "serviceimage",
                    "value" => "",
                    "description" => __("Choose block image.", "my-text-domain")
                )
            )
        )
    );
}

add_shortcode('customcarosel', 'bartag_func_custom_carosel');
function bartag_func_custom_carosel($atts, $content = null, $servicetitle)
{
    extract(shortcode_atts(array(
        'serviceimage' => 'serviceimage',
    ), $atts));

    $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

    $serviceimage = explode(',', $serviceimage);

    ob_start(); ?>
        


    <div class="slick-slider-carousel has-slick-lightbox"  data-slick='{"slidesToShow": 3, "slidesToScroll": 6}'> 
        <?php foreach ($serviceimage as $id) : ?>
            <?php $imageSrc = wp_get_attachment_image_src($id, 'medium'); ?>
            <?php $imageSrcFull = wp_get_attachment_image_src($id, 'full'); ?>
            <a class="image-link" href="<?php echo $imageSrcFull[0]; ?>"> 
                <div class="slick-slide-item">
                    <div class="slick-slider-item-inner">
                        <div class="square-grid-thumbs" style="background-image: url(<?php echo $imageSrc[0]; ?>);"></div>
                    </div>
                </div>
            </a> 
        <?php endforeach; ?>
    </div>


            









    <?php return ob_get_clean();
}
