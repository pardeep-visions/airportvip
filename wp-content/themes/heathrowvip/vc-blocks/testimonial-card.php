<?php
add_action('vc_before_init', 'your_name_testimonialcard');
function your_name_testimonialcard()
{
    vc_map(
        array(
            "name" => __("Testimonial Card", "my-text-domain"),
            "base" => "testimonialcard",
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
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Name", "my-text-domain"),
                    "param_name" => "testimonialname",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Put the block title in here.", "my-text-domain")
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Job Title", "my-text-domain"),
                    "param_name" => "testimonialjobtitle",
                    "value" => __("", "my-text-domain"),
                    "description" => __("Put the block title in here.", "my-text-domain")
                ),

            )
        )
    );
}

add_shortcode('testimonialcard', 'bartag_testimonialcard');
function bartag_testimonialcard($atts, $content = null, $servicetitle)
{

    extract(shortcode_atts(array(
        'servicedesc' => 'content',
        'testimonialname' => 'testimonialname',
        'testimonialjobtitle' => 'testimonialjobtitle'

    ), $atts));
  
    $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

    ob_start(); ?>

    <div class="testimonial-single">
        <div class="row">
            <div class="col-12 testimonial-right"> 
                <div class="testimonial-content">
                    <span class="speach-mark middle"><?php echo $content; ?></span>
                </div>
                <div class="testimonial-attribution">
                    <p class="attribution">
                        <span class="attribution-name">
                            <?php echo $testimonialname; ?>,
                        </span>
                        <span class="attribution-job-title">
                            <?php echo $testimonialjobtitle; ?>
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <?php return ob_get_clean();
}
