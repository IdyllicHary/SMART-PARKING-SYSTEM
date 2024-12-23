<?php
include 'config.php';

// Get the timeout notification
$timeout_data = file_get_contents('php://input');

// Log the timeout data
file_put_contents('mpesa_timeout_log.txt', date('Y-m-d H:i:s') . ": " . $timeout_data . "\n", FILE_APPEND);

// Send response back to M-Pesa
$response = array(
    'ResultCode' => 0,
    'ResultDesc' => 'Timeout notification received'
);

header('Content-Type: application/json');
echo json_encode($response);
?>
