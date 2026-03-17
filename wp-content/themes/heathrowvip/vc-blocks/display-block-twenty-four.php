<?php
add_action('vc_before_init', 'displayblocktwentyfour_integrateWithVC');
function displayblocktwentyfour_integrateWithVC() {
    vc_map(
        array(
            "name" => __("Display Block Twenty Four", "my-text-domain"),
            "base" => "displayblocktwentyfour",
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

add_shortcode('displayblocktwentyfour', 'displayblocktwentyfour_func');
function displayblocktwentyfour_func($atts, $content, $serviceimage) { 

    extract(shortcode_atts(array(
        'serviceimage' => 'serviceimage',
        'serviceid' => 'serviceid',
        'servicetitle' => 'servicetitle'
    ), $atts));

    $imageSrc = wp_get_attachment_image_src($serviceimage, 'medium');

	$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

    ob_start(); ?>

    <div class="display-block-twenty-four">
		<div  class="display-block-twenty-four-image-div" style="background: url(<?php echo $imageSrc[0]; ?>);">
            
        </div>
        <div class="display-block-twenty-four-text-div">
            <div class="display-block-twenty-four-text">
                <?php echo $content; ?>
            </div>
        </div>
	</div>

    <?php return ob_get_clean();
}
