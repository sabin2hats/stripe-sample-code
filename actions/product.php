<?php
function addQuotes($str)
{
    return "'$str'";
}
class Product
{

    // database connection and table name
    private $conn;
    private $table_name = "products";

    // object properties
    public $id;
    public $name;
    public $description;
    public $price;
    public $category_id;
    public $category_name;
    public $created;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }
    // read products
    function read_all()
    {

        // select all query
        $query = "SELECT * FROM `products` where image !=''";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();
        $allproducts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // print_r($allproducts);
        // die;
        return $allproducts;
    }

    // used when filling up the update product form
    function readOne($id = null)
    {

        // query to read single record
        $query = "SELECT * FROM `products` where id=" . $id . " ";

        // prepare query statement
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();

        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row;
    }
    function createOrder($formDatastr = null)
    {

        $formData = json_decode($formDatastr);

        $userId = isset($_SESSION['user']) ? $_SESSION['user']['id'] : 'Guest';

        // $query = "INSERT INTO `order_details`
        //     (`product_id`, `user`, `email`,`payment_intent`, `client_secret`, `ship_name`, `ship_phone`, `ship_line1`,
        //     `ship_line2`, `ship_country`, `ship_state`, `ship_city`, `ship_zip`, `bill_name`, `bill_phone`, `bill_line1`, `bill_line2`, `bill_country`,
        //     `bill_state`, `bill_city`, `bill_zip`) 
        //     VALUES
        //     (:product_id, :user, :email,:payment_intent, :client_secret, :ship_name, :ship_phone, :ship_line1,
        //     :ship_line2, :ship_country, :ship_state, :ship_city, :ship_zip, :bill_name, :bill_phone, :bill_line1, :bill_line2, :bill_country,
        //     :bill_state, :bill_city, :bill_zip";
        // $stmt = $this->conn->prepare($query);
        // // bind values
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
        // $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        // $stmt->bindParam(':user', $userId, PDO::PARAM_STR);
        // $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        // $stmt->bindParam(':payment_intent', $paymentIntent, PDO::PARAM_STR);
        // $stmt->bindParam(':client_secret', $clientSecret, PDO::PARAM_STR);
        // $stmt->bindParam(':ship_name', $shipName, PDO::PARAM_STR);
        // $stmt->bindParam(':ship_phone', $shipPhone, PDO::PARAM_STR);
        // $stmt->bindParam(':ship_line1', $shipLine1, PDO::PARAM_STR);
        // $stmt->bindParam(':ship_line2', $shipLine2, PDO::PARAM_STR);
        // $stmt->bindParam(':ship_country', $shipCountry, PDO::PARAM_STR);
        // $stmt->bindParam(':ship_state', $shipState, PDO::PARAM_STR);
        // $stmt->bindParam(':ship_city', $shipCity, PDO::PARAM_STR);
        // $stmt->bindParam(':ship_zip', $shipZip, PDO::PARAM_STR);
        // $stmt->bindParam(':bill_name', $billName, PDO::PARAM_STR);
        // $stmt->bindParam(':bill_phone', $billPhone, PDO::PARAM_INT);
        // $stmt->bindParam(':bill_line1', $billLine1, PDO::PARAM_STR);
        // $stmt->bindParam(':bill_line2', $billLine2, PDO::PARAM_STR);
        // $stmt->bindParam(':bill_country', $billCountry, PDO::PARAM_STR);
        // $stmt->bindParam(':bill_state', $billState, PDO::PARAM_STR);
        // $stmt->bindParam(':bill_city', $billCity, PDO::PARAM_STR);
        // $stmt->bindParam(':bill_zip', $billZip, PDO::PARAM_STR);

        $query = "INSERT INTO `order_details`
        (`product_id`, `user`, `email`,`payment_intent`, `client_secret`, `ship_name`, `ship_phone`, `ship_line1`,
        `ship_line2`, `ship_country`, `ship_state`, `ship_city`, `ship_zip`, `bill_name`, `bill_phone`, `bill_line1`, `bill_line2`, `bill_country`,
        `bill_state`, `bill_city`, `bill_zip`) 
        VALUES
        (" . addQuotes($product_id) . ", " . addQuotes($billPhone) . ", " . addQuotes($email) . "," . addQuotes($paymentIntent) . ", " . addQuotes($clientSecret) . ", " . addQuotes($shipName) . ", " . addQuotes($shipPhone) . ", " . addQuotes($shipLine1) . ",
        " . addQuotes($shipLine2) . ", " . addQuotes($shipCountry) . ", " . addQuotes($shipState) . ", " . addQuotes($shipCity) . ", " . addQuotes($shipZip) . ", " . addQuotes($billName) . ", " . addQuotes($billPhone) . ", " . addQuotes($billLine1) . ", " . addQuotes($billLine2) . ", " . addQuotes($billCountry) . ",
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
    function updateOrder($data)
    {
        if (!empty($data)) {
            // $stmt = $this->conn->prepare("UPDATE order_details SET order_amount = ':order_amount',client_secret=':client_secret',order_status=':order_status' 
            // WHERE payment_intent = ':payment_intent'");
            // $stmt->bindParam(':payment_intent', $data['id'], PDO::PARAM_STR);
            // $stmt->bindParam(':order_amount', $data['orderAmount'], PDO::PARAM_INT);
            // $stmt->bindParam(':client_secret', $data['clientSecret'], PDO::PARAM_STR);
            // $stmt->bindParam(':order_status', $data['orderStatus'], PDO::PARAM_STR);
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
