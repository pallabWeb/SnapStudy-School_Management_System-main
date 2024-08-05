<?php
session_start();

if (!isset($_SESSION['admin_username'])) {
    header("location: ./home/#login");
}

include_once 'db.php';  // Database Connection

$sql = "SELECT * FROM `booking` ";

$reasult = mysqli_query($data, $sql);

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
    <title>Admin | Seat Booking View</title>
    <!-- Data Table CSS -->
    <link rel="stylesheet" href="assets/datatables/css/style.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css" />
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
                        <!-- <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Good Morning Jason!</h3> -->
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb m-0 p-0">
                                    <li class="breadcrumb-item"><a href="adminhome.php">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item">Booking</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Bread crumb and right sidebar toggle -->

            <!-- Container fluid  -->
            <div class="container-fluid">

                <!-- *************************************************************** -->
                <!-- Start DataTables -->
                <!-- *************************************************************** -->

                <?php
                $sql = "SELECT * FROM `booking` ";

                $reasult = mysqli_query($data, $sql);

                ?>
                <table id="example" class="table table-striped" style="width: 100%">
                    <thead class="bg-info text-white">
                        <tr>
                            <th width="15%">Name</th>
                            <th>Email</th>
                            <th width="5%">Class</th>
                            <th width="8%">Phone no.</th>
                            <th>Message</th>
                            <th width="7%">Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-hover table-info">
                        <?php
                        while ($info = $reasult->fetch_assoc()) {
                        ?>
                            <tr>
                                <td><?php echo $info['name']; ?></td>
                                <td><?php echo $info['email']; ?></td>
                                <td><?php echo $info['class']; ?></td>
                                <td><?php echo $info['phone']; ?></td>
                                <td><?php echo $info['message']; ?></td>
                                <td><?php echo $info['status']; ?></td>
                                <td><a onclick="javascript:return confirm('Are you sure to delete this!!')" href="deletebooking.php?id=<?php echo $info['id']; ?>" class="btn btn-sm btn-danger delete-btn" data-id="<?php echo $info['id']; ?>">Delete</a>
                                    <?php if ($info['status'] != 'Approved') { ?>
                                        <a href="approve_booking.php?id=<?php echo $info['id']; ?>" class="btn btn-success btn-sm">Approve</a>
                                    <?php } ?>
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
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script> <!-- for datatable -->
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