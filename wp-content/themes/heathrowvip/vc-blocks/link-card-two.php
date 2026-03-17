<?php
add_action('vc_before_init', 'your_name_linkcardtwo');
function your_name_linkcardtwo()
{
    vc_map(
        array(
            "name" => __("Link Card Two", "my-text-domain"),
            "base" => "linkcardtwo",
            "class" => "",
            "category" => __("Content", "my-text-domain"),
            "params" => array(
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Title", "my-text-domain"),
                    "param_name" => "linktitle",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Put the block title in here.", "my-text-domain")
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Desc", "my-text-domain"),
                    "param_name" => "linkdesc",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Put the block description in here.", "my-text-domain")
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Link", "my-text-domain"),
                    "param_name" => "linklink",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Put the link in here. Remember to not include the root e.g. /example/.", "my-text-domain")
                ),
                array(
                    "type" => "attach_image",
                    "heading" => __("Image", "my-text-domain"),
                    "param_name" => "linkimage",
                    "value" => "",
                    "description" => __("Choose block image.", "my-text-domain")
                )
            )
        )
    );
}

add_shortcode('linkcardtwo', 'linkcardtwo_func');
function linkcardtwo_func($atts, $content = null, $linktitle = null)
{
    extract(shortcode_atts(array(
        'linkimage' => '',
        'linktitle' => '',
        'linkdesc' => '',
        'linklink' => ''
    ), $atts));

    $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
    
    $imageSrc = wp_get_attachment_image_src($linkimage, 'medium');

    ob_start(); ?>

    <div class="link-card-two-grid-outer" >
        <a href="<?php echo $linklink; ?>" class="link-card-two">
            <div class="link-card-two-grid" >
                <div class="link-card-two-background" style="background: url(<?php echo $imageSrc[0]; ?>);">
                    <div class="link-card-two-arrow-icon">
                        <span class="material-icons">
                            chevron_right
                        </span>
                    </div>
                </div>
                <div class="link-card-two-text" >
                    <h2 class="link-card-two-title"><?php echo $linktitle; ?></h2>
                    <p class="link-card-two-p"><?php echo $linkdesc; ?></p>
                </div>       
            </div>
        </a>
    </div>
    <?php return ob_get_clean();
}
