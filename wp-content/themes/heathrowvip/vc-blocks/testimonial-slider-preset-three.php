<?php
add_action('vc_before_init', 'testimonial_slider_preset_three');
function testimonial_slider_preset_three() {
	vc_map(
		array(
			"name" => __("Testimonial Slider Preset Three", "my-text-domain"),
			"base" => "testimonialsliderpresetthree",
			"class" => "",
			"category" => __("Content", "my-text-domain"),
			"params" => array(
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Background Text", "my-text-domain"),
                    "param_name" => "backgroundtext",
                    "value" => __("", "my-text-domain"),
                    "description" => __("No spaces", "my-text-domain")
                ),
			)
        )
          
	);
}


add_shortcode('testimonialsliderpresetthree', 'testimonial_slider_preset_func_three');
function testimonial_slider_preset_func_three($atts, $content = null, $servicetitle) { 
    extract(shortcode_atts(array(
        'backgroundtext' => '',
    ), $atts));

    ob_start(); ?>

        <div class="testimonial-slider-three">
            <span class="testimonial-slider-three-background-text">
                <?php echo $backgroundtext; ?>
            </span>
            <div class="testimonial-slider-three-inner">
                <div id="slider" class="flexslider">
                    <ul class="slides">

                        <?php
                        $category_slug = get_field('post_category_slug');
                        $args = array(
                            'post_type'   => 'testimonials',
                            'post_status' => 'publish',
                            'posts_per_page' => 5,
                            'tax_query'   => array(
                        array(
                            'taxonomy' => 'testimonial-categories',
                            'field'    => 'slug',
                            'terms'    => 'include-in-slider'
                            )));

                        $testimonials = new WP_Query($args);

                        if ($testimonials->have_posts()) : ?>
                            <?php while ($testimonials->have_posts()) :

                                $testimonials->the_post(); ?>

                                <?php// the_title(); ?>
                                <?php// the_field("testimonial_image"); ?>
                                <?php// the_field("title"); ?>
                                <?php// the_field("testimonial"); ?>
                                <?php// the_field("name"); ?>
                                <?php// the_field("job_title"); ?>

                                <li class="testimonial-slide-three viewport-trigger trigger-target">
                                    <div class="testimonial-slide-three-left-grid">
                                        <div class="testimonial-slide-three-left">
                                            <div class="testimonial-slide-three-left-top">
                                                <div class="testimonial-slider-text-three">
                                                    <?php the_field("testimonial"); ?>
                                                </div>
                                            </div>
                                            <div class="testimonial-slide-three-left-bottom">

                                                <div class="testimonial-slide-three" style="background-image: url(<?php the_field("testimonial_image"); ?>)">
                                                    <div class="testimonial-slide-three">
                                                    </div>
                                                </div>

                                                <div class="testimonial-slide-three-left-bottom-right">
                                                    
                                                        <h2 class="testimonial-slider-three-title"><?php the_field("name"); ?>,</h2>
                                                        <p class="testimonial-slider-three-attribution"><?php the_field("job_title"); ?></p>
                                                   
                                                </div>
                                            </div>

                                        </div>

                                        <div class="testimonial-slide-three-right"  style="background: url(<?php the_field("testimonial_image"); ?>");>

                                        </div>
                                    </div>

                                   
                                </li>
                               
                        <?php endwhile;
                            wp_reset_postdata(); ?>
                        <?php else :
                            esc_html_e('No posts found in the custom taxonomy!', 'text-domain');
                        endif; ?>

                    </ul>
                </div>
            </div>
        </div>

    <?php return ob_get_clean();
}
