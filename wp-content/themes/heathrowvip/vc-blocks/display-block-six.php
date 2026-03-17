<?php
add_action('vc_before_init', 'coolsectionsix_integrateWithVC');
function coolsectionsix_integrateWithVC() {
    vc_map(
        array(
            "name" => __("Display Block Six", "my-text-domain"),
            "base" => "coolsectionsix",
            "class" => "",
            "category" => __("Content", "my-text-domain"),
            "params" => array(
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

add_shortcode('coolsectionsix', 'coolsectionsix_func');
function coolsectionsix_func($atts, $content, $serviceimage) { 

    extract(shortcode_atts(array(
		'serviceimage' => 'serviceimage'
    ), $atts));

    $imageSrc = wp_get_attachment_image_src($serviceimage, 'medium');

	$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

    ob_start(); ?>

    <div class="cool-section-six-outer">
		<div class="cool-section-six">
			<div class="cool-section-six-left">
				<div class="cool-section-six-left-image" style="background: url(<?php echo $imageSrc[0]; ?>);"></div>
			</div>
			<div class="cool-section-six-right align-self-center">
				<?php echo $content; ?>
			</div>
		</div>
	</div>

    <?php return ob_get_clean();
}
