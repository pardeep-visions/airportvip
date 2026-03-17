<?php

define('ABSPATH', __DIR__);

require 'wp-content/themes/heathrowvip/booking-form/vendor/autoload.php';

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

if (strpos($_SERVER['SERVER_NAME'], '.local') !== false) {
    define('VIP_ENVIRONMENT', 'DEV');
} elseif (strpos($_SERVER['SERVER_NAME'], 'squaresocket.com') !== false) {
    define('VIP_ENVIRONMENT', 'STAGING');
} else {
    define('VIP_ENVIRONMENT', 'PRODUCTION');
}

//Set to production for live
// define('VIP_ENVIRONMENT', 'PRODUCTION');

require_once('wp-content/themes/heathrowvip/booking-form/vip_classes/Main.php');
require_once('wp-content/themes/heathrowvip/booking-form/vip_classes/Config.php');
require_once('wp-content/themes/heathrowvip/booking-form/vip_classes/Helpers.php');
require_once('wp-content/themes/heathrowvip/booking-form/vip_classes/Ajax.php');

/**
 * Handles Stripe webhooks
 * 
 * 1) Verify users' Stripe payment 
 * 2) Create Apointedd booking on success (reservation_id and customer_id params in response)
 * 
 * 
 * Notes
 * ----
 * For testing @see https://stripe.com/docs/stripe-cli
 * 
 * 1) Install Stripe CLI
 * 2) Run commands
 * 
 * //Auth
 * > Stripe login 
 * //Forward to your local install
 * > Stripe listen --forward-to heathrowlatest.local/webhook.php
 * //Webhooks will now pass to your local install
 */

//Set Api key 
\Stripe\Stripe::setApiKey(Config::get('STRIPE_PRIVATE_KEY'));

// This is your Stripe CLI webhook secret for testing your endpoint locally.
$endpoint_secret = Config::get('WEBHOOK_SECRET');

$payload = @file_get_contents('php://input');
$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'] ?? false;
$event = null;

try {
    $event = \Stripe\Webhook::constructEvent(
        $payload,
        $sig_header,
        $endpoint_secret
    );
} catch (\UnexpectedValueException $e) {
    // Invalid payload
    http_response_code(400);
    exit();
} catch (\Stripe\Exception\SignatureVerificationException $e) {
    // Invalid signature
    http_response_code(400);
    exit();
}

$response = json_decode($payload);

// Handle the event
switch ($response->type) {
    case 'payment_intent.succeeded':
        $meta = $response->data->object->metadata;
        $form_data = (array) json_decode($meta->form_data);
        $reservation_id = $meta->reservation_id;
        $reservation_id_2 = $meta->reservation_id_2;
        $customer_id = $meta->customer_id;
        $main = new AppointedInterface;

        $response = $main->createBooking($reservation_id, $customer_id, $form_data, 1);

        if ($reservation_id_2) {
            $response2 = $main->createBooking($reservation_id_2, $customer_id, $form_data, 2);
        }

        $contents = $response->getBody()->getContents();
        
        if ($reservation_id_2) {
            $contents2 = $response2->getBody()->getContents();
        }


        $contents = json_decode($contents);

        $has_error = false;

        $status_code_1 = (string) $response->getStatusCode();

        if ($status_code_1[0] != '2') {
            $error_message = 'A booking reservation has failed after taking payment. Check Stripe webhook logs. Appointed reservation ID: ' . $reservation_id . '.<br><br>';
            mail("karl@squaresocket.com", "Apointedd API error", $error_message);
            // mail("richard@squaresocket.com", "Apointedd API error", $error_message);
            $has_error = true;
            echo $error_message;
        }

        if ($reservation_id_2) {
            $status_code_2 = (string) $response2->getStatusCode();
            $contents2 = json_decode($contents2);
            if ($status_code_2[0] != '2') {
                $error_message = 'A booking reservation has failed after taking payment. Check Stripe webhook logs. Appointed reservation ID: ' . $reservation_id_2;
                mail("karl@squaresocket.com", "Apointedd API error", $error_message);
                // mail("richard@squaresocket.com", "Apointedd API error", $error_message);
                $has_error = true;
                echo $error_message;
            }
        }

        break;
    default:
        echo 'Received unknown event type ' . $event->type;
        break;
}

if ($has_error == true) {
    mail("karl@squaresocket.com", "Apointedd API error", 'A booking reservation has failed after taking payment.');
    echo 'A booking reservation has failed after taking payment.';
    http_response_code(500);
    die();
} else {
    http_response_code(200);
}
