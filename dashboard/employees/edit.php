    <?php 
    
    include '../includes/dbConnection.php';
    include '../includes/validation.php';
    
    //get employee data
    if(isset($_GET['ssn'])){

        $ssn = $_GET['ssn'];
    }else {
        echo "<h1 style ='color:red:text-align:center:'>Wrong Page</h1>"; 
        exit();
    }
    $get_result = $connect->query("SELECT e.fname, e.lname, e.ssn, e.bdate, e.address, e.gender, e.salary, e.superssn, e.dno, s.fname AS super_fname, s.lname AS super_lname
FROM employee e

LEFT JOIN employee s ON e.superssn = s.ssn WHERE e.ssn = $ssn" 
);
$get_data = $get_result->fetch(PDO::FETCH_ASSOC);
$ImageQuery = $connect->query("SELECT * FROM images where emp_ssn =$ssn");
$imageResult = $ImageQuery->fetchAll(PDO::FETCH_ASSOC);

// var_dump($imageResult);
// die();

    //edit employee
    $dept_result = $connect->query("SELECT * FROM department");
    $dept_data = $dept_result->fetchAll(PDO::FETCH_ASSOC); 

    $super_result = $connect->query("SELECT * FROM employee");
    $super_data = $super_result->fetchAll(PDO::FETCH_ASSOC); 

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    global $errors;

    // $SSN = ssnValidation(checkInputs($_POST['ssn']));
    $fname = fnameValidation(checkInputs($_POST['fname']));
    $lname = lnameValidation(checkInputs($_POST['lname']));
    $address = checkInputs($_POST['address']);
    $salary = salaryValidation(checkInputs($_POST['salary']));
    $supervisor = integersValidation(checkInputs($_POST['supervisor']));
    $bdate = bdateValiation(checkInputs($_POST['bdate']));
    $gender = checkInputs($_POST['gender']);
    $dno = integersValidation(checkInputs($_POST['dno']));
    $images= $_FILES['image'];
    $imageNames = $_FILES['image']['name'];
    $imageTmps = $_FILES['image']['tmp_name']; 
    // var_dump($gender);
    // die();

    if (!empty($imageNames[0])) {
        $selectedImages = [];
        $selectedTmps = [];
    
        for ($i = 0; $i < count($imageNames); $i++) {
            $selectedImages[] = $imageNames[$i]; 
            $selectedTmps[] = $imageTmps[$i]; 
        }
    
        
        // var_dump($selectedImages);
        // die();
    } else {
        $selectedImages = [];
        for ($i = 0; $i < count($imageResult); $i++) {
            $selectedImages[] = $imageResult[$i]['image_name']; // Use existing images from the database
        }
    
        
        // var_dump($selectedImages);
        // die();
    }
    

        
    // if(checkDublicate("ssn", "employee", $SSN) > 0){
    //     $errors['ssn'] = "Duplicated SSN.";
    // }


    if (empty($errors)) {
        
        $editResult = $connect->query("UPDATE `employee` SET `fname`='$fname', `lname`='$lname', `bdate`='$bdate', `address`='$address', `gender`='$gender', `salary`='$salary', `superssn`='$supervisor', `dno`='$dno' WHERE ssn =$ssn");
    
        if ($editResult) {
            
            $allowedExt = ["jpeg", "jpg", "png", "gif"];
            $imageCode = generateRandomString(10); 
    
            if (!empty($imageNames[0])) { 
                
                for ($i = 0; $i < count($imageNames); $i++) {
                    $imageExt = pathinfo($imageNames[$i], PATHINFO_EXTENSION);
                    $imageExt = strtolower($imageExt);
                    $newImageName = $imageCode . "_" . $i . "." . $imageExt;
    
                    if (in_array($imageExt, $allowedExt)) {
                        
                        $imageInsert = $connect->query("INSERT INTO `images`(`emp_ssn`, `image_name`) VALUES ('$ssn','$newImageName')");
                        if ($imageInsert) {
                            move_uploaded_file($imageTmps[$i], "../uploads/images/$newImageName");
                        } else {
                            $errors['image'] = "Image not uploaded";
                        }
                    } else {
                        $errors['imageExt'] = "Invalid file extension: $imageExt";
                    }
                }
            } else {
                
                for ($i = 0; $i < count($imageResult); $i++) {
                    $imageName = $imageResult[$i]['image_name'];
    
                    
                    $imageUpdate = $connect->query("UPDATE `images` SET `image_name`='$imageName' WHERE emp_ssn='$ssn' AND image_name='$imageName'");
                    if (!$imageUpdate) {
                        $errors['imageUpdate'] = "Failed to retain existing image: $imageName";
                    }
                }
            }
            
        } else {
            $errors['editResult'] = "Failed to update employee details.";
        }
    }
    
    
    }


    ?>


    <!DOCTYPE html>
    <html dir="ltr" lang="en">
    <head>
    <?php
    include '../includes/head.php';
    ?>
    </head>

    <body>

    <div
        id="main-wrapper"
        data-layout="vertical"
        data-navbarbg="skin5"
        data-sidebartype="full"
        data-sidebar-position="absolute"
        data-header-position="absolute"
        data-boxed-layout="full"
    >

        <header class="topbar" data-navbarbg="skin5">
        <?php    include '../includes/rightHeader.php' ?> 

        </header>

        <aside class="left-sidebar" data-sidebarbg="skin5">
        <?php include '../includes/aside.php' ?>
        </aside>

        <div class="page-wrapper">
        <!-- Bread crumb -->
        <div class="page-breadcrumb">
            <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Edit Employee</h4>
                <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                    <a href="#">Add New</a></li>
                    </li>
                    </ol>
                </nav>
                </div>
            </div>
            </div>
        </div>
        <!-- End Bread crumb -->

        <!-- Container fluid -->
        <div class="container-fluid" >
            <!-- Start Page Content -->
            <div class="row">
            <div class="col-md-12">
                <div class="card">
                <?php if(isset($editResult) && $editResult ){?>
                    <div class="alert alert-success">Updated Successfully</div>
                    <?php } elseif(!empty($errors)){?>
                    <div class="alert alert-danger">
                        <ul>
                        <?php 
                        foreach ($errors as $error) {?>
                            <li><?php echo $error ?></li>
                        <?php  }
                        ?>
                        </ul>
                    </div>
                    
                    
                    <?php  }?>
                
                <form class="form-horizontal" id="employee_table" action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" enctype="multipart/form-data" method="post">
                    <div class="card-body">
                    <!-- <div class="form-group row">
                        <label
                        for="ssn"
                        class="col-sm-3 text-end control-label col-form-label"
                        >SSN</label
                        >
                        <div class="col-sm-9">
                        <input
                            type="text"
                            class="form-control"
                            id="ssn"
                            placeholder="SSN Here"
                            name="ssn"
                        />
                        </div>
                    </div> -->
                    <div class="form-group row">
                        <label
                        for="fname" 
                        class="col-sm-3 text-end control-label col-form-label"
                        >Fname</label
                        >
                        <div class="col-sm-9">
                        <input
                            type="text"
                            class="form-control"
                            id="fname"
                            placeholder="First Name Here"
                            name="fname"
                            value="<?php echo $get_data['fname']?>"
                        />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label
                        for="fname"
                        class="col-sm-3 text-end control-label col-form-label"
                        >Lname</label
                        >
                        <div class="col-sm-9">
                        <input
                            type="text"
                            class="form-control"
                            id="lname"
                            placeholder="Last Name Here"
                            name="lname"
                            value="<?php echo $get_data['lname']?>"
                        />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label
                        for="address"
                        class="col-sm-3 text-end control-label col-form-label"
                        >Address</label
                        >
                        <div class="col-sm-9">
                        <input
                            type="text"
                            class="form-control"
                            id="address"
                            placeholder="Address Here"
                            name="address"
                            value="<?php echo $get_data['address']?>"
                        />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label
                        for="salary"
                        class="col-sm-3 text-end control-label col-form-label"
                        >Salary</label
                        >
                        <div class="col-sm-9">
                        <input
                            type="number"
                            min="0" max="10000" step="1"
                            class="form-control"
                            id="salary"
                            placeholder="salary Here"
                            name="salary"
                            value="<?php echo $get_data['salary']?>"
                        />
                        </div>
                    </div>

                    
                    <div class="form-group row">
                        <label
                        for="supervisor"
                        class="col-sm-3 text-end control-label col-form-label"
                        >Supervisor</label
                        >
                        <div class="col-sm-9">
                        <select class="form-control" name="supervisor" >
                        <?php foreach ($super_data as $super) {?>
                            <option value="<?php echo $super['ssn']?>"<?php if($super['ssn']== $get_data['superssn']) {?> selected <?php }?>><?php echo $super['fname']. " ".$super['lname'] ?></option>
                            <?php
                            }?>
                        </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label
                        for="bdate"
                        class="col-sm-3 text-end control-label col-form-label"
                        >Birthday</label
                        >
                        <div class="col-sm-9">
                        <input
                            type="date"
                            class="form-control"
                            id="bdate"
                            value="<?php echo $get_data['bdate']?>"
                            name="bdate"
                        />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label
                        for="image"
                        class="col-sm-3 text-end control-label col-form-label"
                        >Image</label
                        >
                        <div class="col-sm-9">
                        <input
                            type="file"
                            class="form-control"
                            id="image"
                            placeholder="First Name Here"
                            name="image[]"
                            multiple
                        />
                        <div>
                        <?php foreach($imageResult as $image){ ?>
                            <img src="../uploads/images/<?php
                          
                          if(empty($imageResult)){
                            $image['image_name'] ="noImage.png";
                            echo $image['image_name'];

                          }else{
                            echo $image['image_name'];
                          }  ?>" alt="" width="100px">
                        <?php } ?>   
                        
                        </div>
                        </div>
                    </div>
                    <div class="form-group row">
                    <label
                        for="email"
                        class="col-sm-3 text-end control-label col-form-label"
                        >Gender</label
                        >
                        <div class="col-md-9">
                        <div class="form-check">
                            <input
                            type="radio"
                            class="form-check-input"
                            id="customControlValidation1"
                            name="gender"
                            value="m"
                            <?php if($get_data['gender']== 'm'){?>
                                checked
                            <?php }?>
                            />
                            <label
                            class="form-check-label mb-0"
                            for="customControlValidation1"
                            >Male</label
                            >
                        </div>
                        <div class="form-check">
                            <input
                            type="radio"
                            class="form-check-input"
                            id="customControlValidation2"
                            name="gender"
                            value="f"
                            <?php if($get_data['gender']== 'f'){?>
                                checked
                            <?php }?>
                            />
                            <label
                            class="form-check-label mb-0"
                            for="customControlValidation2"
                            >Female</label
                            >
                        </div>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label
                        for="fname"
                        class="col-sm-3 text-end control-label col-form-label"
                        >Department</label
                        >
                        <div class="col-sm-9">
                        <select class="form-control" name="dno">
                            <?php foreach ($dept_data as $dept) {?>
                            <option value="<?php echo $dept['dnum']?>"<?php if($dept['dnum']== $get_data['dno']){ ?> selected <?php }?>><?php echo $dept['dname']?></option>
                            <?php
                            }?>
                        </select>
                        </div>
                    </div>
                    </div>
                    <div class="border-top">
                    <div class="card-body">
                        <button type="submit" onClick="window.location.reload();" id="edit" class="btn btn-primary">
                        Edit
                        </button>
                    </div>
                    </div>
                </form>
                </div>
            </div>
            </div>
            <!-- End Page Content -->

        </div>
        <!-- End Container fluid -->

        <!-- footer -->
        <footer class="footer text-center">
        <?php include '../includes/footer.php' ?>

        </footer>
        <!-- End footer -->
        
        </div>
        <!-- End Page wrapper -->
    </div>
    <!-- End Wrapper -->

    <!-- All Jquery -->
    <?php include '../includes/scripts.php' ?>
    <!-- <script>
        const refreshBtn = document.getElementById("edit");

function handleClick() {
  history.go(0);
}

refreshBtn.addEventListener("click", handleClick);

    </script> -->

    </body>
    </html>

