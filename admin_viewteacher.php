<?php
session_start();
error_reporting(0);


if (!isset($_SESSION['admin_username'])) {
    header("location: ./home/#login");
}

include_once 'db.php';  // Database Connection

$sql = "SELECT * FROM `booking` ";
$sql = "SELECT * FROM `teacher` ";

$result = mysqli_query($data, $sql);

if ($_GET['teacher_id']) {
    $t_id = $_GET['teacher_id'];

    $sql2 = "DELETE FROM `teacher` WHERE id='$t_id'";

    $result2 = mysqli_query($data, $sql2);
    if ($result2) {
        header('location:admin_viewteacher.php');
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
    <title>Admin | Teacher's Details</title>
    <!-- Data Table CSS -->
    <link rel="stylesheet" href="assets/datatables/css/style.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css" />
    <!-- Custom CSS -->
    <link href="css/style2.min.css" rel="stylesheet">
</head>

<body>

    <!-- Preloader -->
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
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb m-0 p-0">
                                    <li class="breadcrumb-item"><a href="adminhome.php">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item">Teachers</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="col-5 d-flex justify-content-end align-self-center">
                        <a type="button" class="btn btn-outline-success rounded-pill float-start" href="admin_addteacher.php">Add Teacher</a>
                    </div>
                </div>
            </div> <!-- End Bread crumb and right sidebar toggle -->



            <div class="container-fluid"> <!-- Container fluid  -->




                <!-- Start DataTables -->

                <?php
                $sql = "SELECT * FROM `teacher` ";

                $reasult = mysqli_query($data, $sql);

                ?>
                <table id="example" class="table table-striped table-hover w-100">
                    <thead class="text-white bg-info">
                        <tr>
                            <th width="7%">Username</th>
                            <th width="9%">Teacher Name</th>
                            <th width="6%">Phone</th>
                            <th width="20%">Email</th>
                            <th width="15%">Bio</th>
                            <th width="5%">Image</th>
                            <th width="8%">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-info">
                        <?php
                        while ($info = $reasult->fetch_assoc()) {
                        ?>
                            <tr>
                                <td><?php echo $info['teacher_username']; ?></td>
                                <td><?php echo $info['name']; ?></td>
                                <td><?php echo $info['phone']; ?></td>
                                <td><?php echo $info['email']; ?></td>
                                <td><?php echo "{$info['description']}"; ?></td>
                                <td><img hight="60px" width="60px" class="" src="<?php echo "{$info['image']}"; ?>" alt=""></td>
                                <td><?php echo "<a onClick=\" javascript:return confirm('Are you sure too delete this!!')\" href='admin_viewteacher.php?teacher_id={$info['id']}' class='btn btn-sm btn-danger'>Delete</a>"; ?>

                                    <?php echo "<a href='admin_updateteacher.php?teacher_id={$info['id']}' class='btn btn-sm btn-success'>Edit</a>"; ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
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
    <!-- Data Table JS -->
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
    <!-- Datatables Custom JS -->
    <script src="assets/datatables/js/script.js"></script>
</body>

</html>