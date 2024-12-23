<?php
include 'config.php';
include 'lipia_config.php';

if(isset($_GET['booking_id'])) {
    $booking_id = mysqli_real_escape_string($conn, $_GET['booking_id']);
    
    // Get the latest reference for this booking
    $query = "SELECT reference FROM payment_logs 
              WHERE booking_id = $booking_id 
              ORDER BY created_at DESC LIMIT 1";
    $result = mysqli_query($conn, $query);
    $payment = mysqli_fetch_assoc($result);
    
    if($payment) {
        // Check status from Lipia API
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://lipia-api.kreativelabske.com/api/transaction/status/" . $payment['reference'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer 6cca150aa8b3eac5ee0a0f8d425e72e0659fffdb"
            ]
        ]);
        
        $response = curl_exec($curl);
        curl_close($curl);
        
        $transaction = json_decode($response, true);
        if(isset($transaction['status']) && $transaction['status'] === 'completed') {
            // Update booking status to paid
            mysqli_query($conn, "UPDATE bookings SET payment_status = 'paid' WHERE id = $booking_id");
            echo json_encode(['status' => 'paid']);
            exit;
        }
    }
    echo json_encode(['status' => 'pending']);
}
?>
