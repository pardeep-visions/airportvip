<?php
add_action('vc_before_init', 'your_name_infographic');
function your_name_infographic()
{
    vc_map(
        array(
            "name" => __("Info Graphic", "my-text-domain"),
            "base" => "infographic",
            "class" => "",
            "category" => __("Content", "my-text-domain"),
            "params" => array(
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Title", "my-text-domain"),
                    "param_name" => "servicetitle",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Put the block title in here.", "my-text-domain")
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Number", "my-text-domain"),
                    "param_name" => "serviceno",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Put the block title in here.", "my-text-domain")
                ),
                array(
                    "type" => "textarea_html",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Content", "my-text-domain"),
                    "param_name" => "content",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Write Description here. Try and keep lengths similar.", "my-text-domain")
                )
            )
        )
    );
}

add_shortcode('infographic', 'bartag_infographic');
function bartag_infographic($atts, $content = null, $servicetitle = null)
{
    extract(shortcode_atts(array(
        'servicetitle' => 'servicetitle',
        'serviceno' => 'serviceno'
    ), $atts));

    $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
    
    ob_start(); ?>
    <div class='infographic'>
        <div class='infographic-left' ><p><?php echo $serviceno; ?></p></div>
        <div class='infographic-right' >
            <h2><?php echo $servicetitle; ?></h2>
            <?php echo $content; ?>
        </div>
    </div>

    <?php return ob_get_clean();
}
