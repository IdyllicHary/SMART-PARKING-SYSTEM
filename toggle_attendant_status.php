<?php
include 'config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(!isset($_SESSION['admin_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not authorized']);
    exit();
}

if(isset($_POST['attendant_id'])) {
    $attendant_id = mysqli_real_escape_string($conn, $_POST['attendant_id']);
    $current_status = mysqli_real_escape_string($conn, $_POST['current_status']);
    
    $new_status = ($current_status == 'active') ? 'inactive' : 'active';
    
    $update = mysqli_query($conn, "UPDATE attendants SET status = '$new_status' WHERE id = $attendant_id");
    
    if($update) {
        echo json_encode([
            'status' => 'success',
            'new_status' => $new_status,
            'script' => "showSuccess('Attendant status updated successfully!')"
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'script' => "showError('Failed to update attendant status')"
        ]);
    }
}
?>
