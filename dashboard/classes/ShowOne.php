<?php

class Employee {
    private $db;
    private $ssn;

    public function __construct($db, $ssn) {
        $this->db = $db->connect;
        $this->ssn = $ssn;
    }

    public function getEmployeeData() {
        $query = $this->db->prepare("
            SELECT e.fname, e.lname, e.ssn, e.bdate, e.address, e.gender, e.salary, e.superssn, e.dno, d.dname, s.fname AS super_fname, s.lname AS super_lname
            FROM employee e
            JOIN department d ON e.dno = d.dnum
            LEFT JOIN employee s ON e.superssn = s.ssn 
            WHERE e.ssn = :ssn
        ");
        $query->execute(['ssn' => $this->ssn]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function getEmployeeImages() {
        $query = $this->db->prepare("SELECT * FROM images WHERE emp_ssn = :ssn");
        $query->execute(['ssn' => $this->ssn]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAge($bdate) {
        $dob = new DateTime($bdate);
        $today = new DateTime('today');
        return $dob->diff($today)->y;
    }
}
?>
