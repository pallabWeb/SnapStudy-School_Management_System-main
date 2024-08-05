<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['admin_username'])) {
    header("location: ./home/#login");
    exit; // Stop further execution
}

// Check if the admission id is provided and it's a valid integer
if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    // Include database connection file

    include_once 'db.php';  // Database Connection



    // Sanitize the admission id
    $admission_id = mysqli_real_escape_string($data, $_GET['id']);

    // Prepare a delete statement
    $sql = "DELETE FROM `booking` WHERE `id` = $admission_id";

    // Execute the delete statement
    if (mysqli_query($data, $sql)) {
        // Redirect back to the admission page after successful deletion
        header("location:booking_view.php");
        exit; // Stop further execution
    } else {
        // If deletion fails, display an error message
        echo "Error: " . mysqli_error($data);
    }

    // Close the database connection
    mysqli_close($data);
} else {
    // If admission id is not provided or invalid, redirect back to the admission page
    header("location:booking_view.php");
    exit; // Stop further execution
}
