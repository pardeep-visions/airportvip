<?php
add_action('vc_before_init', 'displayblockten_integrateWithVC');
function displayblockten_integrateWithVC() {
    vc_map(
        array(
            "name" => __("Display Block Ten", "my-text-domain"),
            "base" => "displayblockten",
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
                    "heading" => __("ID", "my-text-domain"),
                    "param_name" => "serviceid",
                    "value" => __("", "my-text-domain"),
                    "description" => __("No spaces", "my-text-domain")
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

add_shortcode('displayblockten', 'displayblockten_func');
function displayblockten_func($atts, $content, $serviceimage) { 

    extract(shortcode_atts(array(
        'serviceimage' => 'serviceimage',
        'serviceid' => 'serviceid',
        'servicetitle' => 'servicetitle'
    ), $atts));

    $imageSrc = wp_get_attachment_image_src($serviceimage, 'medium');

	$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

    ob_start(); ?>

    <div class="display-block-ten">
		<div  class="display-block-ten-image-div" style="background: url(<?php echo $imageSrc[0]; ?>);">
            
        </div>
        <div class="display-block-ten-text-div">
            <div class="display-block-ten-title-div">
                <h2 class="display-block-ten-title"><?php echo $servicetitle; ?></h2>
            </div>
            <div class="display-block-ten-text">
                <?php echo $content; ?>
            </div>
        </div>
	</div>

    <?php return ob_get_clean();
}
