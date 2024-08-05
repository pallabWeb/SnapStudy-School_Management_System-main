<?php
// session_start();
// $_SESSION = array();
// session_destroy();
// header("location: ./home/");
// exit();
?>

<?php
session_start();

// Check the user role session variables and destroy the session accordingly
if (isset($_SESSION['admin_username'])) {
    unset($_SESSION['admin_username']);
    session_destroy();
    header("location: ./home/#login"); // Redirect to admin login page
    exit();
} elseif (isset($_SESSION['student_username'])) {
    unset($_SESSION['student_username']);
    session_destroy();
    header("location: ./home/#login"); // Redirect to student login page
    exit();
} elseif (isset($_SESSION['teacher_username'])) {
    unset($_SESSION['teacher_username']);
    session_destroy();
    header("location: ./home/#login"); // Redirect to teacher login page
    exit();
} elseif (isset($_SESSION['fees_username'])) {
    unset($_SESSION['fees_username']);
    session_destroy();
    header("location: ./home/#login"); // Redirect to fees admin login page
    exit();
} else {
    header("location: ../home/"); // Redirect to a default home page if no role is set
    exit();
}
?>