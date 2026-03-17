<?php
add_action('vc_before_init', 'customslider_integrateWithVC');
function customslider_integrateWithVC() {
    vc_map(
        array(
            "name" => __("Custom Flex Slider", "my-text-domain"),
            "base" => "customslider",
            "class" => "",
            "category" => __("Content", "my-text-domain"),
            "params" => array(
                array(
                    "type" => "attach_images",
                    "heading" => __("Image", "my-text-domain"),
                    "param_name" => "serviceimage",
                    "value" => "",
                    "description" => __("Choose block images.", "my-text-domain")
                )
            )
        )
    );
}

add_shortcode('customslider', 'customslider_func');
function customslider_func($atts, $content = null, $serviceimage) { 

    extract(shortcode_atts(array(
        'serviceimage' => 'serviceimage'
    ), $atts));

    $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

    $serviceimage = explode(',', $serviceimage);

    ob_start(); ?>

	<div class="header-slider">
		<div class="header-slider-inner">
			<div id="slider" class="flexslider">
				<ul class="slides">
					<?php foreach($serviceimage as $id): ?>
						<?php $imageSrc = wp_get_attachment_image_src($id, 'large'); ?>
						<li style="min-height:500px;background-image: url(<?php echo $imageSrc[0]; ?>);" ></li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>

    <?php return ob_get_clean();
}
