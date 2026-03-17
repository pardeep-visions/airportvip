jQuery(document).ready(function($) {
    
    // Function to toggle the visibility of the COD validation field and update the button state
    function toggleCodValidationField() {
        var selectedPaymentMethod = $('input[name="payment_method"]:checked').val();
        var codValidationField = $('#custom_cod_field');
        var codValidationMessage = $('#cod_validation_message');
        var placeOrderButton = $('#place_order');

        if (selectedPaymentMethod === 'cod') {
            codValidationField.show();
            
            // Check the validity of the COD code and update button state
            var enteredCode = $('#cod_validation_code').val();
            if (enteredCode) {
                validateCodCode(enteredCode, function(isValid) {
                    if (isValid) {
                        $('#cod_validation_code').css('border', '2px solid green');
                        codValidationMessage.hide();
                        placeOrderButton.prop('disabled', false);
                    } else {
                        $('#cod_validation_code').css('border', '2px solid red');
                        codValidationMessage.text('The entered Invoice code is incorrect.').show();
                        placeOrderButton.prop('disabled', true);
                    }
                });
            } else {
                placeOrderButton.prop('disabled', true);
            }
        } else {
            codValidationField.hide();
            codValidationMessage.hide();
            $('#cod_validation_code').val(''); // Reset border
            placeOrderButton.prop('disabled', false);
        }
    }

    // Validate COD code via AJAX
    function validateCodCode(code, callback) {
        $('#checkoutLoader').show();
        $('#cod_validation_code').css('border', '2px solid #ccc'); // Show loader border

        $.ajax({
            url: cod_validation_params.ajax_url,
            type: 'POST',
            data: {
                action: 'validate_cod_code',
                nonce: cod_validation_params.nonce,
                cod_validation_code: code
            },
            beforeSend: function() {
                $('#checkoutLoader').show();
                $('#cod_validation_code').css('border', '2px solid #ccc'); // Show loader border
            },
            success: function(response) {
                callback(response.success);
            },
            complete: function() {
                 $('#checkoutLoader').hide();
               
            }
        });
    }

    // Initial call to check the visibility of the COD validation field and button state
    toggleCodValidationField();

    // Bind the function to the payment method change event
    $(document).on('change', 'input[name="payment_method"]', function() {
           $('#cod_validation_code').css('border', '1px solid #ccc');
        toggleCodValidationField();
    });


       $(document).on('input', '#cod_validation_code', function() {
        $('#place_order').prop('disabled', true); 
        var enteredCode = $(this).val();
        if ($('input[name="payment_method"]:checked').val() === 'cod') {
            if (enteredCode.length >= 3) {
                validateCodCode(enteredCode, function(isValid) {
                    if (isValid) {
                        $('#cod_validation_message').hide();
                        $('#place_order').prop('disabled', false);
                        $('#cod_validation_code').css('border', '2px solid green');
                    } else {
                        $('#cod_validation_message').text('The entered Invoice code is incorrect.').show();
                        $('#place_order').prop('disabled', true);
                        $('#cod_validation_code').css('border', '2px solid red');
                    }
                });
            } else {
                $('#cod_validation_message').hide();
                $('#place_order').prop('disabled', true);
                $('#cod_validation_code').css('border', '1px solid #ccc'); // Reset border if less than 3 characters
            }
        }
    });


    // // Real-time validation via AJAX
    // $(document).on('input', '#cod_validation_code', function() {
    //     var enteredCode = $(this).val();
    //     if ($('input[name="payment_method"]:checked').val() === 'cod') {
    //         validateCodCode(enteredCode, function(isValid) {
    //             if (isValid) {
    //                 $('#cod_validation_message').hide();
    //                 $('#place_order').prop('disabled', false);
    //                 $('#cod_validation_code').css('border', '2px solid green');
    //             } else {
    //                 $('#cod_validation_message').text('The entered COD code is incorrect.').show();
    //                 $('#place_order').prop('disabled', true);
    //                 $('#cod_validation_code').css('border', '2px solid red');
    //             }
    //         });
    //     }
    // });

    // Handle the AJAX update to reinitialize the visibility of the COD field and button state
    $(document).ajaxComplete(function(event, xhr, settings) {
        if (settings.url.indexOf('wc-ajax=update_order_review') !== -1) {
            toggleCodValidationField();
        }
    });
});
