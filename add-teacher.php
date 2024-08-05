<?php
session_start();

if (!isset($_SESSION['admin_username'])) {
    header("location: ./home/#login");
}

include_once 'db.php';  // Database Connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['name']) && isset($_POST['teacher_username']) && isset($_POST['phone']) && isset($_POST['email']) && isset($_POST['password'])) {

        $name = $_POST['name'];
        $username = $_POST['teacher_username'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $class = $_POST['class'];
        $description = $_POST['description'];
        $password = $_POST['password'];
        $hashed_password = md5($password);
        $usertype = "teacher";

        
        // Check if email or phone already exists
        $check_query = "SELECT * FROM teacher WHERE teacher_username='$username' OR email='$email' OR phone='$phone'";
        $check_result = mysqli_query($data, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            echo "error"; // Send error signal if teacher with this email or phone already exists
            exit; // Exit script if error occurs
        } else {
            $sql = "INSERT INTO teacher (`name`, `teacher_username`, `phone`, `email`, `class`, `description`, `usertype`, `password`) VALUES ('$name', '$username', '$phone', '$email', '$class', '$description', '$usertype', '$hashed_password')";

            if (mysqli_query($data, $sql)) {
                echo "success"; // Send success signal if teacher added successfully
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