<!--Start Archive -->
<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package storefront
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : //Start the post loop ?>

			<header class="page-header">

				<?php if ( is_tax() ) { ?>
					<h1><?php echo get_the_archive_title(); ?></h1>
				<?php } ?>

				<?php post_type_archive_title( '<h1>', '</h1>' ); ?>
				
			</header><!-- .page-header -->

			<?php 
			
			//Fetch loop.php
			get_template_part( 'loop-custom' );

		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_template_part( 'cpts/testimonials/sidebar-testimonials' );
get_footer(); ?>
<!-- END Archive -->

