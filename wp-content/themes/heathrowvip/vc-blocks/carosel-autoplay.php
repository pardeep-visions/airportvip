<?php
add_action('vc_before_init', 'custom_Caroselautoplay');
function custom_Caroselautoplay()
{
    vc_map(
        array(
            "name" => __("Carosel Autoplay Gallery", "my-text-domain"),
            "base" => "customCaroselautoplay",
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

add_shortcode('customCaroselautoplay', 'bartag_func_custom_Caroselautoplay');
function bartag_func_custom_Caroselautoplay($atts, $content = null, $servicetitle)
{
    extract(shortcode_atts(array(
        'serviceimage' => 'serviceimage',
    ), $atts));

    $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

    $serviceimage = explode(',', $serviceimage);

    ob_start(); ?>
        


    <div class="slick-slider-carousel has-slick-lightbox"  data-slick='{"slidesToShow": 6, "slidesToScroll": 1, "autoplay": true, "cssEase" : "linear", "autoplaySpeed": 0, "speed" : 2000, "infinite" : true, "draggable" : false}'> 
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
