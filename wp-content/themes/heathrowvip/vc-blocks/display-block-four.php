<?php
add_action('vc_before_init', 'coolsectionfour_integrateWithVC');
function coolsectionfour_integrateWithVC() {
    vc_map(
        array(
            "name" => __("Display Block Four", "my-text-domain"),
            "base" => "coolsectionfour",
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
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __("Title", "my-text-domain"),
					"param_name" => "funkytitle",
					"value" => __("", "my-text-domain"),
					"description" => __("Put the block title in here.", "my-text-domain")
				),
            )
        )
    );
}

add_shortcode('coolsectionfour', 'coolsectionfour_func');
function coolsectionfour_func($atts, $content, $funkyimage) { 

    extract(shortcode_atts(array(
		'funkyimage' => 'funkyimage',
		'funkytitle' => 'funkytitle',
		'funkylink' => 'funkylink'
    ), $atts));

	$imageSrc = wp_get_attachment_image_src($funkyimage, 'medium');

	$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

    ob_start(); ?>

    <div class="row cool-section-four">
        <div class="col-8 cool-section-four-left">
			<div class="cool-section-four-left-text">
				<?php echo $content; ?>
			</div>
        </div>
        <div class="col-4 cool-section-four-right align-self-center right-item">
		</div>
		<span class="cool-section-four-title"><?php echo $funkytitle; ?></span>
    </div>

    <?php return ob_get_clean();
}
