<?php
add_action('vc_before_init', 'your_name_blogblocktwo');
function your_name_blogblocktwo() {
	vc_map(
		array(
			"name" => __("Airports", "my-text-domain"),
			"base" => "blogblocktwo",
			"class" => "",
			"category" => __("Content", "my-text-domain"),
			"params" => array(
			)
		)
	);
}

add_shortcode('blogblocktwo', 'blogblocktwo_func');
function blogblocktwo_func($atts, $content = null, $servicetitle) { 
    ob_start(); ?>

    <div class="airports">
<h1>Airports</h1>



<?php
$categories = get_categories('taxonomy=countries');
$select = "<select name='cat' id='cat' class='postform'>n";
$select .= "<option value='-1'>Select Country</option>n";
foreach ($categories as $category) {
    if ($category->count > 0) {
        $select .= "<option value='" . $category->slug . "'>" . $category->name . "</option>";
    }
}
$select .= "</select>";
echo $select;
?>
<script type="text/javascript">
    var dropdown = document.getElementById("cat");

    function onCatChange() {
        if (dropdown.options[dropdown.selectedIndex].value != -1) {
            location.href = "<?php echo home_url(); ?>/countries/" + dropdown.options[dropdown.selectedIndex].value + "/";
        }
    }
    dropdown.onchange = onCatChange;
</script>


<!--<?php
$taxonomy = 'countries';
$tax_terms = get_terms($taxonomy);
?>
<div class="custom-taxonomy-in-button-list">
<a class="button custom-taxonomy-in-button-list-button" href="/locations">All locations</a>
<?php
foreach ($tax_terms as $tax_term) {
echo '' . '<a class="button custom-taxonomy-in-button-list-button" href="' . esc_attr(get_term_link($tax_term, $taxonomy)) . '" title="' . sprintf( __( "View all posts in %s" ), $tax_term->name ) . '" ' . '>' . $tax_term->name.'</a>';
}
?>
</div>-->


              
<div class="locations-grid">   


                    <?php
                    $category_slug = get_field('post_category_slug');
                    $args = array(
                        'post_type'   => 'locations',
                        'post_status' => 'publish',
                        'posts_per_page' => 10003, 
                        'orderby' => 'title',
                        'order' => 'ASC'
                    );

                    $testimonials = new WP_Query($args);

                    if ($testimonials->have_posts()) : ?>
                        <?php while ($testimonials->have_posts()) :

                            $testimonials->the_post(); ?>

                    <a href="<?php the_permalink() ?>" class="link-card-two airports-card">
                        <div class="link-card-two-grid" >
                            <div class="link-card-two-background" style="background: url(
                                
                                <!--<?php if (has_post_thumbnail()) {
                        echo get_the_post_thumbnail_url(get_the_ID(), 'medium');
                        } else {
                            the_field('fallback_image', 'option');
                        } ?>-->
                        
                        );">
                                <div class="link-card-two-arrow-icon">
                                    <span class="material-icons">
                                        chevron_right
                                    </span>
                                </div>
                            </div>
                            <div class="link-card-two-text" >
                                <h2 class="link-card-two-title"><?php the_title(); ?> <?php the_field("airport_designation"); ?></h2>
                                <p class="link-card-two-p">
                                    <?php
                                        $customtaxonomy = get_the_terms( $post->ID , 'countries','', ', ', '' ); /* Get list of categories */
                                        $customtaxonomyobject = $customtaxonomy[0]; /* Get first item from the list */
                                        $customcatergoryid = $customtaxonomy[0]->term_id; /* Extract the ID of that category */
                                        $customcatergoryimage_id = get_field('category_icon', 'category_'.$customcatergoryid); /* Get the ID of that categories acf image */
                                        $customcatergoryimage_url = wp_get_attachment_image_url ($customcatergoryimage_id, 'thumbnail'); /* Get the URL of that Image by size */
                                        ?>
                                    <img src="<?php echo $customcatergoryimage_url; ?>" class="flag">
                                    <?php
                                        $terms = get_the_terms( $post->ID , 'countries','', ', ', '' );
                                        $term_slugs = [];
                                        foreach ( $terms as $term ) {
                                            $term_slugs[] = $term->name;
                                        }
                                        echo implode( ", ", $term_slugs);
                                    ?>
                                </p>
                                    

                                   

                            </div>       
                        </div>
                    </a>

                        <?php endwhile;
                        wp_reset_postdata(); ?>
                    <?php else :
                        esc_html_e('No posts found in the custom taxonomy!', 'text-domain');
                    endif; ?>

                </div>
                
            </div>
        </div>
    </div>
    <?php return ob_get_clean();
}
