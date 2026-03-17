jQuery(function($) {

    $(document).ready(function() {

        $('#mc-wcb-dates').click(function() {
            $('.mc-wcb-date-picker').toggleClass('visible');
        });
 

        $('input#mc-wcb-fetch').click(function(e) {
            e.preventDefault();
            
            data_search = {};

            var product_id = $('#mc-wcb-product-select').val();  
            var booking_status = $('#mc-wcb-status').val();


            if ( '' !== product_id ) {
                data_search.product_id = product_id
            }

            if ( '' !== booking_status ) {
                data_search.booking_status = booking_status
            } 

            if ( $( '#mc-wcb-dates' ).is( ':checked' ) ) {
                var date_start = $( '#mc_wcv_start_date' ).val();
                var date_end = $( '#mc_wcv_end_date' ).val();
                if ( '' !== date_start ) {
                    data_search.date_start =  date_start
                }
                if ( '' !== date_end ) {
                    data_search.date_end = date_end
                }
            }

            // Validate at least one field is selected
            if (product_id === '' && (!($('#mc-wcb-dates').is(':checked')) || (date_start === '' && date_end === '')) && booking_status === '') {
                alert('Please select at least one field to export bookings.');
                return;
            }
             

            get_bookings_number(data_search);
        });



        function get_bookings_number(data_search) {
            var data = {
                action: 'mc_wcb_find_booking',
                selected_product_id: data_search.product_id,
                date_start: data_search.date_start,
                date_end: data_search.date_end,
                booking_status: data_search.booking_status, // Include booking status
                security: mc_wcb_params.security,
            };

            $.ajax({
                type: 'GET',
                url: mc_wcb_params.ajax_url,
                dataType: 'json',
                data: data,
                beforeSend: function() {
                    $('select#mc-wcb-product-select').prop('disabled', 'disabled');
                    $('.mc-wcb-loader').fadeIn('slow');
                    $('.mc-wcb-export').fadeOut('slow');
                    $('.mc-wcb-result').fadeOut('slow');
                    $('.mc-wcb-download').fadeOut('slow');
                },
                success: function(response) {
                    $('select#mc-wcb-product-select').prop('disabled', false);
                    $('.mc-wcb-loader').fadeOut('slow');
                    $('.mc-wcb-result').hide().html('<span>' + response.data.message + '</span>').fadeIn('slow');
                    if (response.success === true) {
                        $('.mc-wcb-export').fadeIn('slow');
                    }
                },
                error: function(response) {
                    $('.mc-wcb-loader').fadeOut('slow');
                    $('.mc-wcb-result').hide().html('<span>' + response.message + '</span>').fadeIn('slow');
                }
            });
        }

        $('#mc-wcb-submit').click(function(e) {
            e.preventDefault();
            var product_id = $('#mc-wcb-product-select').val();

            var data_search = {};

            if (product_id !== '') {
                data_search.product_id = product_id;
            }

            if ($('#mc-wcb-dates').is(':checked')) {
                var date_start = $('#mc_wcv_start_date').val();
                var date_end = $('#mc_wcv_end_date').val();
                if (date_start !== '') {
                    data_search.date_start = date_start;
                }
                if (date_end !== '') {
                    data_search.date_end = date_end;
                }
            }

            // Get selected booking status
            var booking_status = $('#mc-wcb-status').val();
            if (booking_status !== '') {
                data_search.booking_status = booking_status;
            }

            export_bookings(data_search);
        }); 

        function export_bookings(data_search) {
            var data = {
                action: 'mc_wcb_export',
                selected_product_id: data_search.product_id,
                date_start: data_search.date_start,
                date_end: data_search.date_end,
                booking_status: data_search.booking_status, // Include booking status
                security: mc_wcb_params.security,
            };

            $.ajax({
                type: 'GET',
                url: mc_wcb_params.ajax_url,
                dataType: 'json',
                data: data,
                beforeSend: function() {
                    $('select#mc-wcb-product-select').prop('disabled', 'disabled');
                    $('.mc-wcb-loader').fadeIn('slow');
                    $('.mc-wcb-export').fadeOut('slow');
                    $('.mc-wcb-result').fadeOut('slow');
                    $('.mc-wcb-export-result').fadeIn('slow');
                },
                success: function(response) {
                    $('select#mc-wcb-product-select').prop('disabled', false);
                    $('.mc-wcb-loader').fadeOut('slow');
                    $('.mc-wcb-export-result').fadeOut('slow');

                    if (response.success === true) {
                        $('.mc-wcb-link').attr('href', response.data.file_url);
                        $('.mc-wcb-download').fadeIn('slow');
                    }
                },
                error: function(response) {
                    $('.mc-wcb-loader').fadeOut('slow');
                }
            });
        }
    }); 

});
