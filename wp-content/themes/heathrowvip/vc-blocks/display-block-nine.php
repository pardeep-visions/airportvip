<?php
add_action('vc_before_init', 'coolsectionnine_integrateWithVC');
function coolsectionnine_integrateWithVC() {
    vc_map(
        array(
            "name" => __("Display Block Nine", "my-text-domain"),
            "base" => "coolsectionnine",
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
                    "type" => "attach_image",
                    "heading" => __("Image", "my-text-domain"),
                    "param_name" => "serviceimage",
                    "value" => "",
                    "description" => __("Choose block image.", "my-text-domain")
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Top Colour", "my-text-domain"),
                    "param_name" => "topcolor",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Write Description here. Try and keep lengths similar.", "my-text-domain")
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Bottom Colour", "my-text-domain"),
                    "param_name" => "bottomcolor",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Write Description here. Try and keep lengths similar.", "my-text-domain")
                ),
            )
        )
    );
}

add_shortcode('coolsectionnine', 'coolsectionnine_func');
function coolsectionnine_func($atts, $content, $serviceimage) { 

    extract(shortcode_atts(array(
        'serviceimage' => 'serviceimage',
        'topcolor' => 'topcolor',
        'bottomcolor' => 'bottomcolor',
    ), $atts));

    $imageSrc = wp_get_attachment_image_src($serviceimage, 'medium');

	$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

    ob_start(); ?>

    <div class="cool-section-nine" style="background: <?php echo $bottomcolor; ?>;">
        <div class="cool-section-nine-top-background" style="background: <?php echo $topcolor; ?>;"></div>
        <div class="cool-section-nine-inner">
            <div class="cool-section-nine-left" style="background: url(<?php echo $imageSrc[0]; ?>);">
                <div class="cool-section-nine-left-image" style="background: url(<?php echo $imageSrc[0]; ?>);"></div>
            </div>
            <div class="cool-section-nine-right align-self-center">
                <?php echo $content; ?>
            </div>
        </div>
    </div>

    <?php return ob_get_clean();
}
