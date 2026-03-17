<?php
add_action('vc_before_init', 'coolsectioneight_integrateWithVC');
function coolsectioneight_integrateWithVC() {
    vc_map(
        array(
            "name" => __("Display Block Eight", "my-text-domain"),
            "base" => "coolsectioneight",
            "class" => "",
            "category" => __("Content", "my-text-domain"),
            "params" => array(
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Title", "my-text-domain"),
                    "param_name" => "servicetitle",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Put the block title in here.", "my-text-domain")
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
			
            )
        )
    );
}

add_shortcode('coolsectioneight', 'coolsectioneight_func');
function coolsectioneight_func($atts, $content, $serviceimage) { 

    extract(shortcode_atts(array(
        'serviceimage' => 'serviceimage',
        'serviceid' => 'serviceid',
        'servicetitle' => 'servicetitle'
    ), $atts));

    $imageSrc = wp_get_attachment_image_src($serviceimage, 'medium');

	$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

    ob_start(); ?>

    <div class="cool-section-eight-outer">
		<div  class="cool-section-eight-left">
            <div class="cool-section-left-rotate">
                <h2 class="cool-section-eight-title"><?php echo $servicetitle; ?></h2>
            </div>
        </div>
        <div class="cool-section-eight-right">
            <?php echo $content; ?>
        </div>
	</div>

    <?php return ob_get_clean();
}
