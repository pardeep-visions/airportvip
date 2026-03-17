<?php
add_action('vc_before_init', 'displayblocktwentytwo_integrateWithVC');
function displayblocktwentytwo_integrateWithVC() {
    vc_map(
        array(
            "name" => __("Display Block Twenty Two", "my-text-domain"),
            "base" => "displayblocktwentytwo",
            "class" => "",
            "category" => __("Content", "my-text-domain"),
            "params" => array(
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Year", "my-text-domain"),
                    "param_name" => "year",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Write Description here. Try and keep lengths similar.", "my-text-domain")
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Title", "my-text-domain"),
                    "param_name" => "title",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Write Description here. Try and keep lengths similar.", "my-text-domain")
                ),
                array(
                    "type" => "textarea_html",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Content", "my-text-domain"),
                    "param_name" => "content",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Write content here.", "my-text-domain")
                ),
            )
        )
    );
}

add_shortcode('displayblocktwentytwo', 'displayblocktwentytwo_func');
function displayblocktwentytwo_func($atts, $content) { 

    extract(shortcode_atts(array(
        'year' => '', 
        'title' => '', 
        
    ), $atts));

	$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

    ob_start(); ?>

    <div class="display-block-twenty-two" >
        <div class="display-block-twenty-two-left">
            <div class="display-block-twenty-two-line viewport-trigger trigger-target">
            </div>
        </div>
        <div class="display-block-twenty-two-right">
            <div class="display-block-twenty-two-year-div">
                <span class="display-block-twenty-two-year"><?php echo $year; ?></span>
            </div>
            <div class="display-block-twenty-two-title-div">
                <h2 class="display-block-twenty-two-title"><?php echo $title; ?></h2>
            </div>
            <div class="display-block-twenty-two-content">
                <?php echo $content; ?>   
            </div>      
        </div>
    </div>

    <?php return ob_get_clean();
}
