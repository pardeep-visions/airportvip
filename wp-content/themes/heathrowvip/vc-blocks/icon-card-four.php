<?php
add_action('vc_before_init', 'iconcardfour_integrateWithVC');
function iconcardfour_integrateWithVC()
{
    vc_map(
        array(
            "name" => __("Icon Card Four", "my-text-domain"),
            "base" => "iconcardfour",
            "class" => "",
            "category" => __("Content", "my-text-domain"),

            "params" => array(
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Icon", "my-text-domain"),
                    "param_name" => "icon",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Put the block title in here.", "my-text-domain")
                ),
              
                array(
                    "type" => "textarea",
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

add_shortcode('iconcardfour', 'iconcardfour_func');
function iconcardfour_func($atts, $content, $servicetitle)
{

    extract(shortcode_atts(array(
        'serviceimage' => '',
        'icon' => '',
       
    ), $atts));

    $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
    
    $imageSrc = wp_get_attachment_image_src($serviceimage, 'medium');
    
    ob_start(); ?>

<style>



</style>

 
        <div class="icon-card-four-image" style="background: url('<?php echo $imageSrc[0]; ?>')">
            <div class="icon-card-four-image-overlay">
                <div class="icon-card-four-content">
                    <?php if ($icon) { ?>
                        <div class="icon-card-four-icon">
                            <?php echo $icon; ?>
                        </div>
                    <?php } ?>
                    <div class="icon-card-four-text">
                        <?php echo $content; ?>
                    </div>
                </div>
            </div>
        </div>
   

    <?php return ob_get_clean();
}
