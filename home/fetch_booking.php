<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone_number = $_POST['phone'];

    include_once '../db.php';

    // Check connection
    if ($data->connect_error) {
        die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $data->connect_error]));
    }

    // Query to fetch booking details by phone number
    $sql = "SELECT * FROM booking WHERE phone = '$phone_number'";
    $result = $data->query($sql);

    // Check if any booking found
    if ($result->num_rows > 0) {
        $booking_details = [];
        while ($row = $result->fetch_assoc()) {
            $booking_details[] = $row;
        }
        echo json_encode(['success' => true, 'data' => $booking_details]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No booking found for this phone number.']);
    }
    $data->close();
}
?>