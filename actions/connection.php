<?php

$db_host = "localhost";
$db_user = "root";
$db_password = "123";
$db_dbname = "api_db";
try {
    $conn = new PDO("mysql:host=$db_host;dbname=$db_dbname", $db_user, $db_password);
    if ($conn) {
        // echo "Connected to the <strong>$db</strong> database successfully!";
    }
} catch (PDOException $e) {
    $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    echo $e->getMessage();
}
