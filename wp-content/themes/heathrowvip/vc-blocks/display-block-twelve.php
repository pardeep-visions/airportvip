<?php
add_action('vc_before_init', 'displayblocktwelve_integrateWithVC');
function displayblocktwelve_integrateWithVC() {
    vc_map(
        array(
            "name" => __("Display Block Twelve", "my-text-domain"),
            "base" => "displayblocktwelve",
            "class" => "",
            "category" => __("Content", "my-text-domain"),
            "params" => array(
               
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Vimeo Number", "my-text-domain"),
                    "param_name" => "vimeonumber",
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
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Top Colour", "my-text-domain"),
                    "param_name" => "topcolour",
                    "value" => __("", "my-text-domain"),
                    "description" => __("No spaces", "my-text-domain")
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Bottom Colour", "my-text-domain"),
                    "param_name" => "bottomcolour",
                    "value" => __("", "my-text-domain"),
                    "description" => __("No spaces", "my-text-domain")
                ),
            )
        )
    );
}

add_shortcode('displayblocktwelve', 'displayblocktwelve_func');
function displayblocktwelve_func($atts, $content, $serviceimage) { 

    extract(shortcode_atts(array(
        'vimeonumber' => '',
        'topcolour' => '',
        'bottomcolour' => '',
    ), $atts));

    $imageSrc = wp_get_attachment_image_src($serviceimage, 'medium');

	$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

    ob_start(); ?>

    <div class="display-block-twelve" style="background: <?php echo $topcolour; ?>;">
        <div class="display-block-twelve-inner"> 
            <div  class="display-block-twelve-video embed-responsive embed-responsive-16by9"> 
                <iframe src="https://player.vimeo.com/video/<?php echo $vimeonumber; ?>" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;" title="ICSS Video - Original"></iframe>
            </div>
            <div class="display-block-twelve-text">
                <?php echo $content; ?>
            </div>
        </div>
        <div class="display-block-twelve-bootom-background" style="background: <?php echo $bottomcolour; ?>;">
        </div>
	</div>

    <?php return ob_get_clean();
}
