<?php
add_action('vc_before_init', 'coolsectionseven_integrateWithVC');
function coolsectionseven_integrateWithVC() {
    vc_map(
        array(
            "name" => __("Display Block Seven", "my-text-domain"),
            "base" => "coolsectionseven",
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
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("ID", "my-text-domain"),
                    "param_name" => "serviceid",
                    "value" => __("", "my-text-domain"),
                    "description" => __("No spaces", "my-text-domain")
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

                )
            )
        )
    );
}

add_shortcode('coolsectionseven', 'coolsectionseven_func');
function coolsectionseven_func($atts, $content, $serviceimage) { 

    extract(shortcode_atts(array(
        'serviceimage' => 'serviceimage',
        'serviceid' => 'serviceid',
        'servicetitle' => 'servicetitle'
    ), $atts));

    $imageSrc = wp_get_attachment_image_src($serviceimage, 'medium');

	$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

    ob_start(); ?>

    <div class="cool-section-seven-outer" id="section-seven-id-<?php echo $serviceid; ?>">
		<div  class="cool-section-seven-image" style="background: url(<?php echo $imageSrc[0]; ?>);">
            <div class="cool-section-seven-title-block">
                <h2 class="cool-section-seven-title"><?php echo $servicetitle; ?></h2>
            </div>
        </div>
        <div class="cool-section-seven-text">
            <?php echo $content; ?>
        </div>
	</div>

    <?php return ob_get_clean();
}
