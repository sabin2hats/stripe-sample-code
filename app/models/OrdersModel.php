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
            JOIN `countries` c ON c.sortname = a.ship_country ORDER BY a.created_at DESC";
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
    public function getOne($id = null)
    {
        try {

            $query = "SELECT a.*,c.name as country_name,p.name as product_name FROM `order_details` a
            JOIN `products` p ON p.id = a.product_id
            JOIN `countries` c ON c.sortname = a.ship_country 
            WHERE a.id = " . $id . "
            ORDER BY a.created_at DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $allorders = $stmt->fetch(PDO::FETCH_ASSOC);
            // print_r($allorders);
            // die;
            return $allorders;
        } catch (PDOException $e) {
            return 'Message: ' . $e->getMessage();
        }
    }
    public function createOrder($formDatastr = null, $orderRisk = null)
    {
        $formData = json_decode($formDatastr);
        $userId = isset($_SESSION['user']) ? $_SESSION['user']['id'] : 'Guest';
        $product_id = (int)$formData->product_id;
        $billPhone = (int)$formData->billPhone;
        $email = $formData->email ? $formData->email : NULL;
        $paymentIntent = $formData->payment_intent ? $formData->payment_intent : NULL;
        $clientSecret = $formData->client_secret ? $formData->client_secret : NULL;
        $shipName = $formData->shipName ? $formData->shipName : NULL;
        $shipPhone = $formData->shipPhone ? $formData->shipPhone : NULL;
        $shipLine1 = $formData->shipLine1 ? $formData->shipLine1 : NULL;
        $shipLine2 = $formData->shipLine2 ? $formData->shipLine2 : NULL;
        $shipCountry = $formData->shipCountry ? $formData->shipCountry : NULL;
        $shipState = $formData->shipState ? $formData->shipState : NULL;
        $shipCity = $formData->shipCity ? $formData->shipCity : NULL;
        $shipZip = $formData->shipZip ? $formData->shipZip : NULL;
        $billName = $formData->billName ? $formData->billName : NULL;
        $billPhone = $billPhone ? $billPhone : NULL;
        $billLine1 = $formData->billLine1 ? $formData->billLine1 : NULL;
        $billLine2 = $formData->billLine2 ? $formData->billLine2 : NULL;
        $billCountry = $formData->billCountry ? $formData->billCountry : NULL;
        $billState = $formData->billState ? $formData->billState : NULL;
        $billCity = $formData->billCity ? $formData->billCity : NULL;
        $billZip = $formData->billZip ? $formData->billZip : NULL;
        $emailStructure = $orderRisk['emailStructure'] ? $orderRisk['emailStructure'] : NULL;
        $emailDomain = $orderRisk['emailDomain'] ? $orderRisk['emailDomain'] : NULL;
        $emailRedlisted = $orderRisk['emailRedlisted'] ? $orderRisk['emailRedlisted'] : NULL;
        $validShippingAddress = $orderRisk['validShippingAddress'] ? $orderRisk['validShippingAddress'] : NULL;
        $riskStatus = $orderRisk['riskStatus'] ? $orderRisk['riskStatus'] : NULL;

        $query = "INSERT INTO `order_details`
        (`product_id`, `user`, `email`,`payment_intent`, `client_secret`, `ship_name`, `ship_phone`, `ship_line1`,
        `ship_line2`, `ship_country`, `ship_state`, `ship_city`, `ship_zip`, `bill_name`, `bill_phone`, `bill_line1`, `bill_line2`, `bill_country`,
        `bill_state`, `bill_city`, `bill_zip`,`email_structure`,`email_domain`, `email_redlisted`,`valid_shipping_address`,`risk_status`) 
        VALUES
        (" . addQuotes($product_id) . ", " . addQuotes($userId) . ", " . addQuotes($email) . "," . addQuotes($paymentIntent) . ", " . addQuotes($clientSecret) . ", 
        " . addQuotes($shipName) . ", " . addQuotes($shipPhone) . ", " . addQuotes($shipLine1) . ",
        " . addQuotes($shipLine2) . ", " . addQuotes($shipCountry) . ", " . addQuotes($shipState) . ", " . addQuotes($shipCity) . ", " . addQuotes($shipZip) . ",
         " . addQuotes($billName) . ", " . addQuotes($billPhone) . ", " . addQuotes($billLine1) . ", " . addQuotes($billLine2) . ", " . addQuotes($billCountry) . ",
        " . addQuotes($billState) . ", " . addQuotes($billCity) . ", " . addQuotes($billZip) . ", " . addQuotes($emailStructure) . ", " . addQuotes($emailDomain) . ",
        " . addQuotes($emailRedlisted) . ", " . addQuotes($validShippingAddress) . ", " . addQuotes($riskStatus) . ")";

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
    public function updateOrderStatus($data)
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
    public function updateOrder($formData = null, $orderRisk = null)
    {
        $formData = (object)$formData;
        $orderID = (int)$formData->orderID;
        $billPhone = (int)$formData->billPhone;
        $email = $formData->email ? $formData->email : NULL;
        $shipName = $formData->shipName ? $formData->shipName : NULL;
        $shipPhone = $formData->shipPhone ? $formData->shipPhone : NULL;
        $shipLine1 = $formData->shipLine1 ? $formData->shipLine1 : NULL;
        $shipLine2 = $formData->shipLine2 ? $formData->shipLine2 : NULL;
        $shipCountry = $formData->shipCountry ? $formData->shipCountry : NULL;
        $shipState = $formData->shipState ? $formData->shipState : NULL;
        $shipCity = $formData->shipCity ? $formData->shipCity : NULL;
        $shipZip = $formData->shipZip ? $formData->shipZip : NULL;
        $billName = $formData->billName ? $formData->billName : NULL;
        $billPhone = $billPhone ? $billPhone : NULL;
        $billLine1 = $formData->billLine1 ? $formData->billLine1 : NULL;
        $billLine2 = $formData->billLine2 ? $formData->billLine2 : NULL;
        $billCountry = $formData->billCountry ? $formData->billCountry : NULL;
        $billState = $formData->billState ? $formData->billState : NULL;
        $billCity = $formData->billCity ? $formData->billCity : NULL;
        $billZip = $formData->billZip ? $formData->billZip : NULL;
        $amount = $formData->amount ? $formData->amount : NULL;
        $orderStatus = $formData->orderStatus ? $formData->orderStatus : NULL;
        $emailStructure = $orderRisk['emailStructure'] ? $orderRisk['emailStructure'] : NULL;
        $emailDomain = $orderRisk['emailDomain'] ? $orderRisk['emailDomain'] : NULL;
        $emailRedlisted = $orderRisk['emailRedlisted'] ? $orderRisk['emailRedlisted'] : NULL;
        $validShippingAddress = $orderRisk['validShippingAddress'] ? $orderRisk['validShippingAddress'] : NULL;
        $riskStatus = $orderRisk['riskStatus'] ? $orderRisk['riskStatus'] : NULL;

        $query = "UPDATE `order_details` SET 
        `email` = " . addQuotes($email) . ",`order_amount`=" . addQuotes($amount) . ",`order_status`=" . addQuotes($orderStatus) . " ,`ship_name` = " . addQuotes($shipName) . ", `ship_phone`=" . addQuotes($shipPhone) . ", 
        `ship_line1`=" . addQuotes($shipLine1) . ",  `ship_line2` =" . addQuotes($shipLine2) . ", `ship_country`=" . addQuotes($shipCountry) . ", `ship_state`=" . addQuotes($shipState) . ",
        `ship_city`= " . addQuotes($shipCity) . ", `ship_zip`=" . addQuotes($shipZip) . ", `bill_name` =" . addQuotes($billName) . ", `bill_phone`=" . addQuotes($billPhone) . ", 
        `bill_line1`=" . addQuotes($billLine1) . ", `bill_line2`=" . addQuotes($billLine2) . ", `bill_country`=" . addQuotes($billCountry) . ",`bill_state`=" . addQuotes($billState) . ", 
        `bill_city`=" . addQuotes($billCity) . ", `bill_zip`=" . addQuotes($billZip) . ",`email_structure`=" . addQuotes($emailStructure) . ",`email_domain`=" . addQuotes($emailDomain) . ",
        `email_redlisted`=" . addQuotes($emailRedlisted) . ",`valid_shipping_address`=" . addQuotes($validShippingAddress) . ",`risk_status`=" . addQuotes($riskStatus) . ",
        `updated_at`=" . addQuotes(date('Y-m-d H:i:s')) . "
        WHERE `id`= " . addQuotes($orderID) . " ";


        $stmt = $this->conn->prepare($query);
        // echo '<pre>';
        // print_r($stmt);
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
}
