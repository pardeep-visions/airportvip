<?php


add_shortcode('symptoms_search_form', 'symptoms_search_form_html');
function symptoms_search_form_html()
{ 
    return get_symptoms_search_form();
}



/******** */

function get_symptoms_search_form()
{
    $terms = get_terms(array(
        'taxonomy' => 'Symptoms',
        'hide_empty' => true,
    ));
    return get_terms_filter_html($terms);
}
function get_products_grid_html($terms)
{
    
    ob_start();
    $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1; 
    $args = [
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => 18,
        'paged' => $paged,
    ];
    //Build meta query
    $terms_array = [];
    foreach($terms as $term) {
        if(isset($_GET[$term->slug])) {
            $terms_array[] = $term->slug;
        }
    }

    if(!empty($terms_array)) {
        $term_args = [];
        foreach($terms_array as $term_slug) {
            $term_arg = [
                'taxonomy' => 'Symptoms',
                'field'    => 'slug',
                'terms'    => [$term_slug],
            ];
            $term_args[] = $term_arg;
        }
        $args['tax_query'] = $term_args;
        if(sizeof($terms_array) > 1) {
            $args['tax_query']['relation'] = 'OR';
        }
    }

    $query = new WP_Query($args);
    // The Loop
    if ( $query->have_posts() ) {
        echo '<ul class="products">';
        while ( $query->have_posts() ) {

            $query->the_post();

            wc_get_template_part( 'content', 'product' );
        }
        echo '</ul>';
    } else {
        // no posts found
        echo 'No posts';
    }
    
    echo '<ul class="woocommerce-pagination">';
        echo paginate_links( array(
            // 'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'format' => '?paged=%#%',
            'current' => max( 1, get_query_var('paged') ),
            'total' => $query->max_num_pages
        ) );

    // echo '</ul>';
    wp_reset_postdata();
    return ob_get_clean();
}

function get_terms_filter_html($terms) {
    ob_start(); ?>
    <form class="symptom-form" action="/product-grid">
    <div class="sympton-items">
        <?php foreach($terms as $term) : ?>
            <div class="form-group">
                <input name="<?php echo $term->slug; ?>" type="checkbox" value="1" <?php 
                if(isset($_GET[$term->slug])) {
                    echo ' checked'; 
                    }
                    else { 
                        //echo $_GET[$term->slug];
                } ?>>
                    <label for="<?php echo $term->slug; ?>"><?php echo $term->name; ?></label>
            </div>
        <?php endforeach; ?>
        </div>
        <div class="submit-item">
            <input type="submit">
        </div>
    </form>
    <?php
    return ob_get_clean();
}
function get_fact_sheets()
{
    $has_facts = false;
    $html = '';
    //Get get params.
    $symptoms = get_terms([
        'taxonomy' => 'Symptoms',
        'hide_empty' => false,
    ]);
    foreach($symptoms as $symptom) {
        if (isset($_GET[$symptom->slug])) {
            $fact_sheet_html = get_field('fact_sheet', $symptom->term_id);
            $fact_sheet_html = get_field('fact_sheet', 'Symptoms' . '_' . $symptom->term_id);
            if ($fact_sheet_html) {
                $html .= '<div class="fact-sheet">';
                $html .= $fact_sheet_html;
                $html .= '</div>';
                $has_facts = true;
            }
        } 
    }
    if(!$has_facts) {
       return false;
    }
    return $html;
}


/********* */





add_action('woocommerce_shop_loop_item_title', 'print_after_shop_loop_item_title');

function print_after_shop_loop_item_title () {

$terms = get_the_terms( get_the_ID() , 'Symptoms' ); 
//Check for terms before displaying
if($terms) :
echo '<div style="display: none;" class="symptom-list">';

    //Build up output
    $links_html = '';
        foreach ( $terms as $term ) :
            $links_html .=  '<a  href="'.get_term_link($term->term_id).'">'.$term->name.'</a>, ';//Add seperator to end of every term
        endforeach;
    $links_html = rtrim($links_html);//Remove seperator from last term
    $links_html = rtrim($links_html, ',');//Remove seperator from last term
    echo ''.$links_html.'';//Wrap and output

    echo '</div>';
endif;
}

add_action('init', 'create_symptoms_taxonomy');
function create_symptoms_taxonomy()
{
	register_taxonomy('Symptoms', array('product'), array('label' => 'Symptoms', 'hierarchical' => true,));
}

add_action('woocommerce_single_product_summary', 'print_something_woocommerce_single_product_summary');

function print_something_woocommerce_single_product_summary () {

$terms = get_the_terms( $post->ID , 'Symptoms' ); 

//Check for terms before displaying
if($terms) :
echo '<h4 class="highly-reccomended-for">Highly Recommended For:</h4>';
echo '<div class="symptom-list">';

    //Build up output
    $links_html = '';
        foreach ( $terms as $term ) :
            $links_html .=  '<a  href="'.get_term_link($term->term_id).'">'.$term->name.'</a>, ';//Add seperator to end of every term
        endforeach;
    $links_html = rtrim($links_html);//Remove seperator from last term
    $links_html = rtrim($links_html, ',');//Remove seperator from last term
    echo ''.$links_html.'';//Wrap and output

    echo '</div>';
endif;

     if(get_field('symptom_text_area')){ 
        echo '<div class="product-more-info">';
        the_field('symptom_text_area');
        echo '</div>';
     } 

}

add_action('woocommerce_after_main_content', 'print_something_woocommerce_after_main_content');

function print_something_woocommerce_after_main_content () {

    $product_cat_object = get_queried_object();

     if(get_field('below_category_feed_text_area', 'product_cat_' . $product_cat_object->term_id)){ 
        echo '<div class="below-cat-text-area">';
        the_field('below_category_feed_text_area', 'product_cat_' . $product_cat_object->term_id);
        echo '</div>';
     } 

}

