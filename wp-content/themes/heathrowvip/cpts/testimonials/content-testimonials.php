<!-- Start content-single -->
<?php
/**
 * Template used to display post content on single pages.
 *
 * @package storefront
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
	/**
	 * Functions hooked in to storefront_loop_post action.
	 *
	 * @hooked storefront_post_header          - 10
	 * @hooked storefront_post_meta            - 20
	 * @hooked storefront_post_content         - 30
	 */

	//do_action( 'storefront_loop_post' );
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
		
</article>


	<?php
	/*do_action( 'storefront_single_post_top' );

	/**
	 * Functions hooked into storefront_single_post add_action
	 *
	 * @hooked storefront_post_header          - 10
	 * @hooked storefront_post_meta            - 20
	 * @hooked storefront_post_content         - 30
	 */
	/*do_action( 'storefront_single_post' );

	/**
	 * Functions hooked in to storefront_single_post_bottom action
	 *
	 * @hooked storefront_post_nav         - 10
	 * @hooked storefront_display_comments - 20
	 */

	?>



<!-- #post-## -->
<!-- END content-single -->
