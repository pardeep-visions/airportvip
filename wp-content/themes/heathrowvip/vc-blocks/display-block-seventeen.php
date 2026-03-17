<?php
add_action('vc_before_init', 'coolsectionseventeen_integrateWithVC');
function coolsectionseventeen_integrateWithVC() {
    vc_map(
        array(
            "name" => __("Display Block Seventeen", "my-text-domain"),
            "base" => "displayblockseventeen",
            "class" => "",
            "category" => __("Content", "my-text-domain"),
            "params" => array(
			
                array(
                    "type" => "textarea_html",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Content", "my-text-domain"),
                    "param_name" => "content",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Write content here.", "my-text-domain")
                ),
				array(
                    "type" => "attach_image",
                    "heading" => __("Background Image", "my-text-domain"),
                    "param_name" => "imageone",
                    "value" => "",
                    "description" => __("Choose background image.", "my-text-domain")
                ),	
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Left Colour", "my-text-domain"),
                    "param_name" => "leftcolor",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Write Description here. Try and keep lengths similar.", "my-text-domain")
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Right Colour", "my-text-domain"),
                    "param_name" => "rightcolor",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Write Description here. Try and keep lengths similar.", "my-text-domain")
                ),		
			
            )
        )
    );
}

add_shortcode('displayblockseventeen', 'displayblockseventeen_func');
function displayblockseventeen_func($atts, $content) { 

    extract(shortcode_atts(array(
        'imageone' => '', 
        'leftcolor' => '', 
        'rightcolor' => '', 
        
    ), $atts));

    $imageoneSRC = wp_get_attachment_image_src($imageone, 'hd');
	$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

    ob_start(); ?>

    <div class="display-block-seventeen" >
        <div class="display-block-seventeen-left" style="background-color: <?php echo $leftcolor; ?>">
            <?php echo $content; ?>        
        </div>
        <div class="display-block-seventeen-right" style="background: url(<?php echo $imageoneSRC[0]; ?>)">
            <div class="display-block-seventeen-left-slant" style="background-color: <?php echo $leftcolor; ?>"></div>
            <div class="display-block-seventeen-right-slant" style="background-color: <?php echo $rightcolor; ?>"></div>       
        </div>
    </div>

    <?php return ob_get_clean();
}
