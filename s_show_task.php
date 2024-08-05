<?php
session_start();
error_reporting(0);

if (!isset($_SESSION['student_username'])) {
    header("location: ./home/#login");
}

include_once 'db.php';  // Database Connection

$username = $_SESSION['student_username'];

// Retrieve the class of the logged-in student
$sql_class = "SELECT class FROM students WHERE student_username = '$username'";
$result_class = mysqli_query($data, $sql_class);
$row_class = mysqli_fetch_assoc($result_class);
$class = $row_class['class'];

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

// Select tasks based on the student's class
$sql = "SELECT * FROM `task` WHERE class = '$class'";
$result = mysqli_query($data, $sql);

// Check if the assignment has already been submitted by the student
$sql_check_submission = "SELECT * FROM assignments WHERE student_name = '$username' AND student_class = '$class'";
$result_check_submission = mysqli_query($data, $sql_check_submission);
$has_submitted_assignment = mysqli_num_rows($result_check_submission) > 0;

// Download file function
if (isset($_GET['file'])) {
    $filePath = $_GET['file'];
    if (!empty($filePath) && file_exists($filePath)) {
        $fileName = basename($filePath);
        $downloadFileName = "Assignment." . pathinfo($fileName, PATHINFO_EXTENSION);

        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $downloadFileName . '"');
        header('Content-Length: ' . filesize($filePath));

        readfile($filePath);
        exit;
    } else {
        header('Location: error.php');
        exit;
    }
}

// Handle assignment upload only if the student hasn't submitted before
if (!$has_submitted_assignment && isset($_FILES['assignmentFile']) && isset($_POST['studentName']) && isset($_POST['assignmentTitle']) && isset($_POST['studentClass'])) {
    $student_name = $_POST['studentName'];
    $assignment_title = $_POST['assignmentTitle'];
    $teacher_name = $_POST['teacherName'];
    $student_class = $_POST['studentClass']; // Retrieve student's class from the form
    $file_name = $_FILES['assignmentFile']['name'];
    $file_tmp = $_FILES['assignmentFile']['tmp_name'];

    // Move file to a permanent location
    $destination = 'assignments/' . $file_name;
    move_uploaded_file($file_tmp, $destination);

    // Insert assignment details into database
    $sql_insert = "INSERT INTO assignments (student_name, assignment_title, teacher_name, student_class, file_name, file_path, submission_date) VALUES ('$student_name', '$assignment_title', '$teacher_name', '$student_class', '$file_name', '$destination', NOW())";
    mysqli_query($data, $sql_insert);

    // Show submission successful message
    $submission_message = "Assignment submitted successfully!";
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
    <title>Student | Show Task</title>
    <!-- Custom CSS -->
    <link href="css/student.min.css" rel="stylesheet">
</head>

<body>
    <div class="preloader"> <!-- Preloader - style you can find in spinners.css -->
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>

    <!-- Main wrapper -->
    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">

        <?php include 'components/user_topbar.php'; ?> <!-- Topbar header -->

        <?php include 'components/user_sidebar.php'; ?> <!-- Left Sidebar -->

        <div class="page-wrapper"> <!-- Page wrapper  -->

            <div class="page-breadcrumb"> <!-- Bread crumb and right sidebar toggle -->
                <div class="row">
                    <div class="col-7 align-self-center">
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb m-0 p-0">
                                    <li class="breadcrumb-item"><a href="student.php">Dashboard</a></li>
                                    <li class="breadcrumb-item">Show Task</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div> <!-- End Bread crumb and right sidebar toggle -->

            <div class="container-fluid"> <!-- Container fluid  -->
                <!-- Display submission message if it exists -->
                <?php if (isset($submission_message)) : ?>
                    <div class="alert alert-success fade show" id="Alert" role="alert">
                        <?php echo $submission_message; ?>
                    </div>
                <?php endif; ?>

                <!-- Display tasks -->
                <?php if (mysqli_num_rows($result) > 0) : ?>
                    <?php while ($info = $result->fetch_assoc()) : ?>
                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <h1 class="text-center text-uppercase"><?php echo $info['task_name']; ?></h1>
                                <p class="text-center">Due Date: <span class="text-primary"><?php echo $info['due_date']; ?></span> </p>
                                <p>Instructions</p>
                                <p class="text-uppercase text-dark"><?php echo $info['desc']; ?></p>
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p>Reference materials</p>
                                    </div>
                                    <div>
                                        <p>Assigned by: <span class="text-success"><?php echo $info['t_username']; ?></span></p>
                                    </div>
                                </div>
                                <div class="input-group flex-nowrap">
                                    <div class="custom-file w-100">
                                        <input class="form-control" type="text" readonly value="<?php echo basename($info['file']); ?>">
                                    </div>
                                    <a class="btn btn-outline-secondary" href="s_show_task.php?file=<?php echo urlencode($info['file']); ?>" download><i data-feather="download" class="feather-icon"></i></a>
                                </div>

                                <p class="mt-3">My work</p>
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="input-group flex-nowrap">
                                        <div class="custom-file w-100">
                                            <input class="form-control" type="file" name="assignmentFile" id="formFile">
                                        </div>
                                        <button class="btn btn-success" type="submit">
                                            Upload
                                        </button>
                                    </div>
                                    <input type="hidden" name="studentName" value="<?php echo $username; ?>">
                                    <input type="hidden" name="assignmentTitle" value="<?php echo $info['task_name']; ?>">
                                    <input type="hidden" name="teacherName" value="<?php echo $info['t_username']; ?>">
                                    <input type="hidden" name="studentClass" value="<?php echo $class; ?>">
                                </form>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else : ?>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h2 class="text-success">No Upcoming Assignments Right now.</h2>
                        </div>
                    </div>
                <?php endif; ?>
                <!-- End Display tasks -->

            </div> <!-- End Container fluid -->
        </div> <!-- End Page wrapper -->
    </div> <!-- End Main Wrapper -->

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