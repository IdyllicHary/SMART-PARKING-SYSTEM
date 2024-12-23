<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = mysqli_real_escape_string($conn, $_POST['token']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    if ($password !== $confirm_password) {
        header("Location: reset_password.php?token=$token&error=passwords_dont_match");
        exit();
    }
    
    // Enhanced token verification query
    $query = "SELECT * FROM password_resets 
              WHERE token = '$token' 
              AND expiry > NOW() 
              AND used = 0 
              ORDER BY created_at DESC 
              LIMIT 1";
              
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $email = $row['email'];
        
        // Update password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $update_sql = "UPDATE users SET password = '$hashed_password' WHERE email = '$email'";
        mysqli_query($conn, $update_sql);
        
        // Mark token as used
        mysqli_query($conn, "UPDATE password_resets SET used = 1 WHERE token = '$token'");
        
        header("Location: login.php?success=password_updated");
        exit();
    } else {
        header("Location: forgot_password.php?error=invalid_token");
        exit();
    }
}
