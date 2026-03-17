<?php
add_action('vc_before_init', 'your_name_linkvhcard');
function your_name_linkvhcard()
{
    vc_map(
        array(
            "name" => __("Link View Height Card", "my-text-domain"),
            "base" => "linkvhcard",
            "class" => "",
            "category" => __("Content", "my-text-domain"),
            "params" => array(
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Title", "my-text-domain"),
                    "param_name" => "linktitle",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Put the block title in here.", "my-text-domain")
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Link", "my-text-domain"),
                    "param_name" => "linklink",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Put the link in here. Remember to not include the root e.g. /example/.", "my-text-domain")
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Button Text", "my-text-domain"),
                    "param_name" => "buttontext",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Put the link in here. Remember to not include the root e.g. /example/.", "my-text-domain")
                ),
                array(
                    "type" => "attach_image",
                    "heading" => __("Image", "my-text-domain"),
                    "param_name" => "linkimage",
                    "value" => "",
                    "description" => __("Choose block image.", "my-text-domain")
                )
            )
        )
    );
}

add_shortcode('linkvhcard', 'linkvhcard_func');
function linkvhcard_func($atts, $content = null, $linktitle = null)
{
    extract(shortcode_atts(array(
        'linkimage' => '',
        'linktitle' => '',
        'buttontext' => '',
        'linklink' => '#'
    ), $atts));

    $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
    
    $imageSrc = wp_get_attachment_image_src($linkimage, 'medium');

    ob_start(); ?>

    <div class="link-vh-card-outer" >
        <a href="<?php echo $linklink; ?>" class="link-vh-card">
            <div class="link-vh-card-background" style="background: url(<?php echo $imageSrc[0]; ?>);">
                <div class="link-vh-card-text" >
                    <?php if ($linktitle) { ?>
                        <h2 class="link-vh-card-title"><?php echo $linktitle; ?></h2>
                    <?php } ?>
                    <?php if ($buttontext) { ?>
                        <p class="button link-vh-card-button" href="<?php echo $linklink; ?>"><?php echo $buttontext; ?></p>
                    <?php } ?>

                </div>
            </div>
        </a>
    </div>

    <?php return ob_get_clean();
}
