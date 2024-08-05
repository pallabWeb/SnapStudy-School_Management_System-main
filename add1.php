<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
  header("location:./home/#login");
}

include_once 'db.php';  // Database Connection

// Include the function to send email using SendGrid API
function sendEmailUsingSendGrid($recipientEmail, $subject, $message, $sendgridApiKey)
{
  // SendGrid API endpoint
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

  // Convert email data to JSON format
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

if (isset($_POST['id'])) {
  $admissionId = $_POST['id'];

  // Mark the admission form as added
  $updateSql = "UPDATE `admissionform` SET `added` = 1 WHERE id = $admissionId";
  $updateResult = mysqli_query($data, $updateSql);

  if ($updateResult) {
    // Fetch data from the admissionform table
    $sql = "SELECT * FROM `admissionform` WHERE id='$admissionId'";
    $result = mysqli_query($data, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);

      // Insert data into the students table
      $studentUsername = $row['username'];
      $password = $row['password'];
      $class = $row['class'];
      $email = $row['parent_email'];
      $phone = $row['parent_contact'];
      $imagePath = 'uploads/' . basename($row['picture']); // Specify the image path format

      $insertSql = "INSERT INTO `students` (`student_username`, `name`, `phone`, `class`, `email`, `image`, `usertype`, `password`)
                          VALUES ('$studentUsername', '{$row['name']}', '$phone', '$class', '$email', '$imagePath', 'student', '$password')";

      $insertResult = mysqli_query($data, $insertSql);

      if ($insertResult) {
        // Send email to the student
        $subject = "Enrollment Approval at Sunshine Academy";
        $message = "
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Enrollment Approval</title>
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
                    <p>Dear {$row['name']},</p>
                    <p>Congratulations! Your enrollment at Sunshine Academy has been approved.</p>
                    <p>You will receive your username and password via email shortly.</p>
                    <p>Thank you,<br>Sunshine Academy</p>
                </div>
                <div class='footer'>
                    <p>This is an automated message. Please do not reply.</p>
                </div>
            </div>
        </body>
        </html>";

        $sendgridApiKey = YOUR_SENDGRID_API_KEY; // Replace with your SendGrid API key
        $emailSent = sendEmailUsingSendGrid($email, $subject, $message, $sendgridApiKey);

        if ($emailSent) {
          echo 'success';
        } else {
          // Email sending failed
          echo 'error';
        }
      } else {
        // Student insertion failed
        echo 'error';
      }
    } else {
      // No data found for the provided admission ID
      echo 'error';
    }
  } else {
    // Failed to update the admission form status
    echo 'error';
  }
} else {
  // No admission ID provided
  echo 'error';
}
