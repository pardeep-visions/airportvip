<?php
add_action('vc_before_init', 'your_name_infobanner');
function your_name_infobanner()
{
    vc_map(
        array(
            "name" => __("Info Banner", "my-text-domain"),
            "base" => "infobanner",
            "class" => "",
            "category" => __("Content", "my-text-domain"),
            "params" => array(
                array(
                    "type" => "textarea",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Description", "my-text-domain"),
                    "param_name" => "servicedesc",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Write Description here. Try and keep lengths similar.", "my-text-domain")
                )
            )
        )
    );
}

add_shortcode('infobanner', 'bartag_infobanner');
function bartag_infobanner($atts, $content = null, $servicetitle)
{
    extract(shortcode_atts(array(
        'servicedesc' => 'servicedesc'
    ), $atts));

    $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
    
    ob_start(); ?>

    <div class='info-banner'>
        <p><?php echo $servicedesc; ?></p>
        <div class='info-icon'>
            <i class='fas fa-info-circle'></i>
        </div>
    </div>

    <?php return ob_get_clean();
}
