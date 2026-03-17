<?php
add_action('vc_before_init', 'coolsectioneighteen_integrateWithVC');
function coolsectioneighteen_integrateWithVC() {
    vc_map(
        array(
            "name" => __("Display Block Eighteen", "my-text-domain"),
            "base" => "displayblockeighteen",
            "class" => "",
            "category" => __("Content", "my-text-domain"),
            "params" => array(
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Title", "my-text-domain"),
                    "param_name" => "title",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Write Description here. Try and keep lengths similar.", "my-text-domain")
                ),
			
                array(
                    "type" => "textarea_html",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Upsell", "my-text-domain"),
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

add_shortcode('displayblockeighteen', 'displayblockeighteen_func');
function displayblockeighteen_func($atts, $content) { 

    extract(shortcode_atts(array(
        'imageone' => '', 
        'title' => '', 
        
    ), $atts));

    $imageoneSRC = wp_get_attachment_image_src($imageone, 'hd');
	$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

    ob_start(); ?>

    <div class="display-block-eighteen">
        <div class="display-block-eighteen-image" style="background: url(<?php echo $imageoneSRC[0]; ?>)">
            <div class="display-block-eighteen-left-slant"></div>
            <?php if ($content) { ?>
                <div class="display-block-eighteen-upsell">
                    <?php echo $content; ?>
                </div>
            <?php } ?>
            <div class="display-block-eighteen-right-slant"></div> 
        </div>
        <div class="display-block-eighteen-bottom">
            <h1 class="display-block-eighteen-title"><?php echo $title; ?></h1>
        </div> 
    </div>

    <?php return ob_get_clean();
}
