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

<header class="page-header location-archive-meta">
    <?php if (is_tax()) : ?>
        <h1><?php echo single_term_title(); ?></h1>
        <?php if (category_description()) { ?>
            <div class="category-description-container">
                <?php echo category_description(); ?>
            </div>
        <?php } ?>
    <?php else : ?>
        <h1>Airports</h1>
        <div class="category-description-container">

        </div>
    <?php endif; ?>
</header><!-- .page-header -->


<div id="primary" class="content-area">

    <main id="main" class="site-main" role="main">

        <?php if (have_posts()) : ?>

            <!--<header class="page-header <?php echo $hasImage; ?>">

				<?php
            the_archive_title('<h1 class="page-title">', '</h1>');
            the_archive_description('<div class="taxonomy-description">', '</div>');
            ?>

			</header> -->
            <?php get_template_part('cpts/locations/locations-loop'); ?>

        <?php else : ?>

            <p>No results</p>

        <?php endif; ?>

    </main><!-- #main -->

</div><!-- #primary -->

<?php
get_template_part( 'cpts/locations/sidebar-locations' );
get_footer();
?>
<!-- END Archive -->