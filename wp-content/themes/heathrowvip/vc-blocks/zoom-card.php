<?php
add_action('vc_before_init', 'zoomcard_integrateWithVC');
function zoomcard_integrateWithVC()
{
	vc_map(
		array(
			"name" => __("Zoom Card", "my-text-domain"),
			"base" => "zoomcard",
			"class" => "",
			"category" => __("Content", "my-text-domain"),
			"params" => array(
				array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __("Title", "my-text-domain"),
					"param_name" => "servicetitle",
					"value" => __("", "my-text-domain"),
					"description" => __("Put the block title in here.", "my-text-domain")
				),
				array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __("Link", "my-text-domain"),
					"param_name" => "servicelink",
					"value" => __("", "my-text-domain"),
					"description" => __("Put the link in here. Remember to not include the root e.g. /example/.", "my-text-domain")
				),
				array(
					"type" => "textarea",
					"holder" => "div",
					"class" => "",
					"heading" => __("Description", "my-text-domain"),
					"param_name" => "servicedesc",
					"value" => __("", "my-text-domain"),
					"description" => __("Write Description here. Try and keep lengths similar.", "my-text-domain")
				),
				array(
					"type" => "attach_image",
					"heading" => __("Image", "my-text-domain"),
					"param_name" => "serviceimage",
					"value" => "",
					"description" => __("Choose block image.", "my-text-domain")

				)
			)
		)
	);
}

add_shortcode('zoomcard', 'zoomcard_func');
function zoomcard_func($atts, $content = null, $servicetitle) { 
	extract(shortcode_atts(array(
		'serviceimage' => '',
		'servicetitle' => '',
		'servicelink' => '#',
		'servicedesc' => ''
	), $atts));

	$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

	$imageSrc = wp_get_attachment_image_src($serviceimage, 'medium');

	ob_start(); ?>

	<div class="zoom-card">
		<a href="<?php echo $servicelink; ?>">
			<div class="zoom-block-background-outer">
				<div class="zoom-block-background" style="background: url('<?php echo $imageSrc[0]; ?>');"></div>
			</div>
			<div class="zoom-block-text">
				<?php if ($servicetitle) { ?>
					<h2 class="zoom-title"><?php echo $servicetitle; ?></h2>
				<?php } ?>
				<?php if ($servicedesc) { ?>
					<p class="zoom-desc"><?php echo $servicedesc; ?></p>
				<?php } ?>
			</div>
		</a>
	</div>
	
	<?php return ob_get_clean();
}
