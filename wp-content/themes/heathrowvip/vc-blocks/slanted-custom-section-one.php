<?php
add_action('vc_before_init', 'customsectionslantedone_integrateWithVC');
function customsectionslantedone_integrateWithVC() {
    vc_map(
        array(
            "name" => __("Custom Slanted Section One", "my-text-domain"),
            "base" => "customsectionslantedone",
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

add_shortcode('customsectionslantedone', 'customsectionslantedone_func');
function customsectionslantedone_func($atts, $content, $serviceimage) { 

    extract(shortcode_atts(array(
        'serviceimage' => 'serviceimage',
    ), $atts));

    $imageSrc = wp_get_attachment_image_src($serviceimage, 'large');

    ob_start(); ?>

    <div class="slanted-section-one">
        <div class="slanted-section-background" style="background: url(<?php echo $imageSrc[0]; ?>);">
            <div class="slanted-section-background-mask viewport-trigger trigger-target">
            </div>
        </div>
        <div class="slanted-text-block-outer">
            <div class="slanted-text-block">
                <div class="slanted-text-inner">
                    <?php echo $content; ?>
                </div>
            </div>
        </div>
    </div>

    <?php return ob_get_clean();
}
