<?php
add_shortcode('mailchimpinlineshortcode', 'mailchimpinlineshortcode_func');
function mailchimpinlineshortcode_func()
{ 
    ob_start();
    ?>

<!-- Begin Mailchimp Signup Form -->
<link href='//cdn-images.mailchimp.com/embedcode/slim-10_7.css' rel='stylesheet' type='text/css'>
<style type='text/css'>
	#mc_embed_signup{background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif; }
	/* Add your own Mailchimp form style overrides in your site stylesheet or in this style block.
	   We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
</style>
<div class='inline-mailchimp inline-mailchimp-sc' id='mc_embed_signup'>
<form action='<?php the_field('mailchimp_code','option'); ?>' method='post' id='mc-embedded-subscribe-form' name='mc-embedded-subscribe-form' class='novalidate' target='_blank' novalidate>
    <div id='mc_embed_signup_scroll'>
	<input type='email' value='' name='EMAIL' class='email' id='mce-EMAIL' placeholder='Enter your email...' required>
    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
   
    <input type='submit' value='SUBMIT' name='subscribe' id='mc-embedded-subscribe' class='button'></div>
     <div style='position: absolute; left: -5000px;' aria-hidden='true'><input type='text' name='b_08fc01a537bd1c8449c7fc203_23db697d32' tabindex='-1' value=''></div>
</form>
</div>

<!--End mc_embed_signup-->
    <?php 
    
    return ob_get_clean();
}