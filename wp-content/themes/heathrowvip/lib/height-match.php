<?php

function output_matchheight()
{
    ob_start()

    ?>

<script>
/**
 * Masthead height matching
 */
function matchHeight(mainEl, matchedEl) {
    var height = jQuery(mainEl).height();
    jQuery(matchedEl).height(height);
}

jQuery(window).resize(function () {
    matchHeight('#masthead', '.mastead-height-mirror');
    setTimeout(matchHeight('#masthead', '.mastead-height-mirror'), 100);
});
jQuery(document).ready(function () {
    matchHeight('#masthead', '.mastead-height-mirror');
});
jQuery(window).scroll(function() {
    if(jQuery(window).scrollTop() >= window.innerHeight) {
        matchHeight('#masthead', '.mastead-height-mirror');
        setTimeout(matchHeight('#masthead', '.mastead-height-mirror'), 100);
    }
});

window.setInterval(function(){
    matchHeight('#masthead', '.mastead-height-mirror');
}, 500);
</script>

<?php

    echo ob_get_clean();
    return;
}

add_action('wp_footer', 'output_matchheight');
