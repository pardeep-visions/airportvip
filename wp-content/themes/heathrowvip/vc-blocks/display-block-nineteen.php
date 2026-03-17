<?php
add_action('vc_before_init', 'coolsectionnineteen_integrateWithVC');
function coolsectionnineteen_integrateWithVC() {
    vc_map(
        array(
            "name" => __("Display Block Nineteen", "my-text-domain"),
            "base" => "displayblocknineteen",
            "class" => "",
            "category" => __("Content", "my-text-domain"),
            "params" => array(
                array(
                    "type" => "attach_image",
                    "heading" => __("Background Image", "my-text-domain"),
                    "param_name" => "backgroundimage",
                    "value" => "",
                    "description" => __("Choose background image.", "my-text-domain")
                ),		
                array(
                    "type" => "attach_image",
                    "heading" => __("Foreground Image", "my-text-domain"),
                    "param_name" => "foregroundimage",
                    "value" => "",
                    "description" => __("Choose foreground image.", "my-text-domain")
                ),		
                array(
                    "type" => "textarea_html",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Content", "my-text-domain"),
                    "param_name" => "content",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Write content here.", "my-text-domain")
                ),
					
			
            )
        )
    );
}

add_shortcode('displayblocknineteen', 'displayblocknineteen_func');
function displayblocknineteen_func($atts, $content) { 

    extract(shortcode_atts(array(
        'backgroundimage' => '', 
        'foregroundimage' => '', 
        'title' => '', 
        
    ), $atts));

    $foregroundimageSRC = wp_get_attachment_image_src($foregroundimage, 'hd');
    $backgroundimageSRC = wp_get_attachment_image_src($backgroundimage, 'hd');
	$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

    ob_start(); ?>

    <div class="display-block-nineteen" style="background-image: none, url('<?php echo $backgroundimageSRC[0]; ?>');">
        <div class="display-block-nineteen-inner">
            <div class="display-block-nineteen-text">
                <?php echo $content; ?>
            </div>
            <div class="display-block-nineteen-foreground">
                <img src="<?php echo $foregroundimageSRC[0]; ?>" class="display-block-nineteen-foreground-image">
            </div>
            <div class="display-block-nineteen-blank">
            </div>
        </div>
    </div>

    <?php return ob_get_clean();
}
