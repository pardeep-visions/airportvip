<?php

if ( ! defined( 'ABSPATH' ) ) {
    return;
}

if (!defined('CHAUFFEUR_REDIRECTION')) {
    define('CHAUFFEUR_REDIRECTION', 'woocommerce-bookings/product-chauffeur');
}

class ChauffeurBookingProduct
{
    public function __construct()
    {
        $this->register_chauffeur_settings();
        add_filter('product_type_options', array($this, 'add_product_type_options'), 10);
        add_action('woocommerce_process_product_meta', array($this, 'add_product_process_meta'), 1);
        add_action('woocommerce_before_add_to_cart_button', array($this, 'add_to_cart_button'), 35);

        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts') );
        add_action('wp_enqueue_scripts', array($this, 'enqueue_admin_scripts') );
        add_filter('woocommerce_add_to_cart_validation', array($this, 'add_to_cart_validation'), 20, 3);
        add_filter('woocommerce_rest_prepare_bookable_resource_object', array($this, 'add_meta_to_resource_response'), 20, 3);
        // add_filter('wc_bookings_get_time_slots_html', array($this, 'bookings_get_time_slots_html'), 20, 4);

        // Shortcode
        add_shortcode('chauffeur-service', array($this, 'shortcode') );
        add_filter('woocommerce_register_post_type_bookable_resource', array($this, 'add_support_to_bookable_resource'));
        add_filter('woocommerce_bookings_resource_additional_cost_string', array($this, 'change_additional_cost_string'), 20, 2);
        add_filter('woocommerce_bookings_calculated_booking_cost', array($this, 'calculate_booking_cost'), 10, 3);

        add_filter('wc_get_template', array($this, 'change_resource_template_file'), 11, 5);

        // Cart and order hooks
        add_filter('woocommerce_add_cart_item_data', array($this, 'add_cart_item'), 10, 3);
        add_filter('woocommerce_get_item_data', array($this, 'display_cart_items'), 10, 2);
        add_action('woocommerce_checkout_create_order_line_item', array($this, 'create_order_line_item'), 10, 4);
        add_action('woocommerce_before_calculate_totals', array($this, 'update_custom_price'), 10, 1);

        add_filter('woocommerce_add_to_cart_redirect', array($this, 'add_to_cart_redirect'));
    }

    public function update_custom_price($cart_object)
    {
        foreach ( $cart_object->cart_contents as $cart_item_key => $value ) {
            if (empty($value['distance_price'])) continue;
            $price = floatval($value['distance_price']);
            if (isset($value['new_price'])) {
                $price += floatval($value['new_price']);
            }
            if (isset($value['booking']['_cost'])) {
                $price += floatval($value['booking']['_cost']);
            }
            $value['data']->set_price($price);
        }
    }

    public function create_order_line_item($item, $cart_item_key, $values, $order)
    {
        if (!empty($values['distance'])) {
            $item->add_meta_data(
                __('Distance', 'woocommerce'),
                wc_clean(number_format(floatval($values['distance']) / 1609.344)) . ' miles',
                true
            );
        }
        if (!empty($values['distance_price'])) {
            $item->add_meta_data(
                __('Duration Price', 'woocommerce'),
                wc_price(floatval($values['booking']['_cost'])),
                true
            );

            $item->add_meta_data(
                __('Distance Price', 'woocommerce'),
                wc_price(floatval($values['distance_price'])),
                true
            );
        }
        if (!empty($values['fromAddress'])) {
            $item->add_meta_data(
                __('From Address', 'woocommerce'),
                $values['fromAddress'],
                true
            );
        }
        if (!empty($values['toAddress'])) {
            $item->add_meta_data(
                __('To Address', 'toAddress'),
                $values['toAddress'],
                true
            );
        }
    }

    public function display_cart_items($item_data, $cart_item)
    {
        if (!empty($cart_item['distance']) && !empty($cart_item['distance_price'])) {
            $item_data[] = array(
                'key' => __('Duration Price', 'woocommerce'),
                'value' => wc_clean(wc_price($cart_item['booking']['_cost'])),
                'display' => '',
            );
            $item_data[] = array(
                'key' => __('Distance Price', 'woocommerce'),
                'value' => wc_clean(wc_price($cart_item['distance_price'])),
                'display' => '',
            );
        }
        if (!empty($cart_item['fromAddress'])) {
            $item_data[] = array(
                'key' => __('From Address', 'woocommerce'),
                'value' => $cart_item['fromAddress'],
                'display' => '',
            );
        }
        if (!empty($cart_item['toAddress'])) {
            $item_data[] = array(
                'key' => __('To Address', 'woocommerce'),
                'value' => $cart_item['toAddress'],
                'display' => '',
            );
        }

        return $item_data;
    }

    public function add_cart_item($cart_item_data)
    {
        if (!empty($_REQUEST['distance_price'])) {
            $cart_item_data['distance_price'] = $_REQUEST['distance_price'];
        }
        if (!empty($_REQUEST['distance'])) {
            $cart_item_data['distance'] = $_REQUEST['distance'];
        }
        if (!empty($_REQUEST['fromAddress'])) {
            $cart_item_data['fromAddress'] = $_REQUEST['fromAddress'];
        }
        if (!empty($_REQUEST['fromAddress'])) {
            $cart_item_data['fromAddress'] = $_REQUEST['fromAddress'];
        }
        if (!empty($_REQUEST['toAddress'])) {
            $cart_item_data['toAddress'] = $_REQUEST['toAddress'];
        }
        return $cart_item_data;
    }
    
    public static $applied_cost_rules;
    
    public function calculate_booking_cost($booking_cost, $product, $data )
    { 
        // ini_set('display_errors','on');
        // ini_set('error_reporting', E_ALL );
        
        // Get costs
        $costs    = $product->get_costs();
        $validate = $product->is_bookable( $data );

        if ( is_wp_error( $validate ) ) {
            return $validate;
        }
   
        $product_id = $product->get_id();  
        $max_duration = get_post_meta($product_id, '_wc_booking_max_duration', true);
        $min_duration = get_post_meta($product_id, '_wc_booking_min_duration', true);

        $base_cost        = max( 0, $product->get_cost() );
        $base_block_cost  = max( 0, $product->get_block_cost() );
        $total_block_cost = 0;

        /* Person costs. */
        $person_base_costs        = 0;
        $person_block_costs       = 0;
        $total_person_block_costs = 0;

        // Potentially increase costs if dealing with persons.
        if ( ! empty( $data['_persons'] ) && $product->has_person_types() ) {
            foreach ( $data['_persons'] as $person_id => $person_count ) {
                $person_type       = new WC_Product_Booking_Person_Type( $person_id );
                $person_cost       = $person_type->get_cost();
                $person_block_cost = $person_type->get_block_cost();

                // Only a single cost - multiplication comes later if wc_booking_person_cost_multiplier is enabled.
                if ( $person_count > 0 && $person_cost > 0 ) {
                    if ( $product->get_has_person_cost_multiplier() ) {
                        // If there are person types with costs and person multiplier, separate person costs for calculations.
                        $person_base_costs += ( $person_cost * $person_count );
                    } else {
                        $base_cost += ( $person_cost * $person_count );
                    }
                }
                if ( $person_count > 0 && $person_block_cost > 0 ) {
                    $person_block_costs += ( $person_block_cost * $person_count );
                }
            }
        }

        WC_Bookings_Cost_Calculation::$applied_cost_rules = array();
        $block_duration           = $product->get_duration();
        $block_unit               = $product->get_duration_unit();
        $blocks_booked            = isset( $data['_duration'] ) ? absint( $data['_duration'] ) : $block_duration;
        $block_timestamp          = $data['_start_date'];

        if ( $product->is_duration_type( 'fixed' ) ) {
            $blocks_booked = ceil( $blocks_booked / $block_duration );
        }    

        $buffer_period = $product->get_buffer_period();
        if ( ! empty( $buffer_period ) ) {
            // handle day buffers
            if ( ! in_array( $product->get_duration_unit(), array( 'minute', 'hour' ) ) ) {
                $buffer_days = WC_Bookings_Controller::find_buffer_day_blocks( $product );
                $buffer_days = array_keys( $buffer_days );
                $contains_buffer_days = false;
                // Evaluate costs for each booked block
                for ( $block = 0; $block < $blocks_booked; $block ++ ) {
                    $block_start_time_offset = $block * $block_duration;
                    $block_end_time_offset   = ( ( $block + 1 ) * $block_duration ) - 1;
                    $block_start_time        = date( 'Y-n-j', strtotime( "+{$block_start_time_offset} {$block_unit}", $block_timestamp ) );
                    $block_end_time          = date( 'Y-n-j', strtotime( "+{$block_end_time_offset} {$block_unit}", $block_timestamp ) );

                    if ( in_array( $block_end_time, $buffer_days ) ) {
                        $contains_buffer_days = true;
                    }

                    if ( in_array( $block_start_time, $buffer_days ) ) {
                        $contains_buffer_days = true;
                    }
                }

                if ( $contains_buffer_days ) {
                    return new WP_Error(
                        'Error',
                        __(
                            'It looks like these days are booked and no longer available, please try again with different days.',
                            'woocommerce-bookings'
                        )
                    );
                }
            }
        }

         $i = 0;  
         $totalBlockCost = 0;   
        // Evaluate costs for each booked block
        for ( $block = 0; $block < $blocks_booked; $block ++ ) {
            // If there are person types with costs and person multiplier, separate person costs.
            if ( ( $person_block_costs > 0 ) && $product->get_has_person_cost_multiplier() ) {
                $block_cost = $base_block_cost;
            } else {
                $block_cost = $base_block_cost + $person_block_costs;
            }

            $block_start_time_offset = $block * $block_duration;
            $block_end_time_offset   = ( $block + 1 ) * $block_duration;
            $block_start_time        = wc_bookings_get_formatted_times( strtotime( "+{$block_start_time_offset} {$block_unit}", $block_timestamp ) );
            $block_end_time          = wc_bookings_get_formatted_times( strtotime( "+{$block_end_time_offset} {$block_unit}", $block_timestamp ) );

            if ( in_array( $product->get_duration_unit(), array( 'night' ) ) ) {
                $block_start_time        = wc_bookings_get_formatted_times( strtotime( "+{$block_start_time_offset} day", $block_timestamp ) );
                $block_end_time = wc_bookings_get_formatted_times( strtotime( "+{$block_end_time_offset} day", $block_timestamp ) );
            }

            foreach ( $costs as $rule_key => $rule ) {
                $type         = $rule[0];
                $rules        = $rule[1];
                $rule_applied = false;

                if ( strrpos( $type, 'time' ) === 0 ) {
                    if ( ! in_array( $product->get_duration_unit(), array( 'minute', 'hour' ) ) ) {
                        continue;
                    }

                    if ( 'time:range' === $type ) {
                        $year = date( 'Y', $block_start_time['timestamp'] );
                        $month = date( 'n', $block_start_time['timestamp'] );
                        $day = date( 'j', $block_start_time['timestamp'] );

                        if ( ! isset( $rules[ $year ][ $month ][ $day ] ) ) {
                            continue;
                        }

                        $rule_val = $rules[ $year ][ $month ][ $day ]['rule'];
                        $from     = $rules[ $year ][ $month ][ $day ]['from'];
                        $to       = $rules[ $year ][ $month ][ $day ]['to'];
                    } else {
                        if ( ! empty( $rules['day'] ) ) {
                            if ( $rules['day'] != $block_start_time['day_of_week'] ) {
                                continue;
                            }
                        }

                        $rule_val = $rules['rule'];
                        $from     = $rules['from'];
                        $to       = $rules['to'];
                    }

                    $rule_start_time_hi = date( 'YmdHi', strtotime( str_replace( ':', '', $from ), $block_start_time['timestamp'] ) );
                    $rule_end_time_hi   = date( 'YmdHi', strtotime( str_replace( ':', '', $to ), $block_start_time['timestamp'] ) );
                    $matched            = false;

                    // Reverse time rule - The end time is tomorrow e.g. 16:00 today - 12:00 tomorrow
                    if ( $rule_end_time_hi <= $rule_start_time_hi ) {

                        if ( $block_end_time['time'] > $rule_start_time_hi ) {
                            $matched = true;
                        }
                        if ( $block_start_time['time'] >= $rule_start_time_hi && $block_end_time['time'] >= $rule_end_time_hi ) {
                            $matched = true;
                        }
                        if ( $block_start_time['time'] <= $rule_start_time_hi && $block_end_time['time'] <= $rule_end_time_hi ) {
                            $matched = true;
                        }
                    } else {
                        // Else Normal rule.
                        if ( $block_start_time['time'] >= $rule_start_time_hi && $block_end_time['time'] <= $rule_end_time_hi ) {
                            $matched = true;
                        }
                    }

                    if ( $matched ) {
                        $block_cost   = WC_Bookings_Cost_Calculation::apply_cost( $block_cost, $rule_val['block'][0], $rule_val['block'][1] );
                        $base_cost    = WC_Bookings_Cost_Calculation::apply_base_cost( $base_cost, $rule_val['base'][0], $rule_val['base'][1], $rule_key );
                        $rule_applied = true;
                    }
                } else {
                    switch ( $type ) {
                        case 'months':
                        case 'weeks':
                        case 'days':
                            $check_date = $block_start_time['timestamp'];

                            while ( $check_date < $block_end_time['timestamp'] ) {
                                $checking_date = wc_bookings_get_formatted_times( $check_date );
                                $date_key      = 'days' == $type ? 'day_of_week' : substr( $type, 0, -1 );

                                // cater to months beyond this year
                                if ( 'month' === $date_key && intval( $checking_date['year'] ) > intval( date( 'Y' ) ) ) {

                                    $month_beyond_this_year = intval( $checking_date['month'] ) + 12;
                                    $checking_date['month'] = (string) ( $month_beyond_this_year % 12 );
                                    if ( '0' === $checking_date['month'] ) {
                                        $checking_date['month'] = '12';
                                    }
                                }

                                if ( isset( $rules[ $checking_date[ $date_key ] ] ) ) {
                                    $rule       = $rules[ $checking_date[ $date_key ] ];
                                    $block_cost   = WC_Bookings_Cost_Calculation::apply_cost( $block_cost, $rule['block'][0], $rule['block'][1] );
                                    $base_cost    = WC_Bookings_Cost_Calculation::apply_base_cost( $base_cost, $rule['base'][0], $rule['base'][1], $rule_key );
                                    $rule_applied = true;
                                }
                                $check_date = strtotime( "+1 {$type}", $check_date );
                            }
                            break;
                        case 'custom':
                            $check_date = $block_start_time['timestamp'];

                            while ( $check_date < $block_end_time['timestamp'] ) {
                                $checking_date = wc_bookings_get_formatted_times( $check_date );
                                if ( isset( $rules[ $checking_date['year'] ][ $checking_date['month'] ][ $checking_date['day'] ] ) ) {
                                    $rule         = $rules[ $checking_date['year'] ][ $checking_date['month'] ][ $checking_date['day'] ];
                                    $block_cost   = WC_Bookings_Cost_Calculation::apply_cost( $block_cost, $rule['block'][0], $rule['block'][1] );
                                    $base_cost    = WC_Bookings_Cost_Calculation::apply_base_cost( $base_cost, $rule['base'][0], $rule['base'][1], $rule_key );
                                    $rule_applied = true;

                                    /*
                                     * Why do we break?
                                     * See: Applying a cost rule to a booking block
                                     * from the DEVELOPER.md
                                     */
                                    break;
                                }
                                $check_date = strtotime( '+1 day', $check_date );
                            }
                            break;
                        case 'persons':
                            if ( ! empty( $data['_persons'] ) ) {
                                if ( $rules['from'] <= array_sum( $data['_persons'] ) && $rules['to'] >= array_sum( $data['_persons'] ) ) {
                                    $block_cost   = WC_Bookings_Cost_Calculation::apply_cost( $block_cost, $rules['rule']['block'][0], $rules['rule']['block'][1] );
                                    $base_cost    = WC_Bookings_Cost_Calculation::apply_base_cost( $base_cost, $rules['rule']['base'][0], $rules['rule']['base'][1], $rule_key );
                                    $rule_applied = true;
                                }
                            }
                            break;
                        case 'blocks':
                            if ( ! empty( $data['_duration'] ) ) {
                                if ( $rules['from'] <= $data['_duration'] && $rules['to'] >= $data['_duration'] ) {
                                    $block_cost   = WC_Bookings_Cost_Calculation::apply_cost( $block_cost, $rules['rule']['block'][0], $rules['rule']['block'][1] );
                                    $base_cost    = WC_Bookings_Cost_Calculation::apply_base_cost( $base_cost, $rules['rule']['base'][0], $rules['rule']['base'][1], $rule_key );
                                    $rule_applied = true;
                                }
                            }
                            break;
                    }
                }
                /**
                 * Filter to modify rule cost logic. By default, all relevant cost rules will be
                 * applied to a block. Hooks returning false can modify this so only the first
                 * applicable rule will modify the block cost.
                 *
                 * @since 1.16.0
                 * @param bool
                 * @param WC_Product_Booking Current bookable product.
                 */
                if ( $rule_applied && ( ! apply_filters( 'woocommerce_bookings_apply_multiple_rules_per_block', true, $product ) ) ) {
                    break;
                }
            }

            // Add resource block cost.
            if ( isset( $data['_resource_id'] ) ) {
                $resource    = $product->get_resource( $data['_resource_id'] );
                $block_cost += $resource->get_block_cost();
            }

            $total_block_cost         += $block_cost;
            $total_person_block_costs += $person_block_costs;

                $selectedOption = $i++ ;

        } 
        // Add resource base cost.
        if ( isset( $data['_resource_id'] ) ) {
            $resource   = $product->get_resource( $data['_resource_id'] );
            $base_cost += $resource->get_base_cost();
        } 

        $minusVal = $min_duration - 1 ;
        
        if ($selectedOption >= $min_duration && $selectedOption <= $max_duration) {
            // Calculate the total block cost by multiplying the initial block cost with the difference from 36
            $totalBlockCost = $block_cost * ($selectedOption - $minusVal);
        } 

        $booking_cost = $base_cost + $totalBlockCost;   

        if ( ! empty( $data['_persons'] ) ) {
            if ( $product->get_has_person_cost_multiplier() ) {
                // Person multiplier multiplies booking costs, not person costs.
                $booking_cost = $booking_cost * array_sum( $data['_persons'] ) + max( 0, $total_person_block_costs + $person_base_costs );
            }
        }


        if (isset($_POST['form'])) {
            parse_str( $_POST['form'], $posted );
            if (!empty($posted['distance_price'])) {
                $booking_cost = $booking_cost + floatval($posted['distance_price']);
            }  
        }  

        return $booking_cost;
    }

        
        
    // public function calculate_booking_cost($cost)
    // {
    //     if (isset($_POST['form'])) {
    //         parse_str( $_POST['form'], $posted );
    //         if (!empty($posted['distance_price'])) {
    //             $cost = $cost + floatval($posted['distance_price']);
    //         } elseif (!empty($posted['distance_price'])) {
    //             $cost = $cost + floatval($posted['distance_price']);
    //         }
    //     }
    //     return $cost;
    // }



    public function enqueue_admin_scripts()
    {
        $google_maps_key = get_field('google_maps_key', 'options');
        if (!$google_maps_key) {
            $google_maps_key = 'xxxxx';
        }
        wp_register_script( 'chauffeur-panel-script', get_theme_file_uri( CHAUFFEUR_REDIRECTION.'/assets/js/panel.js' ), array('jquery'), '1.0' );
        wp_register_script( 'chauffeur-script', get_theme_file_uri( CHAUFFEUR_REDIRECTION.'/assets/js/add-to-cart.js' ), array('jquery', 'accounting'), '1.0' );
        wp_register_script( 'chauffeur-locations', get_theme_file_uri( CHAUFFEUR_REDIRECTION.'/assets/js/chauffeur-locations.js' ), array('jquery', 'accounting'), '1.0' );
        wp_register_script( 'chauffeur-google-maps', 'https://maps.googleapis.com/maps/api/js?key=' . $google_maps_key . '&libraries=geometry,places' );

        wp_register_style( 'chauffeur-panel-style', get_theme_file_uri(CHAUFFEUR_REDIRECTION.'/assets/css/panel.css'), false, '1.0.0' );
        wp_register_style( 'chauffeur-style', get_theme_file_uri(CHAUFFEUR_REDIRECTION.'/assets/css/chauffeur.css'), false, '1.0.0' );
        wp_register_style( 'chauffeur-locations', get_theme_file_uri(CHAUFFEUR_REDIRECTION.'/assets/css/chauffeur-locations.css'), false, '1.0.0' );
    }

    /**
     * Add chauffeur product type options
     *
     * @param $options
     * @return array
     */
    public function add_product_type_options($options)
    {
        return array_merge( $options, array(
            'redirect_chauffeur' => array(
                'id'            => '_redirect_chauffeur',
                'wrapper_class' => 'show_if_booking',
                'label'         => __( 'Redirect Chauffeur', 'boilerplate' ),
                'description'   => __( 'Redirect Chauffeur products will redirect to has chauffeur product.', 'boilerplate' ),
            ),
            'chauffeur' => array(
                'id'            => '_chauffeur',
                'wrapper_class' => 'show_if_booking',
                'label'         => __( 'Has Chauffeur', 'boilerplate' ),
                'description'   => __( 'Has Chauffeur products give access to select from and to address to setup product price base on distance.', 'boilerplate' ),
            ),
        ) );
    }

    /**
     * Add chauffeur product tab
     *
     * @param $tabs
     * @return mixed
     */
    public function add_product_data_tab($tabs)
    {
        $tabs['_chauffeur'] = [
            'id'       => 'chauffeur-tab',
            'label'    => __( 'Chauffeur', 'boilerplate' ),
            'target'   => 'chauffeur-panel',
            'class'    => array('show_if_chauffeur'),
            'priority' => 50,
        ];
        return $tabs;
    }

    /**
     * Process save the product meta
     *
     * @param $post_id
     * @return void
     */
    public function add_product_process_meta($post_id)
    {
        $taxi_options = $_POST['_taxi_cars'] ? array_values($_POST['_taxi_cars']) : [];
        $product = wc_get_product( $post_id );
        $product->update_meta_data( '_taxi_cars', $taxi_options );
        $product->update_meta_data( '_chauffeur', isset($_POST["_chauffeur"]) ? "yes" : "no" );
        $product->update_meta_data( '_redirect_chauffeur', isset($_POST["_redirect_chauffeur"]) ? "yes" : "no" );
        $product->save();
    }

    public function add_product_data_panel()
    {
        wp_enqueue_script('chauffeur-panel-script');
        wp_localize_script('chauffeur-panel-script', 'chauffeur',
            array(
                'ajaxUrl' => admin_url( 'admin-ajax.php' ),
            )
        );
        wp_enqueue_style('chauffeur-panel-style');
        include(get_theme_file_path(CHAUFFEUR_REDIRECTION.'/templates/admin/panel.php') );
    }

    /**
     * Add a button to redirect to the chauffeur page
     *
     * @return void
     */
    public function add_to_cart_button()
    {
        global $product;
        if ($product->get_meta('_chauffeur') && $product->get_meta('_chauffeur') === 'yes') {
            wp_enqueue_style('chauffeur-locations');
            wp_enqueue_script('chauffeur-google-maps');
            wp_enqueue_script('chauffeur-locations');
            $localize_array = [
                'ajaxUrl' => admin_url( 'admin-ajax.php' ),
                'price_display_suffix'         => esc_attr( get_option( 'woocommerce_price_display_suffix' ) ),
                'ajax_url'                     => WC()->ajax_url(),
                'i18n_addon_total'             => __( 'Options total:', 'woocommerce-product-addons' ),
                'i18n_sub_total'               => __( 'Sub total:', 'woocommerce-product-addons' ),
                'i18n_remaining'               => __( 'characters remaining', 'woocommerce-product-addons' ),
                'currency_format_num_decimals' => absint( get_option( 'woocommerce_price_num_decimals' ) ),
                'currency_format_symbol'       => get_woocommerce_currency_symbol(),
                'currency_format_decimal_sep'  => esc_attr( stripslashes( get_option( 'woocommerce_price_decimal_sep' ) ) ),
                'currency_format_thousand_sep' => esc_attr( stripslashes( get_option( 'woocommerce_price_thousand_sep' ) ) ),
                'trim_trailing_zeros'          => apply_filters( 'woocommerce_price_trim_zeros', false ),
            ];
            if (isset($_REQUEST['data'])) {
                parse_str(base64_decode($_REQUEST['data']), $output);
                $localize_array['chauffeur'] = $output;
            }
            wp_localize_script('chauffeur-locations', 'hh_wc_ajax', $localize_array);
            include( get_theme_file_path(CHAUFFEUR_REDIRECTION.'/templates/single-product/add-to-cart/chauffeur.php') );
        }
        if ($product->get_meta('_redirect_chauffeur') && $product->get_meta('_redirect_chauffeur') == 'yes') {
            // TODO change the button to show the popup
            wp_enqueue_style('chauffeur-style');
            wp_enqueue_script('chauffeur-script');
            wp_localize_script( 'chauffeur-script', 'chauffeur',
                array(
                    'chauffeur_service_url' => home_url('/product/chauffeur')
                )
            );
            include( get_theme_file_path(CHAUFFEUR_REDIRECTION.'/templates/single-product/add-to-cart/redirect-chauffeur.php') );
        }
    }

    public function add_to_cart_validation($passed, $product_id, $quantity)
    {
        $product = wc_get_product($product_id);
        $is_redirect_chauffeur = isset($_POST['_redirect_chauffeur']) && $_POST['_redirect_chauffeur'] === 'yes';
        if ($product->get_meta('_redirect_chauffeur') && $product->get_meta('_redirect_chauffeur') == 'yes' && $is_redirect_chauffeur) {
            $passed = false;
            if (!session_id()) {
                session_start();
            }
            $_SESSION['chauffeur_product'] = $_POST;
            wp_redirect('/add-chauffeur-services');
        }
        return $passed;
    }

    public function shortcode($attr)
    {
        if (isset($_REQUEST['data'])) {
            ob_start();
            wp_enqueue_script('chauffeur-script');
            parse_str(base64_decode($_REQUEST['data']), $output);
            wp_localize_script( 'chauffeur-script', 'hh_wc_ajax',
                array(
                    'ajaxUrl' => admin_url( 'admin-ajax.php' ),
                    'price_display_suffix'         => esc_attr( get_option( 'woocommerce_price_display_suffix' ) ),
                    'ajax_url'                     => WC()->ajax_url(),
                    'i18n_addon_total'             => __( 'Options total:', 'woocommerce-product-addons' ),
                    'i18n_sub_total'               => __( 'Sub total:', 'woocommerce-product-addons' ),
                    'i18n_remaining'               => __( 'characters remaining', 'woocommerce-product-addons' ),
                    'currency_format_num_decimals' => absint( get_option( 'woocommerce_price_num_decimals' ) ),
                    'currency_format_symbol'       => get_woocommerce_currency_symbol(),
                    'currency_format_decimal_sep'  => esc_attr( stripslashes( get_option( 'woocommerce_price_decimal_sep' ) ) ),
                    'currency_format_thousand_sep' => esc_attr( stripslashes( get_option( 'woocommerce_price_thousand_sep' ) ) ),
                    'trim_trailing_zeros'          => apply_filters( 'woocommerce_price_trim_zeros', false ),
                    'booking_output'                => $output
                )
            );
            wp_enqueue_style('chauffeur-style');
            include __DIR__ . '/templates/shortcode/chauffeur-services.php';
            return ob_get_clean();
        }
        return __('Please go to chauffeur product and choose options.');
    }

    public function add_support_to_bookable_resource($label)
    {
        $label['supports'] = array( 'title', 'thumbnail' );
        return $label;
    }

    public function register_chauffeur_settings()
    {
        if ( function_exists('acf_add_local_field_group') ):

            acf_add_local_field_group(array(
                'key' => 'group_63d782f518e1c',
                'title' => 'Chauffeur Settings',
                'fields' => array(
                    array(
                        'key' => 'field_63d78351a2684',
                        'label' => 'Resource Type',
                        'name' => 'resource_type',
                        'type' => 'radio',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'choices' => array(
                            'default' => 'Default',
                            'chauffeur' => 'Chauffeur',
                        ),
                        'allow_null' => 0,
                        'other_choice' => 0,
                        'default_value' => 'default',
                        'layout' => 'vertical',
                        'return_format' => 'value',
                        'save_other_choice' => 0,
                    ),
                    array(
                        'key' => 'field_63d78310a2683',
                        'label' => 'Price Per Mile',
                        'name' => 'price_per_mile',
                        'type' => 'number',
                        'instructions' => '',
                        'required' => 1,
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field' => 'field_63d78351a2684',
                                    'operator' => '==',
                                    'value' => 'chauffeur',
                                ),
                            ),
                        ),
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'min' => '',
                        'max' => '',
                        'step' => '',
                    ),
                    array(
                        'key' => 'london_price_per_mile',
                        'label' => 'Price Per Mile Inside London',
                        'name' => 'london_price_per_mile',
                        'type' => 'number',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field' => 'field_63d78351a2684',
                                    'operator' => '==',
                                    'value' => 'chauffeur',
                                ),
                            ),
                        ),
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'min' => '',
                        'max' => '',
                        'step' => '',
                    ),
                    array(
                        'key' => 'field_63d78310a2690',
                        'label' => 'Supplement',
                        'name' => 'price_supplement',
                        'type' => 'number',
                        'instructions' => 'The Supplement fee will be added to the price if the from or to address is in airport.',
                        'required' => 0,
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field' => 'field_63d78351a2684',
                                    'operator' => '==',
                                    'value' => 'chauffeur',
                                ),
                            ),
                        ),
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'min' => '',
                        'max' => '',
                        'step' => '',
                    ),
                    array(
                        'key' => 'max_passengers',
                        'label' => 'Max Passengers',
                        'name' => 'max_passengers',
                        'type' => 'number',
                        'required' => 0,
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field' => 'field_63d78351a2684',
                                    'operator' => '==',
                                    'value' => 'chauffeur',
                                ),
                            ),
                        ),
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'min' => '',
                        'max' => '',
                        'step' => '',
                    ),
                    array(
                        'key' => 'max_bags',
                        'label' => 'Max Bags',
                        'name' => 'max_bags',
                        'type' => 'number',
                        'required' => 0,
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field' => 'field_63d78351a2684',
                                    'operator' => '==',
                                    'value' => 'chauffeur',
                                ),
                            ),
                        ),
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'min' => '',
                        'max' => '',
                        'step' => '',
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => 'bookable_resource',
                        ),
                    ),
                ),
                'menu_order' => 0,
                'position' => 'normal',
                'style' => 'default',
                'label_placement' => 'top',
                'instruction_placement' => 'label',
                'hide_on_screen' => '',
                'active' => true,
                'description' => '',
                'show_in_rest' => 0,
            ));

        endif;
    }

    public function change_additional_cost_string($string, $resource)
    {
        return '';
    }

    public function add_meta_to_resource_response($response, $object, $request)
    {
        $data = $response->get_data();
        $data['_meta'] = [
            'price_per_mile'            => (int)get_post_meta($object->get_id(), 'price_per_mile', true),
            'price_per_kilometer'       => (int)get_post_meta($object->get_id(), 'price_per_kilometer', true),
            'price_supplement'          => (int)get_post_meta($object->get_id(), 'price_supplement', true),
            'london_price_per_mile'     => (int)get_post_meta($object->get_id(), 'london_price_per_mile', true)
        ];
        $response->set_data($data);
        return $response;
    }

    public function bookings_get_time_slots_html($html, $available_blocks, $blocks, $product) {
        if (!$product->get_meta('_chauffeur') || $product->get_meta('_chauffeur') !== 'yes') {
            return $html;
        }
        if ($product->get_duration_type() === 'customer' && $product->get_duration_unit() === 'minute') {
            ob_start();
            ?>
            <li style="display: block; width: 100%;">
                <input type="time" id="_wc_booking_time_slot" style="width: 100%;" placeholder="HH:MM" />
                <input type="hidden" name="wc_bookings_field_start_date_time">
                <script type="text/javascript">
                    jQuery(document).ready(function ($) {
                        $('#_wc_booking_time_slot').change(function () {
                            const thisForm = $(this).closest('form')
                            const li = $(this).closest('li')
                            thisForm.find('input[name="wc_bookings_field_duration"]').remove()
                            li.append(`<input type="hidden" name="wc_bookings_field_duration" value="<?php echo $product->get_min_duration(); ?>" />`)
                            const date = new Date();
                            const dateTime = $(this).val().split(':');
                            const year = thisForm.find('input[name="wc_bookings_field_start_date_year"]').val();
                            const month = thisForm.find('input[name="wc_bookings_field_start_date_month"]').val();
                            const day = thisForm.find('input[name="wc_bookings_field_start_date_day"]').val();

                            date.setFullYear(year, month, day);
                            date.setHours(parseInt(dateTime[0]), parseInt(dateTime[1]));
                            const dateString = `${year}-${month}-${day}T${dateTime[0]}:${dateTime[1]}:00+0000`;
                            thisForm.find('[name="wc_bookings_field_start_date_time"]').val(dateString);
                            $.ajax({
                                type: "POST",
                                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                                data: {
                                    action: "wc_bookings_get_end_time_html",
                                    start_date_time: dateString,
                                    product_id: '<?php echo $product->get_id(); ?>',
                                    security: '<?php echo wp_create_nonce('get_end_time_html'); ?>',
                                    blocks: <?php echo json_encode($blocks); ?>
                                },
                                success: function (n) {
                                    const duration = parseInt($(n).find('option:last').val());
                                    thisForm.find('input[name="wc_bookings_field_duration"]').remove()
                                    li.append(`<input type="hidden" name="wc_bookings_field_duration" value="${duration}" />`)
                                    if (duration <= 0) {
                                        thisForm.find(".wc-bookings-booking-cost").html('This timeslot is not available')
                                        return false;
                                    }
                                    let formData = thisForm.serialize()
                                    if (!formData.includes('wc_bookings_field_duration')) {
                                        thisForm.find(".wc-bookings-booking-cost").html(`This timeslot is not available`)
                                        return false
                                    }
                                    $.ajax({
                                        type: "POST",
                                        url: '<?php echo admin_url('admin-ajax.php'); ?>',
                                        data: {
                                            action: "wc_bookings_calculate_costs",
                                            form: formData
                                        },
                                        success: function (e) {
                                            if ("{" !== e.charAt(0)) {
                                            } else {
                                                const n = JSON.parse(e);
                                                "ERROR" === n.result ? (thisForm.find(".wc-bookings-booking-cost").html(n.html), thisForm.find(".wc-bookings-booking-cost").unblock(), thisForm.find(".wc-bookings-booking-cost").show(), thisForm.find(".single_add_to_cart_button").addClass("disabled")) : "SUCCESS" === n.result ? (thisForm.find(".wc-bookings-booking-cost").html(n.html), thisForm.find(".wc-bookings-booking-cost").unblock(), thisForm.find(".single_add_to_cart_button").removeClass("disabled"), booking_form_params.pao_active && "true" !== booking_form_params.pao_pre_30 && void 0 !== n.raw_price && (thisForm.find(".wc-bookings-booking-cost").attr("data-raw-price", n.raw_price), $("form.cart").trigger("woocommerce-product-addons-update"))) : (thisForm.find(".wc-bookings-booking-cost").hide(), thisForm.find(".single_add_to_cart_button").addClass("disabled"), console.log(e)), $(document.body).trigger("wc_booking_form_changed"), $(".woocommerce-error.wc-bookings-notice").slideUp()
                                            }
                                        },
                                        error: function (e, n) {

                                        },
                                        dataType: "html"
                                    })
                                },
                                error: function (n, e) {
                                    //console.log(n)
                                },
                                dataType: "html"
                            })
                        })
                    })
                </script>
            </li>
            <?php
            return ob_get_clean();
        }
        if ($product->get_duration_unit() === 'hour') {
            ob_start();
            ?>
            <li style="display: block; width: 100%;">
                <select id="_wc_booking_time_slot" name="wc_bookings_field_start_date_time">
                    <?php foreach($available_blocks as $block => $available_block): ?>
                        <option value="<?php echo esc_attr( get_time_as_iso8601( $block ) ); ?>"><?php echo date_i18n( wc_bookings_time_format(), $block ); ?></option>
                    <?php endforeach; ?>
                </select>
                <script type="text/javascript">
                    jQuery(document).ready(function ($) {
                        $('#_wc_booking_time_slot').change(function () {
                            const dateTime = $(this).val();
                            $(this).closest('form').find('[name="wc_bookings_field_start_date_time"]').val(dateTime);
                            $.ajax({
                                type: "POST",
                                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                                data: {action: "wc_bookings_get_blocks", form: $(this).closest('form').serialize(), _t: new Date().getTime()},
                                cache: false,
                                success: function (n) {
                                    //console.log(n)
                                },
                                error: function (n, e) {
                                    //console.log(n)
                                },
                                dataType: "html"
                            })
                        })
                    })
                </script>
            </li>
            <?php
            return ob_get_clean();
        } elseif ($product->get_duration_unit() === 'minute') {
            ob_start();
            ?>
            <li style="display: block; width: 100%;">
                <input type="time" id="_wc_booking_time_slot" style="width: 100%;" placeholder="HH:MM" />
                <input type="hidden" name="wc_bookings_field_start_date_time">
                <script type="text/javascript">
                    jQuery(document).ready(function ($) {
                        $('#_wc_booking_time_slot').change(function () {
                            const date = new Date();
                            const dateTime = $(this).val().split(':');
                            const year = $(this).closest('form').find('input[name="wc_bookings_field_start_date_year"]').val();
                            const month = $(this).closest('form').find('input[name="wc_bookings_field_start_date_month"]').val();
                            const day = $(this).closest('form').find('input[name="wc_bookings_field_start_date_day"]').val();
                            date.setUTCFullYear(year, month, day);
                            date.setUTCHours(parseInt(dateTime[0]), parseInt(dateTime[1]));
                            const dateString = date.getUTCFullYear() + '-' +
                                ('00' + (date.getUTCMonth()+1)).slice(-2) + '-' +
                                ('00' + date.getUTCDate()).slice(-2) + 'T' +
                                ('00' + date.getUTCHours()).slice(-2) + ':' +
                                ('00' + date.getUTCMinutes()).slice(-2) + ':' +
                                ('00' + date.getUTCSeconds()).slice(-2) + '+0000';
                            $(this).closest('form').find('[name="wc_bookings_field_start_date_time"]').val(dateString);
                            $.ajax({
                                type: "POST",
                                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                                data: {action: "wc_bookings_get_blocks", form: $(this).closest('form').serialize()},
                                success: function (n) {
                                    //console.log(n)
                                },
                                error: function (n, e) {
                                    //console.log(n)
                                },
                                dataType: "html"
                            })
                        })
                    })
                </script>
            </li>
            <?php
            return ob_get_clean();
        }
        return $html;
    }

    public function change_resource_template_file($template)
    {
        global $product;
        $checkExists = strpos($template, 'woocommerce-bookings/templates/booking-form/select.php');
        if ($checkExists !== false && $product->get_meta('_chauffeur') && $product->get_meta('_chauffeur') === 'yes') {
            $template = locate_template(
                [CHAUFFEUR_REDIRECTION.'/templates/resources.php']
            );
        }
        return $template;
    }

    public function add_to_cart_redirect($url)
    {
        if ( ! isset( $_REQUEST['add-to-cart'] ) || ! is_numeric( $_REQUEST['add-to-cart'] ) ) {
            return $url;
        }
        $product = wc_get_product($_REQUEST['add-to-cart']);
        if ($product->get_meta('_redirect_chauffeur') && $product->get_meta('_redirect_chauffeur') == 'yes' && isset($_REQUEST['redirect_chauffeur']) && $_REQUEST['redirect_chauffeur'] == 'yes') {
            $url = home_url('/product/chauffeur-one-way-bolt-on');
        }
        return $url;
    }
}
new ChauffeurBookingProduct();