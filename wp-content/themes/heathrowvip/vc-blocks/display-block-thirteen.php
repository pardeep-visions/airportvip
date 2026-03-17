<?php
add_action('vc_before_init', 'coolsectionthirteen_integrateWithVC');
function coolsectionthirteen_integrateWithVC() {
    vc_map(
        array(
            "name" => __("Display Block Thirteen", "my-text-domain"),
            "base" => "coolsectionthirteen",
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

                )
            )
        )
    );
}

add_shortcode('coolsectionthirteen', 'coolsectionthirteen_func');
function coolsectionthirteen_func($atts, $content, $serviceimage) { 

    extract(shortcode_atts(array(
		'serviceimage' => 'serviceimage'
    ), $atts));

    $imageSrc = wp_get_attachment_image_src($serviceimage, 'medium');

	$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

    ob_start(); ?>

    <div class="display-block-thirteen">
        <div class="display-block-thirteen-border">
            <div class="display-block-thirteen-left-image" >
                <img src="<?php echo $imageSrc[0]; ?>">
            </div>
            <div class="display-block-thirteen-right align-self-center">
                <?php echo $content; ?>
            </div>
        </div>
    </div>

    <?php return ob_get_clean();
}
