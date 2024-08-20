<?php
$host = "localhost";
$db = "tiara_db";
$user = "root";
$pass = "";

try{
    $conn = new PDO("mysql:host=$host; dbname=$db", $user, $pass);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    die("Could not connect to database $db: " . $e->getMessage());
}
?>