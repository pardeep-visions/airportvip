<?php
add_action('vc_before_init', 'displayblocktwentysix_integrateWithVC');
function displayblocktwentysix_integrateWithVC() {
    vc_map(
        array(
            "name" => __("Display Block Twenty Six", "my-text-domain"),
            "base" => "displayblocktwentysix",
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
					"description" => __("Content", "my-text-domain")
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
                    "heading" => __("Side Text", "my-text-domain"),
                    "param_name" => "sidetext",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Keep it short", "my-text-domain")
                ),
            )
        )
    );
}

add_shortcode('displayblocktwentysix', 'displayblocktwentysix_func');
function displayblocktwentysix_func($atts, $content, $serviceimage) { 

    extract(shortcode_atts(array(
        'serviceimage' => '',
        'sidetext' => '',
    ), $atts));

    $imageSrc = wp_get_attachment_image_src($serviceimage, 'medium');

	$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

    ob_start(); ?>

    <div class="display-block-twenty-six viewport-trigger trigger-target">
        <div class="display-block-twenty-six-inner">
            <div class="display-block-twenty-six-sidetext-div">
                <span class="display-block-twenty-six-sidetext"><?php echo $sidetext; ?></span>
            </div>

            <div class="display-block-twenty-six-grid">
                <div class="display-block-twenty-six-text-div">
                    <div class="display-block-twenty-six-text">
                        <?php echo $content; ?>
                    </div>
                </div>
                <div  class="display-block-twenty-six-image-div" style="backgrounddud: url(<?php echo $imageSrc[0]; ?>);"> 
                    <img src="<?php echo $imageSrc[0]; ?>" class="display-block-twenty-six-image">
                </div>
            </div>
        </div>
	</div>

    <?php return ob_get_clean();
}
