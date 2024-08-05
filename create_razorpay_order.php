<?php
require 'Razorpay/vendor/autoload.php';
use Razorpay\Api\Api;

$keyId = ''; // Use Only razorpay key
$keySecret = ''; // Use Only razorpay key
$api = new Api($keyId, $keySecret);

$orderData = [
    'receipt'         => 'rcptid_11',
    'amount'          => 499900,
    'currency'        => 'INR',
    'payment_capture' => 1
];

$razorpayOrder = $api->order->create($orderData);

$response = [
    'key' => $keyId,
    'order_id' => $razorpayOrder['id']
];

echo json_encode($response);
?>