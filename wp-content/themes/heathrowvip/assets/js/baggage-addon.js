jQuery(function ($) {
    function getAllowanceFromProductClass() {
        var bodyClasses = document.body.className || '';

        if (bodyClasses.indexOf('bronze') !== -1) {
            return 4;
        }

        if (bodyClasses.indexOf('silver') !== -1) {
            return 8;
        }

        if (bodyClasses.indexOf('gold') !== -1) {
            return 10;
        }

        return 0;
    }

    function findBaggageField() {
        var $field = $('.wc-pao-addon-container select[id^="addon-"][id$="-number-of-bags"]');

        if ($field.length) {
            return $field.first();
        }

        var $labelMatch = $('.wc-pao-addon-container label[data-addon-name="Number of bags"]').closest('.wc-pao-addon-container').find('select.wc-pao-addon-field');
        return $labelMatch.first();
    }

    function ensureBaggageSummaryElement() {
        var $summaryTarget = $('.wc-bookings-booking-cost, .wc-pao-subtotal-line').first();

        if (!$summaryTarget.length) {
            return $();
        }

        if ($('#heathrowvip-baggage-cost').length) {
            return $('#heathrowvip-baggage-cost');
        }

        var html = '<div id="heathrowvip-baggage-cost" style="display:none; margin-top:6px;"><strong>Additional baggage cost:</strong> <span class="amount">£0.00</span></div>';

        $summaryTarget.append(html);

        return $('#heathrowvip-baggage-cost');
    }

    function formatGBP(value) {
        return '£' + value.toFixed(2);
    }

    function baggageCost(bagCount, allowance) {
        if (allowance <= 0 || bagCount <= allowance) {
            return 0;
        }

        var extraBags = bagCount - allowance;
        return Math.ceil(extraBags / 8) * 50;
    }

    function updateBaggageSummary($input) {
        var allowance = getAllowanceFromProductClass();
        var bagCount = parseInt($input.val(), 10);

        if (isNaN(bagCount) || bagCount < 0) {
            bagCount = 0;
        }

        var extraCost = baggageCost(bagCount, allowance);
        var $summaryLine = ensureBaggageSummaryElement();

        if (!$summaryLine.length) {
            return;
        }

        if (extraCost > 0) {
            $summaryLine.find('.amount').text(formatGBP(extraCost));
            $summaryLine.show();
        } else {
            $summaryLine.find('.amount').text(formatGBP(0));
            $summaryLine.hide();
        }
    }

    function replaceDropdownWithNumberInput() {
        var $select = findBaggageField();

        if (!$select.length || $select.data('heathrowvip-processed')) {
            return;
        }

        $select.data('heathrowvip-processed', true);

        var currentValue = parseInt($select.val(), 10);

        if (isNaN(currentValue) || currentValue < 0) {
            currentValue = 0;
        }

        var inputId = $select.attr('id') || 'heathrowvip-number-of-bags';
        var inputName = $select.attr('name') || inputId;

        var $input = $('<input/>', {
            id: inputId,
            name: inputName,
            type: 'number',
            min: 0,
            step: 1,
            value: currentValue,
            class: 'wc-pao-addon-field heathrowvip-baggage-count'
        });

        $select.after($input).remove();

        $input.on('input change', function () {
            updateBaggageSummary($input);
        });

        updateBaggageSummary($input);
    }

    replaceDropdownWithNumberInput();

    $(document).ajaxComplete(function () {
        replaceDropdownWithNumberInput();
        var $input = $('.heathrowvip-baggage-count').first();
        if ($input.length) {
            updateBaggageSummary($input);
        }
    });
});
