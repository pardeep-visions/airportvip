<?php
add_action('vc_before_init', 'testimonial_slider_items_funct');

function testimonial_slider_items_funct()
{
    vc_map(
        array(
            "name" => __("Testiminial Slider", "my-text-domain"), // Element name
            "base" => "testimonial_slider", // Element shortcode
            "class" => "box-repeater",
            "category" => __('Content', 'my-text-domain'),
            'params' => array(
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "admin_label" => true,
                    "heading" => __("Heading", "my-text-domain"),
                    "param_name" => "testimonial_slider_heading",
                    "value" => __("", "my-text-domain"),
                    "description" => __('Add heading here', "my-text-domain")
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "admin_label" => true,
                    "heading" => __("Read More Link", "my-text-domain"),
                    "param_name" => "testimonial_slider_link",
                    "value" => __("", "my-text-domain"),
                    "description" => __('Link to testimonials page', "my-text-domain")
                ),
                array(
                    'type' => 'param_group',
                    'param_name' => 'testimonial_slider_items',
                    'params' => array(
                        array(
                            "type" => "textarea",
                            "holder" => "div",
                            "class" => "",
                            "admin_label" => true,
                            "heading" => __("Testimonial", "my-text-domain"),
                            "param_name" => "testimonial_slider_items_testimonial",
                            "value" => __("", "my-text-domain"),
                        ),
                        array(
                            "type" => "textfield",
                            "class" => "",
                            "admin_label" => true,
                            "heading" => __("Attribution", "my-text-domain"),
                            "param_name" => "testimonial_slider_items_attribution",
                            "value" => __("", "my-text-domain"),
                        ),

                    )
                ),
            )
        )
    );
} 

add_shortcode('testimonial_slider', 'testimonial_slider_funct');
function testimonial_slider_funct($atts)
{
    ob_start();
    $atts = shortcode_atts(array(
        'testimonial_slider_heading' => '',
        'testimonial_slider_link' => '',
        'testimonial_slider_items' => '',
    ), $atts, 'testimonial_slider');

    $heading = $atts['testimonial_slider_heading'];
    $link = $atts['testimonial_slider_link'];
    $items = vc_param_group_parse_atts($atts['testimonial_slider_items']); ?>

    <div class="testimonial-slider-outer">

        <div class="speach-mark-center">"</div>

        <?php echo (!empty($heading)) ? '<h2>' . $heading . '<h2>' : ''; ?>

        <?php if ($items) : ?>

            <div class="testimonial-slider">

                <div class="testimonial-slider-inner">

                    <div id="slider" class="flexslider">

                        <ul class="slides">

                            <?php foreach ($items as  $item) : ?>
                                <li class="testimonial-slide">
                                    <div class="testimonial-slider-text">
                                        <h2 class="testimonial-slider-title"><?php echo $item['testimonial_slider_items_testimonial']; ?></h2>
                                        <p class="testimonial-slider-attribution"><?php echo $item['testimonial_slider_items_attribution']; ?></p>
                                    </div>
                                </li>
                            <?php endforeach; ?>

                        </ul>
                    </div>
                </div>
            </div>

            <?php echo (!empty($link)) ? '<a class="button testimonial-slider-read-more" href="' . $link . '">See More</a>' : ''; ?>

        <?php endif; ?>

    </div>
    <?php return ob_get_clean();
}
