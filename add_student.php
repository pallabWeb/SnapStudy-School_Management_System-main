<?php
session_start();
include_once 'db.php';  // Database Connection
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
    <title>Admin | Add Students</title>
    <!-- Custom CSS -->
    <link href="css/style2.min.css" rel="stylesheet">
    <style>
        /* Add your custom CSS styles here */
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
        <!-- Topbar header - style you can find in pages.scss -->
        <?php include 'components/admintopbar.php'; ?>
        <!-- End Topbar header -->


        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <?php include 'components/adminsidebar.php'; ?>
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->


        <!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb and right sidebar toggle -->
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

                </div>
            </div>
            <!-- End Bread crumb and right sidebar toggle -->


            <!-- Container fluid  -->
            <div class="container-fluid">

                <!-- Toast Notification -->
                <div class="toast align-items-center text-white bg-success" role="alert" aria-live="assertive" aria-atomic="true" id="successToast" style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 9999;">
                    <div class="d-flex">
                        <div class="toast-body">
                        </div>
                        <button type="button" class="btn-close me-2 m-auto text-white" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
 
                <form class="row g-3" id="addStudentForm">
                    <div class="col-md-6">
                        <label for="username" class="mt-3">Username:</label>
                        <input type="text" class="form-control" name="student_username" id="username" placeholder="Enter your username" required>
                    </div>
                    <div class="col-md-6">
                        <label for="name" class="mt-3">Student's name:</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter student's name" required>
                    </div>
                    <div class="col-6">
                        <label for="class" class="mt-3">Class:</label>
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect01">Options</label>
                            <select class="form-select" name="class" id="inputGroupSelect01">
                                <option selected="">Choose...</option>
                                <option value="class1">Class 1</option>
                                <option value="class2">Class 2</option>
                                <option value="class3">Class 3</option>
                                <option value="class4">Class 4</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="phone" class="mt-3">Phone:</label>
                        <input type="tel" class="form-control" name="phone" id="phone" placeholder="Enter your phone number" required>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="mt-3">Email:</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email address" required>
                    </div>
                    <div class="col-md-6">
                        <label for="password" class="mt-3">Password:</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password" required>
                    </div>
                    <div class="col-md-6">
                        <label hidden for="image" class="mt-3">Image:</label>
                        <input hidden type="file" class="form-control" name="image" id="image">
                    </div>
                    
                    <div class="col-12">
                    <button type="submit" class="btn btn-success mt-3 rounded-3 float-end submit" name="add_student">Add Student</button>
                </div>
            </form>
            </div>

        </div>
        <!-- End Container fluid  -->
    </div>
    <!-- End Page wrapper  -->
    </div>
    <!-- End Wrapper -->


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

    <script>
        $(document).ready(function() {
            $("#addStudentForm").submit(function(event) {
                event.preventDefault(); // Prevent default form submission

                var formData = $(this).serialize(); // Get form data

                $.ajax({
                    url: "add-student.php", // Change to your actual PHP file URL
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        if (response.trim() === "error") {
                            // Show error toast notification if user already exists
                            $(".toast").removeClass("bg-success").addClass("bg-danger").find(".toast-body").text("Student already exists!");
                            $(".toast").toast('show');
                        } else if (response.trim() === "success") {
                            // Show success toast notification if student added successfully
                            $(".toast").removeClass("bg-danger").addClass("bg-success").find(".toast-body").text("Student added successfully!");
                            $(".toast").toast('show');
                        } else {
                            console.error("Unexpected response from server: " + response);
                        }
                        $("#addStudentForm")[0].reset(); // Clear form fields
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText); // Log error message
                        // Handle errors appropriately, e.g., display user-friendly error message
                    }
                });
            });
        });
    </script>

</body>

</html>