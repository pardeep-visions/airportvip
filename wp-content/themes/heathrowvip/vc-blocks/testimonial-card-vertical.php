<?php
add_action('vc_before_init', 'your_name_testimonialcardvertical');
function your_name_testimonialcardvertical()
{
    vc_map(
        array(
            "name" => __("Testimonial Card Vertical", "my-text-domain"),
            "base" => "testimonialcardvertical",
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

add_shortcode('testimonialcardvertical', 'bartag_testimonialcardvertical');
function bartag_testimonialcardvertical($atts, $content = null, $servicetitle)
{

    extract(shortcode_atts(array(
        'servicedesc' => 'content',
        'testimonialname' => 'testimonialname',
        'testimonialjobtitle' => 'testimonialjobtitle'

    ), $atts));
  
    $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

    ob_start(); ?>

    <div class="testimonial-single-vertical">
        <div class="row">
            <div class="col-12 testimonial-right"> 
                <div class="testimonial-content">
                    <div class="speach-mark-center">"</div>
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
