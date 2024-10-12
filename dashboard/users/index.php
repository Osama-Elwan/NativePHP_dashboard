<?php 
  include "../includes/dbConnection.php";

    
$result = $connect->query("SELECT * FROM users");

    $data = $result->fetchAll(PDO::FETCH_ASSOC);
    // var_dump($data);
    // die();
    

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
                          <th>email</th>
                          <th>Is Admin</th>
                          
                          
                        </tr>
                      </thead>
                      <tbody>
                          
                          <?php foreach ($data as $value) {?>
                            <tr>
                                <td><?php echo $value['username']?></td>
                                <td><?php
                                  echo $value['email'];
                                  ?></td>
                                <td>
                                  
                                  
                                  <a class="btn btn-danger" href="changeUserAuth.php?id=<?php echo $value['id'] ?>">Change To Admin</a>
                                  <a class="btn btn-primary" href="changeAdminAuth.php?id=<?php echo $value['id'] ?>">Change To user</a>
                                  
                                </td>
                                <td><?php if($value['is_admin'] ==1){
                                  echo "Admin";
                                }else{
                                  echo "User";
                                }  ?></td>
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
   
  </body>
</html>
