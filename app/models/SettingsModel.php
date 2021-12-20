<?php

class SettingsModel extends Database
{

    public function __construct()
    {
        $database = new Database();
        $db = $database->dbConnect();
        $this->conn = $db;
    }
    public function getApikey()
    {
        try {

            $query = "SELECT * FROM `apikeys` ";
            $stmt = $this->conn->prepare($query);
            if ($stmt->execute()) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                echo 'Error occurred:' . implode(":", $stmt->errorInfo());
                die;
            }
        } catch (PDOException $e) {
            return 'Message: ' . $e->getMessage();
        }
    }
    public function saveApikey($save = null)
    {

        // $query = "INSERT INTO `apikeys`
        // (`apikey`) 
        // VALUES
        // (" . addQuotes($save['apiKey']) . ")";

        $query = "UPDATE `apikeys`
        SET `apikey` = " . addQuotes($save['apiKey']) . " ";

        $stmt = $this->conn->prepare($query);
        if ($stmt->execute()) {
            return true;
        } else {
            echo 'Error occurred:' . implode(":", $stmt->errorInfo());
            die;
        }
        return false;
    }
    public function getredListedmails()
    {
        try {

            $query = "SELECT * FROM `redlisted_emails` ";
            $stmt = $this->conn->prepare($query);
            if ($stmt->execute()) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                echo 'Error occurred:' . implode(":", $stmt->errorInfo());
                die;
            }
        } catch (PDOException $e) {
            return 'Message: ' . $e->getMessage();
        }
    }
    public function redListemails($save = null)
    {

        // $query = "INSERT INTO `apikeys`
        // (`apikey`) 
        // VALUES
        // (" . addQuotes($save['apiKey']) . ")";

        $query = "UPDATE `redlisted_emails`
        SET `emails` = " . addQuotes($save['emails']) . " ";

        $stmt = $this->conn->prepare($query);
        if ($stmt->execute()) {
            return true;
        } else {
            echo 'Error occurred:' . implode(":", $stmt->errorInfo());
            die;
        }
        return false;
    }
}
