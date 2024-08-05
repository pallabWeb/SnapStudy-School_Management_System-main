<?php

session_start();

include_once 'db.php';  // Database Connection


if(isset($_POST['apply']))
{
    $dataname=$_POST['name'];
    $dataemail=$_POST['email'];
    $dataphone=$_POST['phone'];
    $datamessage=$_POST['message'];


    $sql="INSERT INTO `booking`( `name`, `email`, `phone`, `message`) VALUES ('$dataname','$dataemail','$dataphone','$datamessage')";

    $result=mysqli_query($data,$sql);

    if($result)
    {
        $_SESSION['message']="Your Application Sent Successfully";

        header("location:Add.php");
    }
    else{
        echo"Apply failed";
    }
}
?>