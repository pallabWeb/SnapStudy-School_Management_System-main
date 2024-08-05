<?php
session_start();

if (!isset($_SESSION['admin_username'])) {
    header("location: ./home/#login");
}

include_once 'db.php';  // Database Connection

$sql = "SELECT * FROM `students` ";
$sql = "SELECT * FROM `booking` ";
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
    <title>Admin | Student's Details</title>
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

    <!-- Main wrapper -->
    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">


        <?php include 'components/admintopbar.php'; ?> <!-- Topbar header -->


        <?php include 'components/adminsidebar.php'; ?> <!-- End Left Sidebar -->


        <div class="page-wrapper">

            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-7 align-self-center">
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb m-0 p-0">
                                    <li class="breadcrumb-item"><a href="adminhome.php">Dashboard</a></li>
                                    <li class="breadcrumb-item">Students</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="col-5 d-flex justify-content-end align-self-center">
                        <a type="button" class="btn btn-outline-success rounded-pill float-start" href="add_student.php">Add Students</a>
                    </div>
                </div>

            </div> <!-- End Bread crumb and right sidebar toggle -->


            <div class="container-fluid"> <!-- Container fluid  -->


                <!-- Start DataTables -->

                <?php
                $sql = "SELECT * FROM `students` ";

                $reasult = mysqli_query($data, $sql);

                ?>
                <table id="example" class="table table-striped table-hover w-100">
                    <thead class="bg-info text-white">
                        <tr>
                            <!-- <th width="10%">image</th> -->
                            <th width="10%">Username</th>
                            <th width="10%">Name</th>
                            <th width="6%">Phone no.</th>
                            <th width="6%">Class</th>
                            <th width="17%">Email</th>
                            <th width="8%">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-info">
                        <?php
                        while ($info = $reasult->fetch_assoc()) {
                        ?>
                            <tr>
                                <!-- <td><img src="<?php echo $info['image']; ?>" width="100" height="100"></td> -->
                                <td><?php echo $info['student_username']; ?></td>
                                <td><?php echo $info['name']; ?></td>
                                <td><?php echo $info['phone']; ?></td>
                                <td><?php echo $info['class']; ?></td>
                                <td><?php echo $info['email']; ?></td>
                                <td><?php echo "<a class='btn btn-sm btn-danger' onClick=\"javascript:return confirm('Are You sure to Delete this');\" href='delet.php?student_id={$info['id']}'>Delete</a>"; ?>

                                    <?php echo "<a class='btn btn-sm btn-success'href=\"some.php?id=$info[id]\" >Edit</a>"; ?>
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