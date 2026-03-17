<?php
add_action('vc_before_init', 'gallery_square_grid');
function gallery_square_grid()
{
    vc_map(
        array(
            "name" => __("Gallery Square Style", "my-text-domain"),
            "base" => "gallerysquaregrid",
            "class" => "",
            "category" => __("Content", "my-text-domain"),
            "params" => array(
                array(
                    "type" => "attach_images",
                    "heading" => __("Image", "my-text-domain"),
                    "param_name" => "serviceimage",
                    "value" => "",
                    "description" => __("Choose block image.", "my-text-domain")
                )
            )
        )
    );
}

add_shortcode('gallerysquaregrid', 'bartag_func_gallery_square_grid');
function bartag_func_gallery_square_grid($atts, $content = null, $servicetitle)
{
    extract(shortcode_atts(array(
        'serviceimage' => 'serviceimage',
    ), $atts));

    $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

    $serviceimage = explode(',', $serviceimage);

    ob_start(); ?>
        
    <div class="gallery-lightbox-outer square-style-grid"> 
        <div class="gallery gallery-lightbox"> 
            <?php foreach ($serviceimage as $id) : ?>
                <?php $imageSrc = wp_get_attachment_image_src($id, 'medium'); ?>
                <?php $imageSrcFull = wp_get_attachment_image_src($id, 'full'); ?>
                <a class="image-link" href="<?php echo $imageSrcFull[0]; ?>">
                    <div class="square-grid-thumbs" style="background-image: url(<?php echo $imageSrc[0]; ?>);"></div>
                    <div class="square-grid-caption"><?php echo wp_get_attachment_caption($id); ?></div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <?php return ob_get_clean();
}
