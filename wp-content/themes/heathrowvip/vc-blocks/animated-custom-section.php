<?php
add_action('vc_before_init', 'customsection_integrateWithVC');
function customsection_integrateWithVC() {
    vc_map(
        array(
            "name" => __("Custom Animated Section", "my-text-domain"),
            "base" => "customsection",
            "class" => "",
            "category" => __("Content", "my-text-domain"),
            "params" => array(
                array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __("Title 1", "my-text-domain"),
					"param_name" => "titleone",
					"value" => __("", "my-text-domain"),
					"description" => __("Put the block title in here.", "my-text-domain")
                ),
                array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __("Title 2", "my-text-domain"),
					"param_name" => "titletwo",
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

add_shortcode('customsection', 'customsection_func');
function customsection_func($atts, $content, $serviceimage) { 

    extract(shortcode_atts(array(
        'serviceimage' => 'serviceimage',
        'titleone' => 'titleone',
        'titletwo' => 'titletwo',
    ), $atts));

    $imageSrc = wp_get_attachment_image_src($serviceimage, 'large');

    ob_start(); ?>

    <div class="animated-section">
        <div class="animated-section-top" style="background: url(<?php echo $imageSrc[0]; ?>);">
            <div class="row parralax" style="min-height: 300px; background: url(<?php echo $imageSrc[0]; ?>);"></div>
            <div class="animated-title-block">
                <h2 class="top-animated-title animated-title wow fadeInLeft"><?php echo $titleone; ?></h2>
                <h2 class="bottom-animated-title animated-title wow fadeInRight"><?php echo $titletwo; ?></h2>
            </div>
        </div>
        <div class="animated-text-block wow fadeIn">
            <?php echo $content; ?>
        </div>
    </div>

    <?php return ob_get_clean();
}
