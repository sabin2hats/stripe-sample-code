<?php

class OrdersModel extends Database
{

    public function __construct()
    {
        $database = new Database();
        $db = $database->dbConnect();
        $this->conn = $db;
    }
    public function createOrder($formDatastr = null)
    {
        $formData = json_decode($formDatastr);
        $userId = isset($_SESSION['user']) ? $_SESSION['user']['id'] : 'Guest';
        $product_id = (int)$formData->product_id;
        $billPhone = (int)$formData->bill_phone;
        $email = $formData->email ? $formData->email : 'NULL';
        $paymentIntent = $formData->payment_intent ? $formData->payment_intent : 'NULL';
        $clientSecret = $formData->client_secret ? $formData->client_secret : 'NULL';
        $shipName = $formData->ship_name ? $formData->ship_name : 'NULL';
        $shipPhone = $formData->ship_phone ? $formData->ship_phone : 'NULL';
        $shipLine1 = $formData->ship_line1 ? $formData->ship_line1 : 'NULL';
        $shipLine2 = $formData->ship_country ? $formData->ship_country : 'NULL';
        $shipCountry = $formData->ship_country ? $formData->ship_country : 'NULL';
        $shipState = $formData->ship_state ? $formData->ship_state : 'NULL';
        $shipCity = $formData->ship_city ? $formData->ship_city : 'NULL';
        $shipZip = $formData->ship_zip ? $formData->ship_zip : 'NULL';
        $billName = $formData->bill_name ? $formData->bill_name : 'NULL';
        $billPhone = $billPhone ? $billPhone : 'NULL';
        $billLine1 = $formData->bill_line1 ? $formData->bill_line1 : 'NULL';
        $billLine2 = $formData->bill_line2 ? $formData->bill_line2 : 'NULL';
        $billCountry = $formData->bill_country ? $formData->bill_country : 'NULL';
        $billState = $formData->bill_state ? $formData->bill_state : 'NULL';
        $billCity = $formData->bill_city ? $formData->bill_city : 'NULL';
        $billZip = $formData->bill_zip ? $formData->bill_zip : 'NULL';

        $query = "INSERT INTO `order_details`
        (`product_id`, `user`, `email`,`payment_intent`, `client_secret`, `ship_name`, `ship_phone`, `ship_line1`,
        `ship_line2`, `ship_country`, `ship_state`, `ship_city`, `ship_zip`, `bill_name`, `bill_phone`, `bill_line1`, `bill_line2`, `bill_country`,
        `bill_state`, `bill_city`, `bill_zip`) 
        VALUES
        (" . addQuotes($product_id) . ", " . addQuotes($userId) . ", " . addQuotes($email) . "," . addQuotes($paymentIntent) . ", " . addQuotes($clientSecret) . ", 
        " . addQuotes($shipName) . ", " . addQuotes($shipPhone) . ", " . addQuotes($shipLine1) . ",
        " . addQuotes($shipLine2) . ", " . addQuotes($shipCountry) . ", " . addQuotes($shipState) . ", " . addQuotes($shipCity) . ", " . addQuotes($shipZip) . ",
         " . addQuotes($billName) . ", " . addQuotes($billPhone) . ", " . addQuotes($billLine1) . ", " . addQuotes($billLine2) . ", " . addQuotes($billCountry) . ",
        " . addQuotes($billState) . ", " . addQuotes($billCity) . ", " . addQuotes($billZip) . ")";

        $stmt = $this->conn->prepare($query);
        // echo '<pre>';
        // print_r($stmt->debugDumpParams());
        // die;
        // execute query
        if ($stmt->execute()) {
            return true;
        } else {
            echo 'Error occurred:' . implode(":", $stmt->errorInfo());
            die;
        }
        return false;
    }
    public function updateOrder($data)
    {
        if (!empty($data)) {

            $stmt = $this->conn->prepare("UPDATE order_details SET order_amount = " . addQuotes($data['orderAmount']) . ",client_secret=" . addQuotes($data['clientSecret']) . ",
            order_status=" . addQuotes($data['orderStatus']) . " 
            WHERE payment_intent = " . addQuotes($data['id']) . "");
            if ($stmt->execute()) {
                return true;
            } else {
                echo 'Error occurred:' . implode(":", $stmt->errorInfo());
                die;
            }
        }
        return false;
    }
}
