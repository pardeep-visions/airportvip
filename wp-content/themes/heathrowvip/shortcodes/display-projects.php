<?php
add_shortcode('displayprojects', 'display_projects');
function display_projects()
{
	ob_start();
	$args = array(
		'post_type' => 'projects',
		'post_status' => 'publish',
		'orderby' => 'date',
		'order' => 'DESC',
		'posts_per_page' => 3

	);
	$query = new WP_Query($args);

	if ($query->have_posts()) { ?>

		<div class="shortcodeblock">
			<h1>Projects</h1>
			<div class="projects-shortcode">
				<?php while ($query->have_posts()) {
					$query->the_post(); ?>
					<div class="single-item">
						<a href="<?php the_permalink(); ?>">
							<div class="item-thumb" style="background-image: url('<?php if (has_post_thumbnail()) {
																						echo  get_the_post_thumbnail_url(get_the_ID(), 'large');
																					} else {
																						echo "/wp-content/themes/boilerplate/assets/images/fallbackimage.jpg";
																					} ?>')">
							</div>
						</a>
						<div class="single-item-text">
							<a href="<?php the_permalink(); ?>">
								<h1><strong><?php the_title(); ?></strong></h1>
							</a>
							<?php $terms = get_terms('projects_taxonomy');
							foreach ($terms as $term) {
								$term_link = get_term_link($term);
								if (is_wp_error($term_link)) {
									continue;
								}
								echo '<a href="' . esc_url($term_link) . '">' . $term->name . '</a>';
							}	?>
							<p><?php the_excerpt(__('(more…)')); ?></p>
							<a href="<?php the_permalink() ?>">Read more</a>
						</div>
					</div>

		<?php
		}
		echo '</div>';
	}
	wp_reset_query();
	$string = ob_get_clean();
	return $string;
}
