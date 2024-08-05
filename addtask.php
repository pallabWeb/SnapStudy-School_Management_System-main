<?php
session_start();
error_reporting(0);

if (!isset($_SESSION['teacher_username'])) {
    header("location:./home/#login");
}

include_once 'db.php';  // Database Connection

if (isset($_POST['add_task'])) {
    $t_name = $_POST['name'];
    $task_name = $_POST['task_name'];
    $t_class = $_POST['class'];
    $t_due = $_POST['due_date'];
    $t_descs = $_POST['descs'];

    $file = $_FILES['file']['name'];

    $dst = "./task_file/" . $file;
    $dst_db = "task_file/" . $file;

    move_uploaded_file($_FILES['file']['tmp_name'], $dst);

    $sql = "INSERT INTO `task`(`t_username`,`task_name`, `file`, `class`,`due_date`, `desc`) VALUES ('$t_name','$task_name','$dst_db','$t_class','$t_due','$t_descs')";

    $result = mysqli_query($data, $sql);

    if ($result) {
        header('location:t_show_task.php');
    }
}

// Fetch teacher's assigned class from the database
$teacher_username = $_SESSION['teacher_username'];
$sql_teacher_class = "SELECT class FROM teacher WHERE teacher_username = '$teacher_username'";
$result_teacher_class = mysqli_query($data, $sql_teacher_class);
$row_teacher_class = mysqli_fetch_assoc($result_teacher_class);
$teacher_class = $row_teacher_class['class'];


// Fetch teacher's image path from the database
$teacher_username = $_SESSION['teacher_username'];
$sql = "SELECT image FROM teacher WHERE teacher_username = '$teacher_username'";
$result = mysqli_query($data, $sql);
$row = mysqli_fetch_assoc($result);
$teacher_image = $row['image'];
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
    <title>Teacher | Add Task</title>
    <!-- Custom CSS -->
    <link href="css/teacher.min.css" rel="stylesheet">
</head>

<body>
    <div class="preloader"> <!-- Preloader -->
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- Main wrapper -->
    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">

        <?php include 'components/t_topbar.php'; ?> <!-- Topbar header -->


        <?php include 'components/t_sidebar.php'; ?> <!-- Left Sidebar -->

        <div class="page-wrapper">
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

            </div> <!-- End Bread crumb and right sidebar toggle -->

            <div class="container-fluid"> <!-- Container fluid -->


                <form action="#" class="row g-3" method="POST" enctype="multipart/form-data">
                    <div class="col-md-6">
                        <input type="text" hidden name="name" value="<?php echo $_SESSION['teacher_username']; ?>">
                        <label for="task_name" class="mt-3">Task Name:</label>
                        <input type="text" class="form-control" name="task_name" id="task_name" placeholder="Enter your taskname" required>
                    </div>
                    <div class="col-md-6">
                        <label for="file" class="mt-3">Reference materials:</label>
                        <input type="file" class="form-control" name="file" id="file" required>
                    </div>
                    <div class="col-6">
                        <label for="descs" class="mt-3">Instructions:</label>
                        <input type="text" class="form-control" name="descs" id="descs" placeholder="Enter your instructions" required>
                    </div>
                    <div class="col-6">
                        <label for="due_date" class="mt-3">Due date:</label>
                        <input type="date" class="form-control" name="due_date" id="due_date" required>
                    </div>
                    <div class="col-md-6">
                        <label for="class" class="mt-3">Select class:</label>
                        <select class="form-select" name="class">
                            <option value="<?php echo $teacher_class; ?>" selected><?php echo $teacher_class; ?></option>
                        </select>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-success mt-3 rounded-3 float-end submit" name="add_task">Add Task</button>
                    </div>
                </form>

            </div>


        </div> <!-- End Container fluid -->
    </div> <!-- End Page wrapper -->

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

</body