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
    function readOneuser($userid = null)
    {
        if ($userid) {
            // query to read single record
            $query = "SELECT * FROM `users` u
            LEFT JOIN user_address ua ON ua.user_id = u.id 
            where u.id=" . $userid . " ";

            // prepare query statement
            $stmt = $this->conn->prepare($query);
            // execute query
            $stmt->execute();

            // get retrieved row
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            return $row;
        }
        return false;
    }

    function create($data = null)
    {
        try {
            $this->conn->beginTransaction();
            // query to insert record

            $query = "INSERT INTO
                users
            SET
                name=:name, email=:email, phone=:phone, password=:password ,created_at=:created_at";

            // prepare query
            $stmt = $this->conn->prepare($query);

            // sanitize
            $name = htmlspecialchars(strip_tags($data['name']));
            $email = htmlspecialchars(strip_tags($data['email']));
            $phone = htmlspecialchars(strip_tags($data['phone']));
            $password = sha1($data['psw']);

            // bind values
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":phone", $phone);
            $stmt->bindParam(":password", $password);
            $stmt->bindParam(":created_at", date('Y-m-d'));
            // execute query
            $stmt->execute();

            $id = $this->conn->lastInsertId();
            // $id = 1;
            $query2 = "INSERT INTO
                user_address
            SET
                user_id=:user_id, line1=:line1, line2=:line2, country_code=:country_code ,state=:state,city=:city,zipcode=:zipcode";

            // prepare query
            $stmt2 = $this->conn->prepare($query2);

            // sanitize
            $line1 = htmlspecialchars(strip_tags($data['line1']));
            $line2 = htmlspecialchars(strip_tags($data['line2']));
            $country_code = htmlspecialchars(strip_tags($data['country']));
            $state = htmlspecialchars(strip_tags($data['state']));
            $city = htmlspecialchars(strip_tags($data['city']));
            $zipcode = htmlspecialchars(strip_tags($data['zipcode']));

            // bind values
            $stmt2->bindParam(":user_id", $id);
            $stmt2->bindParam(":line1", $line1);
            $stmt2->bindParam(":line2", $line2);
            $stmt2->bindParam(":country_code", $country_code);
            $stmt2->bindParam(":state", $state);
            $stmt2->bindParam(":city", $city);
            $stmt2->bindParam(":zipcode", $zipcode);
            $stmt2->execute();
            // if ($stmt2->execute()) {
            //     return true;
            // } else {
            //     echo 'Error occurred:' . implode(":", $stmt2->errorInfo());
            //     die;
            // }



            if ($this->conn->commit()) {
                return true;
            }
        } catch (Exception $e) {

            $this->conn->rollBack();
            // return false;
            echo "Failed: " . $e->getMessage();
            die;
        }
        return false;
    }
    function login($data)
    {
        $query = "SELECT * FROM users WHERE email=:email AND password=:password ";

        // prepare query statement
        $stmt = $this->conn->prepare($query);
        $email = htmlspecialchars(strip_tags($data['email']));
        $password = htmlspecialchars(strip_tags($data['psw']));
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", sha1($password));
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
        if ($country_code) {
            $query = "SELECT name FROM states WHERE  country_code =" . "'$country_code'";

            // prepare query statement
            $stmt = $this->conn->prepare($query);
            // print_r($stmt);
            // execute query
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return false;
    }
}
