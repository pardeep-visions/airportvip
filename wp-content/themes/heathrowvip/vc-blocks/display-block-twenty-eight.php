<?php
add_action('vc_before_init', 'displayblocktwentyeight_integrateWithVC');
function displayblocktwentyeight_integrateWithVC() {
    vc_map(
        array(
            "name" => __("Display Block Twenty Eight", "my-text-domain"),
            "base" => "displayblocktwentyeight",
            "class" => "",
            "category" => __("Content", "my-text-domain"),
            "params" => array(

                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Top Title", "my-text-domain"),
                    "param_name" => "toptitle",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Keep it short", "my-text-domain")
                ),  
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Bottom Title", "my-text-domain"),
                    "param_name" => "bottomtitle",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Keep it short", "my-text-domain")
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
                    "type" => "attach_image",
                    "heading" => __("Image", "my-text-domain"),
                    "param_name" => "serviceimage",
                    "value" => "",
                    "description" => __("Choose block image.", "my-text-domain")

                ),

            )
        )
    );
}

add_shortcode('displayblocktwentyeight', 'displayblocktwentyeight_func');
function displayblocktwentyeight_func($atts, $content, $serviceimage) { 

    extract(shortcode_atts(array(
        'toptitle' => '',
        'bottomtitle' => '',
        'sidetext' => '',
        'serviceimage' => '',

    ), $atts));

    $imageSrc = wp_get_attachment_image_src($serviceimage, 'medium');

	$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

    ob_start(); ?>


    <div class="display-block-twenty-eight viewport-trigger trigger-target">
        <div class="display-block-twenty-eight-inner">
            <div class="display-block-twenty-eight-grid">
                <div class="display-block-twenty-eight-text-div">

                    <h4 class="display-block-twenty-eight-text-top-title"><?php echo $toptitle; ?></h4>
                    <h2 class="display-block-twenty-eight-text-bottom-title"><?php echo $bottomtitle; ?></h2>
                    
                    <div class="display-block-twenty-eight-text">
                        <?php echo $content; ?>
                    </div>
                </div>

                <div  class="display-block-twenty-eight-image-div" style="backgrounddud: url(<?php echo $imageSrc[0]; ?>);"> 
                    <img src="<?php echo $imageSrc[0]; ?>" class="display-block-twenty-eight-image">
                </div>
            </div>
        </div>
	</div>

    <?php return ob_get_clean();
}
