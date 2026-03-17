<?php
add_action('vc_before_init', 'your_name_linkcardfive');
function your_name_linkcardfive()
{
    vc_map(
        array(
            "name" => __("Link Card Five", "my-text-domain"),
            "base" => "linkcardfive",
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

add_shortcode('linkcardfive', 'linkcardfive_func');
function linkcardfive_func($atts, $content = null, $linktitle = null)
{
    extract(shortcode_atts(array(
        'linkimage' => '',
        'linktitle' => '',
        'linklink' => ''
    ), $atts));

    $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
    
    $imageSrc = wp_get_attachment_image_src($linkimage, 'medium');

ob_start(); ?>


    <a href="<?php echo $linklink; ?>" class="link-card--five-link">
        <div class="link-card--five">
            <div class="link-card--five-image" style="background: url('<?php echo $imageSrc[0]; ?>')">
                <div class="link-card--five-image-overlay">

                    <div class="link-card--five-text-area">
                        <div class="link-card--five-ribbon">    
                            <div class="link-card--five-title-background">
                                <h4 class="link-card--five-title"><?php echo $linktitle; ?></h4>
                            </div>
                            <div class="link-card--five-ribbon-slash">
                                
                            </div>
                        </div>
                        <div class="link-card--five-arrow">
                            <span class="material-icons">east</span> Read More
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>


    <?php return ob_get_clean();
}
