<?php
add_action('vc_before_init', 'your_name_linkcard');
function your_name_linkcard()
{
    vc_map(
        array(
            "name" => __("Link Card", "my-text-domain"),
            "base" => "linkcard",
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

add_shortcode('linkcard', 'linkcard_func');
function linkcard_func($atts, $content = null, $linktitle = null)
{
    extract(shortcode_atts(array(
        'linkimage' => '',
        'linktitle' => '',
        'linklink' => '#'
    ), $atts));

    $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
    
    $imageSrc = wp_get_attachment_image_src($linkimage, 'medium');

    ob_start(); ?>

    <div class="link-block link-card">
        <a href="<?php echo $linklink; ?>">
            <?php if ($imageSrc[0]) { ?>
                <div class="link-block-background" style="background: url(<?php echo $imageSrc[0]; ?>);"></div>
            <?php } ?>
            <?php if ($linktitle) { ?>
                <div class="link-block-text" >
                    <h2 class="link-block-title"><?php echo $linktitle; ?></h2>
                </div>
            <?php } ?>
        </a>
    </div>

    <?php return ob_get_clean();
}
