<?php
add_action('vc_before_init', 'videobehindtitle_integrateWithVC');
function videobehindtitle_integrateWithVC()
{
    vc_map(
        array(
            "name" => __("Video Behind Title", "my-text-domain"),
            "base" => "videobehindtitle",
            "class" => "",
            "category" => __("Content", "my-text-domain"),
            "params" => array(
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Title", "my-text-domain"),
                    "param_name" => "titleone",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Put the block title in here.", "my-text-domain")
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Video URL", "my-text-domain"),
                    "param_name" => "videourl",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Put the block title in here.", "my-text-domain")
                ),
              
            )
        )
    );
}

add_shortcode('videobehindtitle', 'videobehindtitle_func');
function videobehindtitle_func($atts, $content, $serviceimage)
{
    extract(shortcode_atts(array(
        'titleone' => 'titleone',
        'videourl' => 'videourl',
    ), $atts));

    ob_start(); ?>

    <div class="video-behind-title-block">
        <video autoplay muted loop>
            <source src="https://storage.googleapis.com/coverr-main/mp4%2FOne-Swan.mp4" type="video/mp4">
        </video>
        <h2 class="video-behind-title"><?php echo $titleone; ?></h2>
    </div>

    <?php return ob_get_clean();
}
