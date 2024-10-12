<?php 
    
    // include '../includes/dbConnection.php';

    include "../classes/Database.php";
 

    
  $db = new Database();
  $employeeObj = new Employee($db->connect);

class EmployeeManager {
    private $connect;

    public function __construct($dbConnection) {
        $this->connect = $dbConnection;
    }

    public function deleteEmployee($ssn) {
        $imageResult = $this->getEmployeeImages($ssn);
        
        $deleteResult = $this->connect->query("DELETE FROM employee WHERE ssn='$ssn'");
        
        if ($deleteResult) {
            $this->deleteImages($imageResult);
            header("location:index.php");
        }
    }

    private function getEmployeeImages($ssn) {
        $query = $this->connect->prepare("SELECT * FROM images WHERE emp_ssn = :ssn");
        $query->execute(['ssn' => $ssn]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    private function deleteImages($imageResult) {
        foreach ($imageResult as $image) {
            unlink("../uploads/images/{$image['image_name']}");
        }
    }
}

// Usage example
if (isset($_GET['ssn'])) {
    $ssn = $_GET['ssn'];
    // Assume $connect is your PDO connection
    $employeeManager = new EmployeeManager($connect);
    $employeeManager->deleteEmployee($ssn);
    header('location:index.php');
} else {
    echo "<h1 style='color:red; text-align:center;'>Wrong Page</h1>";
    exit();
}
?>