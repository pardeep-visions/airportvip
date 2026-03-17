<?php


function remove_image_zoom_support_webtalkhub() {
    remove_theme_support( 'wc-product-gallery-zoom' );
}
add_action( 'wp', 'remove_image_zoom_support_webtalkhub', 100 );


/************************************************
 * * WooCommerce General Changes
*************************************************/ 

/***
 *  Change Gallery Thumb in Profuct Single in WooCommerce
 */

add_filter( 'woocommerce_get_image_size_gallery_thumbnail', function( $size ) {
    return array(
    'width' => 150,
    'height' => 150,
    'crop' => 0,
    );
 } );

/***
 *  Change Related Prodeucts Thumb in Product Single in WooCommerce
 */

 add_filter( 'woocommerce_get_image_size_thumbnail', function( $size ) {
	return array(
        'width'  => 565,
        'height' => 350,
		'crop'   => 1,
	);
} );

/***
 * Add buttons under title
 */

add_action('woocommerce_before_add_to_cart_form', 'print_buttons_woocommerce_single_product_summary');
function print_buttons_woocommerce_single_product_summary () { ?>

<?php if ( has_term( 'time-input-overwrite', 'product_cat' ) ) { ?>

    <?php
        if( have_rows('time_input_overrides') ):
            while( have_rows('time_input_overrides') ): the_row();
                $insert_start_time_label = get_sub_field('insert_start_time_label');
                $start_time_label = get_sub_field('start_time_label');
                $start_time_item = get_sub_field('start_time_item');
                $end_time_label = get_sub_field('end_time_label');
                $end_time_item = get_sub_field('end_time_item');
            endwhile;
        endif;
    ?>

    <?php if (isset($insert_start_time_label)): ?>
        <style>
           
            .wc-bookings-start-time-container:before {
                content: "<?php echo $insert_start_time_label; ?>";
                font-weight: 300;
                letter-spacing: 1px;
                font-size: 12px;
                color: #6d6d6d;
            }
         
        </style>
    <?php endif; ?>

    <?php if (isset($start_time_label)): ?>
        <style>
            label[for=wc-bookings-form-start-time] {
                color: transparent;
                pointer-events: none;
                -webkit-user-select: none; /* Safari */
                -ms-user-select: none; /* IE 10 and IE 11 */
                user-select: none; /* Standard syntax */
            }
            label[for=wc-bookings-form-start-time]:before {
                content: "<?php echo $start_time_label; ?>";
                color: var(--content);
                color: #6d6d6d;
            }
        </style>
    <?php endif; ?>

    <?php if (isset($end_time_label)): ?>
        <style>
            label[for=wc-bookings-form-end-time] {
                color: transparent;
                pointer-events: none;
                -webkit-user-select: none; /* Safari */
                -ms-user-select: none; /* IE 10 and IE 11 */
                user-select: none; /* Standard syntax */
            }
            label[for=wc-bookings-form-end-time]:before {
                content: "<?php echo $end_time_label; ?>";
                color: var(--content);
                color: #6d6d6d;
            }
        </style>
    <?php endif; ?>

    <script>
    // Function to modify the select elements
   /* function modifySelectElements() {

        
    <?php if (isset($start_time_item)): ?>
    var startTimeSelect = document.getElementById('wc-bookings-form-start-time');
    if (startTimeSelect && startTimeSelect.options.length > 0) {
        startTimeSelect.options[0].text = '<?php echo $start_time_item; ?>';
    }
    <?php endif; ?>

    <?php if (isset($start_time_item)): ?>
    var startTimeSelect = document.getElementById('_wc_booking_time_slot');
    if (startTimeSelect && startTimeSelect.options.length > 0) {
        startTimeSelect.options[0].text = '<?php echo $start_time_item; ?>';
    }
    <?php endif; ?>

    <?php if (isset($end_time_item)): ?>
    var endTimeSelect = document.getElementById('wc-bookings-form-end-time');
    if (endTimeSelect && endTimeSelect.options.length > 0) {
        endTimeSelect.options[0].text = '<?php echo $end_time_item; ?>';
    }
    <?php endif; ?>
    
    }*/

    // Create an observer instance linked to a callback function
    var observer = new MutationObserver(function(mutationsList, observer) {
        for(var mutation of mutationsList) {
            if (mutation.type === 'childList') {
                modifySelectElements();
            }
        }
    });

    // Select the node that will be observed for mutations
    var targetNode = document.body; // Adjust this if you can be more specific

    // Options for the observer (which mutations to observe)
    var config = { attributes: false, childList: true, subtree: true };

    // Start observing the target node for configured mutations
    observer.observe(targetNode, config);

    // Optionally disconnect the observer when no longer needed
    // observer.disconnect();

    </script>

<?php } ?>






<?php if ( has_term( 'meet-and-greet', 'product_cat' ) ) { ?>





    <?php
        $site_url = home_url();
    ?>

    <style>
        a.button--meet-greet[href$="/product/<?php $post_slug = get_post_field( 'post_name', get_post() ); echo $post_slug; ?>"] {
            color: #fff !important;
            background-color: #052438 !important;
            border-color: #052438 !important;
        }
    </style>

    <div class="cross-reference-buttons">
        <div class="cross-reference-buttons-service">
            <a type="button" class="button button--meet-greet btn btn-sm" href="<?php the_field('arrival'); ?>">Arrival</a>
            <a type="button" class="button button--meet-greet btn btn-sm" href="<?php the_field('departure'); ?>" >Departure</a>
            <a type="button" class="button button--meet-greet btn btn-sm"  href="<?php the_field('transfer'); ?>">Transit</a>
        </div>
        <div class="cross-reference-buttons-colour">
            <a type="button" class="button button--meet-greet btn btn-sm" href="<?php the_field('bronze'); ?>" data-toggle="tooltip" data-html="true" title="<?php the_field('bronze_tooltip', 'option'); ?>" >Bronze</a>
            <a type="button" class="button button--meet-greet btn btn-sm" href="<?php the_field('silver'); ?>" data-toggle="tooltip" data-html="true" title="<?php the_field('silver_tooltip', 'option'); ?>">Silver</a>
            <a type="button" class="button button--meet-greet btn btn-sm" href="<?php the_field('gold'); ?>" data-toggle="tooltip" data-html="true" title="<?php the_field('gold_tooltip', 'option'); ?>">Gold</a>
            <a type="button" class="button button--meet-greet btn btn-sm" href="<?php the_field('tarmac'); ?>" data-toggle="tooltip" data-html="true" title="<?php the_field('tarmac_tooltip', 'option'); ?>">VIP Lounge</a>
        </div>
    </div>
<?php } ?>

<?php if ( has_term( 'chauffeur-fields', 'product_cat' ) ) { ?>

        
    <style>

        fieldset.wc-bookings-date-picker.wc_bookings_field_start_date:not(.enable-panel) {
            pointer-events: none;
            -webkit-user-select: none; /* Safari */
            -ms-user-select: none; /* IE 10 and IE 11 */
            user-select: none; /* Standard syntax */
        }

        fieldset.wc-bookings-date-picker.wc_bookings_field_start_date.enable-panel .custom-tooltip  {
            display: none
        }

        fieldset.wc-bookings-date-picker.wc_bookings_field_start_date:not(.enable-panel)  .picker.hasDatepicker {
            opacity: 0.5;
        }

        .custom-tooltip {
            position: absolute;
            border: 1px solid #ccc;
            background-color: white;
            padding: 13px 30px;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            top: 40%;
            left: 50%;
            transform: translateX(-50%);
            margin-top: 8px;
            font-size: 24px;
            /* inset: 0; */
        }

    </style>

    <script>

        document.addEventListener('DOMContentLoaded', function() {
        // Function to create and show a tooltip
        function createTooltip(element, message) {
            var tooltip = document.createElement('span');
            tooltip.className = 'custom-tooltip';
            tooltip.innerText = message;
            element.style.position = 'relative'; // Ensure the parent is relative
            element.appendChild(tooltip);
        }

        // Select the target element
        var datePickerFieldset = document.querySelector('fieldset.wc-bookings-date-picker.wc_bookings_field_start_date');
        if (datePickerFieldset) {
            createTooltip(datePickerFieldset, 'Please select a car first');
        }
        }, false);

        document.addEventListener('DOMContentLoaded', function() {
            // Function to handle click event
            function handleChauffeurClick() { 
                // Check if there is an element with .car-active within .new-chauffeur
                if (this.querySelector('.car-active')) {
                    // Find the .wc-bookings-date-picker element and add the 'enable-panel' class
                    var datePicker = document.querySelector('.wc-bookings-date-picker');
                    if (datePicker) {
                        datePicker.classList.add('enable-panel');
                    }
                } 

                var carActiveElement = document.querySelector('.car-active');
                if (carActiveElement) {
                    var selectedBags = carActiveElement.getAttribute('data-bags');
                    
                    // Find the parent container of the select element
                    var addonContainer = document.querySelector('.wc-pao-addon-container.wc-pao-addon-number-of-bags');
                    
                    // Find the select element within the parent container
                    var bagsDropdown = addonContainer.querySelector('select.wc-pao-addon-field.wc-pao-addon-select');
                    
                    if (bagsDropdown) {
                        var options = bagsDropdown.options;
                        
                        // Enable all options first
                        for (var i = 0; i < options.length; i++) {
                            options[i].disabled = false;
                        }
                        
                        // Disable options that do not match the selected data-bags range
                        for (var i = 0; i < options.length; i++) {
                            var optionValue = options[i].value;
                            
                            if (optionValue !== '' && !isOptionInRange(optionValue, selectedBags)) {
                                options[i].disabled = true;
                            }
                        }
                    }
                } 
            } 
            // Add event listener to all .new-chauffeur elements
            var chauffeurElements = document.querySelectorAll('.new-chauffeur');
            chauffeurElements.forEach(function(element) {
                element.addEventListener('click', handleChauffeurClick);
            }); 
            function isOptionInRange(optionValue, selectedBags) {
                // Determine if the option's range includes the selectedBags
                var range = optionValue.split('-');
                var minBags = parseInt(range[0]);
                var maxBags = parseInt(range[1]);
                var bags = parseInt(selectedBags);

                return bags >= minBags && bags <= maxBags;
            }

        }, false); 
        
    </script> 


    <style>
        .cross-reference-buttons a.btn[href$="/product/<?php $post_slug = get_post_field( 'post_name', get_post() ); echo $post_slug; ?>"] {
            color: #fff !important;
            background-color: #0A3971 !important;
            border-color: #0A3971 !important;
        }
    </style>

<div class="cross-reference-buttons">
    <div class="cross-reference-buttons-service">
        <a type="button" class="btn  btn-secondary btn-outline-secondary btn-sm" href="/product/chauffeur-one-way">One Way</a>
        <a type="button" class="btn  btn-secondary btn-outline-secondary btn-sm" href="/product/chauffeur-by-the-hour">By The Hour</a>
    </div>
</div>

<?php } ?>

<?php if ( has_term( 'attach-date-to-product', 'product_cat' ) ) { ?>

<script>

    var intervalId = window.setInterval(function(){
        var bookingDateDay = $('input[name="wc_bookings_field_start_date_day"]').val();
        var bookingDateMonth = $('input[name="wc_bookings_field_start_date_month"]').val();
        var bookingDateYear = $('input[name="wc_bookings_field_start_date_year"]').val();
        let bookingDate = '' + bookingDateDay + '/' + bookingDateMonth + '/' + bookingDateYear;
        var bookingDateExport = $('input[name="addon-2935-booking-date-10"]');
        var productBrandValue = bookingDateExport.val(bookingDate);
        // console.log(bookingDateDay);
        // console.log(productBrandValue.val());
    }, 3000);

</script>

<?php } ?>


    <?php // the_field('cross_reference_buttons'); ?>

    <?php 
}


/************************************************
 * FEED Product Changes *
*************************************************/ 

add_filter('storefront_woocommerce_args', 'override_storefront_wc_args');
function override_storefront_wc_args($args) {
    $args['single_image_width'] = 565;

    
    return $args;
} 


