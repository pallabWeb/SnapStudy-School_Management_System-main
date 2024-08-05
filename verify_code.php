<?php
// session_start();

// include_once 'db.php'; // Database Connection

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $uniqueCode = $_POST['unique_code'];

//     // Validate the unique code
//     $query = "SELECT * FROM booking WHERE unique_code = '$uniqueCode' AND status = 'Approved'";
//     $result = mysqli_query($data, $query);

//     if (mysqli_num_rows($result) == 1) {
//         // Unique code is valid
//         $_SESSION['valid_code'] = true;
//         $_SESSION['unique_code'] = $uniqueCode;
//         header("Location: ../admission_form.php");
//     } else {
//         // Unique code is invalid
//         echo '<script>alert("Invalid unique code or the code is not approved.");</script>';
//         echo '<script>window.location.href = "./home/";</script>';
//     }
// } else {
//     echo '<script>alert("Invalid request.");</script>';
//     echo '<script>window.location.href = "enter_code.php";</script>';
// }
?>


<?php
// session_start();

// include_once 'db.php'; // Database Connection

// header('Content-Type: application/json');

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $uniqueCode = $_POST['unique_code'];

//     // Validate the unique code
//     $query = "SELECT * FROM booking WHERE unique_code = '$uniqueCode' AND status = 'Approved'";
//     $result = mysqli_query($data, $query);

//     if (mysqli_num_rows($result) == 1) {
//         // Unique code is valid
//         $_SESSION['valid_code'] = true;
//         $_SESSION['unique_code'] = $uniqueCode;
//         echo json_encode(['status' => 'success', 'redirect' => '../admission_form.php']);
//     } else {
//         // Unique code is invalid
//         echo json_encode(['status' => 'error', 'message' => 'Invalid unique code or the code is not approved.']);
//     }
// } else {
//     echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
// }
?>


<?php
session_start();

include_once 'db.php'; // Database Connection

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uniqueCode = $_POST['unique_code'];

    // Check if the unique code has already been used
    $checkQuery = "SELECT * FROM booking WHERE unique_code = '$uniqueCode' AND usage_status = 1";
    $checkResult = mysqli_query($data, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        // Unique code has already been used
        echo json_encode(['status' => 'error', 'message' => 'The unique code has already been used.']);
        exit();
    }

    // Validate the unique code
    $query = "SELECT * FROM booking WHERE unique_code = '$uniqueCode' AND status = 'Approved'";
    $result = mysqli_query($data, $query);

    if (mysqli_num_rows($result) == 1) {
        // Unique code is valid
        $_SESSION['valid_code'] = true;
        $_SESSION['unique_code'] = $uniqueCode;

        // Mark the unique code as used in the database
        $updateQuery = "UPDATE booking SET usage_status = 1 WHERE unique_code = '$uniqueCode'";
        mysqli_query($data, $updateQuery);

        echo json_encode(['status' => 'success', 'redirect' => '../admission_form.php']);
    } else {
        // Unique code is invalid or not approved
        echo json_encode(['status' => 'error', 'message' => 'Invalid unique code or the code is not approved.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}
?>
