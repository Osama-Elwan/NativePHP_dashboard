<?php 
  include '../classes/Database.php';
  include '../classes/ShowOne.php';
  
  // Create a database connection
  $db = new Database();
  
  if (isset($_GET['ssn'])) {
      $ssn = $_GET['ssn'];
  } else {
      echo "<h1 style ='color:red;text-align:center;'>Wrong Page</h1>";
      exit();
  }
  
  // Instantiate the Employee class
  $employee = new Employee($db, $ssn);
  
  // Fetch employee data and images
  $data = $employee->getEmployeeData();
  $imageResult = $employee->getEmployeeImages();
  $age = $employee->getAge($data['bdate']);
  

?>


<!DOCTYPE html>
<html dir="ltr" lang="en">
  <head>
  <?php 

    include '../includes/head.php'
?>
<style>
    .custom-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    background-color: #f9f9f9;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    overflow: hidden;
}

.custom-table th,
.custom-table td {
    padding: 15px;
    border-bottom: 1px solid #e0e0e0;
}

.custom-table th {
    background-color: #4CAF50;
    color: white;
    font-weight: 600;
    text-align: left;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.custom-table td {
    background-color: #ffffff;
    color: #333;
    font-weight: 400;
}

/* Image Styles */
.custom-table img {
    width: 70px;
    height: auto;
    border-radius: 50%;
    border: 2px solid #4CAF50;
}

/* Row Hover Effect */
.custom-table tr:hover td {
    background-color: #f1f1f1;
    color: #000;
}

/* First Column Styling */
.custom-table th:first-child,
.custom-table td:first-child {
    border-left: 5px solid #4CAF50;
    font-weight: bold;
}
</style>
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
              <h4 class="page-title">Employees</h4>
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
            <div class="col-12">
            <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Basic Datatable</h5>
                  <div class="table-responsive">
                    <table
                      id="zero_config"
                      class="custom-table"
                    >
                      <thead>
                        <tr>
                          <th>Image</th>
                          <td>
                            <?php foreach ($imageResult as $image): ?>
                                <img src="../uploads/images/<?php echo empty($image['image_name']) ? 'noImage.png' : $image['image_name']; ?>" alt="">
                            <?php endforeach; ?>
                          </td>
                        </tr>
                        <tr>
                          <th>SSN</th>
                          <td><?php echo $data['ssn']?></td>
                        </tr>
                        <tr>
                          <th>Name</th>
                          <td><?php echo $data['fname'] ." ".$data['lname'] ?></td>
                        </tr>
                        <tr>
                          <th>BirthDate</th>
                          <td><?php echo $data['bdate']?></td>
                        </tr>
                        <tr>
                          <th>Age</th>
                          <td><?php echo $age ?></td>
                        </tr>
                        <tr>
                          <th>Address</th>
                          <td><?php echo $data['address']?></td>
                        </tr>
                        <tr>
                          <th>Gender</th>
                          <td><?php
                                if($data['gender']== 'm'){
                                    echo "Male";
                                }elseif($data['gender']== 'f'){
                                    echo "Female";
                                }else{
                                    echo "gender Not Selected";
                                };
                                ?></td>
                        </tr>
                        <tr>
                          <th>Salary</th>
                          <td><?php if(empty($data['salary'])){
                            echo "No Salary";
                          }else{
                            echo $data['salary'];
                        } 
                              ?></td>
                        </tr>
                        <tr>
                          <th>supervisor</th>
                          <td><?php if(empty($data['superssn'])){
                            echo "Has Not supervisor";
                          }else{
                            echo $data['super_fname'] . " " . $data['super_lname'];
                        } 
                              ?></td>
                        </tr>
                        <tr>
                          <th>Department</th>
                          <td><?php echo $data['dname']?></td>
                        </tr>
                      </thead>
                     <tbody>
                        <tr>
                            <td>Good Jop........</td>
                        </tr>
                     </tbody>

                    </table>
                  </div>
                </div>
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
