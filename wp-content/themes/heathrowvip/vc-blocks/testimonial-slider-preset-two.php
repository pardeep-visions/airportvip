<?php
add_action('vc_before_init', 'your_name_testimonial_owl_carosel');
function your_name_testimonial_owl_carosel() {
	vc_map(
		array(
			"name" => __("Testimonial Slider Owl Carosel", "my-text-domain"),
			"base" => "testimonialsliderowl",
			"class" => "",
			"category" => __("Content", "my-text-domain"),
			"params" => array(
			)
		)
	);
}

add_shortcode('testimonialsliderowl', 'testimonial_owl_carosel_func');
function testimonial_owl_carosel_func($atts, $content = null, $servicetitle) { 
    ob_start(); ?>


        <div class="testimonial-slider-two">
            <div id="customers-testimonials" class="owl-carousel">

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
                            
                <!--TESTIMONIAL 1 -->
                <div class="item">
                    <div class="shadow-effect">
                    <img class="img-circle" src=" <?php the_field("testimonial_image"); ?>" alt="">
                    <p><?php the_field("testimonial"); ?></p>
                    </div>
                    <div class="testimonial-name"><?php the_field("name"); ?></div>
                </div>
                <!--END OF TESTIMONIAL 1 -->
                 
                <?php endwhile;
                    wp_reset_postdata(); ?>
                <?php else :
                    esc_html_e('No posts found in the custom taxonomy!', 'text-domain');
                endif; ?>   

               
            </div>
        </div>




        
<style>

.shadow-effect {
		    background: #fff;
		    padding: 20px;
		    border-radius: 4px;
		    text-align: center;
	border:1px solid #ECECEC;
		    box-shadow: 0 19px 38px rgba(0,0,0,0.10), 0 15px 12px rgba(0,0,0,0.02);
		}
		#customers-testimonials .shadow-effect p {
		    font-family: inherit;
		    font-size: 17px;
		    line-height: 1.5;
		    margin: 0 0 17px 0;
		    font-weight: 300;
		}
		.testimonial-name {
		    margin: -17px auto 0;
		    display: table;
		    width: auto;
		    background: #3190E7;
		    padding: 9px 35px;
		    border-radius: 12px;
		    text-align: center;
		    color: #fff;
		    box-shadow: 0 9px 18px rgba(0,0,0,0.12), 0 5px 7px rgba(0,0,0,0.05);
		}
		#customers-testimonials .item {
		    text-align: center;
		    padding: 50px;
				margin-bottom:80px;
		    opacity: .2;
		    -webkit-transform: scale3d(0.8, 0.8, 1);
		    transform: scale3d(0.8, 0.8, 1);
		    -webkit-transition: all 0.3s ease-in-out;
		    -moz-transition: all 0.3s ease-in-out;
		    transition: all 0.3s ease-in-out;
		}
		#customers-testimonials .owl-item.active.center .item {
		    opacity: 1;
		    -webkit-transform: scale3d(1.0, 1.0, 1);
		    transform: scale3d(1.0, 1.0, 1);
		}
		.owl-carousel .owl-item img {
		    transform-style: preserve-3d;
		    max-width: 90px;
    		margin: 0 auto 17px;
		}
		#customers-testimonials.owl-carousel .owl-dots .owl-dot.active span,
#customers-testimonials.owl-carousel .owl-dots .owl-dot:hover span {
		    background: #3190E7;
		    transform: translate3d(0px, -50%, 0px) scale(0.7);
		}
#customers-testimonials.owl-carousel .owl-dots{
	display: inline-block;
	width: 100%;
	text-align: center;
}
#customers-testimonials.owl-carousel .owl-dots .owl-dot{
	display: inline-block;
}
		#customers-testimonials.owl-carousel .owl-dots .owl-dot span {
		    background: #3190E7;
		    display: inline-block;
		    height: 20px;
		    margin: 0 2px 5px;
		    transform: translate3d(0px, -50%, 0px) scale(0.3);
		    transform-origin: 50% 50% 0;
		    transition: all 250ms ease-out 0s;
		    width: 20px;
		}
</style>



<script>
    jQuery(document).ready(function ($) {
	"use strict";
	//  TESTIMONIALS CAROUSEL HOOK
	$("#customers-testimonials").owlCarousel({
		loop: true,
		center: true,
		items: 3,
		margin: 0,
		autoplay: true,
		dots: true,
		autoplayTimeout: 8500,
		smartSpeed: 450,
		responsive: {
			0: {
				items: 1
			},
			768: {
				items: 2
			},
			1170: {
				items: 3
			}
		}
	});
});

</script>


    <?php return ob_get_clean();
}
