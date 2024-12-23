<?php
// Include required files
include 'config.php';
require_once 'email_notifications.php';
require_once 'vendor/autoload.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if(!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
    exit();
}

// Process booking form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize form data
    $user_id = $_SESSION['user_id'];
    $slot_id = mysqli_real_escape_string($conn, $_POST['slot_id']);
    $attendant_id = mysqli_real_escape_string($conn, $_POST['attendant_id']);
    $hours = mysqli_real_escape_string($conn, $_POST['hours']);
    $minutes = mysqli_real_escape_string($conn, $_POST['minutes']);
    
    // Check for available active attendants
    $active_attendants = mysqli_query($conn, "SELECT COUNT(*) as count FROM attendants WHERE status = 'active'");
    $attendant_count = mysqli_fetch_assoc($active_attendants)['count'];
    
    if($attendant_count == 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'No active attendants available'
        ]);
        exit();
    }

    // Verify if selected attendant is active
    $check_attendant = mysqli_query($conn, "SELECT status FROM attendants WHERE id = $attendant_id");
    $attendant_status = mysqli_fetch_assoc($check_attendant)['status'];
    
    if($attendant_status != 'active') {
        echo json_encode([
            'status' => 'error',
            'message' => 'Selected attendant is not active'
        ]);
        exit();
    }

    // Check if slot is already booked
    $check_booking = mysqli_query($conn, "SELECT id FROM bookings WHERE slot_id = $slot_id AND status = 'active'");
    if(mysqli_num_rows($check_booking) > 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Slot is already occupied'
        ]);
        exit();
    }

    // Calculate booking duration and times
    $duration = $hours + ($minutes/60);
    $start_time = date('Y-m-d H:i:s');
    $end_time = date('Y-m-d H:i:s', strtotime("+$hours hours +$minutes minutes"));

    // Get slot and user details
    $slot = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM parking_slots WHERE id = $slot_id"));
    $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = $user_id"));
    $amount = $slot['price'] * $duration;

    // Begin transaction for booking process
    mysqli_begin_transaction($conn);
    
    try {
        // Update slot status to occupied
        $update_slot = "UPDATE parking_slots SET status = 'occupied' WHERE id = $slot_id";
        mysqli_query($conn, $update_slot);
        
        // Create new booking record
        $sql = "INSERT INTO bookings (user_id, slot_id, attendant_id, start_time, end_time, amount, status)
                VALUES ($user_id, $slot_id, $attendant_id, '$start_time', '$end_time', $amount, 'active')";
        mysqli_query($conn, $sql);
        
        // Prepare booking data for email
        $booking_data = [
            'email' => $user['email'],
            'name' => $user['name'],
            'booking_id' => mysqli_insert_id($conn),
            'slot_number' => $slot['slot_number'],
            'start_time' => $start_time,
            'end_time' => $end_time,
            'duration' => $hours,
            'price' => number_format($amount, 2)
        ];

        // Send booking confirmation email
        try {
            $sent = sendEmail('booking', $booking_data);
            error_log("Email status: " . ($sent ? "sent" : "failed"));
        } catch (Exception $e) {
            error_log("Email error: " . $e->getMessage());
        }

        // Commit transaction and return success
        mysqli_commit($conn);
        echo json_encode(['status' => 'success', 'message' => 'Booking successful']);
        
    } catch (Exception $e) {
        // Rollback transaction if any error occurs
        mysqli_rollback($conn);
        error_log("Booking Error: " . $e->getMessage());
        echo json_encode(['status' => 'error', 'message' => 'Booking failed']);
    }
}
?>
