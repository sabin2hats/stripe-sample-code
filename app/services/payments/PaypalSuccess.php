<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once '../../../vendor/autoload.php';
require_once '../../models/OrdersModel.php';
$ordersModel = new OrdersModel();
$control = new Controller();
$stripe = new \Stripe\StripeClient(STRIPE_API_KEY);
$paymentDetails = $stripe->paymentIntents->retrieve(
    $_GET['payment_intent'],
    []
);
$orderArray = array();
if (!empty($paymentDetails)) {
    // echo '<pre>';
    // print_r($paymentDetails);
    $orderArray['orderAmount'] = ($paymentDetails->amount) / 100;
    $orderArray['orderStatus'] = ($_GET['redirect_status'] == "succeeded") ? 'Success' : 'Failed';
    $orderArray['clientSecret'] = $paymentDetails->client_secret;
    $orderArray['id'] = $paymentDetails->id;
    $ordersModel->updateOrder($orderArray);
    $control->redirect('checkout/paymentSuccess/?redirect_status=' . $_GET['redirect_status']);
}
