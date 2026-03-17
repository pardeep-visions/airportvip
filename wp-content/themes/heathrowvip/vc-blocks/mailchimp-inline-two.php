<?php
add_action('vc_before_init', 'your_name_mailchimpinlinetwo');
function your_name_mailchimpinlinetwo()
{
    vc_map(
        array(
            "name" => __("MailChimp Inline Two", "my-text-domain"),
            "base" => "mailchimpinlinetwo",
            "class" => "",
            "category" => __("Content", "my-text-domain"),
            "params" => array(
            )
        )
    );
}

add_shortcode('mailchimpinlinetwo', 'mailchimpinlinetwo_func');
function mailchimpinlinetwo_func($atts, $content = null, $servicetitle)
{
    ob_start(); ?>
    <!-- Begin Mailchimp Signup Form -->
    <link href='//cdn-images.mailchimp.com/embedcode/slim-10_7.css' rel='stylesheet' type='text/css'>
    <style type='text/css'>
        #mc_embed_signup{background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif; }
        /* Add your own Mailchimp form style overrides in your site stylesheet or in this style block.
        We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
    </style>

    <div class="align-items-center mailchimp-inline-two-row">
        <div class="mailchimp-inline-two-left">
            <div>
                <img src="https://via.placeholder.com/90">
            </div>
            <div>
                <h5 class="mailchimp-inline-two-title">Title</h5>
                <p class="mailchimp-inline-two-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor. </p>
            </div>
        </div>
        <div class='inline-mailchimp' id='mc_embed_signup'>
            <form action='<?php the_field('mailchimp_code', 'option'); ?>' method='post' id='mc-embedded-subscribe-form' name='mc-embedded-subscribe-form' class='validate' target='_blank' novalidate>
                <div id='mc_embed_signup_scroll'>
                <input type='email' value='' name='EMAIL' class='email' id='mce-EMAIL' placeholder='Enter your email...' required>
                <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                <input type='submit' value='SIGN UP' name='subscribe' id='mc-embedded-subscribe' class='button'></div>
                <div style='position: absolute; left: -5000px;' aria-hidden='true'><input type='text' name='b_08fc01a537bd1c8449c7fc203_23db697d32' tabindex='-1' value=''></div>
            </form>
        </div>
    </div>
    <!--End mc_embed_signup-->
    <?php return ob_get_clean();
}
