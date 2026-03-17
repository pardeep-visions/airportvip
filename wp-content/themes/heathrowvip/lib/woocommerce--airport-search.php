<?php
add_action( 'wp_enqueue_scripts', 'airport_enqueue_script' );
function airport_enqueue_script() {
    wp_enqueue_script( 'hh-airport', get_template_directory_uri().'/assets/js/airport.js', array('jquery', 'jquery-ui-autocomplete'), '1.0.0', true );
}

add_action('storefront_after_footer', 'print_woocommerce_airport_search_code', 90);
function print_woocommerce_airport_search_code()
{
    wp_enqueue_script('jquery-ui-autocomplete');
    ?>
    <style>

        .flatbtn {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            display: inline-block;
            outline: 0;
            border: 0;
            color: #f3faef;
            text-decoration: none;
            background-color: #6bb642;
            border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
            font-size: 1.2em;
            font-weight: bold;
            padding: 12px 22px 12px 22px;
            line-height: normal;
            text-align: center;
            vertical-align: middle;
            cursor: pointer;
            text-transform: uppercase;
            text-shadow: 0 1px 0 rgba(0, 0, 0, 0.3);
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
            -webkit-box-shadow: 0 1px 0 rgba(15, 15, 15, 0.3);
            -moz-box-shadow: 0 1px 0 rgba(15, 15, 15, 0.3);
            box-shadow: 0 1px 0 rgba(15, 15, 15, 0.3);
        }

        .flatbtn:hover {
            color: #fff;
            background-color: #73c437;
        }

        .flatbtn:active {
            -webkit-box-shadow: inset 0 1px 5px rgba(0, 0, 0, 0.1);
            -moz-box-shadow: inset 0 1px 5px rgba(0, 0, 0, 0.1);
            box-shadow: inset 0 1px 5px rgba(0, 0, 0, 0.1);
        }

        .airports-suggestions {
            border: 1px solid #999;
            background: #fff;
            cursor: default;
            overflow: auto;
        }

        .airports-suggestion {
            padding: 10px 5px;
            font-size: 1.2em;
            white-space: nowrap;
            overflow: hidden;
        }

        .airports-selected {
            background: #f0f0f0;
        }

        .airports-suggestions strong {
            font-weight: normal;
            color: #3399ff;
        }


    </style>

    <?php

}