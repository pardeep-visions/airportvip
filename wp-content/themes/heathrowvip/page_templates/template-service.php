<!-- Start template full width -->
<?php
/**
 * The template for displaying full width pages.
 *
 * Template Name: test Page
 *
 * @package storefront
 */

get_header(); ?>

</div>

<div class="regular-irregular-snippet">
	<div class="regular-irregular-snippet-left">
		<div class="regular-irregular-snippet-text-area">
			<?php the_field('header_text_area'); ?>
		</div>
	</div>
	<div class="regular-irregular-snippet-right" style="background-image: url(<?php if (has_post_thumbnail()) {
                the_post_thumbnail_url('large');
            } else {
                the_field('fallback_image', 'option');
            } ?>);">
		
	</div>
</div>



		
<div class="col-full">
	<div class="service-body">
		<div class="service-body-left">
			<?php the_content(); ?>
		</div>
		<div class="service-body-right">	
			<div class="service-body-right-inner">
				<?php echo do_shortcode('[contact-form-7 id="291" title="Pop Up Contact Form"]'); ?>
			</div>
		</div>
	</div>
</div>

<?php
get_footer();
?>
<!-- END template full width -->
