<?php 

require_once '../classes/Validation.php';
require_once '../classes/insert.php';
$db = new DataBase;
$dept_result = $db->connect->query("SELECT * FROM department");
$dept_data = $dept_result->fetchAll(PDO::FETCH_ASSOC); 

$super_result =$db->connect->query("SELECT * FROM employee");
$super_data = $super_result->fetchAll(PDO::FETCH_ASSOC); 

$validator = new EmployeeValidator();
$insertion = new EmployeeInsertion();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
    $data = [
        'ssn' => $_POST['ssn'],
        'fname' => $_POST['fname'],
        'lname' => $_POST['lname'],
        'address' => $_POST['address'],
        'salary' => $_POST['salary'],
        'superssn' => $_POST['superssn'],
        'bdate' => $_POST['bdate'],
        'gender' => $_POST['gender'],
        'dno' => $_POST['dno']
    ];
    

    $errors = $validator->validateForm($data);

    if (empty($errors)) {
        $insertResult = $insertion->insertEmployee($data);
        if ($insertResult === true) {
            $insertResult = true;
        } else {
            $errors = $insertResult;
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
              <h4 class="page-title">Add Employee</h4>
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
        <div class="container-fluid">
          <!-- Start Page Content -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <?php if(isset($insertResult) && $insertResult ){?>
                  <div class="alert alert-success">Added Successfully</div>
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
                
                  <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data" method="post">
                  <div class="card-body">
                  <div class="form-group row">
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
                    </div>
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
                        <select class="form-control" name="superssn">
                        <?php foreach ($super_data as $super) {?>
                            <option value="<?php echo $super['ssn']?>"><?php echo $super['fname']. " ".$super['lname'] ?></option>
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
                            checked
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
                            <option value="<?php echo $dept['dnum']?>"><?php echo $dept['dname']?></option>
                            <?php
                          }?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="border-top">
                    <div class="card-body">
                      <button type="submit" class="btn btn-primary">
                        Add
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

  </body>
</html>
