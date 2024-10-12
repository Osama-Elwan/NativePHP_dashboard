<?php 
  include "../classes/Database.php";
  include "../classes/ShowAll.php";

    
  $db = new Database();
  $employeeObj = new Employee($db->connect);
  
  // Fetch all employee data
  $allEmployees = $employeeObj->fetchAllEmployees();
  

?>


<!DOCTYPE html>
<html dir="ltr" lang="en">
  <head>
  <?php 

    include '../includes/head.php'
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
                      class="table table-striped table-bordered"
                    >
                      <thead>
                        <tr>
                          <th>Name</th>
                          <th>Gender</th>
                          <th>Age</th>
                          <th>Department</th>
                          
                        </tr>
                      </thead>
                      <tbody>
                          
                          <?php foreach ($allEmployees as $employee) {?>
                            <tr>
                                <td><?php echo $employee['fname'] ." ".$employee['lname'] ?></td>
                                <td><?php
                                if($employee['gender']== 'm'){
                                    echo "Male";
                                }elseif($employee['gender']== 'f'){
                                    echo "Female";
                                }else{
                                    echo "gender Not Selected";
                                };
                                ?></td>
                                <td><?php echo $employeeObj->getAge($employee['bdate']) ?></td>
                                <td><?php echo $employee['dname']?></td>
                                <td>
                                    <a class="btn btn-primary" href="show.php?ssn=<?php echo $employee['ssn'] ?>">Show</a>
                                    <a class="btn btn-success" href="edit.php?ssn=<?php echo $employee['ssn'] ?>">Edit</a>
                                    <a class="btn btn-danger delete-btn" href="delete.php?ssn=<?php echo $employee['ssn'] ?>">Delete</a>
                                </td>
                                </tr>
                                <?php
                            } ?>
                        

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
    <script>
  document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.delete-btn');
    
    deleteButtons.forEach(button => {
      button.addEventListener('click', function(event) {
        const confirmed = confirm('Are you sure you want to delete this employee?');
        if (!confirmed) {
          event.preventDefault(); // Stop the link from being followed
        }
      });
    });
  });
</script>
  </body>
</html>
