<?php

class ProductsModel extends Database
{

    public function __construct()
    {
        $database = new Database();
        $db = $database->dbConnect();
        $this->conn = $db;
    }
    public function getAll()
    {

        $query = "SELECT * FROM `products` where image !=''";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $allProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // print_r($allproducts);
        // die;
        return $allProducts;
    }

    public function getOne($id = null)
    {
        $query = "SELECT * FROM `products` where id=" . $id . " ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
}
