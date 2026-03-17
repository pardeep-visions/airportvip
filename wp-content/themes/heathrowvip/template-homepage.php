<!-- Start template homepage -->
<?php
/**
 * The template for displaying the homepage.
 *
 * This page template will display any functions hooked into the `homepage` action.
 * By default this includes a variety of product displays and the page content itself. To change the order or toggle these components
 * use the Homepage Control plugin.
 * https://wordpress.org/plugins/homepage-control/
 *
 * Template name: Homepage
 *
 * @package storefront
 */

get_header(); ?>

</div>


<div class="display-block-heathrow fadebackground" style="background: url(<?php $image_id = get_field('hero_image'); echo wp_get_attachment_image_url ($image_id, 'hd'); ?>)">
	<div class="display-block-heathrow-inner">
		<div class="display-block-heathrow-booking-form">

			<ul class="nav nav-tabs" role="tablist">
				<li class="nav-item">
					<a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab"><span class="material-icons">flight_land</span> Meet & Greet</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab"> <span class="material-icons">airline_seat_recline_extra</span> VIP Lounge</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab"><span class="material-icons">directions_car</span> Chauffeur Services</a>
				</li>
			</ul><!-- Tab panes -->

			<div class="tab-content">
				<div class="tab-pane active" id="tabs-1" role="tabpanel tab-panel-7-11">
					<?php // echo do_shortcode('[vip-booking-form]'); ?>	
					<?php the_field('meet_and_greet'); ?>
				</div>

				<div class="tab-pane" id="tabs-2" role="tabpanel ">

					<?php the_field('vip_lounge'); ?>

				</div>	
				<div class="tab-pane" id="tabs-3" role="tabpanel ">
					<?php the_field('chauffer_services'); ?>
					
				</div>	
			</div>	

		</div>
		<div class="display-block-heathrow-text">
	



			<div class="header-text-slider">
				<div class="header-text-slider-inner">
					<div id="slider" class="flexslider">
						<ul class="slides">
							<?php if (have_rows('text_repeater')) : ?>


								
									<?php while (have_rows('text_repeater')) :
										the_row();
										$text = get_sub_field('text_slide');
									?>
										<li class="testimonial-slide">
											<div class="slider-text-block">
												<?php echo $text ?>
											</div>
										</li>
									<?php endwhile; ?>
								
							<?php endif; ?>
						</ul>
					</div>
				</div>
			</div>




		</div>
	</div>
</div>

</div>

<div class="col-full">

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">


			<div class="row">
                <div class="col-12">
					<?php the_content() ?>
				</div>
			</div>

			<?php
			/**
			 * Functions hooked in to homepage action
			 *
			 * @hooked storefront_homepage_content      - 10
			 * @hooked storefront_product_categories    - 20
			 * @hooked storefront_recent_products       - 30
			 * @hooked storefront_featured_products     - 40
			 * @hooked storefront_popular_products      - 50
			 * @hooked storefront_on_sale_products      - 60
			 * @hooked storefront_best_selling_products - 70
			 */
			 ?>

		</main><!-- #main -->
	</div><!-- #primary -->
<?php
get_footer();
?>
<!-- END template homepage -->
