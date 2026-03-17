/**
 * Theme JS
 */
jQuery(function () {
    App.init(); //Fires on document ready
});

var App = (function ($) {
    function init() {
        exampleFunction();
        swiperSlider();
    }

    function exampleFunction() {
        // console.log('main.js init');
    }

    function swiperSlider() {
        var swiper = new Swiper(".mySwiper", {
            spaceBetween: 10,
            slidesPerView: 4,
            freeMode: true,
            watchSlidesProgress: true,
        });
        var swiper2 = new Swiper(".mySwiper2", {
            spaceBetween: 10,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            thumbs: {
                swiper: swiper,
            },
        });
       
    }

    return {
        init: init
    };

}(jQuery));


// jQuery(document).ready(function () {
//     jQuery(".gallery, .gallery--pinterest").slickLightbox({
//         itemSelector: "> a",
//     });
// });

jQuery(window).ready(function () {
    jQuery(".flexslider").flexslider();
});

jQuery(window).load(function () {
    //Add mansry layout to pinterest grid
    jQuery(".gallery--pinterest").masonry({
        // set itemSelector so .grid-sizer is not used in layout
        itemSelector: ".image-link",
        gutter: 10,
        percentPosition: true,
        // use element for option
        columnWidth: ".grid-sizer",
    });
});

jQuery(document).ready(function () {
    jQuery("#mc-embedded-subscribe-form").off("submit");
});

// jQuery(document).ready(function() {
//     console.log('ready')
//     var acc = document.getElementsByClassName("accordion");
//     var i;
//     for (i = 0; i < acc.length; i++) {
//         acc[i].addEventListener("click", function () {
//             this.classList.toggle("active");
//             var panel = this.nextElementSibling;
//             if (panel.style.display === "block") {
//                 panel.style.display = "none";
//             } else {
//                 panel.style.display = "block";
//             }
//         });
//     }
// });

//Settings options
//https://kenwheeler.github.io/slick/#settings
jQuery(document).ready(function () {
    var slideCount = jQuery(".slick-slider-carousel > div").length;
    console.log('Slide count .slick-slider-carousel: ' + slideCount);

    jQuery(".slick-slider-carousel").slick({
        slidesToShow: 4,
        centerPadding: "20px",
        dots: true,
        // centerMode: true,
        responsive: [{
            breakpoint: 1024,
            settings: {
                slidesToShow: 3,
            },
        },
        {
            breakpoint: 768,
            settings: {
                slidesToShow: 1,
            },
        },
        ],
    });
});

//Settings options
jQuery(document).ready(function () {
    var slideCount = jQuery(".slick-slider-carousel--generic > div").length;
    console.log('Slide count .slick-slider-carousel--generic: ' + slideCount);

    jQuery(".slick-slider-carousel--generic").slick({
        slidesToShow: 4,
        centerPadding: "20px",
        dots: true,
        // centerMode: true,
        responsive: [{
            breakpoint: 1024,
            settings: {
                slidesToShow: 3,
            },
        },
        {
            breakpoint: 768,
            settings: {
                slidesToShow: 1,
            },
        },
        ],
    });
});


jQuery(document).ready(function () {
    try {
        var $hasLightbox = jQuery(".has-slick-lightbox");
        if ($hasLightbox.length) {
            $hasLightbox.slickLightbox();
        }
    } catch (error) {

    }

});

jQuery(document).ready(function () {
    try {
        var $slickSlider = jQuery(".has-slick-lightbox");
        if ($slickSlider.length) {
            jQuery(".slick-slider").slick();
        }
    } catch (error) {

    }

});

jQuery(document).ready(function () {
    jQuery('#gift-checkout-checkbox').change(function () {
        if (jQuery(this).is(":checked")) {
            jQuery('#dift-checkout-checkbox-text_field').slideDown();
        } else {
            jQuery('#dift-checkout-checkbox-text_field').slideUp();
        }
    });
});

jQuery(document).ready(function () {

    jQuery('[data-target="#myModal2"]').click(function () {

        // 
        setTimeout(function () {
            jQuery('.related-products-slider').slick('refresh');
            jQuery('.related-products-slider').show();
        }, 300);

    });

});

jQuery(document).ready(function($) {
    // Listen for the completion of any AJAX request
    $(document).ajaxComplete(function(event, xhr, settings) {
        // only check ajax request if action is get end time and product is departure/Transit VIP Lounge
        if (settings.data && settings.data.indexOf('action=wc_bookings_get_end_time_html') !== -1 && (settings.data.indexOf('product_id=2935') !== -1 || settings.data.indexOf('product_id=2931') !== -1)) {
            updateEndTimeSelect();
        }
    });

    // Function to format the date as required
    function formatDate(date) {
        return date.toISOString();
    }

    function addTwoHours(dateStr){
        console.log("Date Str", dateStr);
        let date = new Date(dateStr);
        
        date.setHours(date.getHours() + 2);

        let options = {
            hour: '2-digit',
            minute: '2-digit',
            hour12: true,
            timeZone: 'UTC'  // Ensure that the time is formatted in UTC
        };
        
        let formattedDate = date.toLocaleString('en-US', options);
        console.log("Generated Date", formattedDate);
        return formattedDate;
    }

    function addOneMinute(dateStr) {
        var date = new Date(dateStr);
        date.setMinutes(date.getMinutes() + 1);
        return formatDate(date);
    }

    // Function to update the end time select dropdown
    function updateEndTimeSelect() {
        var select = $('#wc-bookings-form-end-time');
        
        var secondLastOption = select.children('option').eq(-2);
        
        var secondLastTime = secondLastOption.data('value');

        var endTime = addTwoHours(secondLastTime);
        
        var newTime = addOneMinute(secondLastTime);
        
       
       // var newText = secondLastOption.text().replace(/\(\d+ Minutes\)/, '') + "onwards";
        var lastOption = select.children('option').last();
        lastOption.text(secondLastOption.text().replace(/\(\d+ Minutes\)/, '') + " to " +endTime);
        lastOption.data('value', newTime);
    }
    
    // Allow users to edit number fields
    document.querySelectorAll('input[type="number"]').forEach(el => {
        const newEl = el.cloneNode(true); // Clone input field (preserves attributes)
    
        // Ensure min and max attributes are retained
        if (el.hasAttribute('min')) newEl.setAttribute('min', el.getAttribute('min'));
        if (el.hasAttribute('max')) newEl.setAttribute('max', el.getAttribute('max'));
    
        // Replace old input with new unlocked input
        el.parentNode.replaceChild(newEl, el);
    
        // Add input event listener to prevent alphabets and restrict max value
        newEl.addEventListener('input', function(e) {
            let value = newEl.value;
    
            // Allow only digits and a single decimal point if needed
            if (!/^\d*$/.test(value)) {
                newEl.setCustomValidity('Only numbers are allowed');
            } else {
                newEl.setCustomValidity(''); // Clear validation if input is valid
            }
    
            // Restrict value to max 9
            if (parseInt(value, 10) > 9) {
                newEl.value = 9; // If value exceeds 9, set it to 9
            }
        });
    
        // Optional: You can handle validation on form submission
        newEl.addEventListener('blur', function() {
            let value = newEl.value;
            // If the value is greater than 9, correct it
            if (parseInt(value, 10) > 9) {
                newEl.value = 9;
            }
        });
    });
});

