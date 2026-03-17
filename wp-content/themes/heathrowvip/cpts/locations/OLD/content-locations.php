


<a href="<?php the_permalink() ?>" class="airports-card-link">	
    <div class="airports-card">	
        <h2><?php the_title(); ?></h2>   
        <?php $terms = get_the_terms( get_the_ID(), 'countries'); ?>
        <?php if(!is_wp_error($terms) && $terms) : ?>			
            <?php foreach($terms as $term) : ?>
                <h4><?php echo $term->name; ?></h4>
                <img src="/wp-content/themes/heathrowvip/cpts/locations/flags/<?php echo $term->slug; ?>.png" class="country-flag">
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</a>

	

