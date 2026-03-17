<?php
add_action('vc_before_init', 'customsectiontoptitle_integrateWithVC');
function customsectiontoptitle_integrateWithVC() {
    vc_map(
        array(
            "name" => __("Custom Animated Section Top Title", "my-text-domain"),
            "base" => "customsectiontoptitle",
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
               
            )
        )
    );
}

add_shortcode('customsectiontoptitle', 'customsectiontoptitle_func');
function customsectiontoptitle_func($atts, $content, $serviceimage) { 

    extract(shortcode_atts(array(
        'serviceimage' => 'serviceimage',
        'titleone' => 'titleone',
        'titletwo' => 'titletwo',
    ), $atts));

    $imageSrc = wp_get_attachment_image_src($serviceimage, 'large');

    ob_start(); ?>

    <div class="animated-section-with-top-title">
        <div class="animated-title-block-with-top-title">
            <h2 class="top-animated-title animated-title wow fadeInRight"><?php echo $titleone; ?></h2>
            <h2 class="bottom-animated-title animated-title wow fadeInLeft"><?php echo $titletwo; ?></h2>
        </div>
        <div class="animated-text-block wow fadeIn">
            <?php echo $content; ?>
        </div>
    </div>

    <?php return ob_get_clean();
}
