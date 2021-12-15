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

    public function getCountries()
    {

        $query = "SELECT * FROM countries ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getStatesByCountry($countryCode = null)
    {
        if ($countryCode) {
            $query = "SELECT name FROM states WHERE  country_code =" . "'$countryCode'";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return false;
    }
}
