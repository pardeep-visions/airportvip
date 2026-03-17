<?php
add_action('vc_before_init', 'wysiwygpartiallyoverlaidimage_integrateWithVC');
function wysiwygpartiallyoverlaidimage_integrateWithVC()
{
    vc_map(
        array(
            "name" => __("WYSIWYG Partially Overlaying Image", "my-text-domain"),
            "base" => "wysiwygpartiallyoverlaidimage",
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

add_shortcode('wysiwygpartiallyoverlaidimage', 'wysiwygpartiallyoverlaidimage_func');
function wysiwygpartiallyoverlaidimage_func($atts, $content, $serviceimage)
{
    extract(shortcode_atts(array(
        'serviceimage' => 'serviceimage',
    ), $atts));

    $imageSrc = wp_get_attachment_image_src($serviceimage, 'medium');

    ob_start(); ?>

    <div class="row wysiwyg-partially-overlaid-image">
        <div class="col-5 align-self-center left-item">
            <img class="overlaid-image" src="<?php echo $imageSrc[0]; ?>">
        </div>
        <div class="col-7 align-self-center right-item">
            <div class="floating-wider-pull-right">
                <div class="white-background">
                    <?php echo $content; ?>
                </div>
            </div>
        </div>
    </div>

    <?php return ob_get_clean();
}
