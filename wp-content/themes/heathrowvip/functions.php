<?php

/**
 * Files to include from lib folder Heathrow VIP
 */
$files = [

    /**
     * Lib
     */
    '/lib/PasswordProtector.php',
    '/lib/enqueue-scripts-and-styles.php',
    '/lib/theme-setup.php',
    '/lib/helpers.php',
    '/lib/sidebars.php',
    '/lib/AnnouncementArea.php',
    '/lib/floating-cta-lozenge.php',
    '/lib/footer-custom.php',

    '/lib/height-match.php',
    '/lib/media-library-image-sizes.php',


    //CPTs

    '/cpts/testimonials/testimonials.php',
    '/cpts/locations/locations.php',
    '/cpts/locations/ArchiveFilter.php',

    /**
     * Visual Composer Blocks
     */
    '/vc-blocks/expanding-block.php',
    '/vc-blocks/custom-slider.php',
    '/vc-blocks/custom-slider-with-wysiwyg.php',
    '/vc-blocks/service-card.php',
    '/vc-blocks/service-card-small.php',
    '/vc-blocks/service-card-tall.php',
    '/vc-blocks/info-card.php',
    '/vc-blocks/icon-card.php',
    '/vc-blocks/icon-card-two.php',
    '/vc-blocks/link-card.php',
    '/vc-blocks/link-card-two.php',
    '/vc-blocks/link-vh-card.php',
    '/vc-blocks/download-card.php',

    '/vc-blocks/process-card.php',
    '/vc-blocks/speaker-card.php',
    '/vc-blocks/read-more.php',
    '/vc-blocks/call-to-action.php',
    '/vc-blocks/call-to-action-two-lines.php',
    '/vc-blocks/gallery-pinterest-grid.php',
    '/vc-blocks/gallery-mosaic-grid.php',
    '/vc-blocks/testimonial-card.php',
    '/vc-blocks/testimonial-card-vertical.php',
    '/vc-blocks/testimonial-card-with-image.php',

    '/vc-blocks/testimonial-slider-preset.php',
    '/vc-blocks/testimonial-slider-preset-two.php',
    '/vc-blocks/testimonial-slider-preset-three.php',
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
    '/vc-blocks/blog-block-two.php',
    '/vc-blocks/team-member-card.php',
    '/vc-blocks/funky-card.php',
    '/vc-blocks/funky-card-two.php',
    '/vc-blocks/funky-card-three.php',
    '/vc-blocks/funky-card-four.php',
    '/vc-blocks/round-card.php',
    '/vc-blocks/iframe-block.php',
    '/vc-blocks/two-col-text-block.php',
    '/vc-blocks/carosel.php',
    '/vc-blocks/carosel-autoplay.php',
    '/vc-blocks/display-block-one.php',
    '/vc-blocks/display-block-two.php',
    '/vc-blocks/display-block-three.php',
    '/vc-blocks/display-block-four.php',
    '/vc-blocks/display-block-five.php',
    '/vc-blocks/display-block-six.php',
    '/vc-blocks/display-block-seven.php',
    '/vc-blocks/display-block-eight.php',
    '/vc-blocks/display-block-nine.php',
    '/vc-blocks/display-block-ten.php',
    '/vc-blocks/display-block-eleven.php',
    '/vc-blocks/display-block-twelve.php',
    '/vc-blocks/display-block-thirteen.php',
    '/vc-blocks/display-block-fourteen.php',
    '/vc-blocks/display-block-fifteen.php',
    '/vc-blocks/display-block-sixteen.php',

    '/vc-blocks/display-block-heathrow.php',

    '/vc-blocks/carosel--car.php',

    '/vc-blocks/pricing-list--one.php',

    '/vc-blocks/contact-section.php',
    '/vc-blocks/contact-section-two.php',
    '/vc-blocks/contact-section-three.php',
    '/vc-blocks/contact-section-four.php',
    '/vc-blocks/contact-section-five.php',
    '/vc-blocks/contact-section-six.php',

    '/vc-blocks/flow-selector-grid.php',
    '/vc-blocks/flow-selector-grid-two.php',
    '/vc-blocks/slanted-card.php',
    '/vc-blocks/slanted-custom-section-one.php',
    '/vc-blocks/slanted-custom-section-two.php',
    '/vc-blocks/slanted-custom-section-three.php',
    '/vc-blocks/client-logo-grid.php',
    '/vc-blocks/smart-menu.php',
    '/vc-blocks/wysywig-partially-pulled-to-the-left.php',


    /**
     * WooCommerce customization
     */
    '/woocommerce/woocommerce-functions.php',
     '/woocommerce-bookings/functions.php',
    '/lib/booking-pdf.php',
];

foreach ($files as $file) {
    include_once(__DIR__ . $file);
}

function wpex_order_category( $query ) {
	// exit out if it's the admin or it isn't the main query
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}
	// order category archives by title in ascending order
	if ( is_category() ) {
		$query->set( 'order' , 'asc' );
		$query->set( 'orderby', 'title');
		return;
	}
}
add_action( 'pre_get_posts', 'wpex_order_category', 1 );


function current_year_shortcode() {
    return date('Y');
}
add_shortcode('current_year', 'current_year_shortcode');


// Function to change the "From" name
function custom_wp_mail_from_name($original_email_from) {
    return 'Airport VIP Services';
}
add_filter('wp_mail_from_name', 'custom_wp_mail_from_name');


// Disable the "Password Changed" email.
// add_filter( 'send_password_change_email', '__return_false' );
 

// Add button to WooCommerce order listing page
//add_action('admin_footer', 'custom_add_reports_button_to_orders_page');


function custom_add_reports_button_to_orders_page() {
    global $post_type, $pagenow;

    // Check if we are on the WooCommerce orders page
    if ($pagenow === 'edit.php' && $post_type === 'shop_order') {
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                var reportsUrl = '<?php echo admin_url('admin.php?page=wc-reports'); ?>';
                var buttonHtml = '<a href="' + reportsUrl + '" class="button button-primary">View Reports</a>';
                $('.wrap .page-title-action').after(buttonHtml);
            });
        </script>
        <?php
    }
}


function custom_departure_arrival_validation($result, $tag) {
    $name = $tag['name'];
    $departure = isset($_POST['departurestation']) ? sanitize_text_field($_POST['departurestation']) : '';
    $arrival = isset($_POST['arrivalstation']) ? sanitize_text_field($_POST['arrivalstation']) : ''; 

    if ($name == 'departurestation' || $name == 'arrivalstation') {
        if ($departure == $arrival && !empty($departure) && !empty($arrival)) {
            $result->invalidate($tag, "Station of Departure and Station of Arrival cannot be the same.");
        }
    }

    $airdeparture = isset($_POST['airports']) ? sanitize_text_field($_POST['airports']) : '';
    $arrivalairports = isset($_POST['arrivalairports']) ? sanitize_text_field($_POST['arrivalairports']) : '';


    if ($name == 'airports' || $name == 'arrivalairports') {
        if ($airdeparture == $arrivalairports && !empty($airdeparture) && !empty($arrivalairports)) {
            $result->invalidate($tag, "Departs and Arrives cannot be the same.");
        }
    }

    return $result;
}

add_filter('wpcf7_validate_select', 'custom_departure_arrival_validation', 10, 2);
add_filter('wpcf7_validate_select*', 'custom_departure_arrival_validation', 10, 2);


/* hide the Reports menu under woocommerce Menu*/
function remove_woocommerce_reports_menu_for_all_users() {
    remove_submenu_page('woocommerce', 'wc-reports');
}
 add_action('admin_menu', 'remove_woocommerce_reports_menu_for_all_users', 999);
 

add_action('admin_notices', 'display_total_booking_amount_notice');
function display_total_booking_amount_notice() {
    global $pagenow;

    // Pages where the gross total should not be displayed
    $excluded_pages = [
        'export-bookings-to-csv',
        'wc_bookings_product_templates',
        'create_booking',
        'booking_notification',
        'booking_calendar',
        'wc_bookings_settings'
    ];

    // Check if we are on the WooCommerce Bookings listing page and not on one of the excluded pages
    if ($pagenow == 'edit.php' && isset($_GET['post_type']) && $_GET['post_type'] == 'wc_booking' && 
        (!isset($_GET['page']) || !in_array($_GET['page'], $excluded_pages))) {
        // Display the total booking amount notice with an icon
        $total_amount = calculate_total_booking_amount();
        echo '<div class="notice notice-success is-dismissible booking-total-notice">';
        echo '<p><i class="fas fa-dollar-sign" style="color: #3c763d;"></i> <strong>' . __('Gross Sales: ', 'textdomain') . wc_price($total_amount) . '</strong></p>';
        echo '</div>';
    }
}

 
 
// Function to calculate the total booking amount including tax based on the selected month and year
function calculate_total_booking_amount() {
    global $wpdb;

    // Define all possible post statuses
    $all_post_statuses = ['unpaid', 'paid', 'complete', 'cancelled', 'in-cart', 'confirmed', 'pending-confirmation'];

    // Default post statuses to use when no filter is applied
    $default_post_statuses = $all_post_statuses; 
    
    // Check if a month filter is applied
    $post_statuses_placeholder = '';
    $start_date = '';
    $end_date = '';

    if (isset($_GET['m']) && !empty($_GET['m'])) {
        $month_year = intval($_GET['m']);
        $year = substr($month_year, 0, 4);
        $month = substr($month_year, 4, 2);

        $start_date = "$year-$month-01 00:00:00";
        $end_date = date('Y-m-t 23:59:59', strtotime($start_date)); // Get the last date of the month
    }

    // Determine the post statuses to include in the query based on filters
    if (isset($_GET['post_status']) && !empty($_GET['post_status'])) {
        $post_status = sanitize_text_field($_GET['post_status']);
        if ($post_status === 'all') {
            $post_statuses_placeholder = "'" . implode("','", $all_post_statuses) . "'";
        } elseif (in_array($post_status, $all_post_statuses)) {
            $post_statuses_placeholder = "'$post_status'";
        } else {
            // Default to all statuses if an invalid status is provided
            $post_statuses_placeholder = "'" . implode("','", $default_post_statuses) . "'";
        }
    } else {
        $post_statuses_placeholder = "'" . implode("','", $default_post_statuses) . "'";
    }

    // Query to get total booking amount for the filtered month and status including tax from _order_total
    $query = "
        SELECT SUM(order_meta.meta_value)
        FROM {$wpdb->prefix}posts AS booking_posts
        LEFT JOIN {$wpdb->prefix}postmeta AS booking_meta ON booking_posts.ID = booking_meta.post_id
        LEFT JOIN {$wpdb->prefix}woocommerce_order_items AS order_items ON booking_meta.meta_value = order_items.order_item_id
        LEFT JOIN {$wpdb->prefix}posts AS order_posts ON order_items.order_id = order_posts.ID
        LEFT JOIN {$wpdb->prefix}postmeta AS order_meta ON order_posts.ID = order_meta.post_id AND order_meta.meta_key = '_order_total'
        WHERE booking_posts.post_type = 'wc_booking'
        AND booking_posts.post_status IN ($post_statuses_placeholder)
        AND booking_meta.meta_key = '_booking_order_item_id'
    ";

    // Add date filter if month filter is applied
    if (!empty($start_date) && !empty($end_date)) {
        $query .= $wpdb->prepare(" AND booking_posts.post_date BETWEEN %s AND %s", $start_date, $end_date);
    }

    $total_amount = $wpdb->get_var($query);

    return $total_amount ? $total_amount : 0;
}



// Function to calculate the total booking amount Without tax based on the selected month and year 
// function calculate_total_booking_amount() {
//     global $wpdb;

//     // Define all possible post statuses
//     $all_post_statuses = ['unpaid', 'paid', 'complete', 'cancelled', 'in-cart', 'confirmed', 'pending-confirmation'];

//     // Check if a month filter is applied
//     if (isset($_GET['m']) && !empty($_GET['m'])) {
//         $month_year = intval($_GET['m']);
//         $year = substr($month_year, 0, 4);
//         $month = substr($month_year, 4, 2);

//         $start_date = "$year-$month-01 00:00:00";
//         $end_date = date('Y-m-t 23:59:59', strtotime($start_date)); // Get the last date of the month

//         // Determine the post statuses to include in the query based on filters
//         if (isset($_GET['post_status']) && !empty($_GET['post_status'])) {
//             $post_status = sanitize_text_field($_GET['post_status']);
//             if ($post_status === 'all') {
//                 $post_statuses_placeholder = "'" . implode("','", $all_post_statuses) . "'";
//             } elseif (in_array($post_status, $all_post_statuses)) {
//                 $post_statuses_placeholder = "'$post_status'";
//             } else {
//                 // Default to all statuses if an invalid status is provided
//                 $post_statuses_placeholder = "'" . implode("','", $all_post_statuses) . "'";
//             }
//         }

//         // Query to get total booking amount for the filtered month and status
//         $total_amount = $wpdb->get_var($wpdb->prepare(
//             "
//             SELECT SUM(meta.meta_value)
//             FROM {$wpdb->prefix}posts AS posts
//             LEFT JOIN {$wpdb->prefix}postmeta AS meta ON posts.ID = meta.post_id
//             WHERE posts.post_type = 'wc_booking'
//             AND posts.post_status IN ($post_statuses_placeholder)
//             AND meta.meta_key = '_booking_cost'
//             AND posts.post_date BETWEEN %s AND %s
//             ", 
//             $start_date, 
//             $end_date
//         ));

//         return $total_amount;
//     } else {
//         // If no month filter is applied but post status filter is present
//         if (isset($_GET['post_status']) && !empty($_GET['post_status'])) {
//             $post_status = sanitize_text_field($_GET['post_status']);
//             if (in_array($post_status, $all_post_statuses)) {
//                 $post_statuses_placeholder = "'$post_status'";
//             } else {
//                 // Default to all statuses if an invalid status is provided
//                 $post_statuses_placeholder = "'" . implode("','", $all_post_statuses) . "'";
//             }
//         } else {
//             $post_statuses_placeholder = "'" . implode("','", $all_post_statuses) . "'";
//         }
          
//         // Query to get total booking amount for all bookings when no month filter is applied
//         $total_amount = $wpdb->get_var(
//             "
//             SELECT SUM(meta.meta_value)
//             FROM {$wpdb->prefix}posts AS posts
//             LEFT JOIN {$wpdb->prefix}postmeta AS meta ON posts.ID = meta.post_id
//             WHERE posts.post_type = 'wc_booking'
//             AND posts.post_status IN ($post_statuses_placeholder)
//             AND meta.meta_key = '_booking_cost'
//             "
//         ); 
//         return $total_amount;
//     }
// } 

add_filter('woocommerce_gateway_title', 'change_gateway_title', 10, 2);

function change_gateway_title($title, $id) {
    if ($id === 'wc-bookings-gateway') {
        $title = 'Bookings';
    }
    return $title;
}
// Remove the "Order Again" button from the order received (thank you) page
remove_action( 'woocommerce_order_details_after_order_table', 'woocommerce_order_again_button' );

function kbnt_my_account_orders( $args ) {
    $args['posts_per_page'] = 10; // add number or -1 (display all orderes per page)
    return $args;
}
add_filter( 'woocommerce_my_account_my_orders_query', 'kbnt_my_account_orders', 10, 1 );

/*
 * Disable User Notification of Password Change Confirmation
 */
// add_filter( 'send_email_change_email', '__return_false' );


 

add_action('wp_enqueue_scripts', 'enqueue_custom_script_based_on_product');

function enqueue_custom_script_based_on_product() {
    global $post;

    // Check if we are on a single product page
    if (is_product() && isset($post->post_name)) {
        // Get the product slug
        $product_slug = $post->post_name;

        // Define product slugs where the first script should be loaded
        $product_slugs = array( 
            'heathrow-arrival-bronze',
            'heathrow-arrival-silver',
            'heathrow-arrival-gold',
            'heathrow-arrival-vip-lounge', 
        );

        // Define product slugs where the second script should be loaded
        $product_slugs1 = array( 
            'heathrow-departure-bronze',
            'heathrow-departure-silver',
            'heathrow-departure-gold',
            'heathrow-departure-vip-lounge',  
            'heathrow-transit-bronze',
            'heathrow-transit-silver',
            'heathrow-transit-gold', 
            'heathrow-transit-vip-lounge',
        );

        // Enqueue the first script if the product slug matches
        if (in_array($product_slug, $product_slugs)) {
            wp_enqueue_script(
                'custom-validation',
                get_stylesheet_directory_uri() . '/assets/js/custom-validation.js',
                array('jquery'),
                null,
                true
            );
            wp_localize_script('custom-validation', 'myAjax', array(
                'ajax_url' => admin_url('admin-ajax.php')
            ));
        }

        // Enqueue the second script if the product slug matches
        if (in_array($product_slug, $product_slugs1)) {
            wp_enqueue_script(
                'custom-validation-start-end',
                get_stylesheet_directory_uri() . '/assets/js/custom-validation-start-end.js',
                array('jquery'),
                null,
                true
            );
            wp_localize_script('custom-validation-start-end', 'myAjax', array(
                'ajax_url' => admin_url('admin-ajax.php')
            ));
        }
    }
}

 

add_action('send_email_change_email', 'my_custom_email_change_notification', 10, 3);

function my_custom_email_change_notification( $email_change_email, $user, $userdata ) {
     $to = $user['user_email'];
    $subject = 'Email Change Notification';
    $headers = array('Content-Type: text/html; charset=UTF-8');
    
    // Load the template
    ob_start();
    include get_stylesheet_directory() . '/email-template.php';
    $message = ob_get_clean();
     
    // Replace placeholders with dynamic data
    $message = str_replace( '###USERNAME###', $user['user_login'], $message);
    $message = str_replace( '###ADMIN_EMAIL###', get_option( 'admin_email' ), $message);
    $message = str_replace( '###NEW_EMAIL###', $userdata['user_email'], $message);
    $message = str_replace( '###EMAIL###', $user['user_email'], $message);
    $message = str_replace( '###SITENAME###', $blog_name, $message);
    $message = str_replace( '###SITEURL###', home_url(), $message);
     
    // Send the email
    wp_mail($to, $subject, $message, $headers);
}

add_action('send_password_change_email', 'my_custom_password_change_notification', 10, 3);

function my_custom_password_change_notification( $email_change_email, $user, $userdata ) {
     $to = $user['user_email'];
    $subject = 'Password Change Notification';
    $headers = array('Content-Type: text/html; charset=UTF-8');
    
    // Load the template
    ob_start();
    include get_stylesheet_directory() . '/email-template-password.php';
    $mess = ob_get_clean();
     
    // Replace placeholders with dynamic data
    $mess = str_replace( '###USERNAME###', $user['user_login'], $mess);
    $mess = str_replace( '###ADMIN_EMAIL###', get_option( 'admin_email' ), $mess);
    $mess = str_replace( '###NEW_EMAIL###', $userdata['user_email'], $mess);
    $mess = str_replace( '###EMAIL###', $user['user_email'], $mess);
    $mess = str_replace( '###SITENAME###', $blog_name, $mess);
    $mess = str_replace( '###SITEURL###', home_url(), $mess);
     
    // Send the email
    wp_mail($to, $subject, $mess, $headers);
}


/* Pay By Invoice Payment Method */


 // Enqueue custom JavaScript for AJAX validation
add_action('wp_enqueue_scripts', 'enqueue_cod_validation_script');
function enqueue_cod_validation_script() {
    if (is_checkout()) {
        wp_enqueue_script('cod-validation', get_stylesheet_directory_uri() . '/assets/js/cod-validation.js', array('jquery'), null, false);
        wp_localize_script('cod-validation', 'cod_validation_params', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('cod_validation_nonce'),
        ));
    }
}   
 

function enqueue_admin_validation_assets($hook) {
      if ('woocommerce_page_wc-settings' === $hook && isset($_GET['tab']) && 'checkout' === $_GET['tab'] && isset($_GET['section']) && 'cod' === $_GET['section']) {
        // Enqueue the JavaScript file
        wp_enqueue_script('admin-validation', get_stylesheet_directory_uri() . '/assets/js/admin-validation.js', array('jquery'), null, true);
        
        // Enqueue the CSS file
        wp_enqueue_style('admin-validation-style', get_stylesheet_directory_uri() . '/assets/css/admin-validation.css');
    }
}
add_action('admin_enqueue_scripts', 'enqueue_admin_validation_assets');
 

add_filter('woocommerce_gateway_title', 'custom_cod_title', 10, 2);
function custom_cod_title($title, $id) {
    if ('cod' === $id) {
        $title = 'Invoice Payment (Pay By Invoice)';
    }
    return $title;
}

// Add a custom setting field to the WooCommerce settings
add_filter('woocommerce_get_settings_checkout', 'custom_cod_settings', 10, 2);
function custom_cod_settings($settings, $current_section) {
  //  print_r($current_section); 
    if ('cod' === $current_section) {
        $settings[] = array(
            'title'    => __('Pay By Invoice Code', 'woocommerce'),
            'desc'     => __('Enter the code required for Pay By Invoice payment validation.', 'woocommerce'),
            'id'       => 'woocommerce_cod_validation_code',
            'type'     => 'text',
            'desc_tip' => true,
            'placeholder'  => 'Pay By Invoice Code',
            'default'  => '',

        );
    }
    return $settings;
}

// Save the custom setting
add_action('woocommerce_update_options_checkout', 'save_cod_validation_code');
function save_cod_validation_code() {
    $cod_code = isset($_POST['woocommerce_cod_validation_code']) ? sanitize_text_field($_POST['woocommerce_cod_validation_code']) : '';
    update_option('woocommerce_cod_validation_code', $cod_code);
}
 

// Handle AJAX request for COD code validation
add_action('wp_ajax_validate_cod_code', 'validate_cod_code');
add_action('wp_ajax_nopriv_validate_cod_code', 'validate_cod_code');
function validate_cod_code() {
    // Verify the nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'cod_validation_nonce')) {
        wp_send_json_error(array('message' => 'Invalid request.'));
    }

    $entered_code = isset($_POST['cod_validation_code']) ? sanitize_text_field($_POST['cod_validation_code']) : '';
    $admin_code = get_option('woocommerce_cod_validation_code', '');
    //echo $admin_code; die('dd');
    if ($entered_code === $admin_code) {
        wp_send_json_success();
    } else {
        wp_send_json_error(array('message' => 'Please enter the valid Invoice code.'));
    }
}


// Validate COD code after checkout fields are validated
add_action('woocommerce_after_checkout_validation', 'validate_cod_code_field', 10, 2);
function validate_cod_code_field($fields, $errors) {
    if (isset($_POST['payment_method']) && 'cod' === $_POST['payment_method']) {
        $entered_code = isset($_POST['cod_validation_code']) ? sanitize_text_field($_POST['cod_validation_code']) : '';
        $admin_code = get_option('woocommerce_cod_validation_code', '');

        if ($entered_code !== $admin_code) {
            $errors->add('validation', __('Please enter the valid (Pay By Invoice) code.', 'woocommerce'));
        }
    } 
}


add_action( 'woocommerce_thankyou', 'woocommerce_thankyou_change_order_status', 10, 1 );
function woocommerce_thankyou_change_order_status( $order_id ) {
    if ( ! $order_id ) return;

    $order = wc_get_order( $order_id );
    if (!$order) return;
    
 /********** Woocommerce Thank you hook to add google tracking code************/
  
    if ( $order->get_status() == 'pending' ) {

        // Get the WooCommerce mailer
        $mailer = WC()->mailer();
        
        // Get the "New Order" email instance
        $new_order_email = $mailer->emails['WC_Email_New_Order'];

        // Trigger the new order email
        $new_order_email->trigger( $order_id );
    }
}
/*
add_action('wp_footer', 'add_enhanced_conversion_data_to_datalayer');
function add_enhanced_conversion_data_to_datalayer() {
    if (!is_order_received_page()) return;

    $order_id  = absint(get_query_var('order-received'));
    $order     = wc_get_order($order_id);

    if (!$order) return;

    $billing_email     = $order->get_billing_email();
    $billing_phone     = $order->get_billing_phone();
    $billing_firstname = $order->get_billing_first_name();
    $billing_lastname  = $order->get_billing_last_name();
    
    $phone_digits = preg_replace('/\D+/', '', $billing_phone);
    $country_phone_prefix = WC()->countries->get_country_calling_code($billing_country);
    $phone_e164 = $country_phone_prefix . $phone_digits;
    ?>

    <script>
    window.dataLayer = window.dataLayer || [];
    dataLayer.push({
        'event': 'enhanced_conversion_data',
        'enhanced_conversion_data': {
            "email": "<?php echo esc_js($billing_email); ?>",
            "phone_number": "<?php echo esc_js($phone_e164); ?>",
            "first_name": "<?php echo esc_js($billing_firstname); ?>",
            "last_name": "<?php echo esc_js($billing_lastname); ?>"
        }
    });
    </script>
    <?php
} */

add_action( 'wp_footer', 'custom_woocommerce_thankyou_tracking_script' );
function custom_woocommerce_thankyou_tracking_script() {
    if ( ! is_order_received_page() ) return;

    $order_id = get_query_var( 'order-received' );
    if ( ! $order_id || is_wc_endpoint_url( 'order-received' ) === false ) return;

    $order = wc_get_order( $order_id );
    if ( ! $order ) return;

    // Billing data
    $billing_email    = esc_js( $order->get_billing_email() );
    $billing_phone    = esc_js( $order->get_billing_phone() );
    $billing_country  = esc_js( $order->get_billing_country() );

    // Clean phone number
    $phone_digits = preg_replace( '/\D+/', '', $billing_phone );
    $country_phone_prefix = WC()->countries->get_country_calling_code( $billing_country );
    $phone_e164 = $country_phone_prefix . $phone_digits;

    // Order-level data
    $currency     = esc_js( $order->get_currency() );
    $total        = floatval( $order->get_total() );
    $tax          = floatval( $order->get_total_tax() );
    $shipping     = floatval( $order->get_shipping_total() );
    $coupon_codes = implode( ', ', $order->get_coupon_codes() );

    // Products
    $items = [];
    foreach ( $order->get_items() as $item_id => $item ) {
        $product = $item->get_product();
        if ( ! $product ) continue;

        $items[] = [
            'item_id'                 => $product->get_id(),
            'item_name'               => $product->get_name(),
            'sku'                     => $product->get_sku() ?: $product->get_id(),
            'price'                   => floatval( $product->get_price() ),
            'stocklevel'              => null,
            'stockstatus'             => $product->is_in_stock() ? 'instock' : 'outofstock',
            'google_business_vertical'=> 'retail',
            'item_category'           => wp_strip_all_tags( $product->get_categories( ', ', '', '' ) ),
            'id'                      => $product->get_id(),
            'quantity'                => $item->get_quantity()
        ];
    }

    // Output the full structure
    ?>
    <script>
    window.dataLayer = window.dataLayer || [];
    dataLayer.push({
        "event": "purchase",
        "ecommerce": {
            "currency": "<?php echo $currency; ?>",
            "transaction_id": "<?php echo $order_id; ?>",
            "affiliation": "",
            "value": <?php echo $total; ?>,
            "tax": <?php echo $tax; ?>,
            "shipping": <?php echo $shipping; ?>,
            "coupon": "<?php echo esc_js( $coupon_codes ); ?>",
            "items": <?php echo json_encode( $items ); ?>
        },
        "enhanced_conversion_data": {
            "email": "<?php echo $billing_email; ?>",
            "phone_number": "<?php echo $phone_e164; ?>"
        },
        "gtm.uniqueEventId": <?php echo rand(100, 999); ?>
    });
    </script>
    <?php
}



/***************************************/
/*    New Functionality start here     */
/***************************************/
  //////////// First Point Number of Bags Field start here  /////////////
/**
 * Custom numeric-only text field on product page (Number of Bags).
 *
 * Field name: number-of-bags. jQuery validation and message in a separate JS file.
 */
add_action( 'woocommerce_before_add_to_cart_button', 'hvip_render_number_of_bags_field', 20 );
function hvip_render_number_of_bags_field() {
	if ( ! is_product() ) {
		return;
	}

	$value = '';
	if ( isset( $_POST['number-of-bags'] ) ) {
		$value = wc_clean( wp_unslash( $_POST['number-of-bags'] ) );
	}

	// Match Woo Product Add-Ons markup so existing theme CSS applies (label + wrap + grid-area).
	// Theme CSS targets:
	// - `.wc-pao-addon-number-of-bags` (grid-area)
	// - `label.wc-pao-addon-name`
	// - `p.form-row.form-row-wide.wc-pao-addon-wrap`
	echo '<div class="wc-pao-addon wc-pao-addon-number-of-bags hvip-number-of-bags-field">';
	echo '<label class="wc-pao-addon-name" for="number-of-bags" data-addon-name="Number of bags">' . esc_html__( 'Number of Bags', 'heathrowvip' ) . ' <span class="required">*</span></label>';
	echo '<p class="form-row form-row-wide wc-pao-addon-wrap">';
	echo '<input type="text" class="input-text" id="number-of-bags" name="number-of-bags" value="' . esc_attr( $value ) . '" inputmode="numeric" required disabled="disabled" aria-disabled="true" />';
	echo '</p>';
	echo '<span class="hvip-number-of-bags-error" role="alert" style="display:none;color:#e2401c;"></span>';
	echo '</div>';
}

add_action( 'woocommerce_before_add_to_cart_button', 'hvip_render_fast_track_field', 21 );
function hvip_fast_track_is_supported_product( $product_id = 0 ) {
	$product_id = absint( $product_id );
	if ( ! $product_id ) {
		global $post;
		if ( $post && ! empty( $post->ID ) ) {
			$product_id = (int) $post->ID;
		}
	}

	if ( ! $product_id ) {
		return false;
	}

	$slug = (string) get_post_field( 'post_name', $product_id );
	$slug = sanitize_title( $slug );

	if ( false !== strpos( $slug, 'arrival' ) ) {
		return true;
	}
	if ( false !== strpos( $slug, 'departure' ) ) {
		return true;
	}

	return false;
}

function hvip_render_fast_track_field() {
	if ( ! is_product() ) {
		return;
	}
	if ( ! hvip_fast_track_is_supported_product() ) {
		return;
	}

	$enabled  = ! empty( $_POST['hvip_fast_track_enabled'] ) ? 'yes' : 'no';
	$quantity = isset( $_POST['hvip_fast_track_quantity'] ) ? intval( $_POST['hvip_fast_track_quantity'] ) : 1;
	$quantity = max( 1, min( 10, $quantity ) );

	echo '<div class="wc-pao-addon wc-pao-addon-fast-track hvip-fast-track-field">';
	echo '<label class="wc-pao-addon-name hvip-fast-track-label" for="hvip-fast-track-enabled">';
	echo '<input type="checkbox" id="hvip-fast-track-enabled" name="hvip_fast_track_enabled" value="yes" ' . checked( 'yes', $enabled, false ) . ' />';
	echo ' ' . esc_html__( 'Add Fast Track', 'heathrowvip' );
	echo '</label>';

	echo '<p class="form-row form-row-wide wc-pao-addon-wrap hvip-fast-track-qty-wrap" id="hvip-fast-track-qty-wrap" style="' . ( 'yes' === $enabled ? '' : 'display:none;' ) . '">';
	echo '<label class="wc-pao-addon-name" for="hvip-fast-track-quantity">' . esc_html__( 'Fast Track quantity', 'heathrowvip' ) . '</label> ';
	echo '<select id="hvip-fast-track-quantity" name="hvip_fast_track_quantity">';
	for ( $i = 1; $i <= 10; $i++ ) {
		echo '<option value="' . esc_attr( (string) $i ) . '" ' . selected( $quantity, $i, false ) . '>' . esc_html( (string) $i ) . '</option>';
	}
	echo '</select>';
	echo '</p>';

	echo '<p class="hvip-fast-track-help">';
	echo '<a href="#" id="hvip-fast-track-check-link">' . esc_html__( 'Check if Fast Track is included', 'heathrowvip' ) . '</a>';
	echo '</p>';
	echo '<style>
	.hvip-fast-track-field {
		grid-column: 1 / -1 !important;
		width: 100% !important;
		max-width: 100% !important;
	}
	.hvip-fast-track-field .hvip-fast-track-help {
		margin: 8px 0 10px;
	}
	.hvip-fast-track-field #hvip-fast-track-check-link {
		font-size: 24px;
		line-height: 1.2;
		color: #0d7fa6;
		font-weight: 400;
		text-decoration: underline;
	}
	.hvip-fast-track-field .hvip-fast-track-info-box {
		width: 100%;
		max-width: 100%;
		box-sizing: border-box;
		display: block;
		float: none;
		clear: both;
		border: 1px solid #2f5f9e;
		background: #eaf2ff;
		color: #0f2d52;
		font-size: 15px;
		font-style: italic;
		line-height: 1.55;
		padding: 20px 24px;
		margin: 0 0 14px;
	}
	@media (max-width: 1024px) {
		.hvip-fast-track-field #hvip-fast-track-check-link {
			font-size: 20px;
		}
		.hvip-fast-track-field .hvip-fast-track-info-box {
			font-size: 14px;
			padding: 16px 18px;
		}
	}
	@media (max-width: 767px) {
		.hvip-fast-track-field #hvip-fast-track-check-link {
			font-size: 18px;
		}
		.hvip-fast-track-field .hvip-fast-track-info-box {
			font-size: 13px;
			padding: 12px 14px;
		}
	}
	</style>';
	echo '<div class="hvip-fast-track-info-box">';
	echo esc_html__( 'Please check with your airline to confirm whether Fast Track is included in your ticket. If it is not included, you may book Fast Track using this option.', 'heathrowvip' );
	echo '</div>';

	wp_nonce_field( 'hvip_fast_track_nonce_action', 'hvip_fast_track_nonce' );

	echo '</div>';

	$popup_content = get_option( 'hvip_fast_track_popup_content', '' );
	echo '<div id="hvip-fast-track-modal" class="hvip-fast-track-modal" style="display:none;" aria-hidden="true">';
	echo '<div class="hvip-fast-track-modal__overlay"></div>';
	echo '<div class="hvip-fast-track-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="hvip-fast-track-modal-title">';
	echo '<button type="button" class="hvip-fast-track-modal__close" id="hvip-fast-track-modal-close" aria-label="' . esc_attr__( 'Close', 'heathrowvip' ) . '">&times;</button>';
	echo '<h3 id="hvip-fast-track-modal-title">' . esc_html__( 'Fast Track Information', 'heathrowvip' ) . '</h3>';
	echo '<div class="hvip-fast-track-modal__content">';
	echo wp_kses_post( $popup_content );
	echo '</div>';
	echo '</div>';
	echo '</div>';
}

add_filter( 'woocommerce_add_to_cart_validation', 'hvip_validate_number_of_bags_field', 10, 3 );
function hvip_validate_number_of_bags_field( $passed, $product_id, $quantity ) {
	if ( ! isset( $_POST['number-of-bags'] ) ) {
		return $passed;
	}

	$value = wc_clean( wp_unslash( $_POST['number-of-bags'] ) );

	// Required field.
	if ( '' === $value ) {
		wc_add_notice( __( 'Please enter numbers only.', 'heathrowvip' ), 'error' );
		return false;
	}

	if ( ! preg_match( '/^\d+$/', $value ) ) {
		wc_add_notice( __( 'Please enter numbers only.', 'heathrowvip' ), 'error' );
		return false;
	}

	return $passed;
}

add_filter( 'woocommerce_add_to_cart_validation', 'hvip_validate_fast_track_fields', 11, 3 );
function hvip_validate_fast_track_fields( $passed, $product_id, $quantity ) {
	$has_fast_track_fields = isset( $_POST['hvip_fast_track_enabled'] ) || isset( $_POST['hvip_fast_track_quantity'] ) || isset( $_POST['hvip_fast_track_nonce'] );
	if ( ! $has_fast_track_fields ) {
		return $passed;
	}
	if ( ! hvip_fast_track_is_supported_product( $product_id ) ) {
		return $passed;
	}

	$nonce = isset( $_POST['hvip_fast_track_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['hvip_fast_track_nonce'] ) ) : '';
	if ( empty( $nonce ) || ! wp_verify_nonce( $nonce, 'hvip_fast_track_nonce_action' ) ) {
		wc_add_notice( __( 'Security check failed. Please try again.', 'heathrowvip' ), 'error' );
		return false;
	}

	$enabled = isset( $_POST['hvip_fast_track_enabled'] ) ? sanitize_text_field( wp_unslash( $_POST['hvip_fast_track_enabled'] ) ) : 'no';
	$enabled = ( 'yes' === $enabled ) ? 'yes' : 'no';

	if ( 'yes' !== $enabled ) {
		return $passed;
	}

	$qty_raw   = isset( $_POST['hvip_fast_track_quantity'] ) ? sanitize_text_field( wp_unslash( $_POST['hvip_fast_track_quantity'] ) ) : '1';
	$qty       = intval( $qty_raw );
	$is_in_set = in_array( $qty, range( 1, 10 ), true );
	if ( ! $is_in_set ) {
		wc_add_notice( __( 'Please choose a valid Fast Track quantity (1-10).', 'heathrowvip' ), 'error' );
		return false;
	}

	return $passed;
}

add_action( 'wp_enqueue_scripts', 'hvip_enqueue_number_of_bags_validation_script', 25 );
function hvip_enqueue_number_of_bags_validation_script() {
	if ( ! is_product() ) {
		return;
	}

	wp_enqueue_script(
		'hvip-number-of-bags-validation',
		get_stylesheet_directory_uri() . '/assets/js/number-of-bags-validation.js',
		array( 'jquery' ),
		file_exists( get_stylesheet_directory() . '/assets/js/number-of-bags-validation.js' ) ? filemtime( get_stylesheet_directory() . '/assets/js/number-of-bags-validation.js' ) : null,
		true
	);

	wp_localize_script( 'hvip-number-of-bags-validation', 'hvipNumberOfBagsValidation', array(
		'error_message' => __( 'Please enter numbers only.', 'heathrowvip' ),
	) );
}

/**
 * ----------------------------
 * Baggage pricing (custom)
 * ----------------------------
 *
 * Uses the `number-of-bags` field and applies:
 * - Bronze included: 4
 * - Silver included: 8
 * - Gold/VIP included: 10
 * Extra: £50 per 8 bags (or part thereof)
 */
function hvip_baggage_get_service_level_from_slug( $product_slug ) {
	$product_slug = sanitize_title( (string) $product_slug );

	if ( false !== strpos( $product_slug, 'bronze' ) ) {
		return 'bronze';
	}
	if ( false !== strpos( $product_slug, 'silver' ) ) {
		return 'silver';
	}
	if ( false !== strpos( $product_slug, 'vip' ) || false !== strpos( $product_slug, 'tarmac' ) ) {
		return 'vip';
	}
	if ( false !== strpos( $product_slug, 'gold' ) ) {
		return 'gold';
	}

	return 'unknown';
}

function hvip_baggage_is_vip_lounge_slug( $product_slug ) {
	$product_slug = sanitize_title( (string) $product_slug );
	return ( false !== strpos( $product_slug, 'vip-lounge' ) );
}

function hvip_baggage_included_limit( $service_level ) {
	switch ( (string) $service_level ) {
		case 'silver':
			return 8;
		case 'gold':
		case 'vip':
			return 10;
		case 'bronze':
		case 'unknown':
		default:
			return 4;
	}
}

function hvip_baggage_extra_fee( $bag_count, $service_level ) {
	$bag_count = absint( $bag_count );
	$included  = hvip_baggage_included_limit( $service_level );

	if ( $bag_count <= 0 || $bag_count <= $included ) {
		return 0.0;
	}

	$extra_bags = $bag_count - $included;
	$blocks     = (int) ceil( $extra_bags / 8 );

	return (float) ( 50 * $blocks );
}

add_filter( 'woocommerce_add_cart_item_data', 'hvip_baggage_add_cart_item_data', 10, 3 );
function hvip_baggage_add_cart_item_data( $cart_item_data, $product_id, $variation_id ) {
	if ( ! isset( $_POST['number-of-bags'] ) ) {
		return $cart_item_data;
	}

	$bags = absint( wc_clean( wp_unslash( $_POST['number-of-bags'] ) ) );
	if ( $bags < 1 ) {
		$bags = 1;
	}

	$product = wc_get_product( $variation_id ? $variation_id : $product_id );
	if ( ! $product ) {
		return $cart_item_data;
	}

	$slug          = get_post_field( 'post_name', $product_id );
	$service_level = hvip_baggage_get_service_level_from_slug( $slug );
	$is_vip_lounge = hvip_baggage_is_vip_lounge_slug( $slug );
	$included      = $is_vip_lounge ? $bags : hvip_baggage_included_limit( $service_level );
	$fee           = $is_vip_lounge ? 0.0 : hvip_baggage_extra_fee( $bags, $service_level );

	$cart_item_data['hvip_bags_count']     = $bags;
	$cart_item_data['hvip_bags_included']  = $included;
	$cart_item_data['hvip_bags_fee']       = (float) $fee;
	$cart_item_data['hvip_service_level']  = $service_level;
	$cart_item_data['hvip_is_vip_lounge']  = $is_vip_lounge ? 'yes' : 'no';
	// Base price for bookings is determined later (after Bookings calculates cost).
	$cart_item_data['hvip_base_price']     = null;
	$cart_item_data['hvip_base_price_set'] = false;

	// Prevent merging items with different bag count.
	$cart_item_data['unique_key'] = md5( microtime( true ) . wp_rand() );

	return $cart_item_data;
}

add_filter( 'woocommerce_add_cart_item_data', 'hvip_fast_track_add_cart_item_data', 11, 3 );
function hvip_fast_track_add_cart_item_data( $cart_item_data, $product_id, $variation_id ) {
	if ( ! hvip_fast_track_is_supported_product( $product_id ) ) {
		return $cart_item_data;
	}

	$nonce = isset( $_POST['hvip_fast_track_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['hvip_fast_track_nonce'] ) ) : '';
	if ( empty( $nonce ) || ! wp_verify_nonce( $nonce, 'hvip_fast_track_nonce_action' ) ) {
		return $cart_item_data;
	}

	$enabled = isset( $_POST['hvip_fast_track_enabled'] ) ? sanitize_text_field( wp_unslash( $_POST['hvip_fast_track_enabled'] ) ) : 'no';
	$enabled = ( 'yes' === $enabled ) ? 'yes' : 'no';

	$qty_raw = isset( $_POST['hvip_fast_track_quantity'] ) ? sanitize_text_field( wp_unslash( $_POST['hvip_fast_track_quantity'] ) ) : '1';
	$qty     = intval( $qty_raw );
	if ( $qty < 1 || $qty > 10 ) {
		$qty = 1;
	}

	$product = wc_get_product( $variation_id ? $variation_id : $product_id );
	if ( ! $product ) {
		return $cart_item_data;
	}

	$slug             = get_post_field( 'post_name', $product_id );
	$is_arrival       = ( false !== strpos( (string) $slug, 'arrival' ) );
	$per_person_price = $is_arrival ? 35 : 25;
	if ( 'yes' !== $enabled ) {
		$qty = 0;
	}
	$fast_track_total = ( 'yes' === $enabled ) ? ( $qty * $per_person_price ) : 0;

	$cart_item_data['hvip_fast_track_enabled']    = $enabled;
	$cart_item_data['hvip_fast_track_quantity']   = $qty;
	$cart_item_data['hvip_fast_track_total']      = (float) $fast_track_total;
	$cart_item_data['hvip_fast_track_price_each'] = (float) $per_person_price;

	// Ensure line item stays separate when Fast Track choice differs.
	$cart_item_data['unique_key'] = md5( microtime( true ) . wp_rand() );

	// Shared base-price lock used in before_calculate_totals.
	if ( ! isset( $cart_item_data['hvip_base_price'] ) ) {
		$cart_item_data['hvip_base_price']     = null;
		$cart_item_data['hvip_base_price_set'] = false;
	}

	return $cart_item_data;
}

add_action( 'woocommerce_before_calculate_totals', 'hvip_baggage_apply_price', 20, 1 );
function hvip_baggage_apply_price( $cart ) {
	if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
		return;
	}
	if ( ! $cart || ! is_a( $cart, 'WC_Cart' ) ) {
		return;
	}

	foreach ( $cart->get_cart() as $cart_item_key => $cart_item ) {
		if ( empty( $cart_item['data'] ) || ! is_a( $cart_item['data'], 'WC_Product' ) ) {
			continue;
		}
		$has_baggage    = isset( $cart_item['hvip_bags_count'] );
		$has_fast_track = isset( $cart_item['hvip_fast_track_enabled'] );
		if ( ! $has_baggage && ! $has_fast_track ) {
			continue;
		}

		// Lock the base price once, after Bookings has set the calculated cost.
		if ( empty( $cart_item['hvip_base_price_set'] ) ) {
			$cart_item['hvip_base_price']     = (float) $cart_item['data']->get_price( 'edit' );
			$cart_item['hvip_base_price_set'] = true;
			$cart->cart_contents[ $cart_item_key ] = $cart_item;
		}

		$base = isset( $cart_item['hvip_base_price'] ) && is_numeric( $cart_item['hvip_base_price'] )
			? (float) $cart_item['hvip_base_price']
			: (float) $cart_item['data']->get_price( 'edit' );
		$baggage_fee      = isset( $cart_item['hvip_bags_fee'] ) ? (float) $cart_item['hvip_bags_fee'] : 0.0;
		$fast_track_total = ( isset( $cart_item['hvip_fast_track_enabled'] ) && 'yes' === $cart_item['hvip_fast_track_enabled'] )
			? ( isset( $cart_item['hvip_fast_track_total'] ) ? (float) $cart_item['hvip_fast_track_total'] : 0.0 )
			: 0.0;

		$cart_item['data']->set_price( $base + $baggage_fee + $fast_track_total );
	}
}

add_filter( 'woocommerce_get_item_data', 'hvip_baggage_item_data', 10, 2 );
function hvip_baggage_item_data( $item_data, $cart_item ) {
	$has_baggage    = isset( $cart_item['hvip_bags_count'] );
	$has_fast_track = isset( $cart_item['hvip_fast_track_enabled'] );
	if ( ! $has_baggage && ! $has_fast_track ) {
		return $item_data;
	}

	if ( $has_baggage ) {
		$bags     = absint( $cart_item['hvip_bags_count'] );
		$included = isset( $cart_item['hvip_bags_included'] ) ? absint( $cart_item['hvip_bags_included'] ) : 0;
		$extra    = max( 0, $bags - $included );
		$fee      = isset( $cart_item['hvip_bags_fee'] ) ? (float) $cart_item['hvip_bags_fee'] : 0.0;

		$item_data[] = array(
			'key'   => __( 'Number of Bags', 'heathrowvip' ),
			'value' => (string) $bags,
		);
		$item_data[] = array(
			'key'   => __( 'Included bags', 'heathrowvip' ),
			'value' => (string) $included,
		);
		$item_data[] = array(
			'key'   => __( 'Extra bags', 'heathrowvip' ),
			'value' => (string) $extra,
		);
		$item_data[] = array(
			'key'   => __( 'Extra baggage fee', 'heathrowvip' ),
			'value' => $fee > 0 ? wc_price( $fee ) : __( 'Free', 'heathrowvip' ),
		);
	}

	if ( isset( $cart_item['hvip_fast_track_enabled'] ) ) {
		$enabled = sanitize_text_field( (string) $cart_item['hvip_fast_track_enabled'] );
		$qty     = isset( $cart_item['hvip_fast_track_quantity'] ) ? intval( $cart_item['hvip_fast_track_quantity'] ) : 0;
		$total   = isset( $cart_item['hvip_fast_track_total'] ) ? (float) $cart_item['hvip_fast_track_total'] : 0.0;

		$item_data[] = array(
			'key'   => __( 'Fast Track', 'heathrowvip' ),
			'value' => ( 'yes' === $enabled ) ? esc_html__( 'Yes', 'heathrowvip' ) : esc_html__( 'No', 'heathrowvip' ),
		);
		$item_data[] = array(
			'key'   => __( 'Quantity', 'heathrowvip' ),
			'value' => esc_html( (string) max( 0, $qty ) ),
		);
		$item_data[] = array(
			'key'   => __( 'Fast Track Cost', 'heathrowvip' ),
			'value' => wp_kses_post( wc_price( max( 0, $total ) ) ),
		);
	}

	return $item_data;
}

add_action( 'woocommerce_checkout_create_order_line_item', 'hvip_baggage_add_order_item_meta', 10, 4 );
function hvip_baggage_add_order_item_meta( $item, $cart_item_key, $values, $order ) {
	$has_baggage    = ! empty( $values['hvip_bags_count'] );
	$has_fast_track = isset( $values['hvip_fast_track_enabled'] );
	if ( ! $has_baggage && ! $has_fast_track ) {
		return;
	}

	if ( $has_baggage ) {
		$bags     = absint( $values['hvip_bags_count'] );
		$included = isset( $values['hvip_bags_included'] ) ? absint( $values['hvip_bags_included'] ) : 0;
		$extra    = max( 0, $bags - $included );
		$fee      = isset( $values['hvip_bags_fee'] ) ? (float) $values['hvip_bags_fee'] : 0.0;

		$item->add_meta_data( __( 'Number of Bags', 'heathrowvip' ), $bags, true );
		$item->add_meta_data( __( 'Included bags', 'heathrowvip' ), $included, true );
		$item->add_meta_data( __( 'Extra bags', 'heathrowvip' ), $extra, true );
		$item->add_meta_data( __( 'Extra baggage fee', 'heathrowvip' ), $fee > 0 ? wc_price( $fee ) : __( 'Free', 'heathrowvip' ), true );
	}

	if ( isset( $values['hvip_fast_track_enabled'] ) ) {
		$enabled = sanitize_text_field( (string) $values['hvip_fast_track_enabled'] );
		$qty     = isset( $values['hvip_fast_track_quantity'] ) ? intval( $values['hvip_fast_track_quantity'] ) : 0;
		$total   = isset( $values['hvip_fast_track_total'] ) ? (float) $values['hvip_fast_track_total'] : 0.0;

		$item->add_meta_data( __( 'Fast Track', 'heathrowvip' ), ( 'yes' === $enabled ) ? 'Yes' : 'No', true );
		$item->add_meta_data( __( 'Fast Track Quantity', 'heathrowvip' ), max( 0, $qty ), true );
		$item->add_meta_data( __( 'Fast Track Cost', 'heathrowvip' ), wc_price( $total ), true );
	}
}

add_action( 'admin_menu', 'hvip_fast_track_add_settings_page' );
function hvip_fast_track_add_settings_page() {
	add_options_page(
		__( 'Fast Track Popup', 'heathrowvip' ),
		__( 'Fast Track Popup', 'heathrowvip' ),
		'manage_options',
		'hvip-fast-track-popup',
		'hvip_fast_track_render_settings_page'
	);
}

function hvip_fast_track_render_settings_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	if ( isset( $_POST['hvip_fast_track_popup_save'] ) ) {
		check_admin_referer( 'hvip_fast_track_popup_save_action', 'hvip_fast_track_popup_nonce' );
		$posted_content = isset( $_POST['hvip_fast_track_popup_content'] ) ? wp_kses_post( wp_unslash( $_POST['hvip_fast_track_popup_content'] ) ) : '';
		update_option( 'hvip_fast_track_popup_content', $posted_content );
		echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Fast Track popup content updated.', 'heathrowvip' ) . '</p></div>';
	}
	?>
	<div class="wrap">
		<h1><?php echo esc_html__( 'Fast Track Popup Content', 'heathrowvip' ); ?></h1>
		<form method="post" action="">
			<?php wp_nonce_field( 'hvip_fast_track_popup_save_action', 'hvip_fast_track_popup_nonce' ); ?>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><?php echo esc_html__( 'Popup content', 'heathrowvip' ); ?></th>
					<td>
						<?php
						$content = get_option( 'hvip_fast_track_popup_content', '' );
						wp_editor(
							wp_kses_post( $content ),
							'hvip_fast_track_popup_content',
							array(
								'textarea_name' => 'hvip_fast_track_popup_content',
								'media_buttons' => false,
								'textarea_rows' => 10,
							)
						);
						?>
					</td>
				</tr>
			</table>
			<input type="hidden" name="hvip_fast_track_popup_save" value="1" />
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}

add_action( 'wp_enqueue_scripts', 'hvip_enqueue_fast_track_script', 27 );
function hvip_enqueue_fast_track_script() {
	if ( ! is_product() ) {
		return;
	}
	if ( ! hvip_fast_track_is_supported_product() ) {
		return;
	}

	wp_enqueue_script(
		'hvip-fast-track',
		get_stylesheet_directory_uri() . '/assets/js/fast-track.js',
		array( 'jquery' ),
		null,
		true
	);

	global $post;
	$is_arrival = false;
	if ( $post && ! empty( $post->post_name ) ) {
		$is_arrival = ( false !== strpos( (string) $post->post_name, 'arrival' ) );
	}

	wp_localize_script(
		'hvip-fast-track',
		'hvipFastTrackConfig',
		array(
			'is_arrival'      => $is_arrival ? 'yes' : 'no',
			'arrival_price'   => 35,
			'departure_price' => 25,
			'currency_sym'    => get_woocommerce_currency_symbol(),
			'decimal_sep'     => wc_get_price_decimal_separator(),
			'thousand_sep'    => wc_get_price_thousand_separator(),
			'decimals'        => wc_get_price_decimals(),
			'price_format'    => get_woocommerce_price_format(),
		)
	);
}

add_action( 'wp_enqueue_scripts', 'hvip_baggage_enqueue_pricing_js', 26 );
function hvip_baggage_enqueue_pricing_js() {
	if ( ! is_product() ) {
		return;
	}

	global $post;
	if ( ! $post || empty( $post->post_name ) ) {
		return;
	}

	$service_level = hvip_baggage_get_service_level_from_slug( $post->post_name );
	$is_vip_lounge = hvip_baggage_is_vip_lounge_slug( $post->post_name );
	$included      = hvip_baggage_included_limit( $service_level );
	$included_js   = $is_vip_lounge ? 999999 : $included;

	wp_enqueue_script(
		'hvip-number-of-bags-pricing',
		get_stylesheet_directory_uri() . '/assets/js/number-of-bags-pricing.js',
		array( 'jquery' ),
		null,
		true
	);

	wp_localize_script(
		'hvip-number-of-bags-pricing',
		'hvipNumberOfBagsPricing',
		array(
			'service_level' => $service_level,
			'included'      => $included_js,
			'is_vip_lounge' => $is_vip_lounge ? 'yes' : 'no',
			'fee_per_block' => 50,
			'block_size'    => 8,
			'currency_sym'  => get_woocommerce_currency_symbol(),
			'decimal_sep'   => wc_get_price_decimal_separator(),
			'thousand_sep'  => wc_get_price_thousand_separator(),
			'decimals'      => wc_get_price_decimals(),
			'price_format'  => get_woocommerce_price_format(),
			'free_text'     => __( 'Free', 'heathrowvip' ),
		)
	);
}

add_action( 'woocommerce_single_product_summary', 'hvip_baggage_gold_vip_note', 25 );
function hvip_baggage_gold_vip_note() {
	if ( ! is_product() ) {
		return;
	}

	global $post;
	if ( ! $post || empty( $post->post_name ) ) {
		return;
	}

	$service_level = hvip_baggage_get_service_level_from_slug( $post->post_name );
	if ( 'gold' !== $service_level && 'vip' !== $service_level ) {
		return;
	}

	echo '<style>
	.hvip-complimentary-car-note {
		position: relative;
		margin: 18px 0 14px;
		padding: 18px 68px 18px 24px;
		border: 1px solid #2f5f9e;
		background: #eaf2ff;
		color: #0f2d52;
		font-size: 16px;
		line-height: 1.45;
		font-weight: 400;
	}
	.hvip-complimentary-car-note__icon {
		position: absolute;
		right: 14px;
		top: 50%;
		transform: translateY(-50%);
		width: 42px;
		height: 42px;
		border-radius: 50%;
		background: #d9e7ff;
		color: #7d96bd;
		display: flex;
		align-items: center;
		justify-content: center;
		font-size: 30px;
		font-weight: 700;
		font-family: Georgia, serif;
	}
	@media (max-width: 767px) {
		.hvip-complimentary-car-note {
			font-size: 14px;
			padding: 14px 56px 14px 16px;
		}
		.hvip-complimentary-car-note__icon {
			width: 34px;
			height: 34px;
			font-size: 24px;
		}
	}
	</style>';

	echo '<div class="hvip-complimentary-car-note">';
	echo '<span class="hvip-complimentary-car-note__text">' . esc_html__( 'One complimentary car is included in this quote. If the number of people and bags exceed what we can fit in the car we will contact you to upgrade your car options.', 'heathrowvip' ) . '</span>';
	echo '<span class="hvip-complimentary-car-note__icon" aria-hidden="true">i</span>';
	echo '</div>';
}


  //////////// First Point Number of Bags Field end here  /////////////
