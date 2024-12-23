<?php
include 'config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not authorized']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
   
    switch ($_POST['action']) {
        case 'add':
            $vehicle_reg = mysqli_real_escape_string($conn, $_POST['vehicle_reg']);
            $vehicle_type = mysqli_real_escape_string($conn, $_POST['vehicle_type']);
            
            // Check if vehicle registration already exists
            $check_query = "SELECT * FROM vehicles WHERE vehicle_reg = '$vehicle_reg'";
            $check_result = mysqli_query($conn, $check_query);
            
            if (mysqli_num_rows($check_result) > 0) {
                echo json_encode(['status' => 'error', 'message' => 'Vehicle registration number already exists']);
                exit();
            }
            
            // Insert new vehicle
            $sql = "INSERT INTO vehicles (user_id, vehicle_reg, vehicle_type) 
                    VALUES ($user_id, '$vehicle_reg', '$vehicle_type')";
            
            if (mysqli_query($conn, $sql)) {
                echo json_encode(['success' => true]);
            } else {
                http_response_code(400);
                echo json_encode(['error' => mysqli_error($conn)]);
            }
            break;

        case 'edit':
            $old_reg = mysqli_real_escape_string($conn, $_POST['old_reg']);
            $new_reg = mysqli_real_escape_string($conn, $_POST['new_reg']);
            $new_type = mysqli_real_escape_string($conn, $_POST['new_type']);
            
            $sql = "UPDATE users SET 
                    vehicle_reg = '$new_reg',
                    vehicle_type = '$new_type'
                    WHERE id = $user_id AND vehicle_reg = '$old_reg'";
            
            if (mysqli_query($conn, $sql)) {
                $update_bookings = "UPDATE bookings SET 
                                  vehicle_reg = '$new_reg'
                                  WHERE user_id = $user_id 
                                  AND vehicle_reg = '$old_reg'";
                mysqli_query($conn, $update_bookings);
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => mysqli_error($conn)]);
            }
            break;
            
        case 'delete':
            $vehicle_reg = mysqli_real_escape_string($conn, $_POST['vehicle_reg']);
            
            $check_bookings = mysqli_query($conn, "SELECT id FROM bookings 
                                                 WHERE vehicle_reg = '$vehicle_reg'
                                                 AND user_id = $user_id 
                                                 AND status = 'active'");
            
            if (mysqli_num_rows($check_bookings) > 0) {
                echo json_encode(['status' => 'error', 'message' => 'Cannot delete vehicle with active bookings']);
                exit();
            }
            
            $sql = "UPDATE users SET 
                    vehicle_reg = NULL,
                    vehicle_type = NULL
                    WHERE id = $user_id AND vehicle_reg = '$vehicle_reg'";
            
            if (mysqli_query($conn, $sql)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => mysqli_error($conn)]);
            }
            break;
    }
}
?>
