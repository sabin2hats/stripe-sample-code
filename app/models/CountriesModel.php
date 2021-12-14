<?php
class CountriesModel
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $db = $database->dbConnect();
        $this->conn = $db;
    }

    /* Test (database and table needs to exist before this works)
        public function getUsers() {
            $this->db->query("SELECT * FROM users");

            $result = $this->db->resultSet();

            return $result;
        }
        */

    function getCountries()
    {

        $query = "SELECT * FROM countries ";

        // prepare query statement
        $stmt = $this->conn->prepare($query);
        // print_r($stmt);
        // execute query
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    function getStatesByCountry($countryCode = null)
    {
        if ($countryCode) {
            $query = "SELECT name FROM states WHERE  country_code =" . "'$countryCode'";

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
