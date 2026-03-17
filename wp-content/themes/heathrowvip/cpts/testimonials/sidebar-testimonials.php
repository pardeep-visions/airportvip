<!-- Start sidebar -->
<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package storefront
 */

if ( ! is_active_sidebar( 'sidebar-testimonials' ) ) {
	return;
}
?>

<div id="secondary" class="widget-area" role="complementary">
	<div class="sidebar-internal-wrap">
		<ul style="list-style: none;">
			<?php dynamic_sidebar( 'sidebar-testimonials' ); ?>
		</ul>
	</div>
</div><!-- #secondary -->
<!-- END Sidebar -->
