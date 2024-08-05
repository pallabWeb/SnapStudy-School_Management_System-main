<?php
session_start();

if (!isset($_SESSION['admin_username'])) {
    header("location: ./home/#login");
}

include_once 'db.php';  // Database Connection

if ($_GET['courses_id']) {
    $t_id = $_GET['courses_id'];

    $sql = "SELECT * FROM `courses` WHERE id='$t_id' ";

    $result = mysqli_query($data, $sql);

    $info = $result->fetch_assoc();
}

if (isset($_POST['update_courses'])) {
    $id = $_POST['id'];
    $t_name = $_POST['name'];
    $t_titlename = $_POST['titlename'];
    $file = $_FILES['imgcourse']['name'];
    $dst = "./imgcourse/" . $file;
    $dst_db = "imgcourse/" . $file;

    move_uploaded_file($_FILES['imgcourse']['tmp_name'], $dst);

    if ($file) {
        $sql2 = "UPDATE `courses` SET `name`='$t_name', `titlename`='$t_titlename', `image`='$dst_db' WHERE id='$id' ";
    } else {
        $sql2 = "UPDATE `courses` SET `name`='$t_name', `titlename`='$t_titlename'  WHERE id='$id' ";
    }

    $result2 = mysqli_query($data, $sql2);

    if ($result2) {
        header('location: view_courses.php');
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
    <title>Admin | Edit Details</title>
    <!-- Custom CSS -->
    <link href="css/style2.min.css" rel="stylesheet">
</head>

<body>
    <div class="preloader">  <!-- Preloader -->
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- Main wrapper -->
    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">
         
       
        <?php include 'components/admintopbar.php'; ?>  <!-- Topbar header -->

        
        <?php include 'components/adminsidebar.php'; ?>   <!-- Left Sidebar -->

        <div class="page-wrapper">        <!-- Page wrapper  -->
           
            <div class="page-breadcrumb">   <!-- Bread crumb and right sidebar toggle -->
                <div class="row">
                    <div class="col-7 align-self-center">
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb m-0 p-0">
                                    <li class="breadcrumb-item"><a href="adminhome.php">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item">Update Courses</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>  <!-- End Bread crumb and right sidebar toggle -->
           

            <div class="container-fluid">  <!-- Container fluid  -->


                <form class="row g-3" action="" method="POST" enctype="multipart/form-data">

                    <div class="col-md-6 text-center">
                        <input type="text" hidden name="id" value="<?php echo "{$info['id']}"; ?>">
                        <img src="<?php echo "{$info['image']}"; ?>" class="rounded-4" height="100" width="auto" alt="Current course image">
                    </div>

                    <div class="col-md-6">
                        <label for="image" class="mt-3">Image:</label>
                        <input type="file" class="form-control" name="imgcourse" id="imgcourse">
                    </div>

                    <div class="col-md-6">
                        <label for="username" class="mt-3">Course name:</label>
                        <input type="text" class="form-control" name="name" id="username" value="<?php echo "{$info['name']}";     ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="description" class="mt-3">Bio:</label>
                        <textarea class="form-control" rows="1" name="titlename"><?php echo "{$info['titlename']}"; ?></textarea>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-success mt-3 rounded-3 float-end submit" name="update_courses">Update Courses</button>
                    </div>
                </form>

            </div> <!-- End Container fluid  -->


        </div> <!-- End Page Wrapper  -->

    </div> <!-- End Main Wrapper  -->


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