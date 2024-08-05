<?php
session_start();
error_reporting(0);

if (!isset($_SESSION['teacher_username'])) {
    header("location: ./home/#login");
    exit(); // Make sure to exit after redirecting
}

include_once 'db.php';  // Database Connection

// Fetch teacher's image path from the database
$teacher_username = $_SESSION['teacher_username'];
$sql = "SELECT image FROM teacher WHERE teacher_username = '$teacher_username'";
$result = mysqli_query($data, $sql);
$row = mysqli_fetch_assoc($result);
$teacher_image = $row['image'];

// Fetch the teacher's class
$teacher_username = $_SESSION['teacher_username'];
$sql_teacher_class = "SELECT class FROM teacher WHERE teacher_username = ?";
$stmt_teacher_class = mysqli_prepare($data, $sql_teacher_class);
mysqli_stmt_bind_param($stmt_teacher_class, "s", $teacher_username);
mysqli_stmt_execute($stmt_teacher_class);
$result_teacher_class = mysqli_stmt_get_result($stmt_teacher_class);
$row_teacher_class = mysqli_fetch_assoc($result_teacher_class);
$teacher_class = $row_teacher_class['class'];

$sql = "SELECT * FROM `task` WHERE class = ?"; // Modify SQL query to include class filter
$stmt = mysqli_prepare($data, $sql);
mysqli_stmt_bind_param($stmt, "s", $teacher_class); // Bind parameter for class
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

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
    <title>Teacher | View Task</title>
    <!-- Data Table CSS -->
    <link rel="stylesheet" href="assets/datatables/css/style.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css" />
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
            </div> <!-- End Bread crumb and right sidebar toggle -->

            <div class="container-fluid"> <!-- Container fluid  -->
                <table id="example" class="table table-striped table-hover w-100">
                    <thead class="bg-info text-white">
                        <tr>
                            <th width="20%">Instruction</th>
                            <th width="10%">Reference Material</th>
                            <th width="3%">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-info">
                        <?php while ($info = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?php echo $info['desc']; ?></td>
                                <td><?php echo basename($info['file']); ?></td>
                                <td><?php echo "<a onClick=\"javascript:return confirm('Are you sure to delete this!!')\" href='t_show_task.php?taskr_id={$info['id']}' class='btn btn-danger'>Delete</a>"; ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
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

    <!-- Data Table JS -->
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
    <!-- Datatables Custom JS -->
    <script src="assets/datatables/js/script.js"></script>
</body>

</html>