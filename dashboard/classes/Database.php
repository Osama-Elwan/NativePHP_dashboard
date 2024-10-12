<?php

class Database {
    public $serverName = "localhost";
    public $username = "root";
    public $password = "";
    public $dbName = "company";
    public $connect;

    public function __construct() {
        try {
            $this->connect = new PDO("mysql:host={$this->serverName};dbname={$this->dbName}", $this->username, $this->password);
            $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            echo $e->getMessage();
            exit();
        }
    }
}
?>
