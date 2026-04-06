(function ($) {
	'use strict';

	$(function () {
		var $checkbox = $('#hvip-fast-track-enabled');
		var $qtyWrap = $('#hvip-fast-track-qty-wrap');
		var $modal = $('#hvip-fast-track-modal');
		var $openLink = $('#hvip-fast-track-check-link');
		var $closeBtn = $('#hvip-fast-track-modal-close');

		if (!$checkbox.length) {
			return;
		}

		function toggleQty() {
			if ($checkbox.is(':checked')) {
				$qtyWrap.stop(true, true).slideDown(150);
			} else {
				$qtyWrap.stop(true, true).slideUp(150);
			}
			$(document.body).trigger('wc_booking_form_changed');
		}

		function openModal(e) {
			e.preventDefault();
			$modal.fadeIn(150).attr('aria-hidden', 'false');
			$('body').addClass('hvip-fast-track-modal-open');
		}

		function closeModal(e) {
			if (e) {
				e.preventDefault();
			}
			$modal.fadeOut(150).attr('aria-hidden', 'true');
			$('body').removeClass('hvip-fast-track-modal-open');
		}

		$checkbox.on('change', toggleQty);
		$(document).on('change input', '#hvip-fast-track-quantity', function () {
			$(document.body).trigger('wc_booking_form_changed');
		});
		$openLink.on('click', openModal);
		$closeBtn.on('click', closeModal);

		$modal.on('click', '.hvip-fast-track-modal__overlay', closeModal);
		$(document).on('keydown', function (e) {
			if (e.key === 'Escape' && $modal.is(':visible')) {
				closeModal();
			}
		});

		toggleQty();
	});
})(jQuery);
