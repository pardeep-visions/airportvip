</div>
</div>
<?php $item_id = get_the_ID(); ?>
<div class="booking-block" style="background-image: url('<?php if ( has_post_thumbnail() ) { echo get_the_post_thumbnail_url( $item_id, 'hd' ); } else { the_field('fallback_image', 'option'); } ?>')">
	<div class="booking-block-inner" >
		<div class="booking-block-inputs" >
			<h4>WELCOME TO AVS</h4>
			<h1>VIP Meet & Greet Services</h1>
			<p>For the ultimate airport experience – wherever your destination, our exclusive luxury concierge services deliver a seamless journey.</p>
		</div>
	</div>
</div>

<div class="locations-single-inner" >

	<!--<div class="row backarrow" >
		<div class="col-12">
			<a href="/locations/"> <i class="fas fa-arrow-circle-left"></i>  Back to all advanced locations</a>
		</div>
	</div>-->

	<div class="backarrow" >
		<a href="/locations"> <i class="fas fa-arrow-circle-left"></i>  Back to All Airports</a>
	</div>

	<div class="row">
		<div class="col-12 location-intro">
			<h1 class="location-title"><?php the_title(); ?></h1>
			<h2><?php the_field("airport_designation"); ?></h2>
			<h3 class="link-card-two-p">
				<?php
					$customtaxonomy = get_the_terms( $post->ID , 'countries','', ', ', '' ); /* Get list of categories */
					$customtaxonomyobject = $customtaxonomy[0]; /* Get first item from the list */
					$customcatergoryid = $customtaxonomy[0]->term_id; /* Extract the ID of that category */
					$customcatergoryimage_id = get_field('category_icon', 'category_'.$customcatergoryid); /* Get the ID of that categories acf image */
					$customcatergoryimage_url = wp_get_attachment_image_url ($customcatergoryimage_id, 'thumbnail'); /* Get the URL of that Image by size */
					?>



				<?php
					$terms = get_the_terms( $post->ID , 'countries','', ', ', '' );
					$term_slugs = [];
					foreach ( $terms as $term ) {
						$term_slugs[] = $term->name;
					}
				?>
				<?php if(!is_wp_error($terms) && $terms) : ?>			
					<?php foreach($terms as $term) : ?>		
						<img src="/wp-content/themes/heathrowvip/cpts/locations/flags/<?php echo $term->slug; ?>.png" class="flag">
					<?php endforeach; ?>
				<?php endif; ?>


				<?php
					$terms = get_the_terms( $post->ID , 'countries','', ', ', '' );
					$term_slugs = [];
					foreach ( $terms as $term ) {
						$term_slugs[] = $term->name;
					}
					echo implode( ", ", $term_slugs);
				?>
			</h3>
		</div>
	</div>

	<div class="locations-single--contact">

		<div class="display-block-heathrow-booking-form">

			<ul class="nav nav-tabs" role="tablist">
				<li class="nav-item">
					<a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">Departure</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab">Transit</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab">Arrival</a>
				</li>
			</ul><!-- Tab panes -->

			<div class="tab-content">
				<div class="tab-pane active" id="tabs-1" role="tabpanel tab-panel-7-11">
					<h2>Departure</h2>
					<?php echo do_shortcode('[contact-form-7 id="6f7a2b1" title="International Airport Meet & Greet Outbound"]'); ?>
				</div>

				<div class="tab-pane" id="tabs-2" role="tabpanel ">
					<h2>Transit</h2>
					<?php echo do_shortcode('[contact-form-7 id="dcad418" title="International Airport Meet & Greet Both Ways"]'); ?>
				</div>	
				<div class="tab-pane" id="tabs-3" role="tabpanel ">
					<h2>Arrival</h2>
					<?php echo do_shortcode('[contact-form-7 id="d88426a" title="International Airport Meet & Greet Inbound"]'); ?>
				</div>	
			</div>	
		</div>

	</div>

	<div class="locations-single-content">

		<?php the_content(); ?>

	
	</div>
</div>


<div class="display-block-sixteen" style="background: url(/wp-content/uploads/2022/04/photodune-FUdX9r3V-city-of-monaco-xl.jpg)">
	<img class="display-block-sixteen-mobile-image" src="/wp-content/uploads/2022/04/photodune-FUdX9r3V-city-of-monaco-xl.jpg">
	<div class="display-block-sixteen-inner col-full">
		<div class="display-block-sixteen-text">
			<h4>CONNOISSEURS</h4>
			<h2>About us</h2>
			<p>Airport VIP Services are connoisseurs of what it takes to deliver a first-class airport experience. Established in 2010, we’re one of the most experienced in the field and lead the way in exclusive VIP concierge departure, arrival and transit services.</p>
		</div>           
	</div>
</div>

<div class="col-full">
	<div class="airport-text">
		<h4>AVS SERVICES</h4>
		<h2 class="location-title"><?php the_title(); ?></h2>
		<p>Our services at <?php the_title(); ?> cover the full range of travel options. Whether you are leaving your home, waiting at <?php the_title(); ?> for a connecting flight or arriving in <?php echo implode( ", ", $term_slugs); ?>, for business or pleasure, we can provide a service that is tailored for you.</p>
		<p>Our team will take care of everything at <?php the_title(); ?> whilst you relax. Our <?php the_title(); ?> Agents are a certified handling company operators provide top efficiency in all airport produres, have access to all airport areas including airside. Our operators will speed you through immigration, customs and baggage handling. Fast Tracking you through <?php the_title(); ?> to the comfort of your airline lounge by electric buggy.</p>
		<p>We can also provide limousines, helicopters and private jets to connect you to and from  <?php the_title(); ?> for a door to door experience.</p>
	</div>
</div>

<div class="booking-block" style="background-image: url('<?php if ( has_post_thumbnail() ) { echo get_the_post_thumbnail_url( $item_id, 'hd' ); } else { the_field('fallback_image', 'option'); } ?>')">
	<div class="booking-block-inner" >
		<div class="booking-block-inputs" >
			<h4>WELCOME TO AVS</h4>
			<h2>VIP Meet & Greet Services</h2>
			<p>For the ultimate airport experience – wherever your destination, our exclusive luxury concierge services deliver a seamless journey.</p>
		</div>
	</div>
</div>

<div class="display-block-sixteen" style="background: url(/wp-content/uploads/2022/04/photodune-FUdX9r3V-city-of-monaco-xl.jpg)">
	<img class="display-block-sixteen-mobile-image" src="/wp-content/uploads/2022/04/photodune-FUdX9r3V-city-of-monaco-xl.jpg">
	<div class="display-block-sixteen-inner col-full">
		<div class="display-block-sixteen-text">
			<h4>WE MAKE FLYING A BREEZE.</h4>
			<h2>No queues, no formalities.</h2>
			<p>So you can enjoy an elevated experience every time you fly. Many of our valued customers keep returning because we’ve built trusting relationships over the years. We’re here to make your journey easy for you, and because our service is discreet, you can relax with total peace of mind.</p>
		</div>           
	</div>
</div>

<div class="booking-block" style="background-image: url('<?php if ( has_post_thumbnail() ) { echo get_the_post_thumbnail_url( $item_id, 'hd' ); } else { the_field('fallback_image', 'option'); } ?>')">
	<div class="booking-block-inner" >
		<div class="booking-block-inputs" >
			<h4>AVS SERVICES</h4>
			<h2>DEPARTURE SERVICE</h2>
			<p>Airport VIP Services departure packages are designed to <?php the_title(); ?> and to your aircraft with as quickly and comfortably as possible.</p>
			<p>We can provide luxury cars to collect you and our agents will meet you upon arrival at <?php the_title(); ?>. They will get you through check-in and security and to the comfort of your lounge in as quick and comfortable a manner as possible. They will fast-tracked you past any queues, collect your luggage and will provide you with an electric ride on buggy to get you to your gate.</p>
		</div>
	</div>
</div>

<div class="display-block-sixteen" style="background: url(/wp-content/uploads/2022/04/photodune-FUdX9r3V-city-of-monaco-xl.jpg)">
	<img class="display-block-sixteen-mobile-image" src="/wp-content/uploads/2022/04/photodune-FUdX9r3V-city-of-monaco-xl.jpg">
	<div class="display-block-sixteen-inner col-full">
		<div class="display-block-sixteen-text">
			<h4>AVS SERVICES</h4>
			<h2>CONNECTION SERVICE</h2>
			<p>Airport VIP Services transit packages are designed to connect you from one flight to the next should you choose to use <?php the_title(); ?> for a layover.</p>
			<p>Our Agents will meet you at the aircraft and then get you clear of your inbound flight. Whilst you wait in your comfortable lounge, we will prepare everything ready for you to step onto your outbound journey. Our Fast Track service is particularly popular with transit clients as an fast and comfortaable way to get between flights.</p>
		</div>           
	</div>
</div>


<div class="booking-block" style="background-image: url('<?php if ( has_post_thumbnail() ) { echo get_the_post_thumbnail_url( $item_id, 'hd' ); } else { the_field('fallback_image', 'option'); } ?>')">
	<div class="booking-block-inner" >
		<div class="booking-block-inputs" >
			<h4>AVS SERVICES</h4>
			<h2>ARRIVAL SERVICE</h2>
			<p>Airport VIP Services arrival packages welcome you into <?php echo implode( ", ", $term_slugs); ?> and make getting from the aircraft to your awaiting vehicle fast and comofortable.</p>
			<p>Our friendly agents will meet you at the aircraft, take care of your baggage, Fast Track you through customs and immigration and take care of any of your needs. You can take advantage of a luxury private lounge whilst our staff take care of the paperwork. Once everything is in order, we will escort your to your car, limousine or even helicopter.</p>
		</div>
	</div>
</div>


</div>
</div>



