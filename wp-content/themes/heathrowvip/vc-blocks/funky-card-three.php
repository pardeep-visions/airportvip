<?php
add_action('vc_before_init', 'funkycardthree_integrateWithVC');
function funkycardthree_integrateWithVC()
{
    vc_map(
        array(
            "name" => __("Funky Card 3", "my-text-domain"),
            "base" => "funkycardthree",
            "class" => "",
            "category" => __("Content", "my-text-domain"),

            "params" => array(
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Title", "my-text-domain"),
                    "param_name" => "funkytitle",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Put the block title in here.", "my-text-domain")
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Link", "my-text-domain"),
                    "param_name" => "funkylink",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Put the link in here. Remember to not include the root e.g. /example/.", "my-text-domain")
                ),
                array(
                    "type" => "attach_image",
                    "heading" => __("Image", "my-text-domain"),
                    "param_name" => "funkyimage",
                    "value" => "",
                    "description" => __("Choose block image.", "my-text-domain")

                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Colour", "my-text-domain"),
                    "param_name" => "funkycolour",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Put the decoration colour in here.", "my-text-domain")
                ),

            )
        )
    );
}

add_shortcode('funkycardthree', 'funkycardthree_func');
function funkycardthree_func($atts, $content = null, $funkytitle)
{

    extract(shortcode_atts(array(
        'funkyimage' => 'funkyimage',
        'funkytitle' => 'funkytitle',
        'funkylink' => 'funkylink',
        'funkycolour' => 'funkycolour',

    ), $atts));

    $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
    
    $imageSrc = wp_get_attachment_image_src($funkyimage, 'medium');
    
    ob_start(); ?>

<a href="<?php echo $funkylink; ?>" class="funky-card-three-box" >
    <div class="funky-card-three" style="background-image: url(<?php echo $imageSrc[0]; ?>)!important; border-color:<?php echo $funkycolour; ?>;">
        <div class="funky-card-three-inner">
            <span class="funky-card-three-text"><span><span style="color:<?php echo $funkycolour; ?>;">+</span> <?php echo $funkytitle; ?></span></span>
        </div>
    </div>
</a>

    <?php return ob_get_clean();
}
