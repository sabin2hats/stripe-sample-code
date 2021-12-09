<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
// require 'vendor/autoload.php';
// require_once('stripe-php/init.php');

require_once('../actions/user.php');
require_once('../actions/connection.php');
$user = new User($conn);

// echo '<pre>';
// print_r($user->login($_POST));
$userdet = $user->login($_POST);
if (!empty($userdet)) {
    @session_start();
    $_SESSION['user'] = $userdet;
} else {
    header("Location: http://localhost/stripe-sample-code/users/login.php?success=2");
    exit();
}
if (isset($_SESSION['user'])) {
    // echo "Success";
    header("Location: http://localhost/stripe-sample-code/");
    exit();
}
