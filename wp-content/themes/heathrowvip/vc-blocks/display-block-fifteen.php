<?php
add_action('vc_before_init', 'coolsectionfifteen_integrateWithVC');
function coolsectionfifteen_integrateWithVC() {
    vc_map(
        array(
            "name" => __("Display Block Fifteen", "my-text-domain"),
            "base" => "displayblockfifteen",
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
                    "description" => __("No spaces", "my-text-domain")
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Background Text", "my-text-domain"),
                    "param_name" => "backgroundtext",
                    "value" => __("", "my-text-domain"),
                    "description" => __("No spaces", "my-text-domain")
                ),
				array(
                    "type" => "attach_image",
                    "heading" => __("Image One", "my-text-domain"),
                    "param_name" => "imageone",
                    "value" => "",
                    "description" => __("Choose block image.", "my-text-domain")
                ),			
				array(
                    "type" => "attach_image",
                    "heading" => __("Image Two", "my-text-domain"),
                    "param_name" => "imagetwo",
                    "value" => "",
                    "description" => __("Choose block image.", "my-text-domain")
                ),
            )
        )
    );
}

add_shortcode('displayblockfifteen', 'displayblockfifteen_func');
function displayblockfifteen_func($atts, $content) { 

    extract(shortcode_atts(array(
        'title' => '',
        'backgroundtext' => '',
        'imageone' => 'imageone',
        'imagetwo' => 'imagetwo',
        
    ), $atts));

    $imageoneSRC = wp_get_attachment_image_src($imageone, 'medium');
    $imagetwoSRC = wp_get_attachment_image_src($imagetwo, 'medium');

	$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

    ob_start(); ?>

    <div class="display-block-fifteen">
        <div class="display-block-fifteen-top">
            <div class="display-block-fifteen-top-left">
                <h2><?php echo $title; ?></h2>
            </div>
            <div class="display-block-fifteen-top-right">
                <span class="display-block-fifteen-background-text">
                    <?php echo $backgroundtext; ?>
                </span>
            </div>
        </div>

        <div class="display-block-fifteen-bottom">
            <div class="display-block-fifteen-bottom-left">

                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="256" height="256" viewBox="0 0 256 256" xml:space="preserve">

                    <g transform="translate(128 128) scale(0.72 0.72)" style="">
                        <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform="translate(-175.05 -175.05000000000004) scale(3.89 3.89)" >
                            <path d="M 47 88 V 2 c 0 -1.104 -0.896 -2 -2 -2 s -2 0.896 -2 2 v 86 c 0 1.104 0.896 2 2 2 S 47 89.105 47 88 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: red; fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                            <path d="M 60.627 74.373 c 0 -0.512 -0.195 -1.023 -0.586 -1.414 c -0.781 -0.781 -2.047 -0.781 -2.828 0 L 45 85.172 L 32.787 72.959 c -0.781 -0.781 -2.047 -0.781 -2.828 0 c -0.781 0.781 -0.781 2.047 0 2.828 l 13.626 13.627 C 43.961 89.789 44.469 90 45 90 s 1.039 -0.211 1.414 -0.586 l 13.627 -13.627 C 60.431 75.397 60.627 74.885 60.627 74.373 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: red; fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                        </g>
                    </g>
                </svg>

               
            </div>
            <div class="display-block-fifteen-bottom-right">
                <div class="display-block-fifteen-image" style="background:url(<?php echo $imageoneSRC[0]; ?>);">
                </div>
                <div class="display-block-fifteen-image display-block-fifteen-image-two" style="background:url(<?php echo $imagetwoSRC[0]; ?>);">
                </div>
            </div>
        </div>

        <div class="display-block-fifteen-bottom-color">
        </div>
    </div>

    <?php return ob_get_clean();
}
