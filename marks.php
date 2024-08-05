<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input data
    $student_username = $_POST["student_username"];
    $bengali_marks = $_POST["bengali_marks"];
    $english_marks = $_POST["english_marks"];
    $mathematics_marks = $_POST["mathematics_marks"];
    $life_science_marks = $_POST["life_science_marks"];
    $physical_science_marks = $_POST["physical_science_marks"];
    $history_marks = $_POST["history_marks"];
    $geography_marks = $_POST["geography_marks"];
    $extracurricular_marks = $_POST["extracurricular_marks"];

    // Database connection
    include_once 'db.php';

    // Check connection
    if ($data->connect_error) {
        die("Connection failed: " . $data->connect_error);
    }

    // Prepare SQL statement to insert marks into database
    $sql = "INSERT INTO marks (student_username, bengali_marks, english_marks, mathematics_marks, 
            life_science_marks, physical_science_marks, history_marks, geography_marks, 
            extracurricular_marks) VALUES ('$student_username', '$bengali_marks', '$english_marks', 
            '$mathematics_marks', '$life_science_marks', '$physical_science_marks', '$history_marks', 
            '$geography_marks', '$extracurricular_marks')";

    if ($data->query($sql) === TRUE) {
        echo "<script>alert('Marks added successfully!')</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $data->error;
    }

    // Close connection
    $data->close();
} else {
    // Redirect back to the form if accessed directly without form submission
    header("Location: add_marks.php");
    exit();
}
?>