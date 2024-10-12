<?php

require_once '../classes/Database.php';
require_once '../classes/Validation.php'; 

class EmployeeInsertion {
    private $db;
    private $validator;

    public function __construct() {
        $this->db = new Database();
        $this->validator = new EmployeeValidator();
    }

    public function insertEmployee($data) {
        $errors = $this->validator->validateForm($data); 

        if (!empty($errors)) {
            return $errors;
        }

        try {
            $query = "INSERT INTO employee (ssn, fname, lname, address, salary, superssn, bdate, gender, department) VALUES (:ssn, :fname, :lname, :address, :salary, :superssn, :bdate, :gender, :department)";
            $stmt = $this->db->connect->prepare($query);
            $stmt->bindParam(':ssn', $data['ssn']);
            $stmt->bindParam(':fname', $data['fname']);
            $stmt->bindParam(':lname', $data['lname']);
            $stmt->bindParam(':address', $data['address']);
            $stmt->bindParam(':salary', $data['salary']);
            $stmt->bindParam(':superssn', $data['superssn']);
            $stmt->bindParam(':bdate', $data['bdate']);
            $stmt->bindParam(':gender', $data['gender']);
            $stmt->bindParam(':department', $data['dno']);

            if ($stmt->execute()) {
                $this->uploadImage($_FILES['image']);
                return true;
            } else {
                $errorInfo = $stmt->errorInfo();
                return ["Failed to insert employee data. SQL Error: " . $errorInfo[2]];
            }
        } catch (Exception $e) {
            return [$e->getMessage()];
        }
    }

    private function uploadImage($image) {
        if ($this->validator->validateImage($image)) {
            $targetDir = "../uploads/images/";
            $targetFile = $targetDir . basename($image["name"]);

            if (move_uploaded_file($image["tmp_name"], $targetFile)) {
                echo "File uploaded successfully.";
            } else {
                echo "Failed to upload file.";
            }
        } else {
            echo "Invalid image upload.";
        }
    }
}

?>
