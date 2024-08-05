<?php
session_start();
error_reporting(E_ALL);

if (!isset($_SESSION['admin_username'])) {
    header("location: ./home/#login");
}

include_once 'db.php'; // Database Connection

// Function to send email using SendGrid API
function sendEmailUsingSendGrid($recipientEmail, $subject, $message, $sendgridApiKey)
{
    $url = 'https://api.sendgrid.com/v3/mail/send';

    // Email data
    $data = array(
        'personalizations' => array(
            array(
                'to' => array(
                    array(
                        'email' => $recipientEmail
                    )
                ),
                'subject' => $subject
            )
        ),
        'from' => array(
            'email' => 'mondalpallab0600@gmail.com',
            'name' => 'Sunshine Academy'
        ),
        'content' => array(
            array(
                'type' => 'text/html',
                'value' => $message
            )
        )
    );

    $payload = json_encode($data);

    // cURL setup
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $sendgridApiKey
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute cURL request
    $response = curl_exec($ch);

    // Check for errors
    if ($response === false) {
        echo "Error sending email: " . curl_error($ch);
        return false;
    }

    // Close cURL session
    curl_close($ch);

    // Check response status
    $decodedResponse = json_decode($response, true);
    if ($decodedResponse && isset($decodedResponse['status'])) {
        if ($decodedResponse['status'] == '202 Accepted' || $decodedResponse['status'] == '200 OK') {
            return true; // Email sent successfully
        } else {
            // Log the response for debugging
            error_log("Error sending email. Response: " . print_r($decodedResponse, true));
            return false; // Email sending failed
        }
    } else {
        return false;
    }
}

if (!$data) {
    die("Connection error");
}

$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id === null) {
    die("ID parameter is missing in the URL");
}

$result = mysqli_query($data, "SELECT * FROM students WHERE id=$id");

if ($result) {
    while ($res = mysqli_fetch_array($result)) {
        $username = $res['student_username'];
        $name = $res['name'];
        $phone = $res['phone'];
        $email = $res['email'];
        $usertype = "student";
    }
} else {
    die("Query failed: " . mysqli_error($data));
}

if (isset($_POST['update'])) {

    $id = $_POST['id'];
    $username = $_POST['student_username'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashed_password = md5($password); // Hash the password using MD5
    $usertype = "student";

    // File upload handling
    if ($_FILES['image']['name'] != "") {
        $file = $_FILES['image']['name'];
        $dst = "./uploads/" . $file;
        $dst_db = "uploads/" . $file;
    } else {
        // Update user information excluding the image file path
        $result = mysqli_query($data, "UPDATE `students` SET `student_username`='$username', `name`='$name', `phone`='$phone', `email`='$email', `password`='$hashed_password', `usertype`='$usertype' WHERE id=$id ");

        if ($result) {
            // Send email to the student's email address with the password
            $subject = "Account Updated Successfully";
            $message = "            
            <!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        line-height: 1.6;
                        margin: 0;
                        padding: 0;
                        background-color: #f9f9f9;
                    }
                    .container {
                        max-width: 600px;
                        margin: 0 auto;
                        padding: 20px;
                        border: 1px solid #ccc;
                        border-radius: 5px;
                        background-color: #ffffff;
                    }
                    .header {
                        background-color: #525ceb;
                        color: white;
                        padding: 10px 0;
                        text-align: center;
                        border-radius: 5px 5px 0 0;
                    }
                    .content {
                        padding: 20px;
                        text-align: left;
                        color: #333;
                        font-size: 14px;
                    }
                    .footer {
                        text-align: center;
                        margin-top: 20px;
                        color: #666;
                    }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <h2>User Account Updated</h2>
                    </div>
                    <div class='content'>
                    <p>Dear $name,</p>
                    <p>Your Account has been Updated Successfully.</p>
                    <p>Now you can login with your username and password.</p>
                    <p>Here Your Login Details</p>
                    <p>Username: <strong>$username</strong></p>
                    <p>Password: <strong>$password</strong></p>
                    </div>
                    <div class='footer'>
                        <p>This is an automated message. Please do not reply.</p>
                    </div>
                </div>
            </body>
            </html>";



            $sendgridApiKey = 'YOUR_SENDGRID_API_KEY'; // Replace with your SendGrid API key
            sendEmailUsingSendGrid($email, $subject, $message, $sendgridApiKey);

            header("location: admin_viewstudent.php");
        } else {
            echo "Failed to update user information.";
        }
    }
}
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="icon" href="./img/favicon_logoai/favicon-16x16.png" type="image/x-icon">
    <title>Admin | Edit Details</title>
    <!-- Custom CSS -->
    <link href="css/style2.min.css" rel="stylesheet">
</head>

<body>

    <div class="preloader"> <!-- Preloader - style you can find in spinners.css -->
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>

    <!-- Main wrapper - style you can find in pages.scss -->
    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">


        <?php include('components/admintopbar.php'); ?> <!-- Topbar header - style you can find in pages.scss -->


        <?php include('components/adminsidebar.php'); ?> <!-- Left Sidebar - style you can find in sidebar.scss  -->


        <div class="page-wrapper"> <!-- Page wrapper  -->

            <div class="page-breadcrumb"> <!-- Bread crumb and right sidebar toggle -->
                <div class="row">
                    <div class="col-7 align-self-center">
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb m-0 p-0">
                                    <li class="breadcrumb-item"><a href="adminhome.php">Dashboard</a></li>
                                    <li class="breadcrumb-item">Update Details</li>
                                </ol>
                            </nav>
                        </div>
                    </div>

                </div>
            </div>


            <div class="container-fluid"> <!-- Container fluid  -->

                <form class="row g-3" action="#" method="POST" enctype="multipart/form-data">

                    <div class="col-md-6">
                        <label for="username" class="mt-3">Username:</label>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="text" class="form-control" name="student_username" id="username" value="<?php echo $username; ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="name" class="mt-3">Student's name:</label>
                        <input type="text" class="form-control" name="name" id="name" value="<?php echo $name; ?>">
                    </div>
                    <div class="col-6">
                        <label for="phone" class="mt-3">Phone:</label>
                        <input type="tel" class="form-control" name="phone" id="phone" value="<?php echo $phone; ?>">
                    </div>
                    <div class="col-6">
                        <label for="email" class="mt-3">Email:</label>
                        <input type="email" class="form-control" name="email" id="email" value="<?php echo $email; ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="password" class="mt-3">Password:</label>
                        <input type="text" class="form-control" name="password" id="password" value="<?php echo htmlspecialchars($password); ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="image" class="mt-3">Image:</label>
                        <input type="file" class="form-control" name="image" id="image">
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-success mt-3 rounded-3 float-end submit" name="update">Update Student</button>
                    </div>
                </form>

            </div> <!-- End Container fluid  -->

        </div> <!-- End Page wrapper  -->

    </div> <!-- End Wrapper -->


    <!-- All Jquery -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <!-- apps -->
    <script src="js/app-style-switcher.js"></script>
    <script src="js/feather.min.js"></script>
    <script src="js/perfect-scrollbar.jquery.min.js"></script>
    <script src="js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="js/custom.min.js"></script>
</body>

</html>