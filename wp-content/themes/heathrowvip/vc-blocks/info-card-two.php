<?php
add_action('vc_before_init', 'your_name_infocardtwo');
function your_name_infocardtwo()
{
    vc_map(
        array(
            "name" => __("Info Card Two", "my-text-domain"),
            "base" => "infocardtwo",
            "class" => "",
            "category" => __("Content", "my-text-domain"),

            "params" => array(
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Title", "my-text-domain"),
                    "param_name" => "infotitle",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Put the block title in here.", "my-text-domain")
                ),
                array(
                    "type" => "textarea",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Description", "my-text-domain"),
                    "param_name" => "infodesc",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Write Description here. Try and keep lengths similar.", "my-text-domain")
                ),
                array(
                    "type" => "attach_image",
                    "heading" => __("Image", "my-text-domain"),
                    "param_name" => "infoimage",
                    "value" => "",
                    "description" => __("Choose block image.", "my-text-domain")

                ),

            )
        )
    );
}

add_shortcode('infocardtwo', 'bartag_infocardtwo');
function bartag_infocardtwo($atts, $content = null, $infotitle)
{
    extract(shortcode_atts(array(
        'infoimage' => '',
        'infotitle' => '',
        'infodesc' => ''
    ), $atts));

    $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
    
    $imageSrc = wp_get_attachment_image_src($infoimage, 'medium');
    
    ob_start(); ?>


    <div class="info-card--two">
        <?php if ($infoimage) { ?>
            <div class="info-card--two-background" style="background: url(<?php echo $imageSrc[0]; ?>);">
                <div class="info-card--two-background-overlay"></div>
            </div>
        <?php } ?>
        <div class="info-card--two-text">
            <?php if ($infotitle) { ?>
                <div class="info-card--two-text-title">
                    <h2 class="info-card--two-title"><?php echo $infotitle; ?></h1>
                </div>
            <?php } ?>
            <?php if ($infodesc) { ?>
                <div class="info-card--two-text-desc">
                    <p class="info-card--two-desc"><?php echo $infodesc; ?></p>
                </div>
            <?php } ?>
        </div>
    </div>

    <?php return ob_get_clean();
}
