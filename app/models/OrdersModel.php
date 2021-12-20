<?php

class OrdersModel extends Database
{

    public function __construct()
    {
        $database = new Database();
        $db = $database->dbConnect();
        $this->conn = $db;
    }
    public function getAll()
    {
        try {

            $query = "SELECT a.*,c.name as country_name,p.name as product_name FROM `order_details` a
            JOIN `products` p ON p.id = a.product_id
            JOIN `countries` c ON c.sortname = a.ship_country";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $allorders = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // print_r($allorders);
            // die;
            return $allorders;
        } catch (PDOException $e) {
            return 'Message: ' . $e->getMessage();
        }
    }
    public function createOrder($formDatastr = null)
    {
        $formData = json_decode($formDatastr);
        $userId = isset($_SESSION['user']) ? $_SESSION['user']['id'] : 'Guest';
        $product_id = (int)$formData->product_id;
        $billPhone = (int)$formData->billPhone;
        $email = $formData->email ? $formData->email : 'NULL';
        $paymentIntent = $formData->payment_intent ? $formData->payment_intent : 'NULL';
        $clientSecret = $formData->client_secret ? $formData->client_secret : 'NULL';
        $shipName = $formData->shipName ? $formData->shipName : 'NULL';
        $shipPhone = $formData->shipPhone ? $formData->shipPhone : 'NULL';
        $shipLine1 = $formData->shipLine1 ? $formData->shipLine1 : 'NULL';
        $shipLine2 = $formData->shipLine2 ? $formData->shipLine2 : 'NULL';
        $shipCountry = $formData->shipCountry ? $formData->shipCountry : 'NULL';
        $shipState = $formData->shipState ? $formData->shipState : 'NULL';
        $shipCity = $formData->shipCity ? $formData->shipCity : 'NULL';
        $shipZip = $formData->shipZip ? $formData->shipZip : 'NULL';
        $billName = $formData->billName ? $formData->billName : 'NULL';
        $billPhone = $billPhone ? $billPhone : 'NULL';
        $billLine1 = $formData->billLine1 ? $formData->billLine1 : 'NULL';
        $billLine2 = $formData->billLine2 ? $formData->billLine2 : 'NULL';
        $billCountry = $formData->billCountry ? $formData->billCountry : 'NULL';
        $billState = $formData->billState ? $formData->billState : 'NULL';
        $billCity = $formData->billCity ? $formData->billCity : 'NULL';
        $billZip = $formData->billZip ? $formData->billZip : 'NULL';

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
