<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
  header("location: ./home/#login");
}

include_once 'db.php';  // Database Connection

$sql = "SELECT * FROM `teacher` ";

$result = mysqli_query($data, $sql);

?>

<!-- // Total number of Students -->
<?php $sql = "SELECT * FROM `students`";
$result = mysqli_query($data, $sql);
$total_students = mysqli_num_rows($result); ?>

<!-- // Total number of teachers -->
<?php $sql = "SELECT * FROM `teacher`";
$result = mysqli_query($data, $sql);
$total_teachers = mysqli_num_rows($result); ?>

<!-- // Total number of courses -->
<?php $sql = "SELECT * FROM `courses`";
$result = mysqli_query($data, $sql);
$total_courses = mysqli_num_rows($result); ?>

<!-- // Total number of bookings -->
<?php
$sql = "SELECT * FROM `admissionform` WHERE `added` = ''";

// Execute the query
$result = mysqli_query($data, $sql);

// Check if the query was successful
if ($result) {
    // Get the total number of rows returned
    $total_blank_added = mysqli_num_rows($result);
} else {
    // Error handling if the query fails
    echo "Error: " . mysqli_error($data);
}
?>

<?php
// Fetch updates from the database
$sql = "SELECT * FROM `tblupdates`";
$result = mysqli_query($data, $sql);
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Favicon -->
  <link rel="icon" href="./img/favicon_logoai/favicon-16x16.png" type="image/x-icon">
  <title>Admin | Dashboard</title>
  <!-- Custom CSS -->
  <link href="css/style2.min.css" rel="stylesheet">
</head>

<body>

  <!-- Preloader - style you can find in spinners.css -->
  <div class="preloader">
    <div class="lds-ripple">
      <div class="lds-pos"></div>
      <div class="lds-pos"></div>
    </div>
  </div>

  <!-- Main wrapper - style you can find in pages.scss -->
  <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">


    <?php include 'components/admintopbar.php'; ?> <!-- End Topbar header -->



    <?php include 'components/adminsidebar.php'; ?> <!-- End Left Sidebar -->


    <!-- Page wrapper  -->
    <div class="page-wrapper">

      <!-- Bread crumb and right sidebar toggle -->
      <div class="page-breadcrumb">
        <div class="row">
          <div class="col-7 align-self-center">
            <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Welcome to Dashboard</h3>
            <div class="d-flex align-items-center">
            </div>
          </div>

        </div>
      </div> <!-- End Bread crumb and right sidebar toggle -->


      <div class="container-fluid"> <!-- Container fluid  -->



        <!-- *************************************************************** -->
        <!-- Start First Cards -->
        <!-- *************************************************************** -->
        <div class="row">
          <div class="col-sm-6 col-lg-3">
            <div class="card border-end">
              <div class="card-body">
                <div class="d-flex align-items-center">
                  <div>
                    <div class="d-inline-flex align-items-center">
                      <h2 class="text-dark mb-1 font-weight-medium"><?php echo $total_students; ?></h2>
                      <!-- <span class="badge bg-primary font-12 text-white font-weight-medium rounded-pill ms-2 d-lg-block d-md-none">+18.33%</span> -->
                    </div>
                    <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total Students
                    </h6>
                  </div>
                  <div class="ms-auto mt-md-3 mt-lg-0">
                    <span class="opacity-7 text-muted"><i data-feather="users"></i></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-lg-3">
            <div class="card border-end ">
              <div class="card-body">
                <div class="d-flex align-items-center">
                  <div>
                    <h2 class="text-dark mb-1 w-100 text-truncate font-weight-medium"><?php echo $total_teachers; ?></h2>
                    <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total Teachers
                    </h6>
                  </div>
                  <div class="ms-auto mt-md-3 mt-lg-0">
                    <span class="opacity-7 text-muted"><i data-feather="briefcase"></i></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-lg-3">
            <div class="card border-end ">
              <div class="card-body">
                <div class="d-flex align-items-center">
                  <div>
                    <div class="d-inline-flex align-items-center">
                      <h2 class="text-dark mb-1 font-weight-medium"><?php echo $total_courses; ?></h2>
                    </div>
                    <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total Courses
                    </h6>
                  </div>
                  <div class="ms-auto mt-md-3 mt-lg-0">
                    <span class="opacity-7 text-muted"><i data-feather="book"></i></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-lg-3">
            <div class="card ">
              <div class="card-body">
                <div class="d-flex align-items-center">
                  <div>
                    <h2 class="text-dark mb-1 font-weight-medium"><?php echo $total_blank_added; ?></h2>
                    <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Pending Admissions</h6>
                  </div>
                  <div class="ms-auto mt-md-3 mt-lg-0">
                    <span class="opacity-7 text-muted"><i data-feather="loader"></i></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <!-- Form to add updates -->
                  <form action="addupdates.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                      <label for="updateText1">Update Text:</label>
                      <textarea class="form-control" name="descss" id="updateText1" rows="1"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3" name="add_coursess">Submit</button>
                  </form>

                  <!-- Table to display updates from the database -->
                  <div class="content mt-4">
                    <h1>Updates</h1>
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th class="table_th">Description</th>
                          <th class="table_th">Delete</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        // Iterate over each update and display it in a table row
                        while ($info = $result->fetch_assoc()) {
                        ?>
                          <tr>
                            <td class="table_td"><?php echo $info['descript']; ?></td>
                            <td class="table_td">
                              <a onClick="javascript:return confirm('Are you sure to delete this!!')" href='showupdates.php?tbltaskr_id=<?php echo $info['id']; ?>' class='btn btn-danger'>Delete</a>
                            </td>
                          </tr>
                        <?php
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>




      </div>
    </div> <!-- End Page wrapper  -->
  </div> <!-- End Wrapper -->



  <!-- ============================================================== -->
  <!-- All Jquery -->
  <!-- ============================================================== -->
  <script src="js/jquery.min.js"></script>
  <!-- <script src="js/bootstrap.bundle.min.js"></script> -->
  <!-- apps -->
  <script src="js/app-style-switcher.js"></script>
  <script src="js/feather.min.js"></script>
  <script src="js/perfect-scrollbar.jquery.min.js"></script>
  <script src="js/sidebarmenu.js"></script>
  <!--Custom JavaScript -->
  <script src="js/custom.min.js"></script>
</body>

</html>