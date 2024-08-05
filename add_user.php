<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database credentials
    include_once 'db.php';

    // Check connection
    if ($data->connect_error) {
        die("Connection failed: " . $data->connect_error);
    }

    // Get form input
    $name = $_POST['name'];
    $user_name = $_POST['fees_username'];
    $user_password = $_POST['password'];
    $usertype = "fees";

    // Encrypt the password using MD5
    $encrypted_password = md5($user_password);

    // Prepare the SQL statement
    $sql = "INSERT INTO fees_admin (name, fees_username, password, usertype) VALUES (?, ?, ?, ?)";

    // Initialize prepared statement
    $stmt = $data->prepare($sql);

    if ($stmt) {
        // Bind parameters
        $stmt->bind_param("ssss", $name, $user_name, $encrypted_password, $usertype);

        // Execute the statement
        if ($stmt->execute()) {
            echo "<p style='color:green;'>Fees admin added successfully!</p>";
        } else {
            echo "<p style='color:red;'>Error: " . $stmt->error . "</p>";
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "<p style='color:red;'>Error preparing statement: " . $data->error . "</p>";
    }

    // Close the connection
    $data->close();
} else {
    echo "<p style='color:red;'>Invalid request method.</p>";
}
?>
