<?php
include 'config.php';
require_once 'email_notifications.php';
require_once 'vendor/autoload.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    // Check if email exists
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        // Generate unique token
        $token = bin2hex(random_bytes(32));
        date_default_timezone_set('Africa/Nairobi');
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
        // Store token in database
        $sql = "INSERT INTO password_resets (email, token, expiry) VALUES ('$email', '$token', '$expiry')";
        mysqli_query($conn, $sql);
        
        header("Location: forgot_password.php?success=email_sent");
    } else {
        header("Location: forgot_password.php?error=email_not_found");
    }

        // Prepare email data
        $reset_data = [
            'email' => $email,
            'name' => $user['name'],
            'reset_link' => "http://127.0.0.1/Smart_Parking/reset_password.php?token=" . $token
        ];

        // Send email using the email notification system
        sendEmail('password_reset', $reset_data);
        
        header("Location: forgot_password.php?success=email_sent");
    } else {
        header("Location: forgot_password.php?error=email_not_found");
    }
?>
