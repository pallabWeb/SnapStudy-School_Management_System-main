<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
    header("location: ./home/#login");
}

include_once 'db.php';  // Database Connection

$sql = "SELECT * FROM `teacher` ";

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
    <title>Admin | Add Fees Admin</title>
    <!-- AJAX Cdn Link  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Custom CSS -->
    <link href="css/style2.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 40%;
            border: 2px solid black;
            border-radius: 5px;
            padding: 20px;
            margin: 0 auto;
            margin-top: 50px;
        }
    </style>
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



            <div class="container-fluid"> <!-- Container fluid  -->



                <div class="container mt-5">
                    <div id="result"></div>
                    <form id="addUserForm">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name:</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="fees_username" class="form-label">Username:</label>
                            <input type="text" class="form-control" id="fees_username" name="fees_username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary float-end rounded-pill">Add Fees Admin</button>
                    </form>


                    <script>
                        $(document).ready(function() {
                            $("#addUserForm").on("submit", function(event) {
                                event.preventDefault(); // Prevent the form from submitting via the browser

                                $.ajax({
                                    url: "add_user.php",
                                    type: "POST",
                                    data: $(this).serialize(), // Serialize form data
                                    success: function(response) {
                                        $("#result").html(response);
                                    },
                                    error: function(xhr, status, error) {
                                        $("#result").html("An error occurred: " + error);
                                    }
                                });
                            });
                        });
                    </script>

                </div>
            </div> <!-- End Page wrapper  -->
        </div> <!-- End Wrapper -->



        <!-- ============================================================== -->
        <!-- All Jquery -->
        <!-- ============================================================== -->
        <script src="js/jquery.min.js"></script>
        <!-- <script src="js/bootstrap.bundle.min.js"></script> -->
        <!-- apps -->
        <script src="js/app-style-switcher.js"></script>
        <script src="js/feather.min.js"></script>
        <script src="js/perfect-scrollbar.jquery.min.js"></script>
        <script src="js/sidebarmenu.js"></script>
        <!--Custom JavaScript -->
        <script src="js/custom.min.js"></script>
</body>

</html>