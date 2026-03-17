<?php

//require(dirname( __FILE__ ) . '/wp-config.php');
require( dirname( __FILE__ ) . '/wp-load.php' );


if ($argc > 1) {
    $custom_clear_ok = $argv[1];
    if($custom_clear_ok == 'makesense'){
             if (class_exists('\LiteSpeed\Purge')) {
        \LiteSpeed\Purge::purge_all();
        
        }
        //wp_mail('airport0021@mailinator.com', 'Cron Triggered', 'Cron Triggered');    
    }else{
        //wp_mail('airport0021@mailinator.com', 'Parameter not Triggered', 'Parameter not Triggered');    
    }
    
} else {
    //wp_mail('airport0021@mailinator.com', 'Issue in File', 'Invalid parameter passed: ');
}

/*

Temporarily Commented
if (isset($_GET['custom_clear_ok'])) {
    
    
    if ($_GET['custom_clear_ok'] == 'makesense') {
        
       if (class_exists('\LiteSpeed\Purge')) {
        \LiteSpeed\Purge::purge_all();
        
        }
       
    } else {
        wp_mail('airport0021@mailinator.com', 'Issue in File', 'Invalid parameter passed ');
    }
}
*/