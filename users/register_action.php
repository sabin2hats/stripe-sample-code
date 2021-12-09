<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require '../vendor/autoload.php';
// require_once('stripe-php/init.php');

require_once('../actions/user.php');
require_once('../actions/connection.php');
$user = new User($conn);
if ($user->create($_POST)) {
    // echo "Success";
    header("Location: http://localhost/stripe-sample-code/users/login.php?success=1");
    exit();
} else {
    header("Location: http://localhost/stripe-sample-code/users/login.php?success=0");
    exit();
}
// print_r($_POST);
