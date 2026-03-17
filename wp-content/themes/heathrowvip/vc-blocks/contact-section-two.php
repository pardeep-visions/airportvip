<?php
add_action('vc_before_init', 'contactsectiontwo_integrateWithVC');
function contactsectiontwo_integrateWithVC() {
    vc_map(
        array(
            "name" => __("Contact Section Two with Map", "my-text-domain"),
            "base" => "contactsectiontwo",
            "class" => "",
            "category" => __("Content", "my-text-domain"),
            "params" => array(
			
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Title", "my-text-domain"),
                    "param_name" => "title",
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

add_shortcode('contactsectiontwo', 'contactsectiontwo_func');
function contactsectiontwo_func($atts, $content) { 

    extract(shortcode_atts(array(
        'title' => '',
        'backgroundtext' => '',
        'image' => '',
        'mapiframe' => 'mapiframe',
        
    ), $atts));

    $imageSRC = wp_get_attachment_image_src($image, 'large');
 

	$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

    ob_start(); ?>


    <div class="contact-section-two">
        <div class="contact-section-two-top-color">
        </div>
        
        <div class="contact-section-two-top">
            <div class="contact-section-two-top-left">
                <h2 class="contact-section-two-title"><?php echo $title; ?></h2>
                <?php echo $content; ?>
            </div>
            <div class="contact-section-two-top-right" style="background:url(<?php echo $imageSRC[0]; ?>);">
                
            </div>
        </div>

        <div class="contact-section-two-bottom">
            <div class="contact-section-two-bottom-left">
            </div>
            <div class="contact-section-two-bottom-right">
           
                <iframe src="<?php echo $mapiframe; ?>" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>


                
            </div>
        </div>

        <div class="contact-section-two-bottom-color">
        </div>
    </div>

    <?php return ob_get_clean();
}
