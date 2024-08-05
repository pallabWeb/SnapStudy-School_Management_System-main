<?php
session_start();

include_once 'db.php';  // Database Connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the 'id' parameter is provided in the POST request
    if (isset($_POST['id'])) {
        // Sanitize the input to prevent SQL injection
        $studentId = mysqli_real_escape_string($data, $_POST['id']);

        // Prepare and execute the SQL query to fetch student details based on the provided ID
        $sql = "SELECT * FROM admissionform WHERE id = '$studentId'";
        $result = mysqli_query($data, $sql);

        // Check if the query was successful
        if ($result) {
            // Fetch student details as an associative array
            $studentData = mysqli_fetch_assoc($result);

            // Return the student details as JSON
            echo json_encode($studentData);
        } else {
            // Handle query error
            echo json_encode(['error' => 'Failed to fetch student details']);
        }
    } else {
        // Handle missing 'id' parameter
        echo json_encode(['error' => 'Student ID not provided']);
    }
} else {
    // Handle invalid request method
    echo json_encode(['error' => 'Invalid request']);
}
?>