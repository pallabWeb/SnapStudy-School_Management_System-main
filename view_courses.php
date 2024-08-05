<?php
error_reporting(0);
session_start();

if (!isset($_SESSION['admin_username'])) {
    header("location: ./home/#login");
}

include_once 'db.php';  // Database Connection

$sql = "SELECT * FROM `courses` ";

$result = mysqli_query($data, $sql);


if ($_GET['courses_id']) {
    $t_id = $_GET['courses_id'];

    $sql2 = "DELETE FROM `courses` WHERE id='$t_id'";

    $result2 = mysqli_query($data, $sql2);
    if ($result2) {
        header('location:view_courses.php');
    }
}
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
    <title>Admin | Courses</title>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style2.min.css">
    <link rel="stylesheet" href="css/course_card.css">
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
    <!-- ============================================================== -->
    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">


        <?php include 'components/admintopbar.php'; ?> <!-- Topbar header - style you can find in pages.scss -->

        <?php include 'components/adminsidebar.php'; ?> <!-- Left Sidebar - style you can find in sidebar.scss  -->

        <div class="page-wrapper"> <!-- Page wrapper  -->

            <div class="page-breadcrumb"> <!-- Bread crumb and right sidebar toggle -->
                <div class="row">
                    <div class="col-7 align-self-center">
                        <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">All Courses</h3>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb m-0 p-0">
                                    <li class="breadcrumb-item"><a href="adminhome.php">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item">Courses</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="col-5 d-flex justify-content-end align-self-center">
                        <a type="button" class="btn btn-outline-success rounded-pill float-start" href="add_courses.php">Add Courses</a>
                    </div>
                </div>
            </div> <!-- End Bread crumb and right sidebar toggle -->


            <!-- Container fluid  -->
            <div class="container-fluid">

                <!-- Start DataCards -->
                <?php
                $sql = "SELECT * FROM `courses` ";
                $result = mysqli_query($data, $sql);

                while ($info = $result->fetch_assoc()) { ?>

                    <div class="card">
                        <div class="card-img" style="background-image:url(<?php echo $info['image']; ?>);">
                            <div class="overlay">
                                <div class="overlay-content">
                                    <div class="ovl">
                                        <?php echo "<a onClick=\" javascript:return confirm('Are you sure to delete this!!')\" href='view_courses.php?courses_id={$info['id']}' class='btn btn-danger'> Delete</a>" ?>

                                        <?php echo "<a href='admin_updatecourses.php?courses_id={$info['id']}' class='btn btn-success'>Edit</a>"; ?>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="card-content">
                            <a href="#!">
                                <h2><?php echo $info['name']; ?></h2>
                                <p><?php echo $info['titlename']; ?></p>
                            </a>
                        </div>
                    </div>

                <?php } ?>
            </div> <!-- End Container fluid  -->
        </div> <!-- End Page wrapper  -->

    </div> <!-- End Main wrapper  -->


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