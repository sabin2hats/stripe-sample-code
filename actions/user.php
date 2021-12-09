<?php

class User
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

    function create($data = null)
    {

        // query to insert record

        $query = "INSERT INTO
                users
            SET
                name=:name, email=:email, phone=:phone, address=:address, password=:password ,created_at=:created_at";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $name = htmlspecialchars(strip_tags($data['name']));
        $email = htmlspecialchars(strip_tags($data['email']));
        $phone = htmlspecialchars(strip_tags($data['phone']));
        $address = htmlspecialchars(strip_tags($data['address']));
        $password = sha1($data['psw']);

        // bind values
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":phone", $phone);
        $stmt->bindParam(":address", $address);
        $stmt->bindParam(":password", $password);
        $stmt->bindParam(":created_at", date('Y-m-d'));
        // execute query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
    function login($data = null)
    {
        $psd = sha1($data['psw']);
        $query = "SELECT * FROM users WHERE email = :email AND password = :password ";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind id of product to be updated
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $psd);
        // print_r($stmt);
        // execute query
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    function get_countries()
    {
        $query = "SELECT * FROM countries ";

        // prepare query statement
        $stmt = $this->conn->prepare($query);
        // print_r($stmt);
        // execute query
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function get_states_bycountry($country_code = null)
    {
        $query = "SELECT name FROM states WHERE  country_code =" . "'$country_code'";

        // prepare query statement
        $stmt = $this->conn->prepare($query);
        // print_r($stmt);
        // execute query
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
