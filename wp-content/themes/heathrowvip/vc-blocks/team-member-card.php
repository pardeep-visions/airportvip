<?php
add_action('vc_before_init', 'teammembercard_teammembercard');
function teammembercard_teammembercard()
{
    vc_map(
        array(
            "name" => __("Team Member Card", "my-text-domain"),
            "base" => "teammembercard",
            "class" => "",
            "category" => __("Content", "my-text-domain"),
            "params" => array(
                array(
                    "type" => "attach_image",
                    "heading" => __("Image", "my-text-domain"),
                    "param_name" => "serviceimage",
                    "value" => "",
                    "description" => __("Choose block image.", "my-text-domain")
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Name", "my-text-domain"),
                    "param_name" => "name",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Put the block title in here.", "my-text-domain")
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Job Title", "my-text-domain"),
                    "param_name" => "jobtitle",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Put the block title in here.", "my-text-domain")
                ),
                array(
                    "type" => "textarea_html",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Description", "my-text-domain"),
                    "param_name" => "content",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Write Description here. Try and keep lengths similar.", "my-text-domain")
                ),
               
            )
        )
    );
}

add_shortcode('teammembercard', 'teammembercard_func');
function teammembercard_func($atts, $content, $serviceimage)
{

    extract(shortcode_atts(array(
        'serviceimage' => '',
        'name' => '',
        'jobtitle' => '',
   
    ), $atts));

    $imageSrc = wp_get_attachment_image_src($serviceimage, 'large');

    ob_start(); ?>

    <div class='team-member-card'>
        <?php if ($imageSrc[0]) { ?>
            <div class='team-member-card-image' style='background: url(<?php echo $imageSrc[0]; ?>);'></div>
        <?php } ?>
        <div class="team-member-card-text-area">
            <?php if ($name) { ?>
                <h2 class="team-member-card-name"><?php echo $name; ?></h2>
            <?php } ?>
            <?php if ($jobtitle) { ?>
                <h3 class="team-member-card-job-title"><?php echo $jobtitle; ?></h3>
            <?php } ?>
            <?php echo $content; ?>
        </div>
    </div>

    <?php return ob_get_clean();
}
