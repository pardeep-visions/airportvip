<?php
add_action('vc_before_init', 'materialdcard_integrateWithVC');
function materialdcard_integrateWithVC()
{
    vc_map(
        array(
            "name" => __("Material Design Icon Card", "my-text-domain"),
            "base" => "materialdcard",
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
                    "heading" => __("Material Design Icon", "my-text-domain"),
                    "param_name" => "serviceicon",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Put the Material Design Icon in here. List of icon at https://material.io/resources/icons/?style=baseline.", "my-text-domain")
                ),
                array(
					"type" => "textarea_html",
					"holder" => "div",
					"class" => "",
					"heading" => __("Description", "my-text-domain"),
					"param_name" => "content",
					"value" => __( "", "my-text-domain" ),
					"description" => __("Write Description here. Try and keep lengths similar.", "my-text-domain")
                ),
                
             

            )
        )
    );
}

add_shortcode('materialdcard', 'materialdcard_func');
function materialdcard_func($atts, $content, $servicetitle)
{
    extract(shortcode_atts(array(
        'servicetitle' => '',
        'serviceicon' => '',
        'servicedesc' => ''
    ), $atts));

    $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
    
    ob_start(); ?>

    <div class='card materialdcard'>
        <?php if ($serviceicon) { ?>
            <div class='material-icon'><span class='material-icons'><?php echo $serviceicon; ?></span></div>
        <?php } ?>
        <?php if ($servicetitle) { ?>
            <h4><?php echo $servicetitle; ?></h4>
        <?php } ?>
        <?php if ($content) { ?>
            <?php echo $content; ?>
        <?php } ?>
    </div>

    <?php return ob_get_clean();
}
