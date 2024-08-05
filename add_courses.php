<?php
session_start();

if (!isset($_SESSION['admin_username'])) {
    header("location:./home/#login");
    exit();
}

include_once 'db.php';  // Database Connection

// Handle form submission for adding courses
if (isset($_POST['add_courses'])) {
    // Retrieve form data
    $t_name = $_POST['name'];
    $t_titlename = $_POST['titlename'];
    $category = $_POST['category'];
    $file = $_FILES['imgcourse']['name'];

    // Set destination path for image upload
    $dst = "./imgcourse/" . $file;
    $dst_db = "imgcourse/" . $file;

    // Move uploaded image file to destination directory
    move_uploaded_file($_FILES['imgcourse']['tmp_name'], $dst);


    $sql = "INSERT INTO `courses`( `name`, `titlename`, `category`, `image`) VALUES ('$t_name','$t_titlename', '$category','$dst_db')";

    // Execute SQL query
    $result = mysqli_query($data, $sql);

    // Redirect to view courses page if insertion is successful
    if ($result) {
        header('location:view_courses.php');
        exit(); // Terminate script execution after redirection
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

    <title>Admin | Add Courses</title>
    <!-- Custom CSS -->
    <link href="css/style2.min.css" rel="stylesheet">
</head>

<body>

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
                                    <li class="breadcrumb-item"><a href="adminhome.php">Dashboard</a></li>
                                    <li class="breadcrumb-item">Students</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

            </div>
            <!-- End Bread crumb and right sidebar toggle -->

            <div class="container-fluid">

                <!-- Add Courses -->

                <!-- Toast Notification -->
                <div class="toast align-items-center text-white bg-success" role="alert" aria-live="assertive" aria-atomic="true" id="successToast" style="position: fixed; bottom: 20px; right: 20px; z-index: 9999;">
                    <div class="d-flex">
                        <div class="toast-body">
                        </div>
                        <button type="button" class="btn-close me-2 m-auto text-white" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>

                <form class="row g-3" action="#" method="POST" enctype="multipart/form-data">
                    <div class="col-md-6">
                        <label for="name" class="mt-3">Courses Name:</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter courses name" required>
                    </div>
                    <div class="col-md-6">
                        <label for="titlename" class="mt-3">Title:</label>
                        <input type="tel" class="form-control" name="titlename" id="titlename" placeholder="Enter title name" required>
                    </div>
                    <div class="col-6">
                        <label for="image" class="mt-3">Image:</label>
                        <input class="form-control" type="file" name="imgcourse" id="formFile" accept="image/*" required>
                    </div>
                    <div class="col-md-6">
                        <label for="category" class="mt-3">Category:</label>
                        <select class="form-select" name="category" id="category" required>
                            <option value="">Select a category</option>
                            <option value="Drawing">Drawing</option>
                            <option value="Foreign Languages">Foreign Languages</option>
                            <option value="Computer Science">Computer Science</option>
                            <option value="Physical Education">Physical Education</option>
                            <option value="Electives">Electives</option>
                        </select>
                    </div>


                    <div class="col-12">
                        <button type="submit" class="btn btn-success mt-3 rounded-3 float-end submit" name="add_courses">Add Course</button>
                    </div>
                </form>

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

</body>

</html>