<?php
add_action('vc_before_init', 'coolsectionthree_integrateWithVC');
function coolsectionthree_integrateWithVC()
{
    vc_map(
        array(
            "name" => __("Display Block Three", "my-text-domain"),
            "base" => "coolsectionthree",
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
                array(
                    "type" => "attach_image",
                    "heading" => __("Main Image", "my-text-domain"),
                    "param_name" => "funkyimage",
                    "value" => "",
                    "description" => __("Choose block image.", "my-text-domain")

                ),
            )
        )
    );
}

add_shortcode('coolsectionthree', 'coolsectionthree_func');
function coolsectionthree_func($atts, $content, $funkyimage)
{
    extract(shortcode_atts(array(
        'funkyimage' => 'funkyimage',
        'funkytitle' => 'funkytitle',
        'funkylink' => 'funkylink'
    ), $atts));

    $imageSrc = wp_get_attachment_image_src($funkyimage, 'medium');
    
    $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

    ob_start(); ?>

    <div class="row cool-section-three" style="background: url(<?php echo $imageSrc[0]; ?>">
        <div class="col-8 cool-section-three-left">
            <div class="cool-section-three-left-text">
                <?php echo $content; ?>
            </div>
        </div>
        <div class="col-4 cool-section-three-right align-self-center right-item">
        </div>
        <span class="cool-section-three-title"><?php echo $funkytitle; ?></span>
    </div>

    <?php return ob_get_clean();
}
