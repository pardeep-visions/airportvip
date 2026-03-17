<?php
add_action('vc_before_init', 'displayblocktwentythree_integrateWithVC');
function displayblocktwentythree_integrateWithVC() {
    vc_map(
        array(
            "name" => __("Display Block Twenty Three", "my-text-domain"),
            "base" => "displayblocktwentythree",
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
                    "type" => "attach_image",
                    "heading" => __("Image", "my-text-domain"),
                    "param_name" => "logoimage",
                    "value" => "",
                    "description" => __("Choose block image.", "my-text-domain")
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

add_shortcode('displayblocktwentythree', 'displayblocktwentythree_func');
function displayblocktwentythree_func($atts, $content, $serviceimage) { 

    extract(shortcode_atts(array(
        'vimeonumber' => '',
        'topcolour' => '',
        'bottomcolour' => '',
        'logoimage' => '',
    ), $atts));

    $imageSrc = wp_get_attachment_image_src($logoimage, 'medium');

	$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

    ob_start(); ?>

    <div class="display-block-twenty-three" style="background: <?php echo $topcolour; ?>;">
        <div class="display-block-twenty-three-inner"> 
            <div class="display-block-twenty-three-text">
                <img src="<?php echo $imageSrc[0]; ?>" class="display-block-twenty-three-logo">
                <?php echo $content; ?>
            </div>

            <div  class="display-block-twenty-three-video embed-responsive embed-responsive-16by9"> 
                <iframe src="https://player.vimeo.com/video/<?php echo $vimeonumber; ?>" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;" title="ICSS Video - Original"></iframe>
            </div>
           
        </div>
        <div class="display-block-twenty-three-bootom-background" style="background: <?php echo $bottomcolour; ?>;">
        </div>
	</div>

    <?php return ob_get_clean();
}
