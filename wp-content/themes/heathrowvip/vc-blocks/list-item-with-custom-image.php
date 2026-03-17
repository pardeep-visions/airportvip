<?php
add_action('vc_before_init', 'listitemwithcustomimage_integrateWithVC');
function listitemwithcustomimage_integrateWithVC()
{
    vc_map(
        array(
            "name" => __("List item with custom image", "my-text-domain"),
            "base" => "listitemwithcustomimage",
            "class" => "",
            "category" => __("Content", "my-text-domain"),
            "params" => array(
                array(
                    "type" => "textarea_html",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Description", "my-text-domain"),
                    "param_name" => "content",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Write Description here. Try and keep lengths similar.", "my-text-domain")
                ),
                array(
                    "type" => "attach_image",
                    "heading" => __("Image", "my-text-domain"),
                    "param_name" => "serviceimage",
                    "value" => "",
                    "description" => __("Choose block image.", "my-text-domain")
                )
            )
        )
    );
}

add_shortcode('listitemwithcustomimage', 'listitemwithcustomimage_func');
function listitemwithcustomimage_func($atts, $content, $serviceimage)
{
    extract(shortcode_atts(array(
        'serviceimage' => 'serviceimage',
    ), $atts));

    $imageSrc = wp_get_attachment_image_src($serviceimage, 'medium');

    ob_start(); ?>

    <div class="list-item-with-custom-image">
        <div class="left-item">
            <img class="list-image" src="<?php echo $imageSrc[0]; ?>">
        </div>
        <div class="right-item align-self-center">
            <?php echo $content; ?>
        </div>
    </div>

    <?php return ob_get_clean();
}
