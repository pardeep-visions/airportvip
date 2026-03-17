<?php
add_action('vc_before_init', 'pricelistone_integrateWithVC');
function pricelistone_integrateWithVC() {
    vc_map(
        array(
            "name" => __("Price List One", "my-text-domain"),
            "base" => "pricelistone",
            "class" => "",
            "category" => __("Content", "my-text-domain"),
            "params" => array(

                array(
                    "type" => "attach_image",
                    "heading" => __("Icon", "my-text-domain"),
                    "param_name" => "icon",
                    "value" => "",
                    "description" => __("Choose block image.", "my-text-domain")
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Title", "my-text-domain"),
                    "param_name" => "title",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Keep it short", "my-text-domain")
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
                    "type" => "textarea",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Fine Print", "my-text-domain"),
                    "param_name" => "fineprint",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Keep it short", "my-text-domain")
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Name", "my-text-domain"),
                    "param_name" => "name",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Keep it short", "my-text-domain")
                ),
				array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Link", "my-text-domain"),
                    "param_name" => "link",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Keep it short", "my-text-domain")
                ),
				
            )
        )
    );
}

add_shortcode('pricelistone', 'pricelistone_func');
function pricelistone_func($atts, $content, $serviceimage) { 

    extract(shortcode_atts(array(
        'icon' => '',
        'title' => '',
        'fineprint' => '',
        'name' => '',
		'link' => '',

    ), $atts));

    $imageSrc = wp_get_attachment_image_src($icon, 'medium');

	$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

    ob_start(); ?>


	<a class="price-list--one-link " href="<?php echo $link; ?>">
		<div class="price-list--one price-list--one--<?php echo $name; ?>">               
			<img src="<?php echo $imageSrc[0]; ?>" alt="">  
            <div class="price-list--one-numb"><?php echo $name; ?></div>
			<h5 class="price-list--one-name"><?php echo $title; ?></h5>
			<div class="price-list--one-expanding-hover-line"></div>
			<div class="price-list--one-description">
				<?php echo $content; ?>
			</div>
			<div class="price-list--one-small-print">
				<?php echo $fineprint; ?>
			</div>
			
		</div>
	</a>

    <?php return ob_get_clean();
}
