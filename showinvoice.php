<?php
session_start();

// Redirect to home page if fees username is not set
if (!isset($_SESSION['fees_username'])) {
    header("location: ./home/#login");
    exit(); // Add an exit to stop further execution
}

error_reporting(0);
// Database connection
include_once 'db.php';

// Check if student_id is set in the URL to delete a record
if (isset($_GET['student_id'])) {
    $t_id = $_GET['student_id'];

    $sql2 = "DELETE FROM `fees` WHERE id='$t_id'";

    $result2 = mysqli_query($data, $sql2);
    if ($result2) {
        header('location: showinvoice.php');
        exit(); // Add an exit to stop further execution
    }
}

// Query to select data from fees
$sql = "SELECT * FROM `fees`";

$result = mysqli_query($data, $sql);

?>

<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Favicon -->
    <link rel="icon" href="./img/favicon_logoai/favicon-16x16.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Make Payment | Fees</title>
    <link href="css/fees.min.css" rel="stylesheet">
    <style>
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 15px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .table_td {
            background-color: #f9f9f9;
        }
    </style>
</head>

<body>
    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">


        <?php include_once 'components/f_topbar.php'; ?>

        <?php include_once 'components/f_sidebar.php'; ?>

        <div class="page-wrapper">
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-7 align-self-center">
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb m-0 p-0">
                                    <li class="breadcrumb-item">Make Payment</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <!-- Display current date -->
                    <div class="col-5 align-self-center">
                        <div class="d-flex justify-content-end">

                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">

            <!-- <div class="content"> -->
            <center>
                <h1>Student Fees Data</h1>
                <br>
                <?php
                if ($_SESSION['message']) {
                    echo $_SESSION['message'];
                }
                unset($_SESSION['message']);
                ?>
                <br>
                <table>
                    <thead>
                        <tr>
                            <th class="table_th">Student Username</th>
                            <th class="table_th">Student ID</th>
                            <th class="table_th">Fees Amount</th>
                            <th class="table_th">Date</th>
                            <th class="table_th">Class</th>
                            <th class="table_th">Transaction Mode</th>
                            <th class="table_th">Standard</th>
                            <th class="table_th">Payment Number</th>
                            <th class="table_th">Action</th>
                            <th class="table_th">View</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($info = $result->fetch_assoc()) {
                        ?>
                            <tr>
                                <td class="table_td"><?php echo "{$info['student_username']}"; ?></td>
                                <td class="table_td"><?php echo "{$info['sid']}"; ?></td>
                                <td class="table_td"><?php echo "{$info['feesamount']}"; ?></td>
                                <td class="table_td"><?php echo "{$info['date']}"; ?></td>
                                <td class="table_td"><?php echo "{$info['strems']}"; ?></td>
                                <td class="table_td"><?php echo "{$info['transactionid']}"; ?></td>
                                <td class="table_td"><?php echo "{$info['Standared']}"; ?></td>
                                <td class="table_td"><?php echo "{$info['paynumber']}"; ?></td>
                                <td class="table_td"><?php echo "<a class='btn btn-danger' onClick=\"javascript:return confirm('Are you sure to delete this?');\" href='showinvoice.php?student_id={$info['id']}'>Delete</a>"; ?></td>
                                <td class="table_td"><?php echo "<a class='btn btn-primary' href='uploads/{$info['student_username']}_invoice.pdf' target='_blank'>View PDF</a>"; ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </center>
        <!-- </div> -->

            </div>

            <!-- JavaScript files -->
            <script src="js/jquery.min.js"></script>
            <script src="js/bootstrap.bundle.min.js"></script>
            <script src="js/app-style-switcher.js"></script>
            <script src="js/feather.min.js"></script>
            <script src="js/perfect-scrollbar.jquery.min.js"></script>
            <script src="js/sidebarmenu.js"></script>
            <script src="js/custom.min.js"></script>

        </div>
    </div>

</body>

</html>