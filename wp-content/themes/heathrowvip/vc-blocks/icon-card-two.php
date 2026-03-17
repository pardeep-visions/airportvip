<?php
add_action('vc_before_init', 'iconcardtwo_integrateWithVC');
function iconcardtwo_integrateWithVC()
{
    vc_map(
        array(
            "name" => __("Icon Card Two", "my-text-domain"),
            "base" => "iconcardtwo",
            "class" => "",
            "category" => __("Content", "my-text-domain"),

            "params" => array(
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Title", "my-text-domain"),
                    "param_name" => "iconcardtwotitle",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Put the block title in here.", "my-text-domain")
                ),
                array(
                    "type" => "textarea",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Description", "my-text-domain"),
                    "param_name" => "iconcardtwodesc",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Write Description here. Try and keep lengths similar.", "my-text-domain")
                ),
                array(
                    "type" => "attach_image",
                    "heading" => __("Image", "my-text-domain"),
                    "param_name" => "iconcardtwoimage",
                    "value" => "",
                    "description" => __("Choose block image.", "my-text-domain")

                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Circle Colour", "my-text-domain"),
                    "param_name" => "iconcardcolor",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Put the block title in here.", "my-text-domain")
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Link", "my-text-domain"),
                    "param_name" => "iconcardtwolink",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Put the link in here. Remember to not include the root e.g. /example/.", "my-text-domain")
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Link Text", "my-text-domain"),
                    "param_name" => "iconcardtwolinktext",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Put the block title in here.", "my-text-domain")
                ),

            )
        )
    );
}

add_shortcode('iconcardtwo', 'iconcardtwo_func');
function iconcardtwo_func($atts, $content = null, $iconcardtwotitle)
{

    extract(shortcode_atts(array(
        'iconcardtwoimage' => '',
        'iconcardcolor' => '',
        'iconcardtwotitle' => '',
        'iconcardtwolink' => '#',
        'iconcardtwodesc' => ''
    ), $atts));

    $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
    
    $imageSrc = wp_get_attachment_image_src($iconcardtwoimage, 'medium');
    
    ob_start(); ?>

    <a href="<?php echo $iconcardtwolink; ?>" class="icon-card-two-link">
        <div class="icon-card-two">
            <div class="icon-card-two-top">
                <div class="icon-card-two-top-title">
                    <?php if ($iconcardtwotitle) { ?>
                        <h2 class="icon-card-two-title"><?php echo $iconcardtwotitle; ?></h1>
                    <?php } ?>
                </div>
                <div class="icon-card-two-top-icon-background" style="background: <?php echo $iconcardcolor; ?>;">
                   <img src="<?php echo $imageSrc[0]; ?>" class="icon-card-two-top-icon-image">
                </div>
            </div>
            <div class="icon-card-two-bottom">
                <div class="icon-card-two-bottom-text">
                    <?php echo $iconcardtwodesc; ?> 
                </div>
                <div class="icon-card-two-bottom-link">
                    <span class="material-icons-outlined">east</span> <?php echo $iconcardtwotitle; ?>
                </div>
            </div>
        </div>
    </a>

           

    <?php return ob_get_clean();
}
