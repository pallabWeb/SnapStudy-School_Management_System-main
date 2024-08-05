<?php

session_start();

include_once 'db.php';  // Database Connection

if($_GET['student_id'])
{
    $user_id=$_GET['student_id'];

    $sql="DELETE FROM `students` WHERE id=' $user_id' ";

    $result=mysqli_query($data,$sql);

    if($result)
    {  
        $_SESSION['message']='Student deletion is successfull';
        header("location:admin_viewstudent.php");
    }
}
?>