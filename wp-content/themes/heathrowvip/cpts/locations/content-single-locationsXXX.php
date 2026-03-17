</div>
</div>

<?php
	$terms = get_the_terms( $post->ID , 'countries','', ', ', '' );
	$term_slugs = [];
	foreach ( $terms as $term ) {
		$term_slugs[] = $term->name;
	}
?>


<div class="airport-header" style="background: url('/wp-content/uploads/2022/11/1.jpg')">
	<div class="airport-header-text">
		<h1>VIP SERVICES FOR</h1>
		<h2>
			<?php the_title(); ?> <?php $terms = get_the_terms( get_the_ID(), 'countries'); ?>
			<?php if(!is_wp_error($terms) && $terms) : ?>			
				<?php foreach($terms as $term) : ?>		
					<img src="/wp-content/themes/heathrowvip/cpts/locations/flags/<?php echo $term->slug; ?>.png" class="country-flag">
				<?php endforeach; ?>
			<?php endif; ?>
		</h2>
		
			<?php if (get_field('book_now_link')) { ?>
				<a href="<?php the_field('book_now_link'); ?>" class="button">BOOK NOW</a>
			<?php } else { ?>
				<a href="/booking-forms" class="button">BOOK NOW</a>
			<?php } ?>
		
	</div>
</div>


<div class="airport-col-full">
	<div class="col-full">
		<div class="row">	
			<div class="col-6">
				<h2 class="section-title">About <span class="coloured">VIP Assist</span></h2>
				<br>
				<h5 class="grey-text">Welcome to VIP Assist, experts in delivering world class concierge services.</h5>
				<br>
				<h5 class="grey-text">VIP Assist's airport service is committed to providing you with a comprehensive concierge, beginning with your arrival at the airport where your journey begins and ending with our Meet &amp; Greet service once you reach at your destination.</h5> 
				<br>
			</div>
			<div class="col-6">
				<p class="greytext">Our services at <?php the_title(); ?> cover the full range of travel options. Whether you are leaving your home in <?php echo implode( ", ", $term_slugs); ?>, waiting at <?php the_title(); ?> for a connecting flight or arriving in Albania for business or pleasure, we can provide a service that is tailored for you.</p>
				<br>
				<p class="greytext">Our team will take care of everything at <?php the_title(); ?>, whilst you relax. Our Airport Agents are certified handling company operators and have access to all airport areas including airside, guaranteeing top efficiency in all airport procedures. We'll speed you through immigration, customs and baggage handling and Fast Track you to the comfort of your airline lounge by electric buggy.</p>
				<br>
				<p class="greytext">We can also provide limousines, helicopters and private jets to connect you to and from <?php the_title(); ?> for a door to door experience.</p>
			</div>
		</div>
	</div>
</div>



<div class="parralax-background" style="background: url('/wp-content/uploads/2022/11/3.jpg')">
	<div class="col-full">
		<div class="row">	
			<div class="col-7">
				<h2>DEPARTURE SERVICE</h2> 
				<p>VIP Assist's departure packages are designed to get you from your home or hotel in <?php echo implode( ", ", $term_slugs); ?>, through the airport and to the aircraft with as little stress and discomfort as possible.</p>
				<br>
				<p>We can provide luxury cars to collect you and our airport agents will meet you upon arrival at <?php the_title(); ?>. Their job is then to get you through check-in and security and to the comfort of your lounge in a manner that befits a VIP. You will be fast-tracked to avoid unnecessary queues, your luggage will be taken care of and you can even be provided with an electric ride on buggy to get you to what might be a distant boarding gate.</p>
				<br>
			</div>
			<div class="col-1">
			</div>
			<div class="col-4">
				<div class="price-list--one">               
					<h5 class="price-list--one-name">HOW CAN WE HELP?</h5>
					<div class="price-list--one-expanding-hover-line"></div>
					<div class="price-list--one-description">
						<ul class="list-unstyled pricing-card-list">
							<li><i class="ti-check"></i>Meet & Greet curbside</li>
							<li><i class="ti-check"></i>Porter Service</li>
							<li><i class="ti-check"></i>Check-in Fast-Track</li>
							<li><i class="ti-check"></i>Immigration and Security</li>
							<li><i class="ti-check"></i>Access To Lounge</li>
							<li><i class="ti-check"></i>Escort To Boarding Gate</li>
						</ul>
					</div>
					<div class="price-list--one-numb">Departures</div>
				</div>
			</div>
		</div>
	</div>
</div>



<div class="parralax-background" style="background: url('/wp-content/uploads/2022/11/4.jpg')">
	<div class="col-full">
		<div class="row">	
			<div class="col-7">
				<h2>CONNECTION SERVICE</h2> 
				<p>VIP Assist's transit packages are designed to connect you from one flight to the next should you choose to use <?php the_title(); ?> for a layover.</p>
				<br>
				<p>Our certified Airport Agents will meet you at the aircraft or airbridge and then get you clear of your inbound flight. Whilst you wait in your designated lounge, we'll prepare everything ready for you to step onto your next flight on the outbound journey. Our Fast Track service is particularly popular with transit clients as an expeditious and hassle free way to get between flights.</p>
				<br>
			</div>
			<div class="col-1">
			</div>
			<div class="col-4">
				<div class="price-list--one">               
					<h5 class="price-list--one-name">HOW CAN WE HELP?</h5>
					<div class="price-list--one-expanding-hover-line"></div>
					<div class="price-list--one-description">
						<ul class="list-unstyled pricing-card-list">
							<li><i class="ti-check"></i>Personalised 1-2-1 Service</li>
							<li><i class="ti-check"></i>Meet & Greet At The Gate</li>
							<li><i class="ti-check"></i>Immigration Fast-Track</li>
							<li><i class="ti-check"></i>Baggage Collection</li>
							<li><i class="ti-check"></i>Porter Service</li>
							<li><i class="ti-check"></i>Access To Lounge</li>
							<li><i class="ti-check"></i>Escort To Boarding Gate</li>
						</ul>
					</div>
					<div class="price-list--one-numb">Connections</div>
				</div>
			</div>
		</div>
	</div>
</div>



<div class="parralax-background" style="background: url('/wp-content/uploads/2022/11/5.jpg')">
	<div class="col-full">
		<div class="row">	
			<div class="col-7">
				<h2>ARRIVAL SERVICE</h2> 
				<p>VIP Assist's arrival packages welcome you into <?php echo implode( ", ", $term_slugs); ?> and make getting from the aircraft to your awaiting vehicle quick and simple.</p>
				<br>
				<p>Our friendly agents will meet you at the aircraft or airbridge, take care of your baggage and Fast Track you through customs and immigration. You can take advantage of a private lounge whilst our staff take care of your paperwork. Once everything is in order, we'll escort your to your awaiting car, limousine or even helicopter.</p>
				<br>
			</div>
			<div class="col-1">
			</div>
			<div class="col-4">
				<div class="price-list--one">               
					<h5 class="price-list--one-name">HOW CAN WE HELP?</h5>
					<div class="price-list--one-expanding-hover-line"></div>
					<div class="price-list--one-description">
						<ul class="list-unstyled pricing-card-list">
							<li><i class="ti-check"></i>Personalised 1-2-1 Service</li>
							<li><i class="ti-check"></i>Meet & Greet At The Gate</li>
							<li><i class="ti-check"></i>Immigration Fast-Track</li>
							<li><i class="ti-check"></i>Baggage Collection</li>
							<li><i class="ti-check"></i>Porter Service</li>
							<li><i class="ti-check"></i>Escort To Your Vehicle</li>
						</ul>
					</div>
					<div class="price-list--one-numb">Arrivals</div>
				</div>
			</div>
		</div>
	</div>
</div>





</div>
</div>



