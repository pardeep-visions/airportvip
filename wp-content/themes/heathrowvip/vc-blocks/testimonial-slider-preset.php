<?php
add_action('vc_before_init', 'your_name_testimonial_slider_preset');
function your_name_testimonial_slider_preset() {
	vc_map(
		array(
			"name" => __("Testimonial Slider Preset", "my-text-domain"),
			"base" => "testimonialsliderpreset",
			"class" => "",
			"category" => __("Content", "my-text-domain"),
			"params" => array(
			)
		)
	);
}

add_shortcode('testimonialsliderpreset', 'testimonial_slider_preset_func');
function testimonial_slider_preset_func($atts, $content = null, $servicetitle) { 
    ob_start(); ?>

        <div class="testimonial-slider">
            <div class="testimonial-slider-inner">
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

                                <?php
                                    /* the_title(); 
                                    the_field("testimonial_image"); 
                                    the_field("title"); 
                                    the_field("testimonial"); 
                                    the_field("name"); 
                                    the_field("job_title"); */
                                ?>

                                <li class="testimonial-slide viewport-trigger trigger-target">


                                    <div class="testimonial-single">
                                        
                                        
                                            <div class="testimonial-right">
                                               
                                                
                                                <div class="testimonial-content">
                                                    <span class="speach-mark middle"><?php the_field("testimonial"); ?></span>
                                                </div>

                                                <div class="testimonial-attribution">
                                                    <p  class="attribution">
                                                        <span class="attribution-name">
                                                            <?php the_title(""); ?>  
                                                        </span>
                                                    </p>
                                                </div>
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
