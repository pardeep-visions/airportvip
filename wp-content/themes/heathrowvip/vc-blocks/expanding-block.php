<?php
add_action('vc_before_init', 'expandingblock_integrateWithVC');
function expandingblock_integrateWithVC()
{
    vc_map(
        array(
            "name" => __("Expanding Block", "my-text-domain"),
            "base" => "expandingblock",
            "class" => "",
            "category" => __("Content", "my-text-domain"),
            'admin_enqueue_js' => array(get_template_directory_uri() . '/vc_extend/bartag.js'),
            'admin_enqueue_css' => array(get_template_directory_uri() . '/vc_extend/bartag.css'),
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

add_shortcode('expandingblock', 'expandingblock_func');
function expandingblock_func($atts, $content = null, $servicetitle)
{
    extract(shortcode_atts(array(
        'servicetitle' => 'servicetitle',
        'servicedesc' => 'servicedesc'
    ), $atts));

    $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
    
    ob_start(); ?>
    <div class="openingbox">
        <button class="accordion"><?php echo $servicetitle; ?>  <arrow class="down"></arrow></button>
        <div class="panel" style="display: none;">
        <p><?php echo $servicedesc; ?></p>
        </div>
    </div>

    <?php return ob_get_clean();
}
