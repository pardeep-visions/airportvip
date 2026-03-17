<?php
add_action('vc_before_init', 'twocoltextblock_integrateWithVC');
function twocoltextblock_integrateWithVC() {
    vc_map(
        array(
            "name" => __("Two Col Text Area", "my-text-domain"),
            "base" => "twocoltextblock",
            "class" => "",
            "category" => __("Content", "my-text-domain"),
            "params" => array(
				array(
					"type" => "textarea_html",
					"holder" => "div",
					"class" => "",
					"heading" => __("Description", "my-text-domain"),
					"param_name" => "content",
					"value" => __( "", "my-text-domain" ),
					"description" => __("Write Description here. Try and keep lengths similar.", "my-text-domain")
                )
            )
        )
    );
}

add_shortcode('twocoltextblock', 'twocoltextblock_func');
function twocoltextblock_func($atts, $content, $serviceimage) { 

    extract(shortcode_atts(array(

    ), $atts));

    $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

    ob_start(); ?>

    <div class="two-col-text">
        <?php echo $content; ?>
    </div>

    <?php return ob_get_clean();
}
