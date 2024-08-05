<?php
session_start();
if (!isset($_SESSION['teacher_username'])) {
  header("location: ./home/#login");
}

include_once 'db.php';  // Database Connection

// Fetch teacher's details from the database
$teacher_username = $_SESSION['teacher_username'];
$sql_teacher = "SELECT class, image FROM teacher WHERE teacher_username = '$teacher_username'";
$result_teacher = mysqli_query($data, $sql_teacher);
$row_teacher = mysqli_fetch_assoc($result_teacher);
$teacher_class = $row_teacher['class'];
$teacher_image = $row_teacher['image'];

// Retrieve total number of students for the teacher's class
$sql_student_count = "
  SELECT COUNT(*) AS total_students 
  FROM students 
  WHERE class = '$teacher_class'
";
$result_student_count = mysqli_query($data, $sql_student_count);
$row_student_count = mysqli_fetch_assoc($result_student_count);
$total_students = $row_student_count['total_students'];
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
  <title>Teacher | Dashboard</title>
  <!-- Custom CSS -->
  <link href="css/teacher.min.css" rel="stylesheet">
</head>

<body>

  <!-- Preloader -->
  <div class="preloader">
    <div class="lds-ripple">
      <div class="lds-pos"></div>
      <div class="lds-pos"></div>
    </div>
  </div>

  <!-- Main wrapper -->
  <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">


    <?php include 'components/t_topbar.php'; ?> <!-- End Topbar header -->

    <?php include 'components/t_sidebar.php'; ?> <!-- End Left Sidebar -->

    <!-- Page wrapper  -->
    <div class="page-wrapper">

      <!-- Bread crumb and right sidebar toggle -->
      <div class="page-breadcrumb">
        <div class="row">
          <div class="col-7 align-self-center">
            <div class="d-flex align-items-center">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-0 p-0">
                  <li class="breadcrumb-item"><a href="student.php">Dashboard</a></li>
                  <li class="breadcrumb-item">Students</li>
                </ol>
              </nav>
            </div>
          </div>
        </div>
      </div>
      <!-- End Bread crumb and right sidebar toggle -->

      <div class="container-fluid"> <!-- Container fluid  -->

        <div class="col-sm-6 col-lg-3">
          <div class="card border-end">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div>
                  <div class="d-inline-flex align-items-center">
                    <h2 class="text-dark mb-1 font-weight-medium"><?php echo $total_students; ?></h2>
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

      </div>

    </div> <!-- End Container fluid  -->

  </div> <!-- End Page wrapper  -->

  </div> <!-- End Wrapper -->

  <!-- ============================================================== -->
  <!-- All Jquery -->
  <!-- ============================================================== -->
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
  <!-- apps -->
  <script src="js/app-style-switcher.js"></script>
  <script src="js/feather.min.js"></script>
  <script src="js/perfect-scrollbar.jquery.min.js"></script>
  <script src="js/sidebarmenu.js"></script>
  <!--Custom JavaScript -->
  <script src="js/custom.min.js"></script>

</body>

</html>
