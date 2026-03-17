 <?php 

/**
 * Puts a div into the header for a mobile cta
 */

 add_action('storefront_header', 'print_mobile_header_cta', 25 );
 function print_mobile_header_cta () { ?>
 
 <div class="mobile-header-cta">
    <a href="/quote/"> Quote</a>
 </div>
 
 <?php }