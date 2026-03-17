<?php
add_action('vc_before_init', 'slantedcard_integrateWithVC');
function slantedcard_integrateWithVC()
{
    vc_map(
        array(
            "name" => __("Slanted Card", "my-text-domain"),
            "base" => "slantedcard",
            "class" => "",
            "category" => __("Content", "my-text-domain"),

            "params" => array(
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Title", "my-text-domain"),
                    "param_name" => "slantedtitle",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Put the block title in here.", "my-text-domain")
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Link", "my-text-domain"),
                    "param_name" => "slantedlink",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Put the link in here. Remember to not include the root e.g. /example/.", "my-text-domain")
                ),
                array(
                    "type" => "attach_image",
                    "heading" => __("Image", "my-text-domain"),
                    "param_name" => "slantedimage",
                    "value" => "",
                    "description" => __("Choose block image.", "my-text-domain")

                )

            )
        )
    );
}

add_shortcode('slantedcard', 'slantedcard_func');
function slantedcard_func($atts, $content = null, $slantedtitle)
{

    extract(shortcode_atts(array(
        'slantedimage' => '',
        'slantedtitle' => '',
        'slantedlink' => '#',

    ), $atts));

    $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
    
    $imageSrc = wp_get_attachment_image_src($slantedimage, 'medium');
    
    ob_start(); ?>

    <div class="slanted-card">
        <div class="slanted-card-inner" style="background-image: url(<?php echo $imageSrc[0]; ?>)!important">
        </div>
        <div class="slanted-card-overlay"></div>
        <a href="<?php echo $slantedlink; ?>" class="slanted-card-box slanted-card-foo">
            <div class="slanted-card-box-inner">
                <h2><?php echo $slantedtitle; ?></h2>
            </div>
        </a>
    </div>



    <?php return ob_get_clean();
}
