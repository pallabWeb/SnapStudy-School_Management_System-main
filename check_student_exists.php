<?php
include_once 'db.php';

$response = ['exists' => false];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['contactNumber'];

    // Check if the student already exists in AdmissionForm or students table
    $existsQuery = "SELECT 1 FROM AdmissionForm WHERE username='$username' OR parent_email='$email' OR parent_contact='$phone'
                    UNION
                    SELECT 1 FROM students WHERE student_username='$username' OR email='$email' OR phone='$phone'";
    $existsResult = $data->query($existsQuery);

    if ($existsResult->num_rows > 0) {
        $response['exists'] = true;
    }
}

echo json_encode($response);
?>