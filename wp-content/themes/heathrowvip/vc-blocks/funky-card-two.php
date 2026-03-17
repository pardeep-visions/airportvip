<?php
add_action('vc_before_init', 'funkycardtwo_integrateWithVC');
function funkycardtwo_integrateWithVC()
{
    vc_map(
        array(
            "name" => __("Funky Card 2", "my-text-domain"),
            "base" => "funkycardtwo",
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

add_shortcode('funkycardtwo', 'funkycardtwo_func');
function funkycardtwo_func($atts, $content, $funkyimage)
{
    extract(shortcode_atts(array(
        'funkyimage' => '',
        'funkytitle' => '',
        'funkylink' => '#'
    ), $atts));

    $imageSrc = wp_get_attachment_image_src($funkyimage, 'medium');

    ob_start(); ?>

    <div class="funky-card-two" style="background-image: url('<?php echo $imageSrc[0]; ?>')!important">
        <div class="funky-card-two-overlay"></div>
        <a href="<?php echo $funkylink ?>" class="funky-card-two-box funky-card-two-foo">
            <div class="funky-card-two-box-inner">
                <h2><?php echo $funkytitle; ?></h2>
            </div>
        </a>
    </div>

    <?php return ob_get_clean();
}
