<?php
add_action('vc_before_init', 'gallery_masonry_grid');
function gallery_masonry_grid()
{
    vc_map(
        array(
            "name" => __("Gallery Masonry Style", "my-text-domain"),
            "base" => "gallerymasonrygrid",
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

add_shortcode('gallerymasonrygrid', 'bartag_func_gallery_masonry_grid');
function bartag_func_gallery_masonry_grid($atts, $content = null, $servicetitle)
{

    extract(shortcode_atts(array(
        'serviceimage' => 'serviceimage',
    ), $atts));

    $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

    $serviceimage = explode(',', $serviceimage);

    ob_start(); ?>

    <div class="gallery-outer">
        <div class="gallery--mosaic has-slick-lightbox">
            <?php foreach ($serviceimage as $id) : ?>
                <?php $imageSrc = wp_get_attachment_image_src($id, 'medium'); ?>
                <?php $imageSrcFull = wp_get_attachment_image_src($id, 'full'); ?>
                <a class="image-link" href="<?php echo $imageSrcFull[0]; ?>">
                    <img src="<?php echo $imageSrc[0]; ?>">
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
        jQuery(document).ready(function() {
            jQuery('.gallery--mosaic').justifiedGallery({
                rowHeight: 300,
                lastRow: 'nojustify',
                margins: 20,
            });

        });
    </script>

<?php return ob_get_clean();
}
