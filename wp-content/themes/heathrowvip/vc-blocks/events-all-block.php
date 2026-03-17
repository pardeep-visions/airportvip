<?php
add_action('vc_before_init', 'your_name_eventsallblock');
function your_name_eventsallblock() {
	vc_map(
		array(
			"name" => __("Events All Cards", "my-text-domain"),
			"base" => "eventsallblock",
			"class" => "",
			"category" => __("Content", "my-text-domain"),
			"params" => array(
			)
		)
	);
}

add_shortcode('eventsallblock', 'eventsallblock_func');
function eventsallblock_func($atts, $content = null, $servicetitle) { 
    ob_start(); ?>

<?php
$args = array(
    'post_type' => 'product',
    'post_status' => 'publish',
    'posts_per_page' => 999,
    'orderby' => 'meta_value_num',
    'order' => 'ASC',
    'meta_key' => 'WooCommerceEventsDateTimestamp', //Orderby event date
    'meta_query' => array(
        'relation' => 'AND',
        array(
            'key' => 'WooCommerceEventsEvent', //This is the metakey that says it's an event. Weirdly not a boolean.
            'value' => 'Event',
            'compare' => '=',
        ),
        array(
            'key' => 'WooCommerceEventsDateTimestamp', 
            'value' => time(),
            'compare' => '>',
        )
    ),
);

$wp_query_events = new WP_Query($args);

if ($wp_query_events->have_posts()) : ?>

    <div class="events-feed events-feed--all-block">

        <?php while ($wp_query_events->have_posts()) : ?>

            <?php $wp_query_events->the_post(); ?>

            <?php
            $event_timestamp = get_post_meta(get_the_ID(), 'WooCommerceEventsDateTimestamp', true);
            $event_datetime = new DateTime();
            $event_datetime->setTimestamp($event_timestamp);
            ?>

            <a href="<?php the_permalink(); ?>" class="funky-card-four-box" >
                <div class="funky-card-four" style="background-image: url(<?php if ( has_post_thumbnail() ) { the_post_thumbnail_url('medium'); } else { the_field('fallback_image', 'option'); } ?>)!important; border-color:<?php echo $funkycolour; ?>;">
                    <div class="funky-card-four-inner">
                        <div class="funky-card-four-text-div">
                            <span class="funky-card-four-text"><span><span class="event-colour">+</span> <?php the_title(); ?></span></span>
                        </div>
                        
                        <div class="funky-card-four-date-div">
                            <?php //See here for formatting: https://www.php.net/manual/en/datetime.formats.date.php ?>
                            <span class="funky-card-four-date"><span><span class="event-colour"><?php echo $event_datetime->format('d M'); ?></span></span></span>
                        </div>

                    </div>
                </div>
            </a>

        <?php endwhile;  ?>

    </div>

<?php endif;
wp_reset_postdata();
?>







    <?php return ob_get_clean();
}
