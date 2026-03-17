<?php
add_action('vc_before_init', 'funkycard_integrateWithVC');
function funkycard_integrateWithVC()
{
    vc_map(
        array(
            "name" => __("Funky Card", "my-text-domain"),
            "base" => "funkycard",
            "class" => "",
            "category" => __("Content", "my-text-domain"),
            "params" => array(
                array(
                    "type" => "attach_image",
                    "heading" => __("Image", "my-text-domain"),
                    "param_name" => "funkyimage",
                    "value" => "",
                    "description" => __("Choose block image.", "my-text-domain")
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Title", "my-text-domain"),
                    "param_name" => "funkytitle",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Put the block title in here.", "my-text-domain")
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Link", "my-text-domain"),
                    "param_name" => "funkylink",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Put the link in here. Remember to not include the root e.g. /example/.", "my-text-domain")
                ),
            )
        )
    );
}

add_shortcode('funkycard', 'funkycard_func');
function funkycard_func($atts, $content, $funkyimage)
{
    extract(shortcode_atts(array(
        'funkyimage' => '',
        'funkytitle' => '',
        'funkylink' => '#'
    ), $atts));

    $imageSrc = wp_get_attachment_image_src($funkyimage, 'medium');

    ob_start(); ?>

    <div class="funky-card" style="background-image: url('<?php echo $imageSrc[0]; ?>')!important">
        <div class="funky-card-overlay"></div>
        <a href="<?php echo $funkylink ?>" class="funky-card-box funky-card-foo">
            <div class="funky-card-box-inner">
                <h2><?php echo $funkytitle; ?></h2>
            </div>
        </a>
    </div>

    <?php return ob_get_clean();
}
