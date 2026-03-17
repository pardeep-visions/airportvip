<?php
add_action('vc_before_init', 'your_name_imagechangesonhover');
function your_name_imagechangesonhover()
{
    vc_map(
        array(
            "name" => __("Images Changes on Hover", "my-text-domain"),
            "base" => "imagechangesonhover",
            "class" => "",
            "category" => __("Content", "my-text-domain"),
            "params" => array(
                array(
                    "type" => "attach_image",
                    "heading" => __("Main Image", "my-text-domain"),
                    "param_name" => "serviceimage",
                    "value" => "",
                    "description" => __("Choose block image.", "my-text-domain")
                ),
                array(
                    "type" => "attach_image",
                    "heading" => __("Hover Image", "my-text-domain"),
                    "param_name" => "hoverimage",
                    "value" => "",
                    "description" => __("Choose block image.", "my-text-domain")
                ),
            )
        )
    );
}

add_shortcode('imagechangesonhover', 'bartag_imagechangesonhover');
function bartag_imagechangesonhover($atts, $content = null, $servicetitle)
{
    extract(shortcode_atts(array(
        'serviceimage' => 'serviceimage',
        'hoverimage' => 'hoverimage'
    ), $atts));

    $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
    $imageSrc = wp_get_attachment_image_src($serviceimage, 'medium');
    $imageSrchover = wp_get_attachment_image_src($hoverimage, 'medium');
    
    ob_start(); ?>

    <div class="change-on-hover-image" style="background: url(<?php echo $imageSrchover[0]; ?>);" >
        <img src="<?php echo $imageSrc[0]; ?>">
    </div>
    
    <?php return ob_get_clean();
}
