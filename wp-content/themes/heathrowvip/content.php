<?php
/**
 * Template used to display post content.
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

	/**
	 * So much hook
	 *
	 */


	$category_id = get_cat_ID( 'Category Name' );
	$categories = get_the_category();
	$link = get_the_permalink();
	$imageurl = get_the_post_thumbnail_url();
	$curauth = get_userdata( $id );
	$userdata = get_user_meta( $id  );
	$item_id = get_the_ID();

?>


	<div class="single-feed-item">

		<a href="<?php the_permalink() ?>">
			<div class="post-image-background" style="background-image: url('<?php if ( has_post_thumbnail() ) {
				echo get_the_post_thumbnail_url( $item_id, 'large' ); 
				} else {
				the_field('fallback_image', 'option'); 
			} ?>')">
				
			</div>
		</a>

		
		



		<div class="single-feed-item-text">
			<a href="<?php the_permalink() ?>">
				<h2 class="item-title">
					<?php the_title(); ?>
				</h2>
			</a>

			<div class="meta-info">
				<div class="date-in-feed">
					<?php $post_date = get_the_date( 'j M Y' ); echo $post_date;?>
				</div>
			</div>

			<div class="excerpt-block">
				<?php the_excerpt(); ?>
				<a class="view-more" href="<?php the_permalink(); ?>">Read More</a>
			</div>
		</div>
	</div>


</article><!-- #post-## -->