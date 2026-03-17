<?php
add_action('vc_before_init', 'speakercard_integrateWithVC');
function speakercard_integrateWithVC() {
    vc_map(
        array(
            "name" => __("Speaker Card", "my-text-domain"),
            "base" => "speakercard",
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
                    "param_name" => "speakerimage",
                    "value" => "",
                    "description" => __("Choose block image.", "my-text-domain")
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Speaker Name", "my-text-domain"),
                    "param_name" => "speakername",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Write Description here. Try and keep lengths similar.", "my-text-domain")
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Speaker Details", "my-text-domain"),
                    "param_name" => "speakerdetails",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Write Description here. Try and keep lengths similar.", "my-text-domain")
                ),
            )
        )
    );
}

add_shortcode('speakercard', 'speakercard_func');
function speakercard_func($atts, $content, $serviceimage) { 

    extract(shortcode_atts(array(
        'speakerimage' => 'speakerimage',
        'speakername' => 'speakername',
        'speakerdetails' => 'speakerdetails',
    ), $atts));

    $imageSrc = wp_get_attachment_image_src($speakerimage, 'medium');

	$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

    ob_start(); ?>

    <div class="speaker-card" style="background: <?php echo $bottomcolor; ?>;">
        <div class="speaker-card-top">
            <?php if ($imageSrc[0]) { ?>
                <div class="speaker-card-image" style="background: url(<?php echo $imageSrc[0]; ?>);"></div>
            <?php } ?>
            <div class="speaker-card-top-text">
                <?php if ($speakername) { ?>
                    <h2 class="speaker-name"><?php echo $speakername; ?></h1>
                <?php } ?>
                <?php if ($speakerdetails) { ?>
                    <h4 class="speaker-details"><?php echo $speakerdetails; ?></h4>
                <?php } ?>
            </div>
        </div>
        <?php if ($content) { ?>
            <div class="speaker-card-bottom">
                <?php echo $content; ?>
            </div>
        <?php } ?>
    </div>


    <?php return ob_get_clean();
}
