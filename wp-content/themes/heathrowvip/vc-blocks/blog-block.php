<?php
add_action('vc_before_init', 'your_name_blogblock');
function your_name_blogblock() {
	vc_map(
		array(
			"name" => __("Blog Cards", "my-text-domain"),
			"base" => "blogblock",
			"class" => "",
			"category" => __("Content", "my-text-domain"),
			"params" => array(
			)
		)
	);
}

add_shortcode('blogblock', 'blogblock_func');
function blogblock_func($atts, $content = null, $servicetitle) { 
    ob_start(); ?>

    <div class="blog-block">
        <div class="row">
            <div class="col-12">
                <h1 class="blog-block-title">BLOG</h1>
                <div class="blog-block-cards">
                    <?php
                    $category_slug = get_field('post_category_slug');
                    $args = array(
                        'post_type'   => 'post',
                        'post_status' => 'publish',
                        'posts_per_page' => 3, 
                    );

                    $testimonials = new WP_Query($args);

                    if ($testimonials->have_posts()) : ?>
                        <?php while ($testimonials->have_posts()) :

                            $testimonials->the_post(); ?>

                            <div class="blog-block-card">

                                <a class="" href="<?php the_permalink() ?>">
                                    <div class="blog-block-card-image" style="background-image: url(<?php if (has_post_thumbnail()) { echo get_the_post_thumbnail_url(get_the_id(), 'large'); } else { the_field('fallback_image', 'option'); } ?>)"></div>
                                </a>

                                <div class="blog-block-card-text">
                                    <p class="blog-block-card-title"><?php the_title(); ?></p>
                                    <span class="blog-block-card-excerpt"><?php the_excerpt(__('(more…)')); ?></span>
                                    <p class="blog-block-card-meta"><?php $post_date = get_the_date( 'j M Y' ); echo $post_date;?></p>
                                    <div class="blog-block-card-button">
                                        <a class="blog-block-read-more button" href="<?php the_permalink() ?>">Read more</a>
                                    </div>
                                </div>  

                            </div>   

                        <?php endwhile;
                        wp_reset_postdata(); ?>
                    <?php else :
                        esc_html_e('No posts found in the custom taxonomy!', 'text-domain');
                    endif; ?>

                </div>
                <a href="/blog" class="blog-block-view-all">View Blog</a>
            </div>
        </div>
    </div>
    <?php return ob_get_clean();
}
