<?php
session_start();

include_once 'db.php';  // Database Connection

// Function to send email to user using cURL and SendGrid API
function sendEmailUsingCurl($email, $name, $message, $sendgridApiKey)
{
    $url = 'https://api.sendgrid.com/v3/mail/send';

    // Read the HTML template
    $htmlContent = file_get_contents('email_booking.html');
    $htmlContent = str_replace('{{name}}', $name, $htmlContent);

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
        'subject' => 'Confirmation: Your Seat Booking Request Received',
        'content' => array(
            array(
                'type' => 'text/html',
                'value' => $htmlContent
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
        echo "Error sending email: " . curl_error($ch);
        return false;
    }

    // Close cURL session
    curl_close($ch);

    // Check response status
    $decodedResponse = json_decode($response, true);
    if ($decodedResponse && isset($decodedResponse['status']) && $decodedResponse['status'] == '202 Accepted') {
        return true; // Email sent successfully
    } else {
        echo "Error sending email: " . $response;
        return false; // Email sending failed
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['class']) && isset($_POST['message'])) {

        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $class = $_POST['class'];
        $message = $_POST['message'];

        // Check if email or phone already exists
        $check_query = "SELECT * FROM booking WHERE email='$email' OR phone='$phone'";
        $check_result = mysqli_query($data, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            echo "error"; // Send error signal if student with this email or phone already exists
            exit; // Exit script if error occurs
        } else {
            // Use prepared statement to prevent SQL injection
            $sql = "INSERT INTO booking (`name`, `email`, `phone`, `class`, `message`) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($data, $sql);
            mysqli_stmt_bind_param($stmt, "sssss", $name, $email, $phone, $class, $message);

            if (mysqli_stmt_execute($stmt)) {
                // SendGrid API key
                $sendgridApiKey = 'YOUR_SENDGRID_API_KEY';

                // Send email using SendGrid API
                if (sendEmailUsingCurl($email, $name, $message, $sendgridApiKey)) {
                    echo "success"; // Send success signal if student added successfully
                    exit; // Exit script after sending success signal
                } else {
                    echo "Error sending email";
                }
            } else {
                echo "Error executing SQL statement: " . mysqli_error($data);
            }
        }
    } else {
        echo "All form fields are required!";
    }
} else {
    echo "Invalid request!";
}
