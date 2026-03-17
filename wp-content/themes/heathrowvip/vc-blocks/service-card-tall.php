<?php
add_action('vc_before_init', 'servicecardtall_integrateWithVC');
function servicecardtall_integrateWithVC()
{
    vc_map(
        array(
            "name" => __("Service Card Tall", "my-text-domain"),
            "base" => "servicecardtall",
            "class" => "",
            "category" => __("Content", "my-text-domain"),

            "params" => array(
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Title", "my-text-domain"),
                    "param_name" => "servicetitle",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Put the block title in here.", "my-text-domain")
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Link", "my-text-domain"),
                    "param_name" => "servicelink",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Put the link in here. Remember to not include the root e.g. /example/.", "my-text-domain")
                ),
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

add_shortcode('servicecardtall', 'servicecardtall_func');
function servicecardtall_func($atts, $content,  $servicetitle)
{

    extract(shortcode_atts(array(
        'serviceimage' => 'serviceimage',
        'servicetitle' => 'servicetitle',
        'servicelink' => 'servicelink',
        'servicedesc' => 'servicedesc'
    ), $atts));

    $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
    
    $imageSrc = wp_get_attachment_image_src($serviceimage, 'medium');
    
    ob_start(); ?>

    <div class="service-block servicecardtall">
        <a href="<?php echo $servicelink; ?>">
            <?php if ($imageSrc[0]) { ?>
                <div class="service-block-background" style="background: url(<?php echo $imageSrc[0]; ?>);"></div>
            <?php } ?>
            <div class="service-block-text" >
                <?php if ($servicetitle) { ?>
                    <h2 class="service-block-title"><?php echo $servicetitle; ?></h1>
                <?php } ?>
                <?php if ($content) { ?>
                    <div class="service-desc">
                        <?php echo $content; ?>
                    </div>
                <?php } ?>
            </div>
        </a>
    </div>



    <?php return ob_get_clean();
}
