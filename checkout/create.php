<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require '../vendor/autoload.php';
// require_once('stripe-php/init.php');

require_once('../actions/product.php');
require_once('../actions/connection.php');
$pdt = new Product($conn);


// This is your test secret API key.
\Stripe\Stripe::setApiKey('sk_test_51K3xsPSDQHE9e11yXhRc6GhtcjmahbH4mJek20PfyIT1fnnS2KAm3CmHMZ7ZXlYA885qR3Q4bUpUmKAhOTjT6OUA00IQc1OG1l');

function calculateOrderAmount($price, $quantity = 1): int
{
    // Replace this constant with a calculation of the order's amount
    // Calculate the order total on the server to prevent
    // people from directly manipulating the amount on the client
    return $price * $quantity * 100;
    // return 1400;
}

header('Content-Type: application/json');

try {
    // retrieve JSON from POST body
    $jsonStr = file_get_contents('php://input');
    $jsonObj = json_decode($jsonStr);
    $all_pdt = $pdt->readOne($jsonObj->items->pdt_id);
    // print_r($all_pdt);
    // die;

    // Create a PaymentIntent with amount and currency
    $paymentIntent = \Stripe\PaymentIntent::create([
        'amount' => calculateOrderAmount($all_pdt['price'], 1),
        'currency' => 'inr',
        'automatic_payment_methods' => [
            'enabled' => true,
        ],

    ]);

    $output = [
        'clientSecret' => $paymentIntent->client_secret,
    ];

    echo json_encode($output);
} catch (Error $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
