<?php
add_action('vc_before_init', 'your_name_fooeventsfourblock');
function your_name_fooeventsfourblock()
{
    vc_map(
        array(
            "name" => __("Foo Events 4 Cards", "my-text-domain"),
            "base" => "fooeventsfourblock",
            "class" => "",
            "category" => __("Content", "my-text-domain"),
            "params" => array()
        )
    );
}

add_shortcode('fooeventsfourblock', 'fooeventsfourblock_func');
function fooeventsfourblock_func($atts, $content = null, $servicetitle)
{
    ob_start(); ?>

    <?php
    $args = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => 4,
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

        <div class="events-feed events-feed--four-block">

            <?php while ($wp_query_events->have_posts()) : ?>

                <?php $wp_query_events->the_post(); ?>

                <?php
                $event_timestamp = get_post_meta(get_the_ID(), 'WooCommerceEventsDateTimestamp', true);
                $event_datetime = new DateTime();
                $event_datetime->setTimestamp($event_timestamp);
                ?>


                <a href="<?php the_permalink(); ?>" class="funky-card-four-box" >
                    <div class="funky-card-four" style="background-image: url(<?php if (has_post_thumbnail()) {
                                                                                    the_post_thumbnail_url('medium');
                                                                                } else {
                                                                                    the_field('fallback_image', 'option');
                                                                                } ?>)!important; border-color:<?php echo $funkycolour; ?>;">
                        <div class="funky-card-four-inner">
                            <div class="funky-card-four-text-div">
                                <span class="funky-card-four-text"><span><span style="color:<?php echo $funkycolour; ?>;">+</span> <?php the_title(); ?></span></span>
                            </div>
                            
                            <div class="funky-card-four-date-div">
                                <span class="funky-card-four-date"><span><span style="color:<?php echo $funkycolour; ?>;"><?php echo $event_datetime->format('d M'); ?></span></span></span>
                            </div>

                        </div>
                    </div>
                </a>





            <?php endwhile;  ?>

            <?php $count = $wp_query_events->found_posts; ?>
            <?php $remaining = 4 - $count; ?>
            <?php if ($remaining > 0) :
                for ($x = 1; $x <= $remaining; $x++) : ?>

                    <div class="funky-card-four-box">
                        <div class="funky-card-four" style="background-image: url('<?php  the_field('fallback_image', 'option'); ?>');">
                            
                        </div>
                        <div class="funky-card-four-inner">
                                <div class="funky-card-four-text-div">
                                    <span class="funky-card-four-text"><span><span class="event-colour">+</span> Coming soon</span></span>
                                </div>
                                <div class="funky-card-four-date-div">
                                    <span class="funky-card-four-date"><span><span class="event-colour"></span></span></span>
                                </div>

                            </div>
                    </div>
            <?php
                endfor;
            endif;
            ?>

        </div>

    <?php endif;
    wp_reset_postdata();
    ?>







<?php return ob_get_clean();
}
