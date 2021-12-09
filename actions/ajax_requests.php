<?php
require_once('user.php');
require_once('connection.php');
$objs = new User($conn);
switch ($_POST['function']) {
    case 'get_states':
        echo json_encode($objs->get_states_bycountry($_POST['country_code']));
        break;
}
