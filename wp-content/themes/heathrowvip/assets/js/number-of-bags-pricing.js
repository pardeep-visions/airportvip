(function ($) {
	'use strict';

	function clampInt(v, min) {
		var n = parseInt(v, 10);
		if (isNaN(n)) {
			n = min;
		}
		return Math.max(n, min);
	}

	function extraFee(bags, included, blockSize, feePerBlock) {
		bags = clampInt(bags, 1);
		included = parseInt(included, 10) || 0;
		blockSize = parseInt(blockSize, 10) || 8;
		feePerBlock = parseFloat(feePerBlock) || 50;

		if (bags <= included) {
			return 0;
		}

		var extra = bags - included;
		return Math.ceil(extra / blockSize) * feePerBlock;
	}

	function formatMoney(amount) {
		var p = window.hvipNumberOfBagsPricing || {};
		var decimals = parseInt(p.decimals, 10);
		if (isNaN(decimals)) {
			decimals = 2;
		}

		if (typeof window.accounting !== 'undefined' && typeof window.accounting.formatMoney === 'function') {
			return window.accounting.formatMoney(amount, {
				symbol: p.currency_sym || '£',
				precision: decimals,
				thousand: p.thousand_sep || ',',
				decimal: p.decimal_sep || '.',
				format: p.price_format || '%1$s%2$s'
			});
		}

		return (p.currency_sym || '£') + amount.toFixed(decimals);
	}

	function getBookingsBaseCost() {
		var $cost = $('.wc-bookings-booking-cost').first();
		if (!$cost.length) {
			return 0;
		}

		var raw = $cost.attr('data-raw-price');
		if (typeof raw === 'undefined' || raw === null || raw === '') {
			return 0;
		}

		var n = parseFloat(raw);
		return isNaN(n) ? 0 : n;
	}

	function parseAmountText(amountText, decimalSep, thousandSep) {
		if (!amountText) {
			return 0;
		}

		var v = String(amountText).replace(/\s/g, '');
		v = v.replace(/[^\d\-\.,]/g, '');

		if (thousandSep) {
			var reThousand = new RegExp('\\' + thousandSep, 'g');
			v = v.replace(reThousand, '');
		}
		if (decimalSep && decimalSep !== '.') {
			var reDec = new RegExp('\\' + decimalSep, 'g');
			v = v.replace(reDec, '.');
		}

		var n = parseFloat(v);
		return isNaN(n) ? 0 : n;
	}

	function updateDisplayedTotals(total, fee, freeText) {
		// Update Bookings cost display (so customers see the true total before add-to-cart).
		var $bookingCost = $('.wc-bookings-booking-cost').first();
		if ($bookingCost.length) {
			// Keep Bookings' data-raw-price intact; just update displayed amount.
			var $amount = $bookingCost.find('.amount, .woocommerce-Price-amount').first();
			if ($amount.length) {
				$amount.text(formatMoney(total));
			}
		}

		// Prefer updating the Subtotal inside the bottom-most `.product-addon-totals` block.
		var $mainTotals = getMainSummaryTotalsBox();
		if ($mainTotals.length) {
			var $subtotalRow = $mainTotals.find('ul li').filter(function () {
				return /subtotal/i.test($(this).text());
			}).last();

			if ($subtotalRow.length) {
				var $amountEl = $subtotalRow.find('.wc-pao-col2 .amount, .wc-pao-col2 .woocommerce-Price-amount, .amount, .woocommerce-Price-amount').last();
				if ($amountEl.length) {
					// Preserve any "plus VAT" suffix if it exists in the subtotal row text.
					var rowText = $subtotalRow.text();
					var suffix = '';
					var match = rowText.match(/(plus\s+VAT.*)$/i);
					if (match && match[1]) {
						suffix = ' ' + match[1];
					}
					$amountEl.text(formatMoney(total) + suffix);
					return;
				}
			}
		}

		// Fallback: update any bottom-most "Subtotal" label/value pair.
		var $subtotalValue = getBottomSubtotalValueElement();
		if ($subtotalValue.length) {
			var currentText = $subtotalValue.text();
			var suffixFallback = '';
			var matchFallback = currentText.match(/(plus\s+VAT.*)$/i);
			if (matchFallback && matchFallback[1]) {
				suffixFallback = ' ' + matchFallback[1];
			}
			$subtotalValue.text(formatMoney(total) + suffixFallback);
		}
	}

	function getMainSummaryTotalsBox() {
		// Choose the `.product-addon-totals` block that is lowest on the page.
		var $totals = $('.product-addon-totals');
		if (!$totals.length) {
			return $();
		}

		var $best = $();
		var bestTop = -1;
		$totals.each(function () {
			var $el = $(this);
			var off = $el.offset();
			if (!off) {
				return;
			}
			if (off.top > bestTop) {
				bestTop = off.top;
				$best = $el;
			}
		});

		return $best;
	}

	function getBottomSubtotalValueElement() {
		// Find the *bottom-most* element that contains "Subtotal" and also has a currency value nearby.
		// We use position to avoid the upper totals area.
		var $candidates = [];

		$('span, div, p').each(function () {
			var $el = $(this);
			var text = ($el.text() || '').replace(/\s+/g, ' ').trim();
			if (!text) {
				return;
			}
			if (text.toLowerCase().indexOf('subtotal') === -1) {
				return;
			}

			var off = $el.offset();
			if (!off) {
				return;
			}

			$candidates.push({ el: $el, top: off.top });
		});

		if (!$candidates.length) {
			return $();
		}

		// Sort by vertical position descending and pick the first that looks like the subtotal row.
		$candidates.sort(function (a, b) { return b.top - a.top; });

		for (var i = 0; i < $candidates.length; i++) {
			var $label = $candidates[i].el;
			// Prefer a sibling/right-side value within the same row/container.
			var $row = $label.closest('li, p, div');
			var $value = $row.find('span, strong').filter(function () {
				return /£|\d/.test($(this).text());
			}).last();

			// If label itself contains only "Subtotal", the value is usually elsewhere in the row.
			if ($value.length) {
				return $value;
			}
		}

		return $();
	}

	function setOrUpdateSummary(fee, freeText) {
		var feeText = fee > 0 ? formatMoney(fee) : freeText;

		// Remove any previously injected lines in ANY totals blocks (prevents showing in upper area).
		$('.product-addon-totals li.hvip-bags-fee-line').remove();

		// 1) Preferred: inject as a proper row into the bottom-most `.product-addon-totals` list (main summary box).
		var $mainTotals = getMainSummaryTotalsBox();
		if ($mainTotals.length) {
			var $ul = $mainTotals.find('ul').first();
			if ($ul.length) {
				var $li = $(
					'<li class="hvip-bags-fee-line">' +
						'<div class="wc-pao-col1"><strong>Extra baggage fee:</strong></div>' +
						'<div class="wc-pao-col2"><span class="amount"></span></div>' +
					'</li>'
				);

				var $subtotalRow = $ul.find('li').filter(function () {
					return /subtotal/i.test($(this).text());
				}).first();

				if ($subtotalRow.length) {
					$subtotalRow.before($li);
				} else {
					$ul.append($li);
				}

				$li.find('.wc-pao-col2 .amount').text(feeText);
				return;
			}
		}

		// 2) Fallback: inject into the bottom Summary Box right above Subtotal label/value.
		var $subtotalValue = getBottomSubtotalValueElement();
		if (!$subtotalValue.length) {
			return;
		}

		var $row = $subtotalValue.closest('li, p, div');
		if (!$row.length) {
			return;
		}

		var $existing = $('.hvip-summary-extra-baggage-fee');
		if (!$existing.length) {
			$existing = $(
				'<div class="hvip-summary-extra-baggage-fee" style="display:flex;justify-content:space-between;gap:12px;margin:6px 0;">' +
					'<span class="hvip-label"><strong>Extra baggage fee:</strong></span>' +
					'<span class="hvip-value"></span>' +
				'</div>'
			);
			$row.before($existing);
		}

		$existing.find('.hvip-value').text(feeText);
	}

	$(function () {
		var p = window.hvipNumberOfBagsPricing || {};
		var $field = $('#number-of-bags');
		if (!$field.length) {
			return;
		}

		function debounce(fn, wait) {
			var t;
			return function () {
				var ctx = this;
				var args = arguments;
				window.clearTimeout(t);
				t = window.setTimeout(function () {
					fn.apply(ctx, args);
				}, wait);
			};
		}

		function isBookingStartTimeEnabled() {
			// This matches the "Start time" field behavior on this site.
			// Your theme uses `#_wc_booking_time_slot` and may render it as <select> or <input type="time">.
			var $time = $('#_wc_booking_time_slot');
			if (!$time.length) {
				return false;
			}

			if ($time.is(':disabled')) {
				return false;
			}

			// For a <select>, ensure a real option is selected (not placeholder like "Start time").
			if ($time.is('select')) {
				var val = ($time.val() || '').toString();
				if (!val || val === '0') {
					return false;
				}
				return true;
			}

			// For <input type="time">, require a value.
			var inputVal = ($time.val() || '').toString().trim();
			return inputVal.length > 0;
		}

		function setFieldEnabled(enabled) {
			if (enabled) {
				$field.prop('disabled', false).attr('aria-disabled', 'false');
			} else {
				$field.prop('disabled', true).attr('aria-disabled', 'true');
			}
		}

		/**
		 * Pick the red-box totals area.
		 *
		 * This page can contain multiple `.product-addon-totals` blocks (one near the top,
		 * and one in the booking summary area). We want the one visually in the red box,
		 * so we choose the instance with the greatest vertical offset (lowest on the page).
		 */
		var freeText = p.free_text || 'Free';

		function update() {
			var startTimeReady = isBookingStartTimeEnabled();
			setFieldEnabled(startTimeReady);
			if (!startTimeReady) {
				return;
			}

			var raw = ($field.val() || '').trim();
			if (!/^\d+$/.test(raw)) {
				// If invalid, don't attempt pricing update (validation script will show message).
				return;
			}

			var bags = clampInt(raw, 1);
			var included = parseInt(p.included, 10) || 0;
			var fee = extraFee(bags, included, p.block_size, p.fee_per_block);

			// Update the displayed total (Bookings cost + totals table) to match backend pricing.
			var base = getBookingsBaseCost();
			if (!base || base <= 0) {
				// Fallback: parse the first totals-row amount if raw base isn't available yet.
				var $firstRowAmount = $('.product-addon-totals ul li').first().find('.wc-pao-col2 .amount, .wc-pao-col2 .woocommerce-Price-amount').first();
				if ($firstRowAmount.length) {
					base = parseAmountText($firstRowAmount.text(), p.decimal_sep, p.thousand_sep);
				}
			}
			if (base && base > 0) {
				updateDisplayedTotals(base + fee, fee, freeText);
			}

			// Render fee only inside the bottom Summary Box (before Subtotal).
			setOrUpdateSummary(fee, freeText);
		}

		var scheduleUpdate = debounce(update, 100);

		$field.on('input change', scheduleUpdate);

		// When Bookings recalculates cost, re-render our summary (fee depends only on bags+service).
		$(document.body).on('wc_booking_form_changed found_variation reset_data', function () {
			scheduleUpdate();
		});

		// Enable field when date inputs change (calendar selection updates these).
		$(document).on(
			'change input',
			'#_wc_booking_time_slot, input[name="wc_bookings_field_start_date_day"], input[name="wc_bookings_field_start_date_month"], input[name="wc_bookings_field_start_date_year"]',
			function () {
				scheduleUpdate();
			}
		);

		// Critical: if other booking/add-on fields change after bags are set,
		// the booking summary DOM can be re-rendered without triggering our existing handlers.
		// Re-apply fee/total on any input changes inside the booking/add-to-cart form.
		$(document).on(
			'change input',
			'form.cart :input:not(#number-of-bags)',
			function () {
				scheduleUpdate();
			}
		);

		// Observe summary/cost DOM changes and re-apply (covers AJAX re-renders).
		var observer = new MutationObserver(function () {
			scheduleUpdate();
		});
		var $observeRoot = $('.wc-bookings-booking-cost, .product-addon-totals').last();
		if ($observeRoot.length) {
			observer.observe($observeRoot.get(0), { childList: true, subtree: true });
		}

		scheduleUpdate();
	});
})(jQuery);

