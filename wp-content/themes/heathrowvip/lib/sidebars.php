<?php

add_action('widgets_init', 'child_register_sidebar');
function child_register_sidebar()
{
	register_sidebar(array(
		'name' => 'Sidebar 2',
		'id' => 'sidebar-2',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));
}

add_action('widgets_init', 'above_header_sidebar');
function above_header_sidebar() {
	$args = array(
		'id' => 'sidebar-above-header',
		'name' => __( 'Above Header', 'text_domain' ),
		'description' => __( 'This area is above your menus.', 'text_domain' ),
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => '</section>',
	);
	register_sidebar( $args );
}

function below_footer_sidebar() {
	$args = array(
		'id' => 'sidebar-below-footer',
		'name' => __( 'Below Footer', 'text_domain' ),
		'description' => __( 'This area is below you main footer.', 'text_domain' ),
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => '</section>',
	);
	register_sidebar( $args );
}
	
add_action( 'widgets_init', 'below_footer_sidebar' );
if (function_exists('register_sidebar')) {
	register_sidebar(
		array(
			'name' => 'Below Footer',
			'id' => 'below-footer',
			'before_widget' => '<div class = "below-footer">',
			'after_widget' => '</div>',
			'before_title' => '<h3>',
			'after_title' => '</h3>',
		)
	);
}

