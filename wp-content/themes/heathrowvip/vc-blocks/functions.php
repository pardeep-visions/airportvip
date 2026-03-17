<?php

/**
 * Files to include from lib folder
 */
$files = [
    //Lib
    '/lib/PasswordProtector.php',
    '/lib/enqueue-scripts-and-styles.php',
    '/lib/theme-setup.php',
    '/lib/helpers.php',
    '/lib/sidebars.php',
    '/lib/AnnouncementArea.php',
    //'/lib/strapline.php',
    //'/lib/buddypress-functions.php',
    '/lib/pmpro-functions.php',
    '/lib/wpfrontendadmin/enqueue.php',
    '/lib/wpfrontendadmin/restrict-edit-screen.php',


  
    '/lib/hide-dashboard-notices.php',
    '/lib/height-match.php',

//  '/lib/floating-social-share.php',
//  '/lib/cookie-notice/CookieNotice.php',
    '/lib/viewport-rules.php',
    //Shortcodes
    '/shortcodes/cta-popup.php',
    '/shortcodes/display-projects.php',
    '/shortcodes/mailchimp-inline-shortcode.php',
    //CPTs
    '/cpts/projects/projects.php',
    '/cpts/projects/helpers.php',

    
//    '/cpts/test/test.php',
//    '/cpts/test/helpers.php',

    '/cpts/resource/resource.php',
//    '/cpts/resource/helpers.php',
//    '/cpts/events/events.php',
//    '/cpts/testimonials/testimonials.php',
//    '/cpts/jobs/jobs.php',
//    '/cpts/jobvacancies/jobvacancies.php',
//    '/cpts/team/team.php',
//    '/cpts/team/display-team.php',
    '/cpts/charity-news/charity-news.php',

    
    //USER ROLES
    // '/cpts/jobvacancies/user-role-job-vacancy-editor.php',

    
    //VC
    '/vc-blocks/expanding-block.php',
    '/vc-blocks/custom-slider.php',
    '/vc-blocks/custom-slider-with-wysiwyg.php',
    '/vc-blocks/service-card.php',
    '/vc-blocks/info-card.php',
    '/vc-blocks/icon-card.php',
    '/vc-blocks/link-card.php',
    '/vc-blocks/process-card.php',
    '/vc-blocks/read-more.php',
    '/vc-blocks/call-to-action.php',
    '/vc-blocks/call-to-action-two-lines.php',
    '/vc-blocks/gallery-pinterest-grid.php',
    '/vc-blocks/testimonial-card.php',
    '/vc-blocks/testimonial-card-vertical.php',
    '/vc-blocks/testimonial-card-with-image.php',
    '/vc-blocks/info-banner.php',
    '/vc-blocks/image-changes-on-hover.php',
    '/vc-blocks/mailchimp-inline.php',
    '/vc-blocks/mailchimp-inline-two.php',
    '/vc-blocks/wysywig-partially-overlaid-image.php',
    '/vc-blocks/material-icon-card.php',
    '/vc-blocks/list-item-with-custom-image.php',
    '/vc-blocks/gallery-square-grid.php',
    '/vc-blocks/animated-custom-section.php',
    '/vc-blocks/animated-custom-section-top-title.php',
    '/vc-blocks/parralax-block.php',
    '/vc-blocks/video-behind-title.php',
    '/vc-blocks/zoom-card.php',
    '/vc-blocks/blog-block.php',
    '/vc-blocks/team-member-card.php',
    '/vc-blocks/funky-card.php',
    '/vc-blocks/round-card.php',
    '/vc-blocks/iframe-block.php',
    '/vc-blocks/two-col-text-block.php',
    '/vc-blocks/carosel.php',

    '/vc-blocks/display-block-one.php',
    '/vc-blocks/display-block-two.php',
    '/vc-blocks/display-block-three.php',
    '/vc-blocks/display-block-four.php',
    '/vc-blocks/contact-section.php',
    
 /*   '/vc-blocks/contact-section.php',
    '/vc-blocks/contact-section-two.php',
    '/vc-blocks/contact-section-three.php',
    '/vc-blocks/contact-section-four.php',
    '/vc-blocks/contact-section-five.php',
    '/vc-blocks/contact-section-six.php',*/
    
    '/vc-blocks/cta-card.php',
    '/vc-blocks/fee-table.php',
    '/vc-blocks/pricing-card.php',

    //'/vc-blocks/infographic.php',
    //WooCommerce
    //'/woocommerce/woocommerce-functions.php',
];

foreach ($files as $file) {
    include_once(__DIR__ .$file);
}
