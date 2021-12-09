<?php

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
}
