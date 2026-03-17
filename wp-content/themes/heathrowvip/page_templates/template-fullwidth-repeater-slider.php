<!-- Start template full width -->
<?php
/**
 * The template for displaying full width pages.
 *
 * Template Name: Full Width with Repeater Slider
 *
 * @package storefront
 */

get_header(); ?>
</div>

<?php if( have_rows('repeater_slider') ): ?>
	<div class="flexslider">
		<ul class="slides">
			<?php while( have_rows('repeater_slider') ): the_row(); $image = get_sub_field('repeater_slider_image'); $desc = get_sub_field('repeater_slider_text'); ?>
				<li style="background-image: url(<?php echo $image['sizes']['hd']; ?>); width: 100%;">
					<div class="header-text">
						<div class="header-text-background">
							<div class="header-text-max-width">
								<div class="header-text-inner">
									<?php echo $desc; ?>
								</div>
							</div>
						</div>
					</div>
				</li>
			<?php endwhile; ?>
		</ul>
	</div>
<?php endif; ?>

<div class="col-full">

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">


			<?php while ( have_posts() ) : the_post();

				do_action( 'storefront_page_before' );

				get_template_part( 'content', 'page' );

				/**
				 * Functions hooked in to storefront_page_after action
				 *
				 * @hooked storefront_display_comments - 10
				 */
				do_action( 'storefront_page_after' );

			endwhile; // End of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
?>
<!-- END template full width -->
