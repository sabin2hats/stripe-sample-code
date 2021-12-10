<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require '../vendor/autoload.php';
require_once('../actions/connection.php');
require_once('../actions/product.php');
$pdt = new Product($conn);
$stripe = new \Stripe\StripeClient(
    'sk_test_51K3xsPSDQHE9e11yXhRc6GhtcjmahbH4mJek20PfyIT1fnnS2KAm3CmHMZ7ZXlYA885qR3Q4bUpUmKAhOTjT6OUA00IQc1OG1l'
);
$paymentDetails = $stripe->paymentIntents->retrieve(
    $_GET['payment_intent'],
    []
);

// echo '<pre>';
// print_r($paymentDetails);
$orderArray = array();
$orderArray['orderAmount'] = $paymentDetails->amount;
$orderArray['orderStatus'] = ($_GET['redirect_status'] == "succeeded") ? 'Success' : 'Failed';
$orderArray['clientSecret'] = $paymentDetails->client_secret;
$orderArray['id'] = $paymentDetails->id;
$pdt->updateOrder($orderArray);



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>

    <div class="container">
        <h2>Payment Status</h2>
        <?php if ($_GET['redirect_status'] == 'succeeded') { ?>
            <div class="alert alert-success">
                <strong>Success!</strong> Your Payment is Success.
            </div>
        <?php } else { ?>

            <div class="alert alert-danger">
                <strong>Payment Failed!</strong>
            </div>
        <?php } ?>
        <div align="center">
            <button class="btn btn-primary" onclick="location.href='http://localhost/stripe-sample-code';">Continue Shopping</button>
        </div>

    </div>

</body>

</html>