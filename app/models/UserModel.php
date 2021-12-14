<?php
class UserModel
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

    function getCurrentUser($email = null, $password = null)
    {

        $query = "SELECT * FROM users WHERE email=:email AND password=:password ";

        // prepare query statement
        $stmt = $this->conn->prepare($query);
        $email = sanitize($_POST['email']);
        $password = sanitize($_POST['psw']);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", sha1($password));
        // print_r($stmt);
        // execute query
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function createNewUser($save = null)
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
            $name = sanitize($save['name']);
            $email = sanitize($save['email']);
            $phone = sanitize($save['phone']);
            $password = sha1($save['psw']);

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
            $line1 = sanitize($save['line1']);
            $line2 = sanitize($save['line2']);
            $country_code = sanitize($save['country']);
            $state = sanitize($save['state']);
            $city = sanitize($save['city']);
            $zipcode = sanitize($save['zipcode']);

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
}
