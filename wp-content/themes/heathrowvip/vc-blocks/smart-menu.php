<?php
add_action('vc_before_init', 'your_name_smartmenu');
function your_name_smartmenu() {
	vc_map(
		array(
			"name" => __("Smart Menu", "my-text-domain"),
			"base" => "smartmenu",
			"class" => "",
			"category" => __("Content", "my-text-domain"),
			"params" => array(
			)
		)
	);
}

add_shortcode('smartmenu', 'smartmenu_func');
function smartmenu_func($atts, $content = null, $servicetitle) { 
    ob_start(); ?>
        <div class="smart-menu">
            <?php	wp_nav_menu(
            array(
                'menu' => 'Main menu',
                'link_before' => '<span class="middle-menu-text">',
                'link_after' => '</span>',
            )
            ); ?>
        </div>
    <?php return ob_get_clean();
}
