<?php
session_start();
error_reporting(0);

if (!isset($_SESSION['teacher_username'])) {
    header("location: ./home/#login");
}

include_once 'db.php';  // Database Connection

// Retrieve the teacher's username
$teacher_username = $_SESSION['teacher_username'];

// Retrieve all submitted assignments for the teacher's class
$sql_assignments = "SELECT * FROM assignments WHERE teacher_name = '$teacher_username'";
$result_assignments = mysqli_query($data, $sql_assignments);

// Fetch teacher's image path from the database
$sql_teacher_image = "SELECT image FROM teacher WHERE teacher_username = '$teacher_username'";
$result_teacher_image = mysqli_query($data, $sql_teacher_image);
$row_teacher_image = mysqli_fetch_assoc($result_teacher_image);
$teacher_image = $row_teacher_image['image'];
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
    <title>Teacher | Assigned Tasks</title>
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

        <?php include 'components/t_topbar.php'; ?> <!-- Topbar header  -->

        <?php include 'components/t_sidebar.php'; ?> <!-- Left Sidebar -->


        <div class="page-wrapper"> <!-- Page wrapper  -->
            <div class="page-breadcrumb"> <!-- Bread crumb and right sidebar toggle -->
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

            </div> <!-- End Bread crumb and right sidebar toggle -->

            <div class="container-fluid"> <!-- Container fluid -->

                <div class="row mt-4">
                    <?php if (mysqli_num_rows($result_assignments) > 0) : ?>
                        <?php while ($row = mysqli_fetch_assoc($result_assignments)) : ?>
                            <div class="col-md-6">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h3 class="card-title text-center text-uppercase"><?php echo $row['assignment_title']; ?></h3>
                                        <div class="d-flex justify-content-between">
                                            <p class="card-text text-info"><span class="text-muted">Submitted by: </span><?php echo $row['student_name']; ?></p>
                                            <p class="card-text text-info"><span class="text-muted">Submitted On:</span> <?php echo $row['submission_date']; ?></p>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <p class="card-text">Class: <?php echo $row['student_class']; ?></p>
                                            <p class="card-text">Assigned by: <?php echo $row['teacher_name']; ?></p>
                                        </div>
                                        <div class="input-group flex-nowrap">
                                            <div class="custom-file w-100">
                                                <input class="form-control input-sm" type="text" readonly value="<?php echo $row['file_name']; ?>">
                                            </div>
                                            <a href="<?php echo $row['file_path']; ?>" class="btn btn-outline-success btn-sm" download><i data-feather="download" class="feather-icon"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <div class="col-md-12">
                            <div class="alert alert-info" role="alert">
                                Assignments Not Submitted by Students.
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

            </div>


        </div> <!-- End Container fluid  -->

    </div> <!-- End Page wrapper  -->

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