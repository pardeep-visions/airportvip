<!-- Start loop -->
<?php
/**
 * The loop template file.
 *
 * Included on pages like index.php, archive.php and search.php to display a loop of posts
 * Learn more: https://codex.wordpress.org/The_Loop
 *
 * @package storefront
 */
?>

<?php

//Outside loop, add global stuff

echo '<div class="post-feed">';
 
do_action( 'storefront_loop_before' );

while ( have_posts() ) : the_post();

	/**
	 * Include the Post-Format-specific template for the content.
	 * If you want to override this in a child theme, then include a file
	 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
	 */

	//Inside loop, this function will try to get content-{post_type}.php - if not found it will fallback to content.php
	get_template_part( 'content',  'search-results' );

endwhile;

	echo '</div>'; 

/**
 * Functions hooked in to storefront_paging_nav action
 *
 * @hooked storefront_paging_nav - 10
 */
do_action( 'storefront_loop_after' );
?>
<!-- END loop -->
