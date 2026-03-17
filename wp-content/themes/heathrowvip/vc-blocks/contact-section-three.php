<?php
add_action('vc_before_init', 'contactsectionthree_integrateWithVC');
function contactsectionthree_integrateWithVC() {
    vc_map(
        array(
            "name" => __("Contact Section Three with Map", "my-text-domain"),
            "base" => "contactsectionthree",
            "class" => "",
            "category" => __("Content", "my-text-domain"),
            "params" => array(
			
               
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
			
                

            )
        )
    );
}

add_shortcode('contactsectionthree', 'contactsectionthree_func');
function contactsectionthree_func($atts, $content) { 

    extract(shortcode_atts(array(
        'title' => '',
        'backgroundtext' => '',
        'image' => '',
        'mapiframe' => 'mapiframe',
        
    ), $atts));

    $imageSRC = wp_get_attachment_image_src($image, 'medium');
 

	$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

    ob_start(); ?>


    <div class="contact-section-three">
        <div class="contact-section-three-left">
            <iframe src="<?php echo $mapiframe; ?>" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
        <div class="contact-section-three-right">
            <?php echo $content; ?>
        </div>
    </div>
        
        

    <?php return ob_get_clean();
}
