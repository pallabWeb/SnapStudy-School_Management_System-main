<?php
session_start();
if (!isset($_SESSION['fees_username'])) {
    header("location: ./home/#login");
}

// Redirect to home page if fees username is not set
if (!isset($_SESSION['fees_username'])) {
    header("location: ./home/#login");
    exit; // Stop further execution
}

// Include database connection
include_once 'db.php';

// Fetch yearly payments
$sql_yearly = "SELECT yf.id, s.student_username, yf.yearly_fees_amount, yf.created_at
                FROM yearly_fees yf
                INNER JOIN students s ON yf.student_id = s.id";
$result_yearly = $data->query($sql_yearly);

// Fetch payments made after 6 months
$sql_after_six_months = "SELECT af.id, s.student_username, af.after_6_months_fees_amount, af.created_at 
                            FROM after_6_months_fees af
                            INNER JOIN students s ON af.student_id = s.id";
$result_after_six_months = $data->query($sql_after_six_months);
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
    <title>View Payment | Fees</title>
    <!-- Data Table CSS -->
    <link rel="stylesheet" href="assets/datatables/css/style.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css" />
    <!-- Custom CSS -->
    <link href="css/fees.min.css" rel="stylesheet">
    <style>
        table {
            width: 80%;
            border-collapse: collapse;
            margin: 20px auto;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        h2 {
            text-align: center;
            margin-top: 50px;
        }
    </style>
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

        <?php include 'components/f_topbar.php'; ?> <!-- Topbar header -->

        <?php include 'components/f_sidebar.php'; ?> <!-- End Left Sidebar -->

        <div class="page-wrapper">

            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-7 align-self-center">
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb m-0 p-0">
                                    <li class="breadcrumb-item"><a href="adminhome.php">Dashboard</a></li>
                                    <li class="breadcrumb-item">View Payments</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="col-5 d-flex justify-content-end align-self-center">
                        <!-- <a type="button" class="btn btn-outline-success rounded-pill float-start" href="add_student.php">Add Students</a> -->
                    </div>
                </div>
            </div> <!-- End Bread crumb and right sidebar toggle -->

            <div class="container-fluid"> <!-- Container fluid  -->
                <h2>Yearly Payments</h2>
                <table class="table table-striped w-100">
                    <thead class="bg-info text-white">
                        <tr>
                            <th>Payment ID</th>
                            <th>Student Name</th>
                            <th>Total Amount</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result_yearly->fetch_assoc()) { ?>
                            <tr>
                                <td><?= $row['id'] ?></td>
                                <td><?= $row['student_username'] ?></td>
                                <td><?= $row['yearly_fees_amount'] ?></td>
                                <td><?= $row['created_at'] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <h2>Payments After 6 Months</h2>
                <table class="table table-striped w-100">
                    <thead class="bg-info text-white">
                        <tr>
                            <th>Payment ID</th>
                            <th>Student Name</th>
                            <th>Total Amount</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result_after_six_months->fetch_assoc()) { ?>
                            <tr>
                                <td><?= $row['id'] ?></td>
                                <td><?= $row['student_username'] ?></td>
                                <td><?= $row['after_6_months_fees_amount'] ?></td>
                                <td><?= $row['created_at'] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
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
