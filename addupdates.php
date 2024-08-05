<?php
session_start();
error_reporting(0);
if (!isset($_SESSION['admin_username'])) {
    header("location:./home/#login");
}

include_once 'db.php';

if (isset($_POST['add_coursess'])) {

    $t_descs = $_POST['descss'];
    $sql = "INSERT INTO `tblupdates`(`descript`) VALUES ('$t_descs')";
    $result = mysqli_query($data, $sql);
    if ($result) {
        header('location:adminhome.php');
    }
}
?>