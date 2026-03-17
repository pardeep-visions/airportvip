<?php
add_action('vc_before_init', 'testimonial_slider_preset_four');
function testimonial_slider_preset_four() {
	vc_map(
		array(
			"name" => __("Testimonial Slider Preset Four", "my-text-domain"),
			"base" => "testimonialsliderpresetfour",
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
                array(
                    "type" => "attach_image",
                    "heading" => __("Image", "my-text-domain"),
                    "param_name" => "linkimage",
                    "value" => "",
                    "description" => __("Choose block image.", "my-text-domain")
                ),

			)
        )
          
	);
}


add_shortcode('testimonialsliderpresetfour', 'testimonial_slider_preset_func_four');
function testimonial_slider_preset_func_four($atts, $content = null, $servicetitle) { 
    extract(shortcode_atts(array(
        'backgroundtext' => '',
        'linkimage' => '',
    ), $atts));

    $imageSrc = wp_get_attachment_image_src($linkimage, 'hd');


    ob_start(); ?>


<style>

.testimonial-slider-four-top {
    background-size: cover!important;
    background-repeat: no-repeat!important;
    background-position: center!important;
    position: relative;
}

.testimonial-slider-four-top:after {
    content: " ";
    background: red;
    background: rgba(0, 0, 0, 0.3);
    width: 100%;
    height: 100%;
    display: block!important;
    position: absolute;
    z-index: 0;
    left: 0;
    top: 0;
    pointer-events: none;
}

.testimonial-slider-four-top > * {
    z-index: 1;
    position: relative;
}

.testimonial-slider-four-top-inner {
    display: grid;
    grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
    grid-gap: 40px;
    max-width: 1190px;
    margin: 0 auto;
}

.testimonial-slider-four-left {
    padding: 70px 20px 20px;
}

.testimonial-slider-four-left * {
    color: white!important
}

.testimonial-slider-four-left .button {
    margin-bottom: 25px;
}

.testimonial-slider-four-right {
    background: #272727;
    padding: 40px;
    position: relative;
    top: 70px;
}

.testimonial-slider-four-right * {
    color: white;
}

h3.testimonial-slider-four-title {
    color: white;
    border-bottom: 1px solid white;
    padding-bottom: 25px;
    margin-bottom: 20px;
}

.testimonial-slider-four-flexslider {
    background: transparent;
}

li.testimonial-slide-four {
    display: grid!important;
    align-content: space-between!important;
}

.testimonial-slider-text-four p {
    font-size: 18px;
    line-height: 1.2em;
    color: white;
}

.testimonial-slide-four-left-bottom {
    display: grid;
    grid-template-columns: 100px 1fr;
    grid-gap: 20px;
    align-items: center;
}

.testimonial-slide-four-image {
    border-radius: 50%;
    background-size: cover!important;
    background-repeat: no-repeat!important;
    background-position: center!important;
    padding-top: 100%;
}

.testimonial-slide-four-left-top::before {
    content: '\201c';
    font-size: 12rem;
    color: transparent;
    opacity: .3;
    font-family: serif;
    font-weight: bold;
    position: absolute;
    top: 5px;
    left: -2rem;
    z-index: 1;
    pointer-events: none;
    float: left;
    text-align: left;
    height: 108px;
    -webkit-text-stroke: 2px #000;
}

h2.testimonial-slider-four-title, p.testimonial-slider-four-attribution {
    margin-bottom: 0;
}

.testimonial-slider-four ul.flex-direction-nav {
    display: none!important;
}

.testimonial-slider-four ol.flex-control-nav.flex-control-paging {
    display: block!important;
    bottom: -25px!important;
}

.testimonial-slider-four-bottom {
    background: #323232;
    padding: 20px;
}

.testimonial-slider-four-bottom-inner {
    display: grid;
    grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
    grid-gap: 40px;
    max-width: 1160px;
    margin: 0 auto;
}

.testimonial-slider-four-slick-slider-item-inner {
    padding: 0;
}

.testimonial-slider-four ul.slick-dots, .testimonial-slider-four button.slick-arrow {
    display: none!important;
}

@media screen and (min-width: 768px) { 
    /* MOBILE RULES GO HERE */
    /* Viewport Rules */

    .testimonial-slider-four-right {
        top: 140px;
        transition: 0.5s;
        opacity: 0;
    }
    .testimonial-slider-four-right.fire {
        top: 70px;
        opacity: 1;
    }
}

@media screen and (max-width: 767px) { 
    /* MOBILE RULES GO HERE */
    .testimonial-slider-four-top-inner { 
    grid-template-columns: minmax(0, 1fr); 
    }

    .testimonial-slider-four-bottom-inner {
        grid-template-columns: minmax(0, 1fr);
    }

    .testimonial-slider-four-right {
        top: 0px;
    }

    .testimonial-slider-four-right {
    margin: 20px;
    }
}

</style>

<div class="testimonial-slider-four">

    <div class="testimonial-slider-four-top" style="background: url('<?php echo $imageSrc[0]; ?>')">
        <div class="testimonial-slider-four-top-inner">
            <div class="testimonial-slider-four-left">
                <a href="#" class="button">Book Now</a>
                <h3>Configure Your Booking</h3>
            </div>
            <div class="testimonial-slider-four-right viewport-trigger trigger-target">
                <h3 class="testimonial-slider-four-title">What Clients Say?</h3>

                <div id="slider" class="flexslider testimonial-slider-four-flexslider">
                    <ul class="slides testimonial-slider-four-slides">

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

                                <li class="testimonial-slide-four">                                 
                                    <div class="testimonial-slide-four-left-top">
                                        <div class="testimonial-slider-text-four">
                                            <?php the_field("testimonial"); ?>
                                        </div>
                                    </div>
                                    <div class="testimonial-slide-four-left-bottom">
                                        <div class="testimonial-slide-four-image" style="background-image: url(<?php the_field("testimonial_image"); ?>)">
                                            <div class="testimonial-slide-four-image-inner">
                                            </div>
                                        </div>
                                        <div class="testimonial-slide-four-left-bottom-right">
                                            <h2 class="testimonial-slider-four-title"><?php the_field("name"); ?>,</h2>
                                            <p class="testimonial-slider-four-attribution"><?php the_field("job_title"); ?></p>
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
    </div>
    <div class="testimonial-slider-four-bottom">
        <div class="testimonial-slider-four-bottom-inner">
            <div class="testimonial-slider-four-bottom-left">

                <div class="slick-slider-carousel has-slick-lightbox"  data-slick='{"slidesToShow": 5, "slidesToScroll": 1}'> 
                    <div class="slick-slide-item testimonial-slider-four-slick-slider-item">
                        <div class="slick-slider-item-inner testimonial-slider-four-slick-slider-item-inner">
                            <div class="square-grid-thumbs" style="background-image: url(/wp-content/uploads/2021/01/photodune-AjAM9gbp-modern-office-interior-xxl.jpg);"></div>
                        </div>
                    </div>
                    <div class="slick-slide-item testimonial-slider-four-slick-slider-item">
                        <div class="slick-slider-item-inner testimonial-slider-four-slick-slider-item-inner">
                            <div class="square-grid-thumbs" style="background-image: url(/wp-content/uploads/2021/01/photodune-AjAM9gbp-modern-office-interior-xxl.jpg);"></div>
                        </div>
                    </div>
                    <div class="slick-slide-item testimonial-slider-four-slick-slider-item">
                        <div class="slick-slider-item-inner testimonial-slider-four-slick-slider-item-inner">
                            <div class="square-grid-thumbs" style="background-image: url(/wp-content/uploads/2021/01/photodune-AjAM9gbp-modern-office-interior-xxl.jpg);"></div>
                        </div>
                    </div>
                    <div class="slick-slide-item testimonial-slider-four-slick-slider-item">
                        <div class="slick-slider-item-inner testimonial-slider-four-slick-slider-item-inner">
                            <div class="square-grid-thumbs" style="background-image: url(/wp-content/uploads/2021/01/photodune-AjAM9gbp-modern-office-interior-xxl.jpg);"></div>
                        </div>
                    </div>
                    <div class="slick-slide-item testimonial-slider-four-slick-slider-item">
                        <div class="slick-slider-item-inner testimonial-slider-four-slick-slider-item-inner">
                            <div class="square-grid-thumbs" style="background-image: url(/wp-content/uploads/2021/01/photodune-AjAM9gbp-modern-office-interior-xxl.jpg);"></div>
                        </div>
                    </div>
                    <div class="slick-slide-item testimonial-slider-four-slick-slider-item">
                        <div class="slick-slider-item-inner testimonial-slider-four-slick-slider-item-inner">
                            <div class="square-grid-thumbs" style="background-image: url(/wp-content/uploads/2021/01/photodune-AjAM9gbp-modern-office-interior-xxl.jpg);"></div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="testimonial-slider-four-bottom-right">
            </div>
        </div>
    </div>
</div>

    <?php return ob_get_clean();
}
