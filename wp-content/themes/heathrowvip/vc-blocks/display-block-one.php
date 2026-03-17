<?php
add_action('vc_before_init', 'coolsection_integrateWithVC');
function coolsection_integrateWithVC()
{
    vc_map(
        array(
            "name" => __("Display Block One", "my-text-domain"),
            "base" => "coolsection",
            "class" => "",
            "category" => __("Content", "my-text-domain"),
            "params" => array(
                array(
                    "type" => "textarea_html",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Description", "my-text-domain"),
                    "param_name" => "content",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Write Description here. Try and keep lengths similar.", "my-text-domain")
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Title", "my-text-domain"),
                    "param_name" => "funkytitle",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Put the block title in here.", "my-text-domain")
                ),
            )
        )
    );
}

add_shortcode('coolsection', 'coolsection_func');
function coolsection_func($atts, $content, $funkyimage)
{

    extract(shortcode_atts(array(
        'funkyimage' => 'funkyimage',
        'funkytitle' => 'funkytitle',
        'funkylink' => 'funkylink'
    ), $atts));

    $imageSrc = wp_get_attachment_image_src($funkyimage, 'medium');

    $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

    ob_start(); ?>

    <div class="row cool-section">
        <div class="cool-section-line">
            <div class="col-12 cool-section-left">
                <div class="cool-section-left-text">
                    <?php echo $content; ?>
                </div>
            </div>
            <span class="cool-section-title"><?php echo $funkytitle; ?></span>
        </div>
    </div>

    <?php return ob_get_clean();
}
