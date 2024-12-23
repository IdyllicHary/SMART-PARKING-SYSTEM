<?php
include 'config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(!isset($_SESSION['attendant_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $booking_id = mysqli_real_escape_string($conn, $_POST['booking_id']);
    
    // Update booking status
    $sql = "UPDATE bookings SET status = 'completed' WHERE id = $booking_id";
    
    // Update slot status
    $slot_query = mysqli_query($conn, "SELECT slot_id FROM bookings WHERE id = $booking_id");
    $slot = mysqli_fetch_assoc($slot_query);
    mysqli_query($conn, "UPDATE parking_slots SET status = 'available' WHERE id = ".$slot['slot_id']);
    
    if(mysqli_query($conn, $sql)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error']);
    }
    
    $booking_details = [
        'email' => $user['email'],
        'name' => $user['name'],
        'slot_number' => $slot['slot_number'],
        'actual_duration' => $duration,
        'total_amount' => $total_cost
    ];
    sendParkingEmail($booking_details, 'completed');
        
}
?>
