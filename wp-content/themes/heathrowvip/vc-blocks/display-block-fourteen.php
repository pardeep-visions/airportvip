<?php
add_action('vc_before_init', 'coolsectionfourteen_integrateWithVC');
function coolsectionfourteen_integrateWithVC() {
    vc_map(
        array(
            "name" => __("Display Block Fourteen", "my-text-domain"),
            "base" => "coolsectionfourteen",
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
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Background Text", "my-text-domain"),
                    "param_name" => "backgroundtext",
                    "value" => __("", "my-text-domain"),
                    "description" => __("No spaces", "my-text-domain")
                ),

                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Foreground Text", "my-text-domain"),
                    "param_name" => "foregroundtext",
                    "value" => __("", "my-text-domain"),
                    "description" => __("No spaces", "my-text-domain")
                ),

				
            )
        )
    );
}

add_shortcode('coolsectionfourteen', 'coolsectionfourteen_func');
function coolsectionfourteen_func($atts, $content, $serviceimage) { 

    extract(shortcode_atts(array(
        'backgroundtext' => '',
        'foregroundtext' => '',
    ), $atts));

	$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

    ob_start(); ?>

    <div class="display-block-fourteen">
        <div class="display-block-fourteen-left">
            <span class="display-block-fourteen-background-text">
                <?php echo $backgroundtext; ?>
            </span>
            <div class="display-block-fourteen-foreground-text">
                <h1><?php echo $foregroundtext; ?></h1>
            </div>
        </div>
        <div class="display-block-fourteen-right">
            <?php echo $content; ?>
        </div>
    </div>


    <?php return ob_get_clean();
}
