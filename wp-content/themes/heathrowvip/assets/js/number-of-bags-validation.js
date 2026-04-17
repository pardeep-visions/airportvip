/**
 * Number of Bags field: jQuery validation — numeric only.
 * Displays "Please enter numbers only." when non-numeric characters are entered.
 */
(function ($) {
	'use strict';

	$(function () {
		var $field = $('#number-of-bags');
		var $container = $field.closest('.hvip-number-of-bags-field');
		var $error = $container.find('.hvip-number-of-bags-error');

		// Fallback for unexpected markup changes.
		if (!$error.length) {
			$error = $field.closest('.wc-pao-addon-wrap').siblings('.hvip-number-of-bags-error').first();
		}

		if (!$field.length || !$error.length) {
			return;
		}

		var message = (window.hvipNumberOfBagsValidation && window.hvipNumberOfBagsValidation.error_message) || 'Please enter numbers onlysss.';

		function isNumericOnly(value) {
			if (value === '') {
				return true;
			}
			return /^\d+$/.test(value);
		}

		function hasInvalidNumberState() {
			var el = $field.get(0);
			if (!el) {
				return false;
			}

			// For type="number", browsers can keep intermediate invalid states
			// (e.g. "-" or ".") that are not reflected in .val().
			return !!(el.validity && el.validity.badInput);
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
			if (hasInvalidNumberState() || !isNumericOnly(val)) {
				showError();
				return false;
			}

			if (isNumericOnly(val)) {
				hideError();
				return true;
			}
			return true;
		}

		$field.on('input change blur keyup', function () {
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
