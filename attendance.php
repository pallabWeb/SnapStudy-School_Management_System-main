<?php
session_start();

include_once 'db.php';  // Database Connection

// Check if the teacher is logged in and retrieve their class information
if (!isset($_SESSION['teacher_username'])) {
    header("location: ./home/#login");
    exit();
}

$teacher_username = $_SESSION['teacher_username'];

// Fetch teacher's image path from the database
$teacher_username = $_SESSION['teacher_username'];
$sql = "SELECT image FROM teacher WHERE teacher_username = '$teacher_username'";
$result = mysqli_query($data, $sql);
$row = mysqli_fetch_assoc($result);
$teacher_image = $row['image'];

// Fetch the teacher's class from the database
$sql_teacher_class = "SELECT class FROM teacher WHERE teacher_username = ?";
$stmt_teacher_class = mysqli_prepare($data, $sql_teacher_class);
mysqli_stmt_bind_param($stmt_teacher_class, "s", $teacher_username);
mysqli_stmt_execute($stmt_teacher_class);
$result_teacher_class = mysqli_stmt_get_result($stmt_teacher_class);
$row_teacher_class = mysqli_fetch_assoc($result_teacher_class);
$teacher_class = $row_teacher_class['class'];

// Fetch only students belonging to the teacher's class
$sql_students = "SELECT id, student_username FROM students WHERE class = ?";
$stmt_students = mysqli_prepare($data, $sql_students);
mysqli_stmt_bind_param($stmt_students, "s", $teacher_class);
mysqli_stmt_execute($stmt_students);
$result_students = mysqli_stmt_get_result($stmt_students);

// Get the current date
$current_date = date("Y-m-d");
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Favicon -->
    <link rel="icon" href="./img/favicon_logoai/favicon-16x16.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Teacher | Attendance - <?php echo $teacher_class; ?></title>
    <link href="css/teacher.min.css" rel="stylesheet">
    <style>
        .custom-radio .custom-control-input {
            width: 20px;
            height: 20px;
        }
    </style>
</head>

<body>

    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">


        <?php include_once 'components/t_topbar.php'; ?>

        <?php include_once 'components/t_sidebar.php'; ?>

        <div class="page-wrapper">
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-7 align-self-center">
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb m-0 p-0">
                                    <li class="breadcrumb-item"><a href="student.php">Dashboard</a></li>
                                    <li class="breadcrumb-item">Attendance</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <!-- Display current date -->
                    <div class="col-5 align-self-center">
                        <div class="d-flex justify-content-end">
                            <p class="m-0">Current Date: <?php echo $current_date; ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Toast Notification -->
            <div id="toastContainer">
                <div class="toast align-items-center text-white bg-success" role="alert" aria-live="assertive" aria-atomic="true" style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 9999;">
                    <div class="d-flex">
                        <div class="toast-body">
                        </div>
                        <button type="button" class="btn-close me-2 m-auto text-white" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="container">
                    <form id="attendanceForm" method="post">
                        <input type="hidden" name="teacher_class" value="<?php echo $teacher_class; ?>">
                        <table class="table table-bordered ">
                            <thead>
                                <tr>
                                    <th>Student ID</th>
                                    <th>Student Username</th>
                                    <th width="10%" class="text-center">Present</th>
                                    <th width="10%" class="text-center">Absent</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row_student = mysqli_fetch_assoc($result_students)) : ?>
                                    <tr>
                                        <td><?php echo $row_student['id']; ?></td>
                                        <td><?php echo $row_student['student_username']; ?></td>
                                        <td class="text-center">
                                            <input type="radio" name="attendance[<?php echo $row_student['id']; ?>]" value="Present">
                                        </td>
                                        <td class="text-center ">
                                            <input type="radio" name="attendance[<?php echo $row_student['id']; ?>]" value="Absent">
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-primary float-end">Submit Attendance</button>
                    </form>
                </div>
            </div>

            <!-- JavaScript files -->
            <script src="js/jquery.min.js"></script>
            <script src="js/bootstrap.bundle.min.js"></script>
            <script src="js/app-style-switcher.js"></script>
            <script src="js/feather.min.js"></script>
            <script src="js/perfect-scrollbar.jquery.min.js"></script>
            <script src="js/sidebarmenu.js"></script>
            <script src="js/custom.min.js"></script>
            <script>
                $(document).ready(function() {
                    $("#attendanceForm").submit(function(event) {
                        event.preventDefault(); // Prevent default form submission

                        var formData = $(this).serialize(); // Get form data

                        $.ajax({
                            url: "submit_attendance.php", // Change to your actual PHP file URL
                            type: "POST",
                            data: formData,
                            success: function(response) {
                                if (response.trim() === "error") {
                                    // Show error toast notification if attendance submission fails
                                    $(".toast").removeClass("bg-success").addClass("bg-danger").find(".toast-body").text("Attendance submission failed.");
                                    $(".toast").toast('show');
                                } else if (response.trim() === "success") {
                                    // Show success toast notification if attendance submission succeeds
                                    $(".toast").removeClass("bg-danger").addClass("bg-success").find(".toast-body").text("Attendance submitted successfully.");
                                    $(".toast").toast('show');
                                } else if (response.trim() === "duplicate") {
                                    // Show toast notification for duplicate submission
                                    $(".toast").removeClass("bg-success").addClass("bg-warning").find(".toast-body").text("Attendance already submitted for today.");
                                    $(".toast").toast('show');
                                } else {
                                    console.error("Unexpected response from server: " + response);
                                }
                                $("#attendanceForm")[0].reset(); // Clear form fields
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText); // Log error message
                                // Handle errors appropriately, e.g., display user-friendly error message
                            }
                        });
                    });
                });
            </script>

        </div>
    </div>

</body>

</html>