<?php
add_action('vc_before_init', 'client_logo_grid');
function client_logo_grid()
{
    vc_map(
        array(
            "name" => __("Client Logo Grid", "my-text-domain"),
            "base" => "clientlogogrid",
            "class" => "",
            "category" => __("Content", "my-text-domain"),
            "params" => array(
               
                array(
                    "type" => "attach_images",
                    "heading" => __("Image", "my-text-domain"),
                    "param_name" => "serviceimage",
                    "value" => "",
                    "description" => __("Choose block image.", "my-text-domain")
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Grid Template Colum Command", "my-text-domain"),
                    "param_name" => "gridcol",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Write Description here. Try and keep lengths similar.", "my-text-domain")
                ),
            )
        )
    );
}

add_shortcode('clientlogogrid', 'bartag_func_client_logo_grid');
function bartag_func_client_logo_grid($atts, $content = null, $servicetitle)
{

    extract(shortcode_atts(array(
        'serviceimage' => 'serviceimage',
        'gridcol' => '',
    ), $atts));

    $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

    $serviceimage = explode(',', $serviceimage);

    ob_start(); ?>
        
    <div class="client-logo-grid" style="grid-template-columns:<?php echo $gridcol; ?>!important;">
        
            <?php foreach ($serviceimage as $id) : ?>
                <?php $imageSrc = wp_get_attachment_image_src($id, 'medium'); ?>
                <?php $imageSrcFull = wp_get_attachment_image_src($id, 'full'); ?>
                <div class="client-logo-grid-item" >
                    <img src="<?php echo $imageSrc[0]; ?>">
                </div>
            <?php endforeach; ?>
        
    </div>

    <?php return ob_get_clean();
}
