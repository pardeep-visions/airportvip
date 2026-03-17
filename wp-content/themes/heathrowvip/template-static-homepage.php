<!-- Start template homepage -->
<?php
/**
 * The template for displaying the homepage.
 *
 * This page template will display any functions hooked into the `homepage` action.
 * By default this includes a variety of product displays and the page content itself. To change the order or toggle these components
 * use the Homepage Control plugin.
 * https://wordpress.org/plugins/homepage-control/
 *
 * Template name: Static Homepage
 *
 * @package storefront
 */

get_header(); ?>

</div>

<div class="static-homepage-hero" style="background-image: url(<?php if (has_post_thumbnail()) {
		the_post_thumbnail_url('hd');
	} else {
		the_field('fallback_image', 'option');
	} ?>);" data-thumb="<?php echo $image['sizes']['hd']; ?>); width: 100%;">
	<div class="header-text">
		<div class="header-text-background">
			<div class="header-text-max-width">
				<div class="header-text-inner">
					<?php the_field('header_text_area'); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="col-full">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<div class="row">
                <div class="col-12">
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
				</div>
			</div>

			<?php
			/**
			 * Functions hooked in to homepage action
			 *
			 * @hooked storefront_homepage_content      - 10
			 * @hooked storefront_product_categories    - 20
			 * @hooked storefront_recent_products       - 30
			 * @hooked storefront_featured_products     - 40
			 * @hooked storefront_popular_products      - 50
			 * @hooked storefront_on_sale_products      - 60
			 * @hooked storefront_best_selling_products - 70
			 */
			 ?>

		</main><!-- #main -->
	</div><!-- #primary -->
<?php
get_footer();
?>
<!-- END template homepage -->
