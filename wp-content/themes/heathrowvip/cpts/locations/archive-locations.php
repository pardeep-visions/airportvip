<!--Start Archive -->
<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package storefront
 */
wp_enqueue_style('themify-icon');
get_header(); ?>

<header class="page-header location-archive-meta">
	<?php if (is_tax()) : ?>
		<h1><?php echo single_term_title(); ?></h1>	
		<?php if (category_description()) { ?>
			<div class="category-description-container">
				<?php echo category_description(); ?>
			</div>
		<?php } ?>			
	<?php else : ?>
		<h1>Our Locations</h1>
		<div class="category-description-container">
			
		</div>
	<?php endif; ?>
</header><!-- .page-header -->


<div id="primary" class="content-area">

	<main id="main" class="site-main content-wrapper" role="main">
        <div class="container">
            <div class="row">
            <?php
                $terms = get_terms([
                    'taxonomy'=> 'countries',
                    'parent' => 0
                ]);
                $i = 0;
                if (!is_wp_error($terms)) {
                    foreach ($terms as $term) {
                        $subTerms = get_terms([
                            'taxonomy'=> 'countries',
                            'parent' => $term->term_id
                        ]);
                        ?>
                        <div class="col-md-6 mb-4">
                            <h3><span><?php echo $term->name; ?></span></h3>
                            <ul class="accordion-box clearfix">
                            <?php
                                if (!is_wp_error($subTerms)) {
                                    foreach ($subTerms as $subTerm) {
                                        ?>
                                        <li class="accordion block <?php echo $i === 0 ? 'active-block' : ''; ?>">
                                            <div class="acc-btn <?php echo $i === 0 ? 'active' : ''; ?>">
                                                <span class="count flag"><img src="/wp-content/themes/heathrowvip/cpts/locations/flags/<?php echo $subTerm->slug; ?>.png" alt="albania flag" /></span>
                                                <?php echo $subTerm->name; ?>
                                            </div>
                                            <div class="acc-content <?php echo $i === 0 ? 'current' : ''; ?>">
                                                <div class="content">
                                                    <div class="text">
                                                        <?php
                                                            $locations = new WP_Query([
                                                                'post_type' => 'locations',
                                                                'post_status' => 'publish',
                                                                'tax_query' => array(
                                                                    array(
                                                                        'taxonomy' => 'countries',
                                                                        'field'    => 'slug',
                                                                        'terms'    => $subTerm->slug,
                                                                    ),
                                                                ),
                                                            ]);
                                                            if ($locations->have_posts()) {
                                                                while ($locations->have_posts()) {
                                                                    $locations->the_post();
                                                                    ?>
                                                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                                    <?php
                                                                }
                                                            }
                                                            wp_reset_postdata();
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <?php
                                        $i++;
                                    }
                                }
                            ?>
                            </ul>
                        </div>
                        <?php
                    }
                }
            ?>
            </div>
        </div>
        <script>
            jQuery(document).ready(function ($) {
                if ($(".accordion-box").length) {
                    $(".accordion-box").on("click", ".acc-btn", function () {
                        var outerBox = $(this).parents(".accordion-box");
                        var target = $(this).parents(".accordion");

                        if ($(this).next(".acc-content").is(":visible")) {
                            //return false;
                            $(this).removeClass("active");
                            $(this).next(".acc-content").slideUp(300);
                            $(outerBox).children(".accordion").removeClass("active-block");
                        } else {
                            $(outerBox).find(".accordion .acc-btn").removeClass("active");
                            $(this).addClass("active");
                            $(outerBox).children(".accordion").removeClass("active-block");
                            $(outerBox).find(".accordion").children(".acc-content").slideUp(300);
                            target.addClass("active-block");
                            $(this).next(".acc-content").slideDown(300);
                        }
                    });
                }
            })
        </script>
	</main><!-- #main -->
	
</div><!-- #primary -->

<?php
get_template_part( 'cpts/locations/sidebar-locations' );
get_footer();
?>
<!-- END Archive -->