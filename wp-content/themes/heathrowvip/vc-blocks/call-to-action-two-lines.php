<?php
add_action('vc_before_init', 'your_name_calltoactioninlinetwoline');
function your_name_calltoactioninlinetwoline() {
	vc_map(
		array(
			"name" => __("Call to Action - Inline, 2 Lines", "my-text-domain"),
			"base" => "calltoactioninlinetwoline",
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
					"heading" => __("Description", "my-text-domain"),
					"param_name" => "servicedesc",
					"value" => __("", "my-text-domain"),
					"description" => __("Write Description here. Try and keep lengths similar.", "my-text-domain")
				),
				array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __("Link", "my-text-domain"),
					"param_name" => "servicelink",
					"value" => __("", "my-text-domain"),
					"description" => __("Put the link in here. Remember to not include the root e.g. /example/.", "my-text-domain")
				)
			)
		)
	);
}

add_shortcode('calltoactioninlinetwoline', 'bartag_calltoactioninlinetwoline');
function bartag_calltoactioninlinetwoline($atts, $content = null, $servicetitle) { 

	extract(shortcode_atts(array(
		'servicetitle' => '',
		'servicedesc' => '',
		'servicelink' => ''
	), $atts));

	$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

	ob_start(); ?>

	<div class="call-to-action-inline call-to-action-inline-two-lines">
		<div class="align-items-center cta-desc">
			<?php if ($servicetitle) { ?>
				<h2><?php echo $servicetitle; ?></h2>
			<?php } ?>
			<?php if ($servicedesc) { ?>
				<p><?php echo $servicedesc; ?></p>
			<?php } ?>
		</div>
		<div class="align-self-center">
			<a href="<?php echo $servicelink; ?>" class="button cta-button">Act Now <i class="fa fa-angle-right" aria-hidden="true"></i></a>
		</div>
	</div>	

	<?php return ob_get_clean(); 

}
