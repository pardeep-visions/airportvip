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
                // Check if the time slot dropdown has a valid selection
                var $timeSlotDropdown = $('#_wc_booking_time_slot');
                var timeSlotValue = $timeSlotDropdown.val();

                if (timeSlotValue === undefined || timeSlotValue === "0") {
                    // Prevent focusing on the field
                    event.preventDefault();

                    // Scroll to the dropdown field to prompt the user
                    var scrollToElement = $timeSlotDropdown; // Adjust as needed
                    var scrollOffset = 100; // Adjust as needed
                    $('html, body').animate({
                        scrollTop: scrollToElement.offset().top - scrollOffset
                    }, 500);

                    // Show the error message and highlight the dropdown field
                    $timeSlotDropdown.next('.error-message').show();
                    $timeSlotDropdown.css('border', '2px solid red');
                    // Disable all input fields in wc-pao-addons-container
                    $('.wc-pao-addons-container input').prop('disabled', true);
                } else {
                    // Hide the error message and remove border if the time slot is selected
                    $calendarFieldSet.find('.error-message').hide();
                    $timeSlotDropdown.css('border', 'none');
                        // Enable all input fields in wc-pao-addons-container
                    $('.wc-pao-addons-container input').prop('disabled', false);

                }
            }
    });

    // Event listener for dropdown change
    $(document).on('change', '#_wc_booking_time_slot', function() {
        var $timeSlotDropdown = $(this);
        var timeSlotValue = $timeSlotDropdown.val();

        if (timeSlotValue !== "0" && timeSlotValue !== undefined) {
            // Hide the error message and remove border
            $timeSlotDropdown.next('.error-message').hide();
            $timeSlotDropdown.css('border', 'none');
            // Enable all input fields in wc-pao-addons-container
            $('.wc-pao-addons-container input').prop('disabled', false);
        }
    });

    // AJAX completion handler (replace with your actual AJAX call)
    $(document).ajaxComplete(function(event, xhr, settings) {
        if (settings.url === myAjax.ajax_url) {
            handleAjaxComplete();

            // Reattach event listeners for dynamically loaded elements
            // For example, if the dropdown is dynamically loaded, reattach event listeners here
            $('#_wc_booking_time_slot').on('change', function() {
                var $timeSlotDropdown = $(this);
                var timeSlotValue = $timeSlotDropdown.val();

                if (timeSlotValue !== "0" && timeSlotValue !== undefined) {
                    // Hide the error message and remove border
                    $timeSlotDropdown.next('.error-message').hide();
                    $timeSlotDropdown.css('border', 'none');
                    // Enable all input fields in wc-pao-addons-container
                  $('.wc-pao-addons-container input').prop('disabled', false);
                }
            });
        }
    });
});