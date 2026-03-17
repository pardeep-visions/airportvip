<?php
add_action('vc_before_init', 'coolsectiontwentyone_integrateWithVC');
function coolsectiontwentyone_integrateWithVC() {
    vc_map(
        array(
            "name" => __("Display Block Twenty One", "my-text-domain"),
            "base" => "displayblocktwentyone",
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
                    "type" => "attach_image",
                    "heading" => __("Background Image Two", "my-text-domain"),
                    "param_name" => "imagetwo",
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

add_shortcode('displayblocktwentyone', 'displayblocktwentyone_func');
function displayblocktwentyone_func($atts, $content) { 

    extract(shortcode_atts(array(
        'imageone' => '', 
        'imagetwo' => '', 
        'leftcolor' => '', 
        'rightcolor' => '', 
        
    ), $atts));

    $imageoneSRC = wp_get_attachment_image_src($imageone, 'hd');
    $imagetwoSRC = wp_get_attachment_image_src($imagetwo, 'hd');
	$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

    ob_start(); ?>

    <div class="display-block-twenty-one" >

        <div class="display-block-twenty-one-left" style="background-color: <?php echo $leftcolor; ?>">
            <div class="display-block-twenty-one-text" >
                <?php echo $content; ?>        
            </div>
        </div>

        <div class="display-block-twenty-one-middle">
            <div class="display-block-twenty-one-middle-unskew" style="background: url(<?php echo $imageoneSRC[0]; ?>)">
            </div>
            <div class="display-block-twenty-one-left-slantxx" style="background-color: <?php echo $leftcolor; ?>"></div>
            <div class="display-block-twenty-one-right-slantxx" style="background-color: <?php echo $rightcolor; ?>"></div>   
        </div>
        
        <div class="display-block-twenty-one-right">
            <div class="display-block-twenty-one-right-unskew" style="background: url(<?php echo $imagetwoSRC[0]; ?>)">
            </div>
                <div class="display-block-twenty-one-left-slantxx" style="background-color: <?php echo $leftcolor; ?>"></div>
                <div class="display-block-twenty-one-right-slantxx" style="background-color: <?php echo $rightcolor; ?>"></div>       
            
        </div>

    </div>

    <?php return ob_get_clean();
}
