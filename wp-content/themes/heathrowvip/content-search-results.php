<!-- Start content-search-results -->
<?php
/**
 * Template used to display search results
 *
 */
?>

<a href="<?php the_permalink(); ?>">
	<h2><?php the_title(); ?></h2>
</a>

<?php the_post_thumbnail('medium'); ?>
