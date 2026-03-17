<!-- Start content-single -->
<?php
/**
 * Template used to display post content on single pages.
 *
 * @package storefront
 */
?>

<?php 	$item_id = get_the_ID(); ?>

<!--<div class="post-image-background" style="background-image: url('<?php if ( has_post_thumbnail() ) { echo get_the_post_thumbnail_url( $page->ID, 'large' ); } else { the_field('fallback_image', 'option'); } ?>')">
	<div class="post-image-inner">
		<?php the_post_thumbnail( 'large' ) ?>
	</div>
</div>-->

<?php if ( has_post_thumbnail() ) { ?>
	<div class="post-image-background" style="background-image: url('<?php echo get_the_post_thumbnail_url( $item_id, 'large' ); ?>')">
		<div class="post-image-inner">
			<!--<?php the_post_thumbnail( 'large' ) ?>-->
		</div>
	</div>
<?php } ?>


<div class="single-feed-item-text">
	<h1 class="item-title">
		<?php the_title(); ?>
	</h1>

	<div class="meta-info">
		<div class="date-in-feed">
			<?php $post_date = get_the_date( 'j M Y' ); echo $post_date;?>
		</div>
		
	</div>

	

	<?php the_content(''); ?>

	<?php
	do_action( 'storefront_single_post_top' );

	/**
	 * Functions hooked into storefront_single_post add_action
	 *
	 * @hooked storefront_post_header          - 10
	 * @hooked storefront_post_meta            - 20
	 * @hooked storefront_post_content         - 30
	 */
	//do_action( 'storefront_single_post' );

	/**
	 * Functions hooked in to storefront_single_post_bottom action
	 *
	 * @hooked storefront_post_nav         - 10
	 * @hooked storefront_display_comments - 20
	 */
	do_action( 'storefront_single_post_bottom' );
	?>


	<div class="other-blog-posts-row">
		<h1 class="other-blog-posts-title">Other Posts</h1>
			<div class="other-blog-posts-feed">
			

			<?php
			$category_slug = get_field('post_category_slug');
			$args = array(
				'post_type'   => 'post',
				'post_status' => 'publish',
				'posts_per_page' => 3, 
				'post__not_in' => array( $post->ID )
			);

			$otherposts = new WP_Query($args);

			if ($otherposts->have_posts()) : ?>
				<?php while ($otherposts->have_posts()) :

					$otherposts->the_post(); ?>

			<?php 	$item_id = get_the_ID(); ?>
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
						<h1 class="item-title">
							<?php the_title(); ?>
						</h1>
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

			<?php endwhile;
				wp_reset_postdata(); ?>
			<?php else :
				esc_html_e('No posts found in the custom taxonomy!', 'text-domain');
			endif; ?>

		</div>
	</div>

	<div id="share-buttons">

		<h4>Share this post</h4>
		
		<!-- Email -->
		<a class="email-share share-button" href="mailto:?Subject=<?php the_title(); ?>&amp;Body=I%20saw%20this%20and%20thought%20of%20you!%20 <?php echo get_permalink( $post->ID ); ?>">
			<i class="far fa-envelope"></i>
		</a>
	
		<!-- Facebook -->
		<a class="facebook-share share-button" href="http://www.facebook.com/sharer.php?u=<?php echo get_permalink( $post->ID ); ?>" target="_blank">
			<i class="fab fa-facebook-f"></i>
		</a>
	
		<!-- LinkedIn -->
		<a class="linkedin-share share-button" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo get_permalink( $post->ID ); ?>" target="_blank">
			<i class="fab fa-linkedin-in"></i>
		</a>
	
		<!-- Print -->
		<!--<a class="print-share share-button" href="javascript:;" onclick="window.print()">
			<i class="fas fa-print"></i>
		</a>-->
		
		<!-- Twitter -->
		<a class="twitter-share share-button" href="https://twitter.com/share?url=<?php echo get_permalink( $post->ID ); ?>&amp;<?php the_title(); ?>" target="_blank">
			<i class="fab fa-twitter"></i>
		</a>
		
		<!-- Pinterest -->
		<!--<a class="pinterest-share share-button" href="http://pinterest.com/pin/create/bookmarklet/?url=<?php echo get_permalink( $post->ID ); ?>&is_video=false&description=<?php the_title(); ?> by <?php the_field("speaker"); ?>&media=<?php the_field("email_featured_image"); ?>">
			<i class="fab fa-pinterest"></i>
		</a>-->

		<!-- Whatsapp -->
		<a class="whatsapp-share share-button" href="whatsapp://send?text=<?php echo get_permalink( $post->ID ); ?> &amp; <?php the_title(); ?>" data-action="share/whatsapp/share">
			<i class="fab fa-whatsapp"></i>
		</a>

	</div>
</div>

<!-- #post-## -->
<!-- END content-single -->
