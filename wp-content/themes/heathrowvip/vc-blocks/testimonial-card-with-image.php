<?php
add_action('vc_before_init', 'your_name_testimonialcardwithimage');
function your_name_testimonialcardwithimage()
{
    vc_map(
        array(
            "name" => __("Testimonial Card With Image", "my-text-domain"),
            "base" => "testimonialcardwithimage",
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

add_shortcode('testimonialcardwithimage', 'bartag_testimonialcardwithimage');
function bartag_testimonialcardwithimage($atts, $content = null, $servicetitle)
{

    extract(shortcode_atts(array(
        'servicedesc' => 'content',
        'serviceimage' => 'serviceimage',
        'testimonialname' => 'testimonialname',
        'testimonialjobtitle' => 'testimonialjobtitle'

    ), $atts));
  
    $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

    $imageSrc = wp_get_attachment_image_src($serviceimage, 'medium');

    ob_start(); ?>

    <div class="testimonial-single">
        <div class="row">
            <div class="col-2 testimonial-left">
                <div class="testimonial-image-background" style="background-image: url(<?php echo $imageSrc[0]; ?>)">
                    <div class="testimonial-image-inner">
                    </div>
                </div>
            </div>
            <div class="col-10 testimonial-right">  
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
