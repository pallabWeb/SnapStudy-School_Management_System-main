<?php
// session_start();
// error_reporting(0);

// include_once 'db.php';

// if ($data === false) {
//     die("Connection error: " . mysqli_connect_error());
// }

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $username = $_POST['username'];
//     $pass = $_POST['password'];

//     // Hash the provided password using MD5
//     $hashed_pass = md5($pass);

//     // Query all user tables for login
//     $sql_admin = "SELECT * FROM `admin` WHERE admin_username='$username'";
//     $sql_student = "SELECT * FROM `students` WHERE student_username='$username'";
//     $sql_teacher = "SELECT * FROM `teacher` WHERE teacher_username='$username'";
//     $sql_fees = "SELECT * FROM `fees_admin` WHERE fees_username='$username' AND password='$hashed_pass'";

//     $result_admin = mysqli_query($data, $sql_admin);
//     $result_student = mysqli_query($data, $sql_student);
//     $result_teacher = mysqli_query($data, $sql_teacher);
//     $result_fees = mysqli_query($data, $sql_fees);

//     // Check if credentials match any user type
//     if ($result_admin && mysqli_num_rows($result_admin) > 0) {
//         $row = mysqli_fetch_assoc($result_admin);
//         $redirect = 'adminhome.php';
//         $role = 'admin';
//     } elseif ($result_student && mysqli_num_rows($result_student) > 0) {
//         $row = mysqli_fetch_assoc($result_student);
//         $redirect = 'student.php';
//         $role = 'student';
//     } elseif ($result_teacher && mysqli_num_rows($result_teacher) > 0) {
//         $row = mysqli_fetch_assoc($result_teacher);
//         $redirect = 'teacher.php';
//         $role = 'teacher';
//     } elseif ($result_fees && mysqli_num_rows($result_fees) > 0) {
//         $row = mysqli_fetch_assoc($result_fees);
//         $redirect = 'invoice.php';
//         $role = 'fees';
//     } else {
//         $message = "Username or password do not match";
//         $_SESSION['loginMessage'] = $message;
//         header("location: ./home/"); // Redirect back to login page with error message
//         exit();
//     }

//     // Check if the hashed password matches
//     if ($row && $row['password'] === $hashed_pass) {
//         $_SESSION[$role . '_username'] = $username;
//         header("location: $redirect"); // Redirect to appropriate page based on role
//         exit();
//     } else {
//         $message = "Username or password do not match";
//         $_SESSION['loginMessage'] = $message;
//         header("location: ./home/"); // Redirect back to login page with error message
//         exit();
//     }
// }
?>


<?php
session_start();
error_reporting(0);

include_once 'db.php';

header('Content-Type: application/json');

if ($data === false) {
    die(json_encode(["status" => "error", "message" => "Connection error: " . mysqli_connect_error()]));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $pass = $_POST['password'];

    // Hash the provided password using MD5
    $hashed_pass = md5($pass);

    // Query all user tables for login
    $sql_admin = "SELECT * FROM `admin` WHERE admin_username='$username'";
    $sql_student = "SELECT * FROM `students` WHERE student_username='$username'";
    $sql_teacher = "SELECT * FROM `teacher` WHERE teacher_username='$username'";
    $sql_fees = "SELECT * FROM `fees_admin` WHERE fees_username='$username' AND password='$hashed_pass'";

    $result_admin = mysqli_query($data, $sql_admin);
    $result_student = mysqli_query($data, $sql_student);
    $result_teacher = mysqli_query($data, $sql_teacher);
    $result_fees = mysqli_query($data, $sql_fees);

    // Check if credentials match any user type
    if ($result_admin && mysqli_num_rows($result_admin) > 0) {
        $row = mysqli_fetch_assoc($result_admin);
        $redirect = '../adminhome.php';
        $role = 'admin';
    } elseif ($result_student && mysqli_num_rows($result_student) > 0) {
        $row = mysqli_fetch_assoc($result_student);
        $redirect = '../student.php';
        $role = 'student';
    } elseif ($result_teacher && mysqli_num_rows($result_teacher) > 0) {
        $row = mysqli_fetch_assoc($result_teacher);
        $redirect = '../teacher.php';
        $role = 'teacher';
    } elseif ($result_fees && mysqli_num_rows($result_fees) > 0) {
        $row = mysqli_fetch_assoc($result_fees);
        $redirect = '../updatestu.php';
        $role = 'fees';
    } else {
        echo json_encode(["status" => "error", "message" => "Username or password do not match"]);
        exit();
    }

    // Check if the hashed password matches
    if ($row && $row['password'] === $hashed_pass) {
        $_SESSION[$role . '_username'] = $username;
        echo json_encode(["status" => "success", "redirect" => $redirect]);
        exit();
    } else {
        echo json_encode(["status" => "error", "message" => "Username or password do not match"]);
        exit();
    }
}
?>
