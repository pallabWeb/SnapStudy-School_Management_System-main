<?php
// Start the session
session_start();

// Check if the user is logged in
if (isset($_SESSION['student_username'])) {
    header("Location: ./home/#login");
    // database connection
    include_once 'db.php';

    // Check the connection
    if ($data === false) {
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }

    // Retrieve user details from the database
    $student_username = $_SESSION['student_username'];
    $query = "SELECT * FROM students WHERE student_username = '$student_username'";
    $result = mysqli_query($data, $query);

    // Check if query executed successfully
    if ($result) {
        // Fetch user details
        $user_details = mysqli_fetch_assoc($result);
    } else {
        $error_message = "Error: Unable to fetch user details.";
    }

    // Close the connection
    mysqli_close($data);
} else {
    // Redirect to the login page if the user is not logged in
    header("Location: loginstu.php");
    exit();
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
    <title>Student Dashboard </title>
    <!-- Custom CSS -->
    <link href="css/student.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/profile.css">
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
        

        <?php include 'components/user_topbar.php'; ?>  <!-- End Topbar header -->


        <?php include 'components/user_sidebar.php'; ?>  <!-- End Left Sidebar -->

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

            </div>   <!-- End Bread crumb and right sidebar toggle -->


            <!-- Container fluid  -->
            <div class="container-fluid">

                <?php
                // Display error message if exists
                if (isset($error_message)) {
                ?>
                    <div class='alert alert-danger' role='alert'><?php echo $error_message; ?></div>
                <?php
                }

                // Display student details if they exist
                if (isset($user_details)) {
                ?>
                    <img src="<?php echo $user_details['image']; ?>" class="rounded-circle" style="width: 200px; height: 200px;" alt="">
                <?php
                }
                ?>

            </div>

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