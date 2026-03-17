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


        <div class="slick-slider-carousel has-slick-lightbox"  data-slick='{"slidesToShow": 4, "slidesToScroll": 4}'> 

        <?php
                        $category_slug = get_field('post_category_slug');
                        $args = array(
                            'post_type'   => 'testimonials',
                            'post_status' => 'publish',
                            'posts_per_page' => 115,
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

                                <?php // the_title(); ?>
                                <?php // the_field("testimonial_image"); ?>
 
                        <a class="image-link" href="<?php the_field("testimonial_image"); ?>"> 
                            <div class="slick-slide-item">
                                <div class="slick-slider-item-inner">
                                    <div class="square-grid-thumbs" style="background-image: url(<?php the_field("testimonial_image"); ?>);"></div>
                                    <h2><?php the_title(); ?></h2>
                                </div>
                            </div>
                           
                        </a> 


             <?php endwhile;
                            wp_reset_postdata(); ?>
                        <?php else :
                            esc_html_e('No posts found in the custom taxonomy!', 'text-domain');
                        endif; ?>
    </div>






    <?php return ob_get_clean();
}
