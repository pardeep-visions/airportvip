<?php
add_action('vc_before_init', 'funkycardfour_integrateWithVC');
function funkycardfour_integrateWithVC()
{
    vc_map(
        array(
            "name" => __("Funky Card 4", "my-text-domain"),
            "base" => "funkycardfour",
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
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Date", "my-text-domain"),
                    "param_name" => "funkydate",
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

add_shortcode('funkycardfour', 'funkycardfour_func');
function funkycardfour_func($atts, $content = null, $funkytitle)
{

    extract(shortcode_atts(array(
        'funkyimage' => 'funkyimage',
        'funkytitle' => 'funkytitle',
        'funkylink' => 'funkylink',
        'funkydate' => 'funkydate',
        'funkycolour' => 'funkycolour',

    ), $atts));

    $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
    
    $imageSrc = wp_get_attachment_image_src($funkyimage, 'medium');
    
    ob_start(); ?>

<a href="<?php echo $funkylink; ?>" class="funky-card-four-box" >
    <div class="funky-card-four" style="background-image: url(<?php echo $imageSrc[0]; ?>)!important; border-color:<?php echo $funkycolour; ?>;">
        <div class="funky-card-four-inner">
            <div class="funky-card-four-text-div">
                <span class="funky-card-four-text"><span><span style="color:<?php echo $funkycolour; ?>;">+</span> <?php echo $funkytitle; ?></span></span>
            </div>
            
            <div class="funky-card-four-date-div">
                <span class="funky-card-four-date"><span><span style="color:<?php echo $funkycolour; ?>;"><?php echo $funkydate; ?></span></span></span>
            </div>

        </div>
    </div>
</a>

    <?php return ob_get_clean();
}
