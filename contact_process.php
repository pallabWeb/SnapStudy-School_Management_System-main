<?php
session_start();

include_once 'db.php'; // Database Connection

// Function to send email to user using cURL and SendGrid API
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
        'subject' => 'Confirmation: Your Message Received',
        'content' => array(
            array(
                'type' => 'text/plain',
                'value' => "Dear $name,\n\nWe've received your message. Thank you for reaching out!\n\nOur team will review your message and get back to you as soon as possible.\n\nIf you have any urgent inquiries, please contact us directly.\n\nThank you,\nSunshine Academy"
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
        echo "<script>alert('Error sending email: " . curl_error($ch) . "');</script>";
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

            // Display error message only if status indicates failure
            if (isset($decodedResponse['errors'])) {
                echo "<script>alert('Error sending email: " . print_r($decodedResponse['errors'], true) . "');</script>";
            } else {
                echo "<script>alert('Error sending email: Unexpected response from SendGrid API');</script>";
            }
            return false; // Email sending failed
        }
    } else {
        echo "<script>alert('We Received Your Message. Thank you for reaching out!');</script>";
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['subject']) && isset($_POST['message'])) {

        $name = $_POST['name'];
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];

        // Use prepared statement to prevent SQL injection
        $sql = "INSERT INTO messages (name, email, subject, message) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($data, $sql);
        mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $subject, $message);

        if (mysqli_stmt_execute($stmt)) {
            // SendGrid API key
            $sendgridApiKey = 'YOUR_SENDGRID_API_KEY';

            // Send email using SendGrid API
            if (sendEmailUsingCurl($email, $name, $message, $sendgridApiKey)) {
                echo "<script>alert('Message sent successfully!');</script>"; 
                exit;
            } else {

            }
        } else {
            echo "<script>alert('Error executing SQL statement: " . mysqli_error($data) . "');</script>"; 
        }
    } else {
        echo "<script>alert('All form fields are required!');</script>";
    }
} else {
    echo "<script>alert('Invalid request!');</script>";
}
?>