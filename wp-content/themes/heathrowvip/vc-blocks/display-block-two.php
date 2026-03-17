<?php
add_action('vc_before_init', 'coolsectiontwo_integrateWithVC');
function coolsectiontwo_integrateWithVC()
{
    vc_map(
        array(
            "name" => __("Display Block Two", "my-text-domain"),
            "base" => "coolsectiontwo",
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

add_shortcode('coolsectiontwo', 'coolsectiontwo_func');
function coolsectiontwo_func($atts, $content, $funkyimage)
{
    extract(shortcode_atts(array(
        'funkyimage' => 'funkyimage',
        'funkytitle' => 'funkytitle',
        'funkylink' => 'funkylink'
    ), $atts));

    $imageSrc = wp_get_attachment_image_src($funkyimage, 'medium');
    
    $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

    ob_start(); ?>

    <div class="row cool-section-two" style="background: url(<?php echo $imageSrc[0]; ?>)">
        <div class="col-8 cool-section-two-left">
            <div class="cool-section-two-left-text">
                <?php echo $content; ?>
            </div>
        </div>
        <div class="col-4 cool-section-two-right align-self-center right-item">
        </div>
        <span class="cool-section-two-title"><?php echo $funkytitle; ?></span>
    </div>
    
    <?php return ob_get_clean();
}
