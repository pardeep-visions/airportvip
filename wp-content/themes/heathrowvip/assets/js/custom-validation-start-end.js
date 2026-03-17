jQuery(document).ready(function($) {
    // Initialize variables
    var $calendarFieldSet = $('.wc_bookings_field_start_date');
    var calendarValidated = false;


   

    // Function to handle AJAX completion
    function handleAjaxComplete() {
        // Hide error message and remove border
        $calendarFieldSet.find('.error-message').hide();
        $calendarFieldSet.css('border', 'none');
        calendarValidated = true; // Set calendar validation flag to true
    } 


    // Event listener for focusing on fields
    $(document).on('focus', '.wc-pao-addons-container .wc-pao-addon-field', function(event) {

        $('.wc-pao-addons-container input[id^="addon-"][id*="-infants-below-3y-o-"]').prop('disabled', false);
        // Check if the focused field is the excluded field
        var isExcludedField = $(event.target).is('input[id^="addon-"][id*="-infants-below-3y-o-"]');
        if (isExcludedField) {
            return; // Skip validation if the field is excluded
        }
        if (!calendarValidated) {
            // Prevent focusing on the field
            event.preventDefault();
              // Check if the error message already exists
                if ($calendarFieldSet.find('.error-message').length === 0) {
                    // Add error message container to the calendar field set
                    $calendarFieldSet.append('<div class="error-message" style="color:red;">Choose a date first to see available times.</div>');
                }
            // Scroll to the calendar field set to prompt the user
            var scrollToElement = $calendarFieldSet; // Adjust as needed
            var scrollOffset = 50; // Adjust as needed
            $('html, body').animate({
                scrollTop: scrollToElement.offset().top - scrollOffset
            }, 500);

            // Show the error message and highlight the calendar field set
            $calendarFieldSet.find('.error-message').show();
            $calendarFieldSet.css('border', '2px solid red');

            // Disable all input fields in wc-pao-addons-container
            $('.wc-pao-addons-container input').prop('disabled', true);
        } else {
            // Check if the start time dropdown has a valid selection
            var $startTimeDropdown = $('#wc-bookings-form-start-time');
            var startTimeValue = $startTimeDropdown.val();

            // Show loader on end time dropdown
            $('#wc-bookings-form-end-time').next('.loader').show();

            // Check if the end time dropdown has a valid selection
            var $endTimeDropdown = $('#wc-bookings-form-end-time');
            var endTimeValue = $endTimeDropdown.val();

            if (startTimeValue === undefined || startTimeValue === "0" || endTimeValue === undefined || endTimeValue === "0") {
                // Prevent focusing on the field
                event.preventDefault();

                // Determine which dropdown to scroll to and validate
                var scrollToElement = (startTimeValue === undefined || startTimeValue === "0") ? $startTimeDropdown : $endTimeDropdown;
                var scrollOffset = 100; // Adjust as needed
                $('html, body').animate({
                    scrollTop: scrollToElement.offset().top - scrollOffset
                }, 500);

                // Show the error message and highlight the respective dropdown field
                scrollToElement.next('.error-message').show();
                scrollToElement.css('border', '2px solid red');

                // Disable all input fields in wc-pao-addons-container
                $('.wc-pao-addons-container input').prop('disabled', true);

                // Hide loader on end time dropdown
                $endTimeDropdown.next('.loader').hide();
                
            } else {
                // Hide the error message and remove border if both dropdowns have valid selections
                $calendarFieldSet.find('.error-message').hide();
                $startTimeDropdown.css('border', 'none');
                $endTimeDropdown.css('border', 'none');

                // Enable all input fields in wc-pao-addons-container
                $('.wc-pao-addons-container input').prop('disabled', false);

                // Hide loader on end time dropdown
                $endTimeDropdown.next('.loader').hide();
                
            }
        }
    });

    // Event listener for start time dropdown change
    $(document).on('change', '#wc-bookings-form-start-time', function() {

         // Add loader HTML for end time dropdown
        

        var $startTimeDropdown = $(this);
        var startTimeValue = $startTimeDropdown.val();

        // Show loader on end time dropdown
        $('#wc-bookings-form-end-time').next('.loader').show();

        // Hide the loader if start time is valid
        if (startTimeValue !== "0" && startTimeValue !== undefined) {
            $('#wc-bookings-form-end-time').next('.loader').hide();

        }

        // Hide the error message and remove border if a valid selection is made
        if (startTimeValue !== "0" && startTimeValue !== undefined) {
            $startTimeDropdown.next('.error-message').hide();
            $startTimeDropdown.css('border', 'none');

            // Enable all input fields in wc-pao-addons-container
            $('.wc-pao-addons-container input').prop('disabled', false);
        }
    });

    // Event listener for end time dropdown change
    $(document).on('change', '#wc-bookings-form-end-time', function() {
        var $endTimeDropdown = $(this);
        var endTimeValue = $endTimeDropdown.val();

        // Hide the error message and remove border if a valid selection is made
        if (endTimeValue !== "0" && endTimeValue !== undefined) {
            $endTimeDropdown.next('.error-message').hide();
            $endTimeDropdown.css('border', 'none');

            // Enable all input fields in wc-pao-addons-container
            $('.wc-pao-addons-container input').prop('disabled', false);
        }
    });

    // AJAX completion handler (replace with your actual AJAX call)
    $(document).ajaxComplete(function(event, xhr, settings) {
        if (settings.url === myAjax.ajax_url) {
            handleAjaxComplete();
            $('#wc-bookings-form-end-time').after('<span class="loader" style="display:none;"></span>');
            // Reattach event listeners for dynamically loaded elements
            // For example, if the dropdowns are dynamically loaded, reattach event listeners here
            $('#wc-bookings-form-start-time').on('change', function() {

                 // Add loader HTML for end time dropdown
                 

                var $startTimeDropdown = $(this);
                var startTimeValue = $startTimeDropdown.val();

                // Show loader on end time dropdown
                $('#wc-bookings-form-end-time').next('.loader').show();

                // Hide the loader if start time is valid
                if (startTimeValue !== "0" && startTimeValue !== undefined) {
                    $('#wc-bookings-form-end-time').next('.loader').show();
                   
                }

                if (startTimeValue !== "0" && startTimeValue !== undefined) {
                    // Hide the error message and remove border
                    $startTimeDropdown.next('.error-message').hide();
                    $startTimeDropdown.css('border', 'none');

                    // Enable all input fields in wc-pao-addons-container
                    $('.wc-pao-addons-container input').prop('disabled', false);
                }
            });

            $('#wc-bookings-form-end-time').on('change', function() {
                var $endTimeDropdown = $(this);
                var endTimeValue = $endTimeDropdown.val();

                // Hide the error message and remove border if a valid selection is made
                if (endTimeValue !== "0" && endTimeValue !== undefined) {
                    $endTimeDropdown.next('.error-message').hide();
                    $endTimeDropdown.css('border', 'none');

                    // Enable all input fields in wc-pao-addons-container
                    $('.wc-pao-addons-container input').prop('disabled', false);
                }
            });
        }
    });
});