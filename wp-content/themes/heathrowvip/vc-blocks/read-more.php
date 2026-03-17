<?php
add_action('vc_before_init', 'read_more_dropdown_vc');
function read_more_dropdown_vc()
{
    vc_map(
        array(
            "name" => __("Read More Drop Down", "my-text-domain"),
            "base" => "ReadMoreDropDown",
            "class" => "",
            "category" => __("Content", "my-text-domain"),
            "params" => array(
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

add_shortcode('ReadMoreDropDown', 'read_more_dropdown_vc_func');
function read_more_dropdown_vc_func($atts, $content)
{
    extract(shortcode_atts(array(
        'servicedesc' => 'content'
    ), $atts));
    
    ob_start(); ?>

    <div class='openingbox'>
        <button class='accordion'>Read More  <arrow class='down'></arrow></button>
        <div class='panel' style='display: none;'>
            <p class='service-desc'><?php echo $content; ?></p>
        </div>
    </div>

    <?php return ob_get_clean();
}
