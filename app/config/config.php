<?php
//Database params
define('DB_HOST', 'localhost'); //Add your db host
define('DB_USER', 'root'); // Add your DB root
define('DB_PASS', '123'); //Add your DB pass
define('DB_NAME', 'api_db'); //Add your DB Name

//APPROOT
define('APPROOT', dirname(dirname(__FILE__)));

//URLROOT (Dynamic links)
define('URLROOT', 'http://localhost/StripeMVC/');

//Sitename
define('SITENAME', 'Stripe MVC');

define('STRIPE_API_KEY', 'sk_test_51K3xsPSDQHE9e11yXhRc6GhtcjmahbH4mJek20PfyIT1fnnS2KAm3CmHMZ7ZXlYA885qR3Q4bUpUmKAhOTjT6OUA00IQc1OG1l');
define('STRIPE_PUBLISHABLE_KEY', 'pk_test_51K3xsPSDQHE9e11yo66oFzwlAEETm1OQKpr60hoI2BcZTQU0G2AW5K1XytzTh8NjTNYBex1e0fFJFg8TM1l9QHv500JKgkzf5j');
define('STRIPE_SUCCESS_URL', URLROOT . 'checkout/paymentSuccess'); //Payment success URL 
// define('STRIPE_CANCEL_URL', 'http://localhost/stripe_checkout_integration_php/payment-cancel.php'); //Payment cancel URL 
