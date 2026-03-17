<?php
add_action('vc_before_init', 'contactsectionfive_integrateWithVC');
function contactsectionfive_integrateWithVC() {
    vc_map(
        array(
            "name" => __("Contact Section Five with Map", "my-text-domain"),
            "base" => "contactsectionfive",
            "class" => "",
            "category" => __("Content", "my-text-domain"),
            "params" => array(
			
                array(
                    "type" => "textarea",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Contact Form", "my-text-domain"),
                    "param_name" => "contactform",
                    "value" => __("", "my-text-domain"),
                    "description" => __("No spaces", "my-text-domain")
                ),
                array(
					"type" => "textarea_html",
					"holder" => "div",
					"class" => "",
					"heading" => __("Content", "my-text-domain"),
					"param_name" => "content",
					"value" => __( "", "my-text-domain" ),
					"description" => __("Write Description here. Try and keep lengths similar.", "my-text-domain")
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Map Iframe URL", "my-text-domain"),
                    "param_name" => "mapiframe",
                    "value" => __("", "my-text-domain"),
                    "description" => __("No spaces", "my-text-domain")
                ),
				array(
                    "type" => "attach_image",
                    "heading" => __("Image", "my-text-domain"),
                    "param_name" => "image",
                    "value" => "",
                    "description" => __("Choose block image.", "my-text-domain")
                ),			
                
                

            )
        )
    );
}

add_shortcode('contactsectionfive', 'contactsectionfive_func');
function contactsectionfive_func($atts, $content) { 

    extract(shortcode_atts(array(
        'title' => '',
        'backgroundtext' => '',
        'image' => '',
        'mapiframe' => '',
        'contactform' => '',
        
    ), $atts));

    $imageSRC = wp_get_attachment_image_src($image, 'hd');
 

	$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

    ob_start(); ?>


    <div class="contact-section-five">
        <div class="contact-section-five-map" style="background:url(<?php echo $imageSRC[0]; ?>);">
            <?php if ($mapiframe) { ?>
                <iframe src="<?php echo $mapiframe; ?>" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            <?php } ?>
        </div>
        <div class="contact-section-five-text-grid">
            <div class="contact-section-five-left">
                <h1>Contact Us</h1>
                <?php if ($contactform) { ?>
                    <?php echo $contactform; ?>
                <?php } ?>
                <?php echo do_shortcode('[contact-form-7 id="150" title="Contact Form with Bootstrap"]'); ?>
            </div>
            <div class="contact-section-five-right">
                <?php echo $content; ?>
            </div>
        </div>   
     </div>

    <?php return ob_get_clean();
}
