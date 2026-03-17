<?php
add_action('vc_before_init', 'your_name_linkcardfour');
function your_name_linkcardfour()
{
    vc_map(
        array(
            "name" => __("Link Card Four", "my-text-domain"),
            "base" => "linkcardfour",
            "class" => "",
            "category" => __("Content", "my-text-domain"),
            "params" => array(
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Top Title", "my-text-domain"),
                    "param_name" => "linktoptitle",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Put the block title in here.", "my-text-domain")
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Bottom Title", "my-text-domain"),
                    "param_name" => "linkbottomtitle",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Put the block title in here.", "my-text-domain")
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

add_shortcode('linkcardfour', 'linkcardfour_func');
function linkcardfour_func($atts, $content = null, $linktitle = null)
{
    extract(shortcode_atts(array(
        'linkimage' => '',
        'linktoptitle' => '',
        'linkbottomtitle' => '',
        'linklink' => ''
    ), $atts));

    $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
    
    $imageSrc = wp_get_attachment_image_src($linkimage, 'medium');

ob_start(); ?>

<style>




    </style>

    <a href="<?php echo $linklink; ?>" class="link-card--four-link">
        <div class="link-card--four">
            <div class="link-card--four-image" style="background: url('<?php echo $imageSrc[0]; ?>')">
                <div class="link-card--four-text-area">
                    <div class="link-card--four-text-area-inner">

                        <h4 class="link-card--four-top-title"><?php echo $linktoptitle; ?></h4>
                        <h2 class="link-card--four-bottom-title"><?php echo $linkbottomtitle; ?></h4>
                        <div class="link-card--four-line"></div>
                        <div class="link-card--four-arrow">
                            <span class="material-icons">east</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>


    <?php return ob_get_clean();
}
