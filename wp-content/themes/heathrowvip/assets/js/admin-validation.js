jQuery(document).ready(function($) {
    var $saveButton = $('button[name="save"]');
    var $codField = $('#woocommerce_cod_validation_code');
    var maxLength = 15; // Set your character limit

    // Create an error message element
    var $errorMessage = $('<p class="cod-validation-error" style="color: red; display: none;">The Pay By Invoice Code cannot exceed ' + maxLength + ' characters.</p>');

    // Append the error message below the input field
    $codField.after($errorMessage);

    // Event handler for keyup event
    $codField.on('keyup', function() {
        var inputValue = $(this).val();
        if (inputValue.length > maxLength) {
            $errorMessage.show(); // Show error message
            $saveButton.prop('disabled', true); // Disable save button
        } else {
            $errorMessage.hide(); // Hide error message
            $saveButton.prop('disabled', false); // Enable save button
        }
    });
});
