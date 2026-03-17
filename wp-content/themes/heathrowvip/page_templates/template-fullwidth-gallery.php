<!-- Start template full width -->
<?php
/**
 * The template for displaying full width pages.
 *
 * Template Name: Full Width with Gallery
 *
 * @package storefront
 */

get_header(); ?>


    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">

    
            <?php while (have_posts()) :
                the_post();

                do_action('storefront_page_before');

                get_template_part('content', 'page');

                /**
                 * Functions hooked in to storefront_page_after action
                 *
                 * @hooked storefront_display_comments - 10
                 */
                do_action('storefront_page_after');
            endwhile; // End of the loop. ?>

            <h2>Carosel (Slick)</h2>
            <div class="slick-slider-carousel has-slick-lightbox" data-slick='{"slidesToShow": 2, "slidesToScroll": 4}'>
                <?php for ($x = 0; $x <= 10; $x++) : ?>
                    <div class="slick-slide-item">
                        <div class="slick-slider-item-inner">
                            <a href="https://via.placeholder.com/300">
                                <img src="https://via.placeholder.com/300" alt="Placeholder Image">
                            </a>
                        </div>
                    </div>

                <?php endfor; ?>
            </div>


            <h2>Carosel (Slick) with ACF</h2>        
            <?php $images = get_field('gallery'); ?> 
            <?php if ($images) : ?> 
                <div class="slick-slider-carousel has-slick-lightbox">
                    <?php foreach ($images as $image) : ?>  
                        <a class="image-link" href="<?php echo $image['sizes']['large']; ?>"> 
                            <div class="slick-slide-item">
                                <div class="slick-slider-item-inner">
                                    <div class="square-grid-thumbs" style="background-image: url(<?php echo $image['sizes']['medium']; ?>);"></div>
                                </div>
                            </div>
                        </a> 
                    <?php endforeach; ?> 
                </div>
            <?php endif; ?>


            <h2>New Pinterest style gallery</h2>        
            <?php $images = get_field('gallery'); ?> 
            <?php if ($images) : ?> 
                <div class="gallery-outer"> 
                    <div class="gallery--pinterest has-slick-lightbox"> 
                        <div class="grid-sizer"></div>
                        <?php foreach ($images as $image) : ?> 
                            <a class="image-link" href="<?php echo $image['sizes']['large']; ?>"> 
                                <img src="<?php echo $image['sizes']['medium']; ?>" alt="<?php the_title(); ?>" /> 
                            </a> 
                        <?php endforeach; ?> 
                    </div> 
                </div> 
            <?php endif; ?>

            <h2>Display Pinterest Grid CSS Gallery</h2>         
            <?php $images = get_field('gallery'); ?> 
            <?php if ($images) : ?> 
                <div class="gallery-lightbox-outer pinterest-style"> 
                    <div class="gallery gallery-lightbox"> 
                        <?php foreach ($images as $image) : ?> 
                            <a href="<?php echo $image['sizes']['large']; ?>" target="_blank" class="thumbnail"> 
                                <img src="<?php echo $image['sizes']['medium']; ?>" alt="<?php the_title(); ?>" /> 
                            </a> 
                        <?php endforeach; ?> 
                    </div> 
                </div> 
            <?php endif; ?>

            <h2>Display Square Grid Gallery</h2>        
            <?php $images = get_field('gallery'); ?> 
            <?php if ($images) : ?> 
                <div class="gallery-lightbox-outer square-style-grid"> 
                    <div class="gallery gallery-lightbox"> 
                        <?php foreach ($images as $image) : ?> 
                            <a href="<?php echo $image['sizes']['large']; ?>" target="_blank" class="thumbnail">
                                <div class="square-grid-thumbs" style="background-image: url(<?php echo $image['sizes']['medium']; ?>);"></div>
                            </a> 
                        <?php endforeach; ?> 
                    </div> 
                </div> 
            <?php endif; ?>

            <h2>Display Grid Gallery</h2>       
            <?php $images = get_field('gallery'); ?> 
            <?php if ($images) : ?> 
                <div class="gallery-lightbox-outer"> 
                    <div class="gallery gallery-lightbox"> 
                        <?php foreach ($images as $image) : ?> 
                            <a href="<?php echo $image['sizes']['large']; ?>" target="_blank" class="thumbnail"> 
                                <img src="<?php echo $image['sizes']['medium']; ?>" alt="<?php the_title(); ?>" /> 
                            </a> 
                        <?php endforeach; ?> 
                    </div> 
                </div> 
            <?php endif; ?>

        </main><!-- #main -->
    </div><!-- #primary -->

<?php
get_footer();
?>
<!-- END template full width -->
