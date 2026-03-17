<?php
add_action('vc_before_init', 'your_name_infocard');
function your_name_infocard()
{
    vc_map(
        array(
            "name" => __("Info Card", "my-text-domain"),
            "base" => "infocard",
            "class" => "",
            "category" => __("Content", "my-text-domain"),

            "params" => array(
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Title", "my-text-domain"),
                    "param_name" => "infotitle",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Put the block title in here.", "my-text-domain")
                ),
                array(
                    "type" => "textarea",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Description", "my-text-domain"),
                    "param_name" => "infodesc",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Write Description here. Try and keep lengths similar.", "my-text-domain")
                ),
                array(
                    "type" => "attach_image",
                    "heading" => __("Image", "my-text-domain"),
                    "param_name" => "infoimage",
                    "value" => "",
                    "description" => __("Choose block image.", "my-text-domain")

                )

            )
        )
    );
}

add_shortcode('infocard', 'bartag_infocard');
function bartag_infocard($atts, $content = null, $infotitle)
{
    extract(shortcode_atts(array(
        'infoimage' => 'infoimage',
        'infotitle' => 'infotitle',
        'infodesc' => 'infodesc'
    ), $atts));

    $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
    
    $imageSrc = wp_get_attachment_image_src($infoimage, 'medium');
    
    ob_start(); ?>

    <div class="info-block">
        <div class="info-block-background" style="background: url(<?php echo $imageSrc[0]; ?>);"></div>
        <div class="info-block-text">
            <h2 class="info-block-title"><?php echo $infotitle; ?></h1>
            <p class="info-desc"><?php echo $infodesc; ?></p>
        </div>
    </div>

    <?php return ob_get_clean();
}
