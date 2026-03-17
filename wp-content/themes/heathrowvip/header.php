<!-- Start header -->
<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package storefront
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>

	
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

<link rel="stylesheet" href="https://use.typekit.net/ivj0ysv.css">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
<!-- Google Fonts -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
<!-- Bootstrap core CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
<!-- Material Design Bootstrap -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css" rel="stylesheet">
<!-- JQuery -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/js/mdb.min.js"></script>

<!-- Bootstrap CDN -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="stylesheet" href="https://use.typekit.net/hta3pxo.css">

<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
<link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">

<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

    	<!-- Google tag (gtag.js) --> 
<script async src="https://www.googletagmanager.com/gtag/js?id=G-7YESKGBX69"></script> 

	<script>
        function consentGranted() {
            window.dataLayer = window.dataLayer || []; 
            function gtag(){dataLayer.push(arguments);} 
            gtag('js', new Date()); 
            gtag('config', 'G-7YESKGBX69');
            gtag('config', 'AW-16927764520');
        }
</script> 
<?php wp_head(); ?>


   
</head>

<body <?php body_class(); ?>>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5SX6MWPN"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<?php do_action('storefront_before_site'); ?>

<div id="page" class="hfeed site">

    <?php do_action('storefront_before_header'); ?>

    
    <div class="mastead-height-mirror"></div>
    <header id="masthead" class="site-header" role="banner" style="<?php storefront_header_styles(); ?>">
        <?php if (is_active_sidebar('sidebar-above-header')) : ?>
            <div class="above-header-sidebar-relative">
                <div class="above-header-sidebar-outer">
                    <div class="above-header-sidebar">
                        <div class="above-header-sidebar-inner">
                            <?php dynamic_sidebar('sidebar-above-header'); ?>
                        </div>
                    </div>  
                </div>  
            </div>
        <?php endif; ?>
        <div class="col-full header-outer">



            <?php
            /**
             * Functions hooked into storefront_header action
             *
             * @hooked storefront_skip_links                       - 0
             * @hooked storefront_social_icons                     - 10
             * @hooked storefront_site_branding                    - 20
             * @hooked storefront_secondary_navigation             - 30
             * @hooked storefront_product_search                   - 40
             * @hooked storefront_primary_navigation_wrapper       - 42
             * @hooked storefront_primary_navigation               - 50
             * @hooked storefront_header_cart                      - 60
             * @hooked storefront_primary_navigation_wrapper_close - 68
             */
        
            do_action('storefront_header'); ?>

        </div>
        
        <!--<div class="col-full">
            <?php echo do_shortcode('[free-shipping-cta]'); ?>
        </div>-->

    </header><!-- #masthead -->

    <?php
    /**
     * Functions hooked in to storefront_before_content
     *
     * @hooked storefront_header_widget_region - 10
     */
    do_action('storefront_before_content'); ?>

    <?php if (is_page_template('page_templates/template-fullwidth-absolute-slider.php')) { ?>
        <div class="absolute-slider header-slider">
            <div class="header-slider-inner">
                <?php $images = get_field('gallery'); if ($images) : ?>
                    <div id="slider" class="flexslider">
                        <ul class="slides">
                            <?php if (is_array($images) || is_object($images)) { foreach ($images as $image) : ?>
                                <li style="min-height:500px;background-image: url(<?php echo $image['sizes']['large']; ?>);" data-thumb="<?php echo $image['sizes']['thumbnail']; ?>"> 
                                    <div class="absolute-header-text-background"></div>
                                </li>
                            <?php endforeach; } ?>
                        </ul>
                    </div>
                <?php endif; ?>                        
            </div>
        </div>
    <?php  } ?>

    <div id="content" class="site-content" tabindex="-1">
        <div class="col-full">


        <?php
        /**
         * Functions hooked in to storefront_content_top
         *
         * @hooked woocommerce_breadcrumb - 10
         */
        do_action('storefront_content_top');
        ?>

<!-- END header -->
