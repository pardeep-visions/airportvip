<?php
add_action('vc_before_init', 'coolsectionthirty_integrateWithVC');
function coolsectionthirty_integrateWithVC() {
    vc_map(
        array(
            "name" => __("Display Block Thirty", "my-text-domain"),
            "base" => "displayblockthirty",
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
			
            )
        )
    );
}

add_shortcode('displayblockthirty', 'displayblockthirty_func');
function displayblockthirty_func($atts, $content) { 

    extract(shortcode_atts(array(
        'imageone' => 'imageone', 
        
    ), $atts));

    $imageoneSRC = wp_get_attachment_image_src($imageone, 'hd');
	$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

    ob_start(); ?>

    <style>




    </style>

    <div class="display-block-thirty">
        <div class="display-block-thirty-parralax" style="background: url(<?php echo $imageoneSRC[0]; ?>)">
        </div>
        <img class="display-block-thirty-mobile-image" src="<?php echo $imageoneSRC[0]; ?>">
        <div class="display-block-thirty-inner col-full">
            <div class="display-block-thirty-text">
                <?php echo $content; ?>
            </div>           
        </div>
    </div>

    <?php return ob_get_clean();
}
