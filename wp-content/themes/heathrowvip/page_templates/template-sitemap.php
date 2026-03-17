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
 * Template name: Sitemap
 *
 * @package storefront
 */

get_header(); ?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<?php the_content() ?>


			<div class="sitemap-block">
				<h1>Pages</h1>
				<?php wp_list_pages('&title_li=&link_before=<span>&link_after=</span>&depth=3'); ?>
			</div>


			<div class="sitemap-block">
				<h1>Recently Completed Work</h1>
				<?php
				// WP_Query arguments
				$args = array(
					'post_type'   => 'work',
					'post_status' => 'publish',
					'posts_per_page' => 99999, 
				);
				// The Query
				$query = new WP_Query($args);
				// The Loop
				if ($query->have_posts()) : ?>
					<div class="sitemap-block-list">
						<ul>
							<?php while ($query->have_posts()) {
								$query->the_post(); ?>	
								<li>
									<a href="<?php the_permalink(); ?>">
										<?php the_title(); ?>
									</a>
								</li>
							<?php } ?>
						</ul>  
					</div>
				<?php endif;
				wp_reset_postdata(); ?>
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
