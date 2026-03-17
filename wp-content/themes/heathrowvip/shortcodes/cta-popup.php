<?php
add_shortcode('ctapopup', 'ctapopup_func');
function ctapopup_func($atts, $content = null, $servicetitle)
{ 
    // New function parameter $content is added!
	extract(shortcode_atts(array(
		'servicetitle' => 'servicetitle',
		'servicedesc' => 'servicedesc'
	), $atts));
	$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
	return "<a onclick='openLightbox();' class='button'>Open Lightbox</a>";
}
