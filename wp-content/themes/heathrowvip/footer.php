<!-- Start footer -->
<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package storefront
 */

?>

</div><!-- .col-full -->
</div><!-- #content -->


<!-- OWL Carosel JS -->
<script src="/wp-content/plugins/owl-carosel/dist/owl.carousel.min.js"></script>


<!-- CUSTOM ACCORDION SCRIPT --> 

<script>
   
    // var acc = document.getElementsByClassName("accordion");
    // var i;
    // for (i = 0; i < acc.length; i++) {
    //     acc[i].addEventListener("click", function() {
    //         this.classList.toggle("active");
    //         var panel = this.nextElementSibling;
    //         if (panel.style.display === "block") {
    //             panel.style.display = "none";
    //         } else {
    //             panel.style.display = "block";
    //         }
    //     });
    // }

//     document.addEventListener("DOMContentLoaded", function() {
//     var acc = document.getElementsByClassName("accordion");
//     var i;
//     for (i = 0; i < acc.length; i++) {
//         acc[i].addEventListener("click", function() {
//             this.classList.toggle("active");
//             var panel = this.nextElementSibling;
//             if (panel.style.display === "block") {
//                 panel.style.display = "none";
//             } else {
//                 panel.style.display = "block";
//             }
//         });
//     }
// });



</script> 

<script>
    /**
     * Makes two columns equal height
     * @param {string} breakpoint Above this value triggers resize, below will unset.
     * @param {string} el1 A jQuery selector. Must be unique.
     * @param {string} el2 A jQuery selector. Must be unique.
     */
    function equalColumns(el1, el2, breakpoint) {

        if (!(window.innerWidth > breakpoint)) {
            jQuery(el1).css('min-height', '');
            jQuery(el2).css('min-height', '');
            return;
        }

        var $el1 = jQuery(el1);
        var $el2 = jQuery(el2);

        if (!($el1.length == 1 && $el2.length == 1)) {
            return;
        }

        var el1Height = $el1.outerHeight();
        var el2Height = $el2.outerHeight();

        if (el1Height < el2Height) {
            $el1.css('min-height', el2Height);
        } else if (el1Height > el2Height) {
            $el2.css('min-height', el1Height);
        }
    }

    //Fire equal columns on page load
    jQuery(window).load(function() {
        equalColumns('#primary', '#secondary', 767);
    });

    //Fire equal columns after windows resize
    jQuery(window).resize(function() {
        clearTimeout(window.resizedFinished);
        window.resizedFinished = setTimeout(function() {
            // console.log('Resized finished.');
            equalColumns('#primary', '#secondary', 767);
        }, 100);
    });
</script>

<script>
    jQuery(document).ready(function() {
        jQuery('input[type="number"]').keypress(function(event){
            event.preventDefault();
        });    

        jQuery('input[type="number"]').on('paste', function(e) {
            e.preventDefault();
        });    

        //When sidebar item is opened, close the sibling items
        jQuery('.left-modal-menu .menu-item-has-children .dropdown-toggle').click(function() {
            //When dropdown toggle is clicked, find siblings of the parent and close them
            jQuery(this).parent('.menu-item-has-children').siblings('.menu-item-has-children').each(function() {
                //Remove toggle from button and set ARIA expanded false
                jQuery(this).find('button.dropdown-toggle').removeClass('toggled-on').attr('aria-expanded', false);
                //Remove toggle from sub-menu
                jQuery(this).find('ul.sub-menu').removeClass('toggled-on');
            })
        });
    });
</script>



<script src="https://f.vimeocdn.com/js/froogaloop2.min.js"></script>
<script src="https://player.vimeo.com/api/player.js"></script>

<script>
    jQuery('.product-card-media').each(function() {
        var player = jQuery("#" + this.id);
        player.mouseover(function() {
            var froogaloop = $f(player[0].id);
            froogaloop.api('play');
        }).mouseout(function() {
            var froogaloop = $f(player[0].id);
            froogaloop.api('pause');
        });
    });
</script>

<!-- Material Design for Bootstrap Trigger -->
<script>
    $(document).ready(function() {
        new WOW().init();
    });
</script>


<!-- CTA BUTTON LIGHTBOX -->
<?php if (  is_post_type_archive( 'courses' ) || is_singular( 'courses' )  ) { } else { ?>
    <div id='Lightbox' class='modal'>
        <span class='close pointer' onclick='closeLightbox()'>&times;</span>
        <div class='lightbox-content'>
            <div class='lightbox-content-inner'>
                <div href='#' class='close' onclick='closeLightbox()'></div>
                <?php echo do_shortcode("[contact-form-7 id='291' title='Pop Up Contact Form']"); ?>
            </div>
        </div>
    </div>
<?php } ?>

<!-- SLICK LIGHTBOX SCRIPT -->

<script>
    jQuery(document).ready(function() {
        jQuery('.gallery').slickLightbox({
            itemSelector: '> a',
            caption: function(element, info) {
                var caption =  $(element).find('.square-grid-caption').text();
                if(caption) {
                    return caption;
                }
                return '';
            }
        });
 
    // Select all input fields with type="email"
    var emailInputs = $('input[type="email"]');
    
    // Loop through each email input field
    emailInputs.each(function() {
        var emailInput = $(this);
        
        // Create error message dynamically for each input
        emailInput.after('<span class="error-message" style="color: red; font-size: 13px; display: none;">Invalid email address</span>');
        var errorMessage = emailInput.next('.error-message');

        emailInput.on('input', function() {
            var email = $(this).val().trim();
            var isValid = validateEmail(email);

            if (isValid) {
                // Email is valid
                errorMessage.hide();
                $(this).removeClass('invalid');
            } else {
                // Email is invalid
                errorMessage.show();
                $(this).addClass('invalid');
            }
        });
    });

    function validateEmail(email) {
        // Regular expression for basic email validation
        var re = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        return re.test(String(email).toLowerCase());
    } 

 



    });
</script>

<!-- CUSTOM LIGHTBOX SCRIPT -->

<script>
    let slideIndex = 1;
    // showSlide(slideIndex);   
    function openLightbox() {
        document.getElementById('Lightbox').style.display = 'block';
    };

    function closeLightbox() {
        document.getElementById('Lightbox').style.display = 'none';
    };
</script>

<!-- CF7 GOOGLE EVENT LISTENER SCRIPT -->

<script>
    document.addEventListener('wpcf7mailsent', function(event) {
        gtag('event', 'submit', {
            'event_category': 'Contact Form',
            'event_label': 'Contact Form',
            'value': 'Contact Form'
        });
    }, false);
</script>

<script>
    window.addEventListener("scroll", function(e) {
        if (window.scrollY == 0) {
            jQuery("body").removeClass("has-y-scroll");
        } else {
            jQuery("body").addClass("has-y-scroll");
        }
    });


    var scrollPos = 0;

    window.addEventListener("scroll", function() {

        if (document.body.getBoundingClientRect().top > scrollPos) {
            jQuery('body').addClass('has-y-scroll-up');
            jQuery('body').removeClass('has-y-scroll-down');
        } else if (document.body.getBoundingClientRect().top < scrollPos) {
            jQuery('body').addClass('has-y-scroll-down');
            jQuery('body').removeClass('has-y-scroll-up');
        } else {
            jQuery('body').removeClass('has-y-scroll-up');
            jQuery('body').removeClass('has-y-scroll-down');
        }
        scrollPos = document.body.getBoundingClientRect().top;
    });
</script>

<script>
    function handleOutboundLinkClicks(event) {
        gtag('event', 'click', {
            'event_category': 'Outbound Link',
            'event_label': event.target.href,
            'value': 'Outbound Link'
        });
    }
</script>

<!-- CUSTOM SIDEBAR STICKY WRAP -->
<script>
    //jQuery( ".widget-area" ).wrapAll( "<div class='new' />");
</script>


<!-- CUSTOM ACCORDION SCRIPT -->

<script>
    // jQuery('.collapse').collapse();
</script>

<script>
    // var acc = document.getElementsByClassName("accordion");
    // var i;
    // for (i = 0; i < acc.length; i++) {
    //     acc[i].addEventListener("click", function() {
    //         this.classList.toggle("active");
    //         var panel = this.nextElementSibling;
    //         if (panel.style.display === "block") {
    //             panel.style.display = "none";
    //         } else {
    //             panel.style.display = "block";
    //         }
    //     });
    // }
</script>

<script>
    // jQuery(window).ready(function() {
    //     jQuery('.flexslider').flexslider();
    // });
</script>

<script>
    /**
     * Makes two columns equal height
     * @param {string} breakpoint Above this value triggers resize, below will unset.
     * @param {string} el1 A jQuery selector. Must be unique.
     * @param {string} el2 A jQuery selector. Must be unique.
     */
    function equalColumns(el1, el2, breakpoint) {

        if (!(window.innerWidth > breakpoint)) {
            jQuery(el1).css('min-height', '');
            jQuery(el2).css('min-height', '');
            return;
        }

        var $el1 = jQuery(el1);
        var $el2 = jQuery(el2);

        if (!($el1.length == 1 && $el2.length == 1)) {
            return;
        }

        var el1Height = $el1.outerHeight();
        var el2Height = $el2.outerHeight();

        if (el1Height < el2Height) {
            $el1.css('min-height', el2Height);
        } else if (el1Height > el2Height) {
            $el2.css('min-height', el1Height);
        }
    }

    //Fire equal columns on page load
    jQuery(window).load(function() {
        equalColumns('#primary', '#secondary', 767);
    });

    //Fire equal columns after windows resize
    jQuery(window).resize(function() {
        clearTimeout(window.resizedFinished);
        window.resizedFinished = setTimeout(function() {
            // console.log('Resized finished.');
            equalColumns('#primary', '#secondary', 767);
        }, 100);
    });
</script>

<script>
    jQuery(document).ready(function() {
        ~
        //When sidebar item is opened, close the sibling items
        jQuery('.left-modal-menu .menu-item-has-children .dropdown-toggle').click(function() {
            //When dropdown toggle is clicked, find siblings of the parent and close them
            jQuery(this).parent('.menu-item-has-children').siblings('.menu-item-has-children').each(function() {
                //Remove toggle from button and set ARIA expanded false
                jQuery(this).find('button.dropdown-toggle').removeClass('toggled-on').attr('aria-expanded', false);
                //Remove toggle from sub-menu
                jQuery(this).find('ul.sub-menu').removeClass('toggled-on');
            })
        });
    });
</script>

<!--<script>
jQuery(document).ready(function(){ 
    jQuery(window).scroll(function(){ 
        if (jQuery(this).scrollTop() > 100) { 
            jQuery('#scroll').fadeIn(); 
        } else { 
            jQuery('#scroll').fadeOut(); 
        } 
    }); 
    jQuery('#scroll').click(function(){ 
        jQuery("html, body").animate({ scrollTop: 0 }, 600); 
        return false; 
    }); 
});

jQuery(document).on('click', 'a[href^="#"]', function (event) {
    event.preventDefault();

    jQuery('html, body').animate({
        scrollTop: jQuery(jQuery.attr(this, 'href')).offset().top
    }, 500);
});

</script> -->

<!-- in footer.php -->
<a href="#" id="scroll" style="display: none;">
    <i class="fas fa-arrow-up"></i>
    <p>Back To Top</p>
</a>

<?php do_action('storefront_before_footer'); ?>

<footer id="colophon" class="site-footer" role="contentinfo">
    <div class="col-full">


        <?php
        /**
         * Functions hooked in to storefront_footer action
         *
         * @hooked storefront_footer_widgets - 10
         * @hooked storefront_credit         - 20
         */
        do_action('storefront_footer'); ?>

    </div><!-- .col-full -->

    <?php if (is_active_sidebar('sidebar-below-footer')) : ?>
        <div class="container below-footer">
            <div class="row">
                <div class="col-12">
                    <?php dynamic_sidebar('sidebar-below-footer'); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>


</footer><!-- #colophon -->

<?php do_action('storefront_after_footer'); ?>

</div><!-- #page -->

<script src="https://unpkg.com/packery@2.1/dist/packery.pkgd.min.js"></script>


<?php wp_footer(); ?>

<link rel='stylesheet' id='hh-taxi-add-to-cart-css' href='/wp-content/themes/heathrowvip/woocommerce-bookings/taxi/assets/css/taxi-add-to-cart.css?ver=1.0.0' media='all' />

<script src="/wp-content/themes/heathrowvip/woocommerce-bookings/taxi/assets/js/taxi-add-to-cart.js?ver=1.0" id="hh-add-to-cart-js"></script>


</body>

</html>
<!-- END footer -->