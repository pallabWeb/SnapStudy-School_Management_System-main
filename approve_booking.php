<?php
// session_start();

// if (!isset($_SESSION['admin_username'])) {
//     header("location: ./home/#login");
// }

// include_once 'db.php';  // Database Connection

// // Function to send email using SendGrid API
// function sendEmailUsingCurl($email, $name, $message, $sendgridApiKey)
// {
//     $url = 'https://api.sendgrid.com/v3/mail/send';

//     // Email data
//     $data = array(
//         'personalizations' => array(
//             array(
//                 'to' => array(
//                     array(
//                         'email' => $email,
//                         'name' => $name
//                     )
//                 )
//             )
//         ),
//         'from' => array(
//             'email' => 'mondalpallab0600@gmail.com', // Sender Email
//             'name' => 'Sunshine Academy' // Sender Name
//         ),
//         'subject' => 'Booking Approved',
//         'content' => array(
//             array(
//                 'type' => 'text/html',
//                 'value' => $message
//             )
//         )
//     );

//     // Encode data to JSON
//     $payload = json_encode($data);

//     // cURL setup
//     $ch = curl_init($url);
//     curl_setopt($ch, CURLOPT_POST, true);
//     curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
//     curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//         'Content-Type: application/json',
//         'Authorization: Bearer ' . $sendgridApiKey
//     ));
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//     // Execute cURL request
//     $response = curl_exec($ch);

//     // Check for errors
//     if ($response === false) {
//         echo '<script>alert("Error sending email: ' . curl_error($ch) . '");</script>';
//         return false;
//     }

//     // Close cURL session
//     curl_close($ch);

//     // Check response status
//     $decodedResponse = json_decode($response, true);
//     if ($decodedResponse && isset($decodedResponse['errors'])) {
//         $errorMessage = $decodedResponse['errors'][0]['message'];
//         echo '<script>alert("Error sending email: ' . $errorMessage . '");</script>';
//         return false; // Email sending failed
//     } else {
//         return true; // Email sent successfully
//     }
// }

// if (isset($_GET['id'])) {
//     $id = $_GET['id'];

//     // Update the database to mark the booking as approved
//     $updateQuery = "UPDATE booking SET status='Approved' WHERE id=$id";
//     if (mysqli_query($data, $updateQuery)) {
//         // Retrieve user's email from the database
//         $getEmailQuery = "SELECT email FROM booking WHERE id=$id";
//         $result = mysqli_query($data, $getEmailQuery);
//         $row = mysqli_fetch_assoc($result);
//         $userEmail = $row['email'];

//         // Email sending functionality using SendGrid API
//         $sendgridApiKey = 'YOUR_SENDGRID_API_KEY'; // Replace with your SendGrid API key
//         $to = $userEmail;
//         $message = "
//         <!DOCTYPE html>
//         <html lang='en'>
//         <head>
//             <meta charset='UTF-8'>
//             <meta name='viewport' content='width=device-width, initial-scale=1.0'>
//             <title>Enrollment Approval</title>
//             <style>
//                 body {
//                     font-family: Arial, sans-serif;
//                     line-height: 1.6;
//                     margin: 0;
//                     padding: 0;
//                     background-color: #f9f9f9;
//                 }
//                 .container {
//                     max-width: 600px;
//                     margin: 0 auto;
//                     padding: 20px;
//                     border: 1px solid #ccc;
//                     border-radius: 5px;
//                     background-color: #ffffff;
//                 }
//                 .header {
//                     background-color: #525ceb;
//                     color: white;
//                     padding: 10px 0;
//                     text-align: center;
//                     border-radius: 5px 5px 0 0;
//                 }
//                 .content {
//                     padding: 20px;
//                 }
//                 .footer {
//                     text-align: center;
//                     margin-top: 20px;
//                     color: #666;
//                 }
//             </style>
//         </head>
//         <body>
//             <div class='container'>
//                 <div class='header'>
//                     <h2>Enrollment Approval</h2>
//                 </div>
//                 <div class='content'>
//                 <p>Your booking has been approved.</p>
//                 <p>Thank you for booking with Sunshine Academy.</p>
//                 <p>Now you can Apply for Admission. click here <a href='https://sunshineproject.000webhostapp.com/home/admission.php'>Apply for Admission</a>.</p>
//                 <p>Your Unique Code: <h2>98567</h2></p>
//                 <p>Use this code to apply for Admission.</p>
//                 </div>
//                 <div class='footer'>
//                     <p>This is an automated message. Please do not reply.</p>
//                 </div>
//             </div>
//         </body>
//         </html>";


//         // Send email using SendGrid API
//         if (sendEmailUsingCurl($to, '', $message, $sendgridApiKey)) {
//             echo '<script>alert("Booking approved successfully! Email sent to user.");</script>';
//             echo '<script>window.location.href = "booking_view.php";</script>';
//         } else {
//             echo '<script>alert("Booking approved successfully! Failed to send email to user.");</script>';
//             echo '<script>window.location.href = "booking_view.php";</script>';
//         }
//     } else {
//         echo '<script>alert("Failed to approve booking!");</script>';
//         echo '<script>window.location.href = "booking_view.php";</script>';
//     }
// } else {
//     echo '<script>alert("Invalid booking ID!");</script>';
//     echo '<script>window.location.href = "booking_view.php";</script>';
// }
?>



<?php
session_start();

if (!isset($_SESSION['admin_username'])) {
    header("location: ./home/#login");
}

include_once 'db.php';  // Database Connection

// Function to send email using SendGrid API
function sendEmailUsingCurl($email, $name, $message, $sendgridApiKey)
{
    $url = 'https://api.sendgrid.com/v3/mail/send';

    // Email data
    $data = array(
        'personalizations' => array(
            array(
                'to' => array(
                    array(
                        'email' => $email,
                        'name' => $name
                    )
                )
            )
        ),
        'from' => array(
            'email' => 'mondalpallab0600@gmail.com', // Sender Email
            'name' => 'Sunshine Academy' // Sender Name
        ),
        'subject' => 'Booking Approved',
        'content' => array(
            array(
                'type' => 'text/html',
                'value' => $message
            )
        )
    );

    // Encode data to JSON
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
        echo '<script>alert("Error sending email: ' . curl_error($ch) . '");</script>';
        return false;
    }

    // Close cURL session
    curl_close($ch);

    // Check response status
    $decodedResponse = json_decode($response, true);
    if ($decodedResponse && isset($decodedResponse['errors'])) {
        $errorMessage = $decodedResponse['errors'][0]['message'];
        echo '<script>alert("Error sending email: ' . $errorMessage . '");</script>';
        return false; // Email sending failed
    } else {
        return true; // Email sent successfully
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Generate a unique code
    $uniqueCode = bin2hex(random_bytes(4)); // Generates a random 8-character hexadecimal string

    // Update the database to mark the booking as approved and store the unique code
    $updateQuery = "UPDATE booking SET status='Approved', unique_code='$uniqueCode' WHERE id=$id";
    if (mysqli_query($data, $updateQuery)) {
        // Retrieve user's email and name from the database
        $getEmailQuery = "SELECT email, name FROM booking WHERE id=$id";
        $result = mysqli_query($data, $getEmailQuery);
        $row = mysqli_fetch_assoc($result);
        $userEmail = $row['email'];
        $userName = $row['name'];

        // Email sending functionality using SendGrid API
        $sendgridApiKey = 'YOUR_SENDGRID_API_KEY';
        $to = $userEmail;
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
                    <h2>Enrollment Approval</h2>
                </div>
                <div class='content'>
                <p>Dear $userName,</p>
                <p>Your booking has been approved.</p>
                <p>Thank you for booking with Sunshine Academy.</p>
                <p>Now you can apply for admission. Click here <a href='http://localhost/SnapStudy/home/#codeForm'>Admission Form</a>.</p>
                <p>Your Unique Code: <h2>$uniqueCode</h2></p>
                <p>This code is valid only one time.</p>
                </div>
                <div class='footer'>
                    <p>This is an automated message. Please do not reply.</p>
                </div>
            </div>
        </body>
        </html>";

        // Send email using SendGrid API
        if (sendEmailUsingCurl($to, $userName, $message, $sendgridApiKey)) {
            echo '<script>alert("Booking approved successfully! Email sent to user.");</script>';
            echo '<script>window.location.href = "booking_view.php";</script>';
        } else {
            echo '<script>alert("Booking approved successfully! Failed to send email to user.");</script>';
            echo '<script>window.location.href = "booking_view.php";</script>';
        }
    } else {
        echo '<script>alert("Failed to approve booking!");</script>';
        echo '<script>window.location.href = "booking_view.php";</script>';
    }
} else {
    echo '<script>alert("Invalid booking ID!");</script>';
    echo '<script>window.location.href = "booking_view.php";</script>';
}
?>