<?php
include 'config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(isset($_POST['booking_id']) && isset($_POST['current_status'])) {
    $booking_id = mysqli_real_escape_string($conn, $_POST['booking_id']);
    $new_status = ($_POST['current_status'] == 'paid') ? 'not_paid' : 'paid';
    
    $query = "UPDATE bookings SET payment_status = '$new_status' WHERE id = $booking_id";
    
    if(mysqli_query($conn, $query)) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Payment status updated successfully',
            'new_status' => $new_status
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to update payment status'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request parameters'
    ]);
}
?>
