<?php
// Include database connection file
include_once 'db.php';

// Retrieve selected date from POST data
$selected_date = $_POST['selected_date'];

// Retrieve teacher's class from session
session_start();
if (!isset($_SESSION['teacher_username'])) {
    header("location: ./home/#login");
    exit();
}
$teacher_username = $_SESSION['teacher_username'];

// Fetch teacher's class from the database
$sql_teacher_class = "SELECT class FROM teacher WHERE teacher_username = ?";
$stmt_teacher_class = mysqli_prepare($data, $sql_teacher_class);
mysqli_stmt_bind_param($stmt_teacher_class, "s", $teacher_username);
mysqli_stmt_execute($stmt_teacher_class);
$result_teacher_class = mysqli_stmt_get_result($stmt_teacher_class);
$row_teacher_class = mysqli_fetch_assoc($result_teacher_class);
$teacher_class = $row_teacher_class['class'];

// Fetch attendance data for the selected date and teacher's class
$sql_attendance = "SELECT * FROM attendance WHERE class = ? AND date = ?";
$stmt_attendance = mysqli_prepare($data, $sql_attendance);
mysqli_stmt_bind_param($stmt_attendance, "ss", $teacher_class, $selected_date);
mysqli_stmt_execute($stmt_attendance);
$result_attendance = mysqli_stmt_get_result($stmt_attendance);

// Build HTML table rows with attendance data
$table_rows = '';
while ($row_attendance = mysqli_fetch_assoc($result_attendance)) {
    $table_rows .= "<tr>";
    $table_rows .= "<td>{$row_attendance['student_id']}</td>";
    $table_rows .= "<td>{$row_attendance['student_username']}</td>";
    $table_rows .= "<td>{$row_attendance['status']}</td>";
    $table_rows .= "</tr>";
}

// Output HTML table rows
echo $table_rows;
?>