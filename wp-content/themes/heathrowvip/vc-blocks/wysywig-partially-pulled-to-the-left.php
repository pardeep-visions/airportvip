<?php
add_action('vc_before_init', 'wysiwygpartiallypulledleft_integrateWithVC');
function wysiwygpartiallypulledleft_integrateWithVC()
{
    vc_map(
        array(
            "name" => __("WYSIWYG Pulled to the Left", "my-text-domain"),
            "base" => "wysiwygpartiallypulledleft",
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
                )
            )
        )
    );
}

add_shortcode('wysiwygpartiallypulledleft', 'wysiwygpartiallypulledleft_func');
function wysiwygpartiallypulledleft_func($atts, $content, $serviceimage)
{
    extract(shortcode_atts(array(
       
    ), $atts));

    $imageSrc = wp_get_attachment_image_src($serviceimage, 'medium');

    ob_start(); ?>

    <div class="wysiwyg-partially-pulled-to-the-left">
        <?php echo $content; ?>
    </div>

    <?php return ob_get_clean();
}
