<?php
add_action('vc_before_init', 'contactsection_integrateWithVC');
function contactsection_integrateWithVC() {
    vc_map(
        array(
            "name" => __("Contact Section", "my-text-domain"),
            "base" => "contactsection",
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
				array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __("Title Colour", "my-text-domain"),
					"param_name" => "funkytitlecolour",
					"value" => __("", "my-text-domain"),
					"description" => __("Put the block title in here.", "my-text-domain")
				),
				
            )
        )
    );
}

add_shortcode('contactsection', 'contactsection_func');
function contactsection_func($atts, $content, $funkyimage) { 

    extract(shortcode_atts(array(
		'funkyimage' => 'funkyimage',
		'funkytitle' => 'funkytitle',
		'funkytitlecolour' => 'funkytitlecolour',
		'funkylink' => 'funkylink'
    ), $atts));

	$imageSrc = wp_get_attachment_image_src($funkyimage, 'medium');

	$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

    ob_start(); ?>

    <div class="row contact-section">
		<span class="contact-section-title" style="color:<?php echo $funkytitlecolour; ?>!important"><?php echo $funkytitle; ?></span>
        <div class="col-12 contact-section-inner">
			<div class="contact-section-text">
				<?php echo $content; ?>
				<?php echo do_shortcode('[contact-form-7 id="150" title="Contact Form with Bootstrap"]'); ?>
			</div>
        </div>
    </div>

	<?php return ob_get_clean();
}
