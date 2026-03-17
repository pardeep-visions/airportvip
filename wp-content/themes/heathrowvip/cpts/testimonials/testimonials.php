<?php
add_action('init', 'create_testimonials_taxonomy');
function create_testimonials_taxonomy()
{
	register_taxonomy('testimonial-categories', array('testimonials'), array('label' => 'Testimonial Categories', 'hierarchical' => true,));
}

function my_custom_post_testimonials()
{
	$labels = array(
		'name' => _x('Testimonials', 'post type general name'),
		'singular_name' => _x('Testimonial', 'post type singular name'),
		'add_new' => _x('Add New', 'Testimonial'),
		'add_new_item' => __('Add New Testimonial'),
		'edit_item' => __('Edit Testimonial'),
		'new_item' => __('New Testimonial'),
		'all_items' => __('All Testimonials'),
		'view_item' => __('View Testimonial'),
		'search_items' => __('Search Testimonials'),
		'not_found' => __('No testimonials found'),
		'not_found_in_trash' => __('No testimonials found in the Trash'),
		'parent_item_colon' => '',
		'menu_name' => 'Testimonials'
	);
	$args = array(
		'labels' => $labels,
		'description' => 'Holds our testimonials and testimonial specific data',
		'taxonomies' => array(''),
		'public' => true,
		'menu_position' => 5,
		'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'thumbnail'),
		'has_archive' => true,
		'menu_icon' => 'dashicons-thumbs-up',
	);
	register_post_type('testimonials', $args);
}
add_action('init', 'my_custom_post_testimonials');

add_filter( 'template_include', 'wpse119820_use_different_template_testimonials' );
function wpse119820_use_different_template_testimonials( $template ){

   if( is_post_type_archive( 'testimonials' ) ){

       if( $_template = locate_template( 'cpts/testimonials/archive-testimonials.php' ) ){
            //Template found, - use that
            $template = $_template;
       }
   }
   if( is_singular( 'testimonials' ) ) {

		if( $_template = locate_template( 'cpts/testimonials/single-testimonials.php' ) ){
			//Template found, - use that
			$template = $_template;
		}
	}      
	if( is_tax('testimonials_taxonomy')) {
		if( $_template = locate_template( 'cpts/testimonials/archive-testimonials.php' ) ){
			//Template found, - use that
			$template = $_template;
		}
	}         

    return $template;
}

/**
 * Add testimonials sidebar.
 */
function register_testimonials_sidebar() {
    register_sidebar( array(
        'name'          => __( 'Testimonials Sidebar', 'textdomain' ),
        'id'            => 'sidebar-testimonials',
        'description'   => __( 'Widgets in this area will be shown on testimonials.', 'textdomain' ),
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget'  => '</li>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>',
    ) );
}
add_action( 'widgets_init', 'register_testimonials_sidebar' );



/**
 * Add Testimonial VC BLOCK
 */

add_action('vc_before_init', 'your_name_testimonialblock');
function your_name_testimonialblock()
{
	vc_map(

		array(
			"name" => __("Testimonial Block", "my-text-domain"),
			"base" => "bartagtestimonialblock",
			"class" => "",
			"category" => __("Content", "my-text-domain"),

			"params" => array(
				array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __("Category Slug", "my-text-domain"),
					"param_name" => "testcat",
					"value" => __("", "my-text-domain"),
					"description" => __("Put the block title in here.", "my-text-domain")
				),
				array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __("Number of Testimonials to Show", "my-text-domain"),
					"param_name" => "testno",
					"value" => __("", "my-text-domain"),
					"description" => __("Put the link in here. Remember to not include the root e.g. /example/.", "my-text-domain")
				)

			)
		)
	);
}

add_shortcode('bartagtestimonialblock', 'bartag_testimonialblock');
function bartag_testimonialblock($atts, $content = null, $servicetitle)
{ 
	// New function parameter $content is added!
	extract(shortcode_atts(array(
		'testcat' => 'testcat',
		'testno' => 'testno'
	), $atts));

	$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

    ob_start();
    
    ?>
    

	<h2><?php $testcat ?></h2>
	<h2><?php $testno ?></h2>

	<?php
						$args = array(
							'post_type'   => 'testimonials',
							'post_status' => 'publish',
							'posts_per_page' => 1,	
							'tax_query'   => array(
						array(
							'taxonomy' => 'testimonial-categories',
							'field'    => 'slug',
							'terms'    => 'test-2'
													
						)));	
						$testimonials = new WP_Query( $args  );
						if( $testimonials->have_posts() ) :
					?>
					<?php
						while( $testimonials->have_posts() ) :
						$testimonials->the_post();
					?>


					<div class="testimonial-single">
						<div class="row">
							<div class="col-3 testimonial-left">
								<div class="testimonial-image-background" style="background-image: url('<?php the_field("testimonial_image"); ?>')">
									<div class="testimonial-image-inner">
									</div>
								</div>
							</div>
							<div class="col-9 testimonial-right">
								<h2 class="testimonial-title"><?php the_field("title"); ?></h2>
									
								<div class="testimonial-content">
									<span class="speach-mark middle"><?php the_field("testimonial"); ?></span>
								</div>

								<div class="testimonial-attribution">
									<p  class="attribution">
										<span class="attribution-name">
											<?php the_field("name"); ?>,
										</span>
										<span class="attribution-job-title">
											<?php the_field("job_title"); ?>
										</span>
									</p>
								</div>
							</div>
						</div>
					</div>

					<?php
						endwhile;
						wp_reset_postdata();
					?>
					<?php
						else :
							esc_html_e( 'No posts found in the custom taxonomy!', 'text-domain' );
						endif;
					?>


    <?php
    return ob_get_clean();






}
