<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once('user.php');
require_once('product.php');
require_once('connection.php');
$objs = new User($conn);
$pdt = new Product($conn);
// print_r($_POST);
// die;
switch ($_POST['function']) {
    case 'get_states':
        echo json_encode($objs->get_states_bycountry($_POST['country_code']));
        break;
    case 'createOrder':
        $pdt->createOrder($_POST['formdata']);
        break;
}
