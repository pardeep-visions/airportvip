<?php
add_action('vc_before_init', 'iframeblockfunc_integrateWithVC');
function iframeblockfunc_integrateWithVC()
{
    vc_map(
        array(
            "name" => __("Iframe Block", "my-text-domain"),
            "base" => "iframeblockfunc",
            "class" => "",
            "category" => __("Content", "my-text-domain"),

            "params" => array(
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Height in Pixels", "my-text-domain"),
                    "param_name" => "iframeheight",
                    "value" => __("", "my-text-domain"),
                    "description" => __("e.g. 400", "my-text-domain")
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Link", "my-text-domain"),
                    "param_name" => "iframeurl",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Put the full link in here.", "my-text-domain")
                ),
              

            )
        )
    );
}

add_shortcode('iframeblockfunc', 'iframeblockfunc_func');
function iframeblockfunc_func($atts, $content = null, $servicetitle)
{

    extract(shortcode_atts(array(

        'iframeheight' => 'iframeheight',
        'iframeurl' => 'iframeurl',
 
    ), $atts));

    $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
    
    ob_start(); ?>

    <div class="iframe-block">
        <iframe src='<?php echo $iframeurl; ?>' width='100%' height='<?php echo $iframeheight; ?>' frameBorder="0"></iframe>
    </div>

    <?php return ob_get_clean();
}
