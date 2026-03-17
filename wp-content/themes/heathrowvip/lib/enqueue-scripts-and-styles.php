<?php
add_action('wp_enqueue_scripts', 'ss_enqueue_scripts');
function ss_enqueue_scripts()
{
	//JS
	wp_enqueue_script('flexslider', get_stylesheet_directory_uri() . '/assets/vendor/flexslider/jquery.flexslider-min.js', array('jquery'), '1.0.0', true);
	wp_enqueue_script('slickslider', get_stylesheet_directory_uri() . '/assets/vendor/slickslider/slick.min.js', array('jquery'), '1.0.0', true);
	wp_enqueue_script('slick-lightbox', get_stylesheet_directory_uri() . '/assets/vendor/slicksliderlightbox/slick-lightbox.min.js', array('jquery'), '1.0.0', true);
	wp_enqueue_script('masonry', get_stylesheet_directory_uri() . '/assets/vendor/masonry/masonry.min.js', array('jquery'), '1.0.0', true);
	wp_enqueue_script('mosaic', get_stylesheet_directory_uri() . '/assets/vendor/mosaic/mosaic.js', array('jquery'), '1.0.0', true);
	wp_enqueue_script('swiper-js', get_stylesheet_directory_uri() . '/assets/vendor/swiper/swiper-bundle.min.js', array('jquery'), '7.4.1', true);

	//Add dependencies to main js 
	wp_enqueue_script('main-js', get_stylesheet_directory_uri() . '/assets/js/main.js', array('jquery', 'flexslider', 'slickslider', 'slick-lightbox', 'masonry', 'swiper-js'), '2.0.3', true);

	//CSS
	// wp_enqueue_style('parent-style', get_stylesheet_directory_uri() . '/style.css');
	wp_enqueue_style('flexslider', get_stylesheet_directory_uri() . '/assets/vendor/flexslider/flexslider-rtl-min.css');
	wp_enqueue_style('slick', get_stylesheet_directory_uri() . '/assets/vendor/slickslider/slick.css');
	wp_enqueue_style('slick-lightbox', get_stylesheet_directory_uri() . '/assets/vendor/slicksliderlightbox/slick-lightbox.css');
	wp_enqueue_style('swiper-css', get_stylesheet_directory_uri() . '/assets/vendor/swiper/swiper-bundle.min.css');

	wp_enqueue_style('moasic', get_stylesheet_directory_uri() . '/assets/vendor/mosaic/mosaic.css');
}
