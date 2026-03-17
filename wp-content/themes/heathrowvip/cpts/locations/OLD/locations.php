<?php
add_action('init', 'create_locations_taxonomy');
function create_locations_taxonomy()
{
	register_taxonomy('countries', array('locations'), array('label' => 'Countries', 'hierarchical' => true,));
}

add_action('init', 'create_continents_taxonomy');
function create_continents_taxonomy()
{
	register_taxonomy('continents', array('locations'), array('label' => 'Continents', 'hierarchical' => true,));
}

/*add_action('init', 'create_locations_role_taxonomy');
function create_locations_role_taxonomy()
{
	register_taxonomy('location-role', array('locations'), array('label' => 'location Role', 'hierarchical' => true,));
}*/



function my_custom_post_locations()
{
	$labels = array(
		'name' => _x('Locations', 'post type general name'),
		'singular_name' => _x('Location', 'post type singular name'),
		'add_new' => _x('Add New', 'Location'),
		'add_new_item' => __('Add New Location'),
		'edit_item' => __('Edit Location'),
		'new_item' => __('New Location'),
		'all_items' => __('All Locations'),
		'view_item' => __('View Location'),
		'search_items' => __('Search Locations'),
		'not_found' => __('No locations found'),
		'not_found_in_trash' => __('No locations found in the Trash'),
		'parent_item_colon' => '',
		'menu_name' => 'Locations'
	);
	$args = array(
		'labels' => $labels,
		'description' => 'Holds our locations and location specific data',
		'taxonomies' => array(''),
		'public' => true,
		'menu_position' => 5,
		'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'comments'),
		'has_archive' => true,
		'menu_icon' => 'dashicons-admin-site-alt2',
	);
	register_post_type('locations', $args);
}
add_action('init', 'my_custom_post_locations');

add_filter( 'template_include', 'wpse119820_use_different_template_locations' );
function wpse119820_use_different_template_locations( $template ){

   if( is_post_type_archive( 'locations' ) ){

       if( $_template = locate_template( 'cpts/locations/archive-locations.php' ) ){
            //Template found, - use that
            $template = $_template;
       }
   }
   if( is_singular( 'locations' ) ) {

		if( $_template = locate_template( 'cpts/locations/single-locations.php' ) ){
			//Template found, - use that
			$template = $_template;
		}
	}      
	if( is_tax('countries')) {
		if( $_template = locate_template( 'cpts/locations/archive-locations.php' ) ){
			//Template found, - use that
			$template = $_template;
		}
	}       
	if( is_tax('location-role')) {
		if( $_template = locate_template( 'cpts/locations/archive-locations.php' ) ){
			//Template found, - use that
			$template = $_template;
		}
	}         

    return $template;
}

/**
 * Add locations sidebar.
 */
function register_locations_sidebar() {
    register_sidebar( array(
        'name'          => __( 'locations Sidebar', 'textdomain' ),
        'id'            => 'sidebar-locations',
        'description'   => __( 'Widgets in this area will be shown on locations.', 'textdomain' ),
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget'  => '</li>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>',
    ) );
}
add_action( 'widgets_init', 'register_locations_sidebar' );

/**
 * Search locations
 */

add_shortcode('searchlocations', 'searchlocations_func');
function searchlocations_func($atts, $content = null, $servicetitle)
{ 
	// New function parameter $content is added!
	
	return "<form class='search' action='/'>
	<input type='search' name='s' placeholder='Search&hellip;'>
	<input type='submit' value='Search'>
	<input type='hidden' name='post_type' value='locations'>
</form>
";
}

