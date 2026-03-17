<!-- Start sidebar -->
<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package storefront
 */

if ( ! is_active_sidebar( 'sidebar-locations' ) ) {
	return;
}
?>

<div id="secondary" class="widget-area" role="complementary">
	<div class="sidebar-internal-wrap">
		<ul style="list-style: none; margin: 0;">
			<?php dynamic_sidebar( 'sidebar-locations' ); ?>
		</ul>
	</div>
</div><!-- #secondary -->
<!-- END Sidebar -->
