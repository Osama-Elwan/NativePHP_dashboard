<?php
$serverName = "localhost";
$username = "root";
$password = "";
$dbName = "company";

try {
    $connect = new PDO("mysql:host=$serverName;dbname=$dbName", $username, $password);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Set error mode to exception
} catch(Exception $e) {
    echo $e->getMessage();
    exit();
}