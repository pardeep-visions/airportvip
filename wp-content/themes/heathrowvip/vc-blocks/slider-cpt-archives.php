<?php
add_action('vc_before_init', 'slider_cpt_article_integrateWithVC');
function slider_cpt_article_integrateWithVC() {
    vc_map(
        array(
            "name" => __("Article Slider", "my-text-domain"),
            "base" => "slider_cpt_article",
            "class" => "",
            "category" => __("Content", "my-text-domain"),
            "params" => array(
               
            )
        )
    );
}

add_shortcode('slider_cpt_article', 'slider_cpt_article_func');
function slider_cpt_article_func($atts, $content, $serviceimage) { 

    extract(shortcode_atts(array(
        
    ), $atts));

	$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

    ob_start(); ?>
<?php
// WP_Query arguments
$args = array(

    'post_type'   => 'articles',
    'post_status' => 'publish',
    'posts_per_page' => 8, 

);
// The Query
$query = new WP_Query($args);
// The Loop
if ($query->have_posts()) : ?>

<div class="article-slider">
    <div class="article-slider-text">
        <h1>Articles<span class="colour">.</span></h1>
        <h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</h2>
    </div>
    
    <div class="slick-slider-carousel--generic" data-slick='{"slidesToShow": 3, "slidesToScroll": 1}'>
        <?php while ($query->have_posts()) {
            $query->the_post(); ?>
            <div class="slick-slide-item article-slider-item">
                <a href="<?php the_permalink(); ?>">
                <h4><?php the_title(); ?></h4>
                    <p class="article-excert"><?php the_field('short_description'); ?></p>
                </a>
            </div>
        <?php } ?>
    </div>
</div>

<?php endif;
wp_reset_postdata(); ?>


    <?php return ob_get_clean();
}
