<?php
include 'config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Add error logging
    error_log("Admin login attempt for email: " . $email);

    $query = "SELECT * FROM admin WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) == 1) {
        $admin = mysqli_fetch_assoc($result);
        if(password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['name'];
            $_SESSION['user_type'] = 'admin';
            
            error_log("Admin login successful for: " . $email);
            header("Location: admin_dashboard.php?success=login");
            exit();
        } else {
            error_log("Invalid password for admin: " . $email);
            header("Location: admin_login.php?error=invalid_password");
            exit();
        }
    } else {
        error_log("Admin not found: " . $email);
        header("Location: admin_login.php?error=admin_not_found");
        exit();
    }
}
?>
