<!-- Start template full width -->
<?php
/**
 * The template for displaying full width pages.
 *
 * Template Name: Side Column
 *
 * @package storefront
 */

get_header(); ?>

</div>



<div class="side-template-grid">
	<div class="left-side-template">	
		<div class="header-slider">
			<div class="header-slider-inner">
				<?php $images = get_field('gallery'); if( $images ): ?>
					<div id="slider" class="flexslider">
						<ul class="slides">
							<?php if (is_array($images) || is_object($images)) { foreach($images as $image): ?>
								<li style="min-height:500px;background-image: url(<?php echo $image['sizes']['large']; ?>);" data-thumb="<?php echo $image['sizes']['thumbnail']; ?>">
									<div class="header-text">
										<div class="header-text-background">
											<div class="header-text-max-width">
												<div class="header-text-inner">
													<?php the_field('gallery-text'); ?>
												</div>
											</div>
										</div>
									</div>
								</li>
								<?php endforeach; } ?>
							</ul>
						</div>
					<?php endif; ?>
				</div>
			</div>	
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

			</div>
		</div>
		<div class="right-side-template">
			<div class="on-its-side">
				This Is One Its Side
			</div>
		</div>
	</div>

<?php
get_footer();
?>
<!-- END template full width -->
