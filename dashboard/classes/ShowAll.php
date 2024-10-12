<?php
class Employee {
    private $connect;
    private $employees;

    public function __construct($connect) {
        $this->connect = $connect;
        $this->employees = [];
    }

    public function fetchAllEmployees() {
        $result = $this->connect->query("
            SELECT e.fname, e.lname, e.ssn, e.bdate, e.address, e.gender, e.salary, e.superssn, e.dno, 
                   d.dname, s.fname AS super_fname, s.lname AS super_lname
            FROM employee e
            JOIN department d ON e.dno = d.dnum
            LEFT JOIN employee s ON e.superssn = s.ssn
        ");
        $this->employees = $result->fetchAll(PDO::FETCH_ASSOC);
        return $this->employees;
    }

    public function getAge($bdate) {
        $dob = new DateTime($bdate);
        $today = new DateTime('today');
        return $dob->diff($today)->y;
    }

    public function getEmployees() {
        return $this->employees;
    }
}


?>
