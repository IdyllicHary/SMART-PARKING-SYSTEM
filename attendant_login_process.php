<?php
include 'config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM attendants WHERE email = '$email' AND status = 'active'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) == 1) {
        $attendant = mysqli_fetch_assoc($result);
        if (password_verify($password, $attendant['password'])) {
            $_SESSION['attendant_id'] = $attendant['id'];
            $_SESSION['name'] = $attendant['name'];
            header("Location: attendant_dashboard.php?success=login");
            exit();
        } else {
            header("Location: attendant_login.php?error=invalid_password");
            exit();
        }
        } else {
            header("Location: attendant_login.php?error=user_not_found");
            exit();
        }        

}
?>