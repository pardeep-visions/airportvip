/**
 * Number of Bags field: jQuery validation — numeric only.
 * Displays "Please enter numbers only." when non-numeric characters are entered.
 */
(function ($) {
	'use strict';

	$(function () {
		var $field = $('#number-of-bags');
		var $error = $field.siblings('.hvip-number-of-bags-error');

		if (!$field.length || !$error.length) {
			return;
		}

		var message = (window.hvipNumberOfBagsValidation && window.hvipNumberOfBagsValidation.error_message) || 'Please enter numbers only.';

		function isNumericOnly(value) {
			if (value === '') {
				return true;
			}
			return /^\d+$/.test(value);
		}

		function showError() {
			$error.text(message).show().attr('aria-hidden', 'false');
			$field.addClass('hvip-validation-error');
		}

		function hideError() {
			$error.text('').hide().attr('aria-hidden', 'true');
			$field.removeClass('hvip-validation-error');
		}

		function validate() {
			if ($field.is(':disabled')) {
				hideError();
				return true;
			}

			var val = $field.val().trim();
			if (isNumericOnly(val)) {
				hideError();
				return true;
			}
			showError();
			return false;
		}

		$field.on('input blur', function () {
			validate();
		});

		// Block form submit if invalid (server-side still validates).
		$field.closest('form').on('submit', function () {
			if (!validate()) {
				$error.show();
				$field.focus();
				return false;
			}
		});
	});
})(jQuery);
