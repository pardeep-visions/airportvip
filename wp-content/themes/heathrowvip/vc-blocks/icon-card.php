<?php
add_action('vc_before_init', 'iconcard_integrateWithVC');
function iconcard_integrateWithVC()
{
    vc_map(
        array(
            "name" => __("Icon Card", "my-text-domain"),
            "base" => "iconcard",
            "class" => "",
            "category" => __("Content", "my-text-domain"),
            "params" => array(
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Title", "my-text-domain"),
                    "param_name" => "icontitle",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Put the block title in here.", "my-text-domain")
                ),
                array(
                    "type" => "textarea",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Description", "my-text-domain"),
                    "param_name" => "icondesc",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Write Description here. Try and keep lengths similar.", "my-text-domain")
                ),
                array(
                    "type" => "attach_image",
                    "heading" => __("Image", "my-text-domain"),
                    "param_name" => "iconimage",
                    "value" => "",
                    "description" => __("Choose block image.", "my-text-domain")
                )
            )
        )
    );
}

add_shortcode('iconcard', 'iconcard_func');
function iconcard_func($atts, $content = null, $icontitle)
{
    extract(shortcode_atts(array(
        'iconimage' => '',
        'icontitle' => '',
        'icondesc' => ''
    ), $atts));

    $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
    $imageSrc = wp_get_attachment_image_src($iconimage, 'medium');
    
    ob_start(); ?>

    <div class="icon-card">

        <?php if ($icontitle) { ?>
            <div class="icon-card-text-top" >
                <h2 class="icon-card-title"><?php echo $icontitle; ?></h2>
            </div>
        <?php } ?>
        <?php if ($imageSrc[0]) { ?>
            <div class="icon-card-background" style="background: url(<?php echo $imageSrc[0]; ?>);"></div>
        <?php } ?>
        <?php if ($icondesc) { ?>
            <div class="icon-card-text-bottom" >
                <p class="icon-desc"><?php echo $icondesc; ?></p>
            </div>
        <?php } ?>

    </div>

    <?php return ob_get_clean();
}
