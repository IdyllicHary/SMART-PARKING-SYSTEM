<?php
include 'config.php';
require_once 'email_notifications.php';
require_once 'vendor/autoload.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit();
}

if(isset($_POST['booking_id'])) {
    $booking_id = mysqli_real_escape_string($conn, $_POST['booking_id']);
    
    // Get booking details before cancellation
    $booking_query = "SELECT b.*, p.slot_number, u.name, u.email 
                     FROM bookings b 
                     JOIN parking_slots p ON b.slot_id = p.id 
                     JOIN users u ON b.user_id = u.id 
                     WHERE b.id = '$booking_id'";
    
    $booking_result = mysqli_query($conn, $booking_query);
    $booking_data = mysqli_fetch_assoc($booking_result);
    
    // Update booking status
    $update_booking = mysqli_query($conn, "UPDATE bookings SET status = 'cancelled' WHERE id = $booking_id");
    
    // Update slot status to available
    $update_slot = mysqli_query($conn, "UPDATE parking_slots SET status = 'available' WHERE id = ".$booking_data['slot_id']);
    
    if($update_booking && $update_slot) {
        // Prepare email data
        $email_data = [
            'email' => $booking_data['email'],
            'name' => $booking_data['name'],
            'booking_id' => $booking_id,
            'slot_number' => $booking_data['slot_number'],
            'start_time' => $booking_data['start_time'],
            'amount' => $booking_data['amount']
        ];

        // Send cancellation email
        sendEmail('booking_cancelled', $email_data);

        echo json_encode(['status' => 'success', 'message' => 'Booking cancelled successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to cancel booking']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid booking']);
}
?>
