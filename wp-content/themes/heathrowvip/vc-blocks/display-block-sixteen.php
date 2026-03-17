<?php
add_action('vc_before_init', 'coolsectionsixteen_integrateWithVC');
function coolsectionsixteen_integrateWithVC() {
    vc_map(
        array(
            "name" => __("Display Block Sixteen", "my-text-domain"),
            "base" => "displayblocksixteen",
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

add_shortcode('displayblocksixteen', 'displayblocksixteen_func');
function displayblocksixteen_func($atts, $content) { 

    extract(shortcode_atts(array(
        'imageone' => 'imageone', 
        
    ), $atts));

    $imageoneSRC = wp_get_attachment_image_src($imageone, 'hd');
	$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

    ob_start(); ?>

    <div class="display-block-sixteen" style="background: url(<?php echo $imageoneSRC[0]; ?>)">
        <img class="display-block-sixteen-mobile-image" src="<?php echo $imageoneSRC[0]; ?>">
        <div class="display-block-sixteen-inner col-full">
            <div class="display-block-sixteen-text">
                <?php echo $content; ?>
            </div>           
        </div>
    </div>

    <?php return ob_get_clean();
}
