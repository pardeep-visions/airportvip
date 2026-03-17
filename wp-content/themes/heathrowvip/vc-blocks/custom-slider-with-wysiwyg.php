<?php
add_action('vc_before_init', 'customsliderwithwysiwyg_integrateWithVC');
function customsliderwithwysiwyg_integrateWithVC() {
    vc_map(
        array(
            "name" => __("Custom Flex Slider with WYSIWYG", "my-text-domain"),
            "base" => "customsliderwithwysiwyg",
            "class" => "",
            "category" => __("Content", "my-text-domain"),
            "params" => array(
                array(
                    "type" => "attach_images",
                    "heading" => __("Image", "my-text-domain"),
                    "param_name" => "serviceimage",
                    "value" => "",
                    "description" => __("Choose block image.", "my-text-domain")
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

add_shortcode('customsliderwithwysiwyg', 'customsliderwithwysiwyg_func');
function customsliderwithwysiwyg_func($atts, $content, $serviceimage) { 

    extract(shortcode_atts(array(
        'serviceimage' => 'serviceimage'
    ), $atts));

    $serviceimage = explode(',', $serviceimage);

    ob_start();  ?>



	<div class="header-slider">
		<div class="header-slider-inner">
			<div id="slider" class="flexslider">
				<ul class="slides">
					<?php foreach($serviceimage as $id): ?>
                    <?php $imageSrc = wp_get_attachment_image_src($id, 'large'); ?>
                        <li style="min-height:500px;background-image: url(<?php echo $imageSrc[0]; ?>);" >
                            <div class="header-text">
                                <div class="header-text-background">
                                    <div class="header-text-max-width">
                                        <div class="header-text-inner">
                                            <?php echo $content; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>                  
                        </li>
                    <?php endforeach; ?>
				</ul>
            </div> 
		</div>
	</div>

    <?php return ob_get_clean();
}
