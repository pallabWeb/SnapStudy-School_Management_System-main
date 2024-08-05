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

// Fetch distinct dates for which attendance is recorded for the teacher's class
$sql_dates = "SELECT DISTINCT date FROM attendance WHERE class = ? ORDER BY date DESC";
$stmt_dates = mysqli_prepare($data, $sql_dates);
mysqli_stmt_bind_param($stmt_dates, "s", $teacher_class);
mysqli_stmt_execute($stmt_dates);
$result_dates = mysqli_stmt_get_result($stmt_dates);

// Fetch attendance data for the latest date by default
$latest_date_sql = "SELECT MAX(date) AS latest_date FROM attendance WHERE class = ?";
$stmt_latest_date = mysqli_prepare($data, $latest_date_sql);
mysqli_stmt_bind_param($stmt_latest_date, "s", $teacher_class);
mysqli_stmt_execute($stmt_latest_date);
$result_latest_date = mysqli_stmt_get_result($stmt_latest_date);
$row_latest_date = mysqli_fetch_assoc($result_latest_date);
$selected_date = isset($_POST['selected_date']) ? $_POST['selected_date'] : $row_latest_date['latest_date'];

// Fetch attendance data for the selected date
if ($selected_date) {
    $sql_attendance = "SELECT * FROM attendance WHERE class = ? AND date = ?";
    $stmt_attendance = mysqli_prepare($data, $sql_attendance);
    mysqli_stmt_bind_param($stmt_attendance, "ss", $teacher_class, $selected_date);
    mysqli_stmt_execute($stmt_attendance);
    $result_attendance = mysqli_stmt_get_result($stmt_attendance);
}
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Favicon -->
    <link rel="icon" href="./img/favicon_logoai/favicon-16x16.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Teacher | Attendance Report - <?php echo $teacher_class; ?></title>
    <link href="css/teacher.min.css" rel="stylesheet">
    <style>
        /* Custom CSS for status colors */
        .status-present {
            color: green !important;
        }

        .status-absent {
            color: red !important;
        }
    </style>
</head>

<body>

    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">
        
        <!-- Topbar header -->
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
                                    <li class="breadcrumb-item">Students</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="col-5 d-flex justify-content-end align-self-center">
                        <form id="filterForm">
                            <div class="input-group mb-3">
                                <input type="date" id="selected_date" name="selected_date" class="form-control" value="<?php echo $selected_date; ?>">
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="container">
                    <?php if ($selected_date) : ?>
                        <table class="table table-bordered">
                            <thead class="text-center">
                                <tr>
                                    <th>Student ID</th>
                                    <th>Student Username</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody class="text-center" id="attendanceTable">
                                <?php while ($row_attendance = mysqli_fetch_assoc($result_attendance)) : ?>
                                    <tr>
                                        <td><?php echo $row_attendance['student_id']; ?></td>
                                        <td><?php echo $row_attendance['student_username']; ?></td>
                                        <td><?php echo $row_attendance['status']; ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>

                <!-- A download button to download attendance report as PDF -->
                <div class="text-center mt-3">
                    <form id="downloadForm" method="post" action="download_attendance.php">
                        <input type="hidden" id="downloadSelectedDate" name="selected_date" value="<?php echo $selected_date; ?>">
                        <button type="submit" class="btn btn-success btn-sm float-end rounded-3">Download Attendance</button>
                    </form>
                </div>

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
                $("#filterForm").submit(function(event) {
                    event.preventDefault(); // Prevent default form submission

                    var formData = $(this).serialize(); // Get form data

                    $.ajax({
                        url: "view-attendance.php",
                        type: "POST",
                        data: formData,
                        success: function(response) {
                            $("#attendanceTable").html(response);

                            // Update the form action URL with the selected date
                            var selectedDate = $("#selected_date").val();
                            $("#downloadSelectedDate").val(selectedDate);
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

</body>

</html>