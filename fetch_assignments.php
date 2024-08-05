<?php
session_start();
error_reporting(0);

if (!isset($_SESSION['teacher_username'])) {
    header("location: ./home/#login");
}

include_once 'db.php';  // Database Connection

// Retrieve the selected class from the POST request
$selectedClass = $_POST['class'];

// Retrieve assignments for the selected class from the database
$sql_assignments = "SELECT * FROM assignments WHERE student_class = '$selectedClass'";
$result_assignments = mysqli_query($data, $sql_assignments);

// Check if there are any assignments
if (mysqli_num_rows($result_assignments) > 0) {
    // Output HTML for each assignment
    while ($row = mysqli_fetch_assoc($result_assignments)) {
        echo '<div class="col-md-6">';
        echo '<div class="card mb-3">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . $row['assignment_title'] . '</h5>';
        echo '<p class="card-text">Submitted by: ' . $row['student_name'] . '</p>';
        echo '<p class="card-text">Class: ' . $row['student_class'] . '</p>';
        echo '<p class="card-text">Submission Date: ' . $row['submission_date'] . '</p>';
        echo '<a href="' . $row['file_path'] . '" class="btn btn-primary" download><i data-feather="download" class="feather-icon"></i></a>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
} else {
    // If no assignments found for the selected class
    echo '<p>No assignments found for this class.</p>';
}

?>
