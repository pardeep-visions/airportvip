<?php
add_action('vc_before_init', 'coolsectiontwenty_integrateWithVC');
function coolsectiontwenty_integrateWithVC() {
    vc_map(
        array(
            "name" => __("Display Block Twenty", "my-text-domain"),
            "base" => "displayblocktwenty",
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

add_shortcode('displayblocktwenty', 'displayblocktwenty_func');
function displayblocktwenty_func($atts, $content) { 

    extract(shortcode_atts(array(
        'imageone' => '', 
        'title' => '', 
        
    ), $atts));

    $imageoneSRC = wp_get_attachment_image_src($imageone, 'hd');
	$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

    ob_start(); ?>

    <div class="display-block-twenty">
        <div class="display-block-twenty-image" style="background: url(<?php echo $imageoneSRC[0]; ?>)">
        </div>
        <div class="display-block-twenty-content">
            <?php echo $content; ?>
        </div>
    </div>

    <?php return ob_get_clean();
}
