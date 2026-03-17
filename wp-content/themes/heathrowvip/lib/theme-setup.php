<?php
// ************************* SECTION BREAK - START SVG File Type Override

function cc_mime_types($mimes) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

// ************************* SECTION BREAK - END SVG File Type Override

//Allow shortcode in widgets
add_filter( 'widget_text', 'shortcode_unautop');
add_filter( 'widget_text', 'do_shortcode');

function custom_excerpt_length($length)
{
	return 20;
}
add_filter('excerpt_length', 'custom_excerpt_length', 999);



if (!function_exists('storefront_skip_links')) {
	/**
	 * Skip links
	 *
	 * @since  1.4.1
	 * @return void
	 */
	function storefront_skip_links()
	{
?>
		<div id="skip-link-wrapper" class="">
			<a class="skip-link screen-reader-text" href="#site-navigation"><?php esc_attr_e('Skip to navigation', 'storefront'); ?></a>
			<a class="skip-link screen-reader-text" href="#content"><?php esc_attr_e('Skip to content', 'storefront'); ?></a>
			<div class="cleafix"></div>
		</div>
	<?php
	}
}

function storefront_post_header()
{
	?>
	<? the_post_thumbnail(); ?>
	<header class="entry-header">
		<?php
		if (is_single()) {
			storefront_posted_on();
			the_title('<h1 class="entry-title">', '</h1>');
		} else {
			if ('post' == get_post_type()) {
				storefront_posted_on();
			}

			the_title(sprintf('<h2 class="alpha entry-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h2>');
		}
		?>
	</header><!-- .entry-header -->
	<?php
}

function storefront_post_content()
{
?>
	<div class="entry-content">
		<?php

		/**
		 * Functions hooked in to storefront_post_content_before action.
		 *
		 * @hooked storefront_post_thumbnail - 10
		 */
		do_action('storefront_post_content_before');

		the_content(
			sprintf(
				__('Continue reading %s', 'storefront'),
				'<span class="screen-reader-text">' . get_the_title() . '</span>'
			)
		);

		do_action('storefront_post_content_after');

		wp_link_pages(array(
			'before' => '<div class="page-links">' . __('Pages:', 'storefront'),
			'after'  => '</div>',
		));
		?>


	</div><!-- .entry-content -->
	<?php
}


add_filter('get_the_archive_title', 'prefix_category_title');
function prefix_category_title($title) {
	if (is_category()) {
		$title = single_cat_title('', false);
	}
	return $title;
}

if (function_exists('acf_add_options_page')) {
		acf_add_options_page([
			'page_title' 	=> 'Options',
			'menu_title' 	=> 'Options',
	]);
}

add_action( 'init', 'place_cart_header');
function place_cart_header() {
	if ( class_exists( 'WooCommerce' ) ) {
		$cart_position_top = true; 
		$cart_position_bottom = true; 

		if(!$cart_position_top){
			remove_action( 'storefront_header', 'storefront_header_cart', 60 );
		}

		if($cart_position_bottom) {
			add_action( 'storefront_header', 'storefront_header_cart', 35 );
			add_filter( 'body_class', function( $classes ) {
				return array_merge( $classes, array( 'cart-position-top' ) );
			} );
		}
	 }
}

remove_action('storefront_post_content_before', 'storefront_post_thumbnail', 10);
// remove_action( 'storefront_single_post', 'storefront_post_header', 10  );
// remove_action( 'storefront_single_post', 'storefront_post_meta', 20  );
// remove_action( 'storefront_single_post', 'storefront_post_content', 30  );


// add_action( 'storefront_single_post', 'storefront_post_header', 20  );
// add_action( 'storefront_single_post', 'storefront_post_meta', 10  );
// add_action( 'storefront_single_post', 'storefront_post_content', 30  );

// Remove WordPress Auto P around shortcodes


/**
 * Fix Shortcode auto p nonsense
 */
function wpex_fix_shortcodes($content){
	$array = array (
		'<p>[' => '[',
		']</p>' => ']',
		']<br />' => ']'
	);
	$content = strtr($content, $array);
	return $content;
}
add_filter('the_content', 'wpex_fix_shortcodes');


