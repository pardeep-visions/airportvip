<?php
add_action('vc_before_init', 'vimeobackground_integrateWithVC');
function vimeobackground_integrateWithVC()
{
    vc_map(
        array(
            "name" => __("Vimeo Background", "my-text-domain"),
            "base" => "vimeobackground",
            "class" => "",
            "category" => __("Content", "my-text-domain"),
            "params" => array(
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Video URL", "my-text-domain"),
                    "param_name" => "videourl",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Put the block title in here.", "my-text-domain")
                ),
                array(
                    "type" => "attach_image",
                    "heading" => __("Background Image", "my-text-domain"),
                    "param_name" => "imageone",
                    "value" => "",
                    "description" => __("Choose background image.", "my-text-domain")
                ),	
              
            )
        )
    );
}

add_shortcode('vimeobackground', 'vimeobackground_func');
function vimeobackground_func($atts, $content, $serviceimage)
{
    extract(shortcode_atts(array(
        'videourl' => '',
        'imageone' => '', 
    ), $atts));

    $imageoneSRC = wp_get_attachment_image_src($imageone, 'hd');

    ob_start(); ?>

    <?php function isMobileDevice()
    {
        return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
    }
    if (isMobileDevice()) { ?>

        <div style="padding:56.25% 0 0 0;position:relative;">
            <iframe src="https://player.vimeo.com/video/<?php echo $videourl; ?>?h=d3751f77b9&amp;badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479&amp;autoplay=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;" title="Alternating Squat Curl"></iframe>
        </div>
        <script src="https://player.vimeo.com/api/player.js"></script>

    <?php } else { ?>
        
        <div class="vimeo-background-outer" style="background: url(<?php echo $imageoneSRC; ?>);">
            <div class="vimeo-wrapper">
                <iframe src="https://player.vimeo.com/video/<?php echo $videourl; ?>?background=1" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
            </div>
        </div>

    <?php } ?>

    <?php return ob_get_clean();
}
