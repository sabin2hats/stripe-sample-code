<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require '../vendor/autoload.php';
if (isset($_SESSION['user'])) {
    session_destroy();
    header("Location: http://localhost/stripe-sample-code/users/login.php");
    exit();
} else {
    session_destroy();
    header("Location: http://localhost/stripe-sample-code/users/login.php");
    exit();
}
