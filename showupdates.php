<?php
session_start();
error_reporting(0);
if (!isset($_SESSION['admin_username'])) {
    header("location: ./home/#login");
}

include_once 'db.php';


$sql = "SELECT * FROM `tblupdates` ";
$result = mysqli_query($data, $sql);
if ($_GET['tbltaskr_id']) {
    $t_id = $_GET['tbltaskr_id'];
    $sql2 = "DELETE FROM `tblupdates` WHERE id='$t_id'";
    $result2 = mysqli_query($data, $sql2);
    if ($result2) {
        header('location:adminhome.php');
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Updates</title>
    <?php
    include 'admin_css.php';
    ?>
    <style>
        .table_th {
            padding: 10px;
            font-size: 20px;
        }

        .table_td {
            padding: 20px;
            background-color: skyblue;
        }
    </style>
</head>

<body>
    <!-- <h1>Admin page
 </h1>
 <a href="logout.php"> logout</a> -->
    <?php
    include 'adminsidebar.php';
    ?>
    <div class="content">
        <center>
            <h1>view All updates</h1>

            <table border="1px">
                <tr>

                    <th class="table_th">Description</th>

                    <th class="table_th">Delete</th>

                </tr>
                <?php
                while ($info = $result->fetch_assoc()) {
                ?>
                    <tr>

                        <td class="table_td"><?php echo "{$info['descript']}";
                                                ?></td>

                        <td class="table_td">
                            <?php

                            echo "
 <a onClick=\" javascript:return confirm('Are you sure to 
delete this!!')\" href='showupdates.php?tbltaskr_id={$info['id']}' class='btn 
btn-danger' > 
 Delete
 </a>";
                            ?>
                        </td>

                    </tr>
                <?php
                }
                ?>
            </table>
        </center>
    </div>
</body>

</html>