<?php
add_action('vc_before_init', 'displayblockeleven_integrateWithVC');
function displayblockeleven_integrateWithVC() {
    vc_map(
        array(
            "name" => __("Display Block Eleven", "my-text-domain"),
            "base" => "displayblockeleven",
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

add_shortcode('displayblockeleven', 'displayblockeleven_func');
function displayblockeleven_func($atts, $content, $serviceimage) { 

    extract(shortcode_atts(array(
        'serviceimage' => 'serviceimage',
        'serviceid' => 'serviceid',
        'servicetitle' => 'servicetitle'
    ), $atts));

    $imageSrc = wp_get_attachment_image_src($serviceimage, 'medium');

	$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

    ob_start(); ?>
    

    <div class="display-block-eleven">
		
        <div class="display-block-eleven-text-div">
            <div class="display-block-eleven-title-div">
                <h2 class="display-block-eleven-title"><?php echo $servicetitle; ?></h2>
            </div>
            <div class="display-block-eleven-text">
                <?php echo $content; ?>
            </div>
        </div>
        <div  class="display-block-eleven-image-div" style="background: url(<?php echo $imageSrc[0]; ?>);">
            
        </div>
	</div>

    <?php return ob_get_clean();
}
