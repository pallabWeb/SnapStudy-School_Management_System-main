<?php
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the teacher is logged in
    if (!isset($_SESSION['teacher_username'])) {
        header("location: ./home/#login");
        exit();
    }

    // Check if attendance data is provided
    if (isset($_POST['attendance']) && isset($_POST['teacher_class'])) {
        // Get teacher's class and attendance data
        $teacher_class = $_POST['teacher_class'];
        $attendance = $_POST['attendance'];

        // Include database connection
        include_once 'db.php';

        // Get current date
        $current_date = date('Y-m-d');

        // Check if attendance for the current date already exists
        $sql_check_attendance = "SELECT COUNT(*) AS count FROM attendance WHERE class = ? AND date = ?";
        $stmt_check_attendance = mysqli_prepare($data, $sql_check_attendance);
        mysqli_stmt_bind_param($stmt_check_attendance, "ss", $teacher_class, $current_date);
        mysqli_stmt_execute($stmt_check_attendance);
        $result_check_attendance = mysqli_stmt_get_result($stmt_check_attendance);
        $row_check_attendance = mysqli_fetch_assoc($result_check_attendance);
        $attendance_count = $row_check_attendance['count'];

        if ($attendance_count > 0) {
            // Attendance for the current date already exists
            echo "duplicate"; // Send duplicate response
        } else {
            // Initialize variables to track success and error count
            $successCount = 0;
            $errorCount = 0;

            // Loop through attendance data and insert into database
            foreach ($attendance as $student_id => $status) {
                // Get student's username and student ID
                $sql_student_data = "SELECT id, student_username FROM students WHERE id = ?";
                $stmt_student_data = mysqli_prepare($data, $sql_student_data);
                mysqli_stmt_bind_param($stmt_student_data, "i", $student_id);
                mysqli_stmt_execute($stmt_student_data);
                $result_student_data = mysqli_stmt_get_result($stmt_student_data);
                $row_student_data = mysqli_fetch_assoc($result_student_data);
                $student_id = $row_student_data['id'];
                $student_username = $row_student_data['student_username'];

                // Prepare SQL statement to insert attendance record
                $sql_insert_attendance = "INSERT INTO attendance (student_id, student_username, class, status, date) VALUES (?, ?, ?, ?, ?)";
                $stmt_insert_attendance = mysqli_prepare($data, $sql_insert_attendance);
                mysqli_stmt_bind_param($stmt_insert_attendance, "issss", $student_id, $student_username, $teacher_class, $status, $current_date);

                // Execute SQL statement
                if (mysqli_stmt_execute($stmt_insert_attendance)) {
                    $successCount++; // Increment success count
                } else {
                    $errorCount++; // Increment error count
                }
            }

            // Check if there were any errors
            if ($errorCount == 0) {
                echo "success"; // Send success response
            } else {
                echo "error"; // Send error response
            }
        }
    }
}
?>