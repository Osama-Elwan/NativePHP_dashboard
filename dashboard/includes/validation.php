<?php

$errors = []; 

function checkDublicate($col, $table, $val){
    global $connect;
    $code_result = $connect->query("SELECT $col FROM $table WHERE $col ='$val'");
    return $code_result->rowCount();
}

function checkInputs($input){
    $input = trim($input);
    $input = stripslashes($input);
    $input = strip_tags($input);
    $input = strtolower($input);
    return $input;
}

function ssnValidation($ssn){
    global $errors;
    if(empty($ssn)){
        $errors['emp_ssn'] = "Enter SSN, please.";
    } elseif (!(strlen($ssn) == 6 && preg_match('/^\d{6}$/', $ssn))) {
        $errors['emp_ssn'] = "SSN must be  6 digits.";
    }
    return $ssn;
}

function fnameValidation($fname){
    global $errors;
    if(empty($fname)){
        $errors['fname'] = "Enter first name, please.";
    } elseif (!(strlen($fname) >= 3 && strlen($fname) <= 15 && preg_match('/^[a-zA-Z]{3,15}$/', $fname))) {
        $errors['fname'] = "First name must be 3 to 15 alphabetic characters.";
    }
    return $fname;
}

function lnameValidation($lname){
    global $errors;
    if(empty($lname)){
        $errors['lname'] = "Enter last name, please.";
    } elseif (!(strlen($lname) >= 3 && strlen($lname) <= 15 && preg_match('/^[a-zA-Z]{3,15}$/', $lname))) {
        $errors['lname'] = "Last name must be 3 to 15 alphabetic characters.";
    }
    return $lname;
}

function bdateValiation($birthdate){
    global $errors;
    $birthdateDateTime = new DateTime($birthdate);
    $currentDate = new DateTime();
    $age = $currentDate->diff($birthdateDateTime)->y;
    if($age < 20){
        $errors['age'] = "Age under 20 is not allowed.";
    }
    return $birthdate;
}
function salaryValidation($salary){
    global $errors;
    if(!is_numeric($salary) || $salary < 1000 || $salary > 10000){
        $errors['salary'] = "Salary must be a number between 1000 and 10000.";
    }
    return $salary;
}
function integersValidation($input){
    global $errors;
    if (!(strlen($input) >= 1 && strlen($input) <= 6 && preg_match('/^\d{1,6}$/', $input))) {
        $errors['integer_error'] = "$input must be a number with 6 digits or less.";
    }
    return $input;
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}