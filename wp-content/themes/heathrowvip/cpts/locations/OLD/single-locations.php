<!-- Start single -->
<?php
/**
 * The template for displaying all single posts.
 *
 * @package storefront
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post();

			do_action( 'storefront_single_post_before' );


			get_template_part( 'cpts/locations/content-single-locations' );  //for content-single-locations.php
			// get_template_part( 'content-locations', 'single-locations' ); //CONTENT WAS HERE

			do_action( 'storefront_single_post_after' );

		endwhile; // End of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_template_part( 'cpts/locations/sidebar-locations' );
get_footer();
?>
<!-- END single -->
