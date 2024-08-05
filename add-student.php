<?php
session_start();

if (!isset($_SESSION['admin_username'])) {
    header("location: ./home/#login");
}

include_once 'db.php';  // Database Connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['name']) && isset($_POST['student_username']) && isset($_POST['phone']) && isset($_POST['class']) && isset($_POST['email']) && isset($_POST['password'])) {

        $name = $_POST['name'];
        $username = $_POST['student_username'];
        $phone = $_POST['phone'];
        $class = $_POST['class'];
        $email = $_POST['email'];
        $usertype = "student";
        $password = $_POST['password'];

        $hashed_password = md5($password);

        // Check if email or phone already exists
        $check_query = "SELECT * FROM students WHERE student_username='$username' OR email='$email' OR phone='$phone'";
        $check_result = mysqli_query($data, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            echo "error"; // Send error signal if student with this email or phone already exists
            exit; // Exit script if error occurs
        } else {
            $sql = "INSERT INTO students (`name`, `student_username`, `phone`, `class`, `email`, `usertype`, `password`) VALUES ('$name', '$username', '$phone', '$class', '$email','$usertype', '$hashed_password')";

            if (mysqli_query($data, $sql)) {
                echo "success"; // Send success signal if student added successfully
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($data);
            }
        }
    } else {
        echo "All form fields are required!";
    }
} else {
    echo "Invalid request!";
}
?>