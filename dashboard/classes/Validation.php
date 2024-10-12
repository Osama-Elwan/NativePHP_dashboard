<?php

class EmployeeValidator {
    private $allowedImageTypes = ['image/jpeg', 'image/png', 'image/gif'];
    private $maxImageSize = 5 * 1024 * 1024;
    public function validateSSN($ssn) {
        return preg_match('/^\d{6}$/', $ssn);
    }

    public function validateName($name) {
        return !empty($name) && preg_match('/^[a-zA-Z\s]+$/', $name);
    }

    public function validateSalary($salary) {
        return is_numeric($salary) && $salary >= 1000 && $salary <= 10000;
    }

    public function validateDate($date) {
        return DateTime::createFromFormat('Y-m-d', $date) !== false;
    }

    public function validateImage($images) {
        $errors = [];

        foreach ($images['tmp_name'] as $index => $tmpName) {
            $fileType = $images['type'][$index];
            $fileSize = $images['size'][$index];
            $fileError = $images['error'][$index];

            // Check for upload errors
            if ($fileError !== UPLOAD_ERR_OK) {
                switch ($fileError) {
                    case UPLOAD_ERR_INI_SIZE:
                    case UPLOAD_ERR_FORM_SIZE:
                        $errors[] = "File size exceeds the limit.";
                        break;
                    case UPLOAD_ERR_PARTIAL:
                        $errors[] = "File was only partially uploaded.";
                        break;
                    case UPLOAD_ERR_NO_FILE:
                        $errors[] = "No file was uploaded.";
                        break;
                    case UPLOAD_ERR_NO_TMP_DIR:
                        $errors[] = "Missing a temporary folder.";
                        break;
                    case UPLOAD_ERR_CANT_WRITE:
                        $errors[] = "Failed to write file to disk.";
                        break;
                    case UPLOAD_ERR_EXTENSION:
                        $errors[] = "A PHP extension stopped the file upload.";
                        break;
                    default:
                        $errors[] = "Unknown upload error.";
                        break;
                }
                continue;
            }

           
            if (!in_array($fileType, $this->allowedImageTypes)) {
                $errors[] = "Invalid file type for file: " . basename($images['name'][$index]);
            }

           
            if ($fileSize > $this->maxImageSize) {
                $errors[] = "File size exceeds the limit for file: " . basename($images['name'][$index]);
            }
        }

        return $errors;
    }

    public function validateForm($data) {
        $errors = [];

        if (!$this->validateSSN($data['ssn'])) {
            $errors[] = "Invalid SSN.";
        }

        if (!$this->validateName($data['fname'])) {
            $errors[] = "Invalid first name.";
        }

        if (!$this->validateName($data['lname'])) {
            $errors[] = "Invalid last name.";
        }

        if (!$this->validateSalary($data['salary'])) {
            $errors[] = "Invalid salary.";
        }

        if (!$this->validateDate($data['bdate'])) {
            $errors[] = "Invalid birthday.";
        }

      
        if (isset($_FILES['image'])) {
            $imageErrors = $this->validateImage($_FILES['image']);
            if (!empty($imageErrors)) {
                $errors = array_merge($errors, $imageErrors);
            }
        }

        return $errors;
    }
}

?>
