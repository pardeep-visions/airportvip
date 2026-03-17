<?php
add_action('vc_before_init', 'servicecardtwo_integrateWithVC');
function servicecardtwo_integrateWithVC()
{
    vc_map(
        array(
            "name" => __("Service Card Two", "my-text-domain"),
            "base" => "servicecardtwo",
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
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Description", "my-text-domain"),
                    "param_name" => "servicedesc",
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

add_shortcode('servicecardtwo', 'servicecardtwo_func');
function servicecardtwo_func($atts, $content = null, $servicetitle)
{

    extract(shortcode_atts(array(
        'serviceimage' => '',
        'servicetitle' => '',
        'servicelink' => '#',
        'servicedesc' => ''
    ), $atts));

    $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
    
    $imageSrc = wp_get_attachment_image_src($serviceimage, 'medium');
    
    ob_start(); ?>

    
        <a class="service-card-two-link" href="<?php echo $servicelink; ?>">
            <div class="service-card-two">
                <?php if ($imageSrc[0]) { ?>
                    <div class="service-card-two-image">
                        <div class="service-card-two-background" style="background: url(<?php echo $imageSrc[0]; ?>);"></div>
                    </div>
                <?php } ?>
                <div class="service-card-two-text" >
                    <?php if ($servicedesc) { ?>
                        <p class="service-card-two-desc"><?php echo $servicedesc; ?></p>
                    <?php } ?>

                    <?php if ($servicetitle) { ?>
                        <h2 class="service-card-two-title"><?php echo $servicetitle; ?></h1>
                    <?php } ?>
                    
                    
                </div>
            </div>
        </a>
    

    <?php return ob_get_clean();
}
