<?php
add_action('vc_before_init', 'customsectionslantedthree_integrateWithVC');
function customsectionslantedthree_integrateWithVC() {
    vc_map(
        array(
            "name" => __("Custom Slanted Section Three", "my-text-domain"),
            "base" => "customsectionslantedthree",
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
					"param_name" => "serviceimage",
					"value" => "",
					"description" => __("Choose block image.", "my-text-domain")
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Vimeo URL", "my-text-domain"),
                    "param_name" => "vimeourl",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Put the block title in here.", "my-text-domain")
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Title", "my-text-domain"),
                    "param_name" => "title",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Put the block title in here.", "my-text-domain")
                ),
            )
        )
    );
}

add_shortcode('customsectionslantedthree', 'customsectionslantedthree_func');
function customsectionslantedthree_func($atts, $content, $serviceimage) { 

    extract(shortcode_atts(array(
        'serviceimage' => 'serviceimage',
        'vimeourl' => 'vimeourl',
        'title' => 'title',
    ), $atts));

    $imageSrc = wp_get_attachment_image_src($serviceimage, 'large');

    ob_start(); ?>

    <div class="slanted-section-three">
        <div class="slanted-section-three-background" style="background: url(<?php echo $imageSrc[0]; ?>);">
            <div class="slanted-section-three-background-mask viewport-trigger trigger-target">
            </div>
        </div>
        <div class="slanted-three-text-block-outer">
            <div class="slanted-three-text-title-div">
                <h2 class="slanted-three-text-title"><?php echo $title; ?></h2>
            </div>

            <div class="slanted-three-text-block">
                <div class="slanted-three-text-inner">
                    <div class="embed-responsive embed-responsive-16by9">
                    <iframe src="<?php echo $vimeourl; ?>" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php return ob_get_clean();
}
