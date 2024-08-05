<?php
session_start();

include_once 'db.php';
require 'PHPspreadsheet/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (!isset($_SESSION['teacher_username'])) {
    header("location: ./home/#login");
    exit();
}

$teacher_username = $_SESSION['teacher_username'];

if (isset($_POST['selected_date'])) {
    $selected_date = $_POST['selected_date'];

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

    // Create a new Spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Attendance');

    // Set the header row
    $sheet->setCellValue('A1', 'Student ID');
    $sheet->setCellValue('B1', 'Student Username');
    $sheet->setCellValue('C1', 'Status');

    // Populate the spreadsheet with attendance data
    $rowIndex = 2;
    while ($row_attendance = mysqli_fetch_assoc($result_attendance)) {
        $sheet->setCellValue('A' . $rowIndex, $row_attendance['student_id']);
        $sheet->setCellValue('B' . $rowIndex, $row_attendance['student_username']);
        $sheet->setCellValue('C' . $rowIndex, $row_attendance['status']);
        $rowIndex++;
    }

    // Generate the Excel file
    $writer = new Xlsx($spreadsheet);
    $filename = 'Attendance_' . $teacher_class . '_' . $selected_date . '.xlsx';
    $filePath = 'attendance/' . $filename;

    // Save the file to the server
    $writer->save($filePath);

    // Redirect to the download link
    header("Location: $filePath");
    exit();
} else {
    echo "No date selected.";
    exit();
}
?>
