<?php

/**
 * Puts a floating share icon on the while site
 */

add_action('storefront_before_footer', 'print_floating_social_share_storefront_before_footer');
function print_floating_social_share_storefront_before_footer () {

   ?>

<div class="floating-social-share-outer">
    <div class="floating-social-share">
        <div class="floating-social-share-inner">
            <div class="openingbox">
                <button class="accordion">
                    <span class="material-icons">
                        share
                    </span>
                </button>
                <div class="panel" style="display: none;">
                    <div id="share-buttons">
                
                        <!-- Email -->
                        <a class="email-share share-button" href="mailto:?Subject=<?php the_title(); ?>&amp;Body=I%20saw%20this%20and%20thought%20of%20you!%20 <?php echo get_permalink( $post->ID ); ?>">
                            <i class="far fa-envelope"></i>
                        </a>
                    
                        <!-- Facebook -->
                        <a class="facebook-share share-button" href="http://www.facebook.com/sharer.php?u=<?php echo get_permalink( $post->ID ); ?>" target="_blank">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    
                        <!-- LinkedIn -->
                        <a class="linkedin-share share-button" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo get_permalink( $post->ID ); ?>" target="_blank">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        
                        <!-- Twitter -->
                        <a class="twitter-share share-button" href="https://twitter.com/share?url=<?php echo get_permalink( $post->ID ); ?>&amp;<?php the_title(); ?>" target="_blank">
                            <i class="fab fa-twitter"></i>
                        </a>

                        <!-- Whatsapp -->
                        <a class="whatsapp-share share-button" href="whatsapp://send?text=<?php echo get_permalink( $post->ID ); ?> &amp; <?php the_title(); ?>" data-action="share/whatsapp/share">
                            <i class="fab fa-whatsapp"></i>
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php }