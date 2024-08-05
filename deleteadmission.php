<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
  header("location: ./home/#login");
}

include_once 'db.php';  // Database Connection

$sql = "SELECT * FROM `admissionform` ";

$result = mysqli_query($data, $sql);

// Check if 'id' key is set in $_GET array
if (isset($_GET['id'])) {
  $t_id = $_GET['id'];

  // SQL query to delete data from the database where id matches
  $sql2 = "DELETE FROM `admissionform` WHERE id='$t_id'";

  // Execute the delete query
  $result2 = mysqli_query($data, $sql2);

  // Check if deletion was successful
  if ($result2) {
    // Redirect back to the page after successful deletion
    header('location:admission.php');
  }
}
?>