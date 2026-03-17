<?php
add_action('vc_before_init', 'roundcard_integrateWithVC');
function roundcard_integrateWithVC()
{
    vc_map(
        array(
            "name" => __("Round Card", "my-text-domain"),
            "base" => "roundcard",
            "class" => "",
            "category" => __("Content", "my-text-domain"),
            "params" => array(
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Title", "my-text-domain"),
                    "param_name" => "funkytitle",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Put the block title in here.", "my-text-domain")
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Text", "my-text-domain"),
                    "param_name" => "funkytext",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Put the link in here. Remember to not include the root e.g. /example/.", "my-text-domain")
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Colour", "my-text-domain"),
                    "param_name" => "colour",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Put the link in here. Remember to not include the root e.g. /example/.", "my-text-domain")
                ),
            )
        )
    );
}

add_shortcode('roundcard', 'roundcard_func');
function roundcard_func($atts, $content, $funkyimage)
{

    extract(shortcode_atts(array(
        'funkytitle' => '',
        'funkytext' => '',
        'colour' => 'red'
    ), $atts));

    ob_start(); ?>
    
    <div class="circle-card-outer">
        <a href="/#">
            <div class="circle-card-upper"></div>
            <div class="circle-card" style="background: <?php echo $colour; ?>;">
                <div class="circle-card-text">
                    <?php if ($funkytitle) { ?>
                        <h2 class="circle-card-title"><?php echo $funkytitle; ?></h2>
                    <?php } ?>
                    <?php if ($funkytext) { ?>
                        <p class="circle-card-desc"><?php echo $funkytext; ?></p>
                    <?php } ?>
                </div>
            </div>
        </a>
    </div>

    <?php return ob_get_clean();
}
