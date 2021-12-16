<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once '../../../vendor/autoload.php';
require_once '../../models/ProductsModel.php';
$productsModel = new ProductsModel();


// This is your test secret API key.
\Stripe\Stripe::setApiKey(STRIPE_API_KEY);

function calculateOrderAmount($price, $quantity = 1): int
{
    return $price * $quantity * 100;
}

header('Content-Type: application/json');

try {
    // retrieve JSON from POST body
    $jsonStr = file_get_contents('php://input');
    $jsonObj = json_decode($jsonStr);
    $allPdt = $productsModel->getOne($jsonObj->items->pdtId);
    // print_r($all_pdt);
    // die;

    // Create a PaymentIntent with amount and currency
    $paymentIntent = \Stripe\PaymentIntent::create([
        'amount' => calculateOrderAmount($allPdt['price'], 1),
        'currency' => 'inr',
        'automatic_payment_methods' => [
            'enabled' => true,
        ],

    ]);

    $output = [
        'clientSecret' => $paymentIntent->client_secret,
        'id' => $paymentIntent->id
    ];

    echo json_encode($output);
} catch (Error $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
