<?php
add_action('vc_before_init', 'parralaxblock_integrateWithVC');
function parralaxblock_integrateWithVC()
{
    vc_map(
        array(
            "name" => __("Parralax Block", "my-text-domain"),
            "base" => "parralaxblock",
            "class" => "",
            "category" => __("Content", "my-text-domain"),
            "params" => array(
                array(
                    "type" => "attach_image",
                    "heading" => __("Image", "my-text-domain"),
                    "param_name" => "serviceimage",
                    "value" => "",
                    "description" => __("Choose block image.", "my-text-domain")
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Height", "my-text-domain"),
                    "param_name" => "height",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Min Height for Block.", "my-text-domain")
                ),
            )
        )
    );
}

add_shortcode('parralaxblock', 'parralaxblock_func');
function parralaxblock_func($atts, $content, $serviceimage)
{
    extract(shortcode_atts(array(
        'serviceimage' => 'serviceimage',
        'height' => 'height',
    ), $atts));

    $imageSrc = wp_get_attachment_image_src($serviceimage, 'large');

    ob_start(); ?>

    <div class="row parralax" style="min-height: <?php echo $height; ?>px; background: url(<?php echo $imageSrc[0]; ?>);"></div>

    <?php return ob_get_clean();
}
