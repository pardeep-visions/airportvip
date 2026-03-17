<?php ob_start(); ?>

<style>
body.wp-admin #wpbody-content > .wrap > [class*="notice"] {
    display: none;
}
</style>

<?php $style = ob_get_clean(); ?>

<?php

$user = wp_get_current_user();

if(is_admin() && $user->user_login != 'richardh' && $user->user_login != 'karlm') {
    echo $style;
} 
