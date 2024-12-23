<?php
header('Content-Type: application/json');

ob_clean();

include 'config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'not_authorized']);
    exit();
}

try {
    $user_id = $_SESSION['user_id'];
    $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = $user_id"));
    $password = $_POST['confirm_password'];

    if (password_verify($password, $user['password'])) {
        // First delete related vehicles
        mysqli_query($conn, "DELETE FROM vehicles WHERE user_id = $user_id");
        
        // Then delete the user
        $delete_result = mysqli_query($conn, "DELETE FROM users WHERE id = $user_id");
        
        if ($delete_result) {
            include 'email_notifications.php';
            $user_data = [
                'name' => $user['name'],
                'email' => $user['email'],
            ];
            sendEmail('account_deletion', $user_data);
            session_destroy();
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'deletion_failed']);
        }
    } else {
        echo json_encode(['error' => 'wrong_password']);
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
exit();
