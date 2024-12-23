<?php
include 'config.php';
include 'mpesa_config.php';

$callbackData = file_get_contents('php://input');
$data = json_decode($callbackData);

if($data->Body->stkCallback->ResultCode == 0) {
    $remarks = $data->Body->stkCallback->Remarks;
    preg_match('/Booking#(\d+)/', $remarks, $matches);
    $booking_id = $matches[1];
    
    $query = "UPDATE bookings SET payment_status = 'paid' WHERE id = $booking_id";
    mysqli_query($conn, $query);
    
    // Log successful payment
    $log_query = "INSERT INTO payment_logs (booking_id, transaction_id, amount) 
                  VALUES ($booking_id, '".$data->Body->stkCallback->CheckoutRequestID."', 
                  ".$data->Body->stkCallback->Amount.")";
    mysqli_query($conn, $log_query);
}

// Return response to M-Pesa
header('Content-Type: application/json');
echo json_encode(['ResultCode' => 0, 'ResultDesc' => 'Success']);
?>
