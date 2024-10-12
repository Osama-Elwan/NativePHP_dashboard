<?php

include "../includes/dbConnection.php";
if(isset($_GET['id'])){
    
    $id = $_GET['id'];
    // $result = $connect->query("SELECT * FROM employee WHERE ssn = $ssn");
    
    $sql = "UPDATE users SET is_admin = 1 WHERE id = :id";
    $stmt = $connect->prepare($sql);
    $stmt->execute(['id' => $id]);
    header("location: index.php");
}else {
    echo "<h1 style ='color:red:text-align:center:'>Wrong Page</h1>"; 
    exit();
}