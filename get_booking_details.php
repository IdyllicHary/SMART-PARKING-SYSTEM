<?php
include 'config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(!isset($_SESSION['attendant_id'])) {
    echo json_encode(['error' => 'Not authorized']);
    exit();
}

if(isset($_POST['booking_id'])) {
    $booking_id = mysqli_real_escape_string($conn, $_POST['booking_id']);
    
    $query = "SELECT id, amount, status, payment_status 
              FROM bookings 
              WHERE id = $booking_id";
              
    $result = mysqli_query($conn, $query);
    
    if($booking = mysqli_fetch_assoc($result)) {
        echo json_encode($booking);
    } else {
        echo json_encode(['error' => 'Booking not found']);
    }
}
?>
