<?php
include 'config.php';
require_once 'email_notifications.php';
require_once 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $id_number = mysqli_real_escape_string($conn, $_POST['id_number']);
    $vehicle_reg = mysqli_real_escape_string($conn, $_POST['vehicle_reg']);
    $vehicle_type = mysqli_real_escape_string($conn, $_POST['vehicle_type']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        header("Location: register.php?error=passwords_dont_match");
        exit();
    }

    // check if email already exists
    $check_email = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
    if (mysqli_num_rows($check_email) > 0) {
        header("Location: register.php?error=email_exists");
        exit();
    }

    // Phone number validation - must be 10 digits
    if (strlen($_POST['phone']) !== 10 || !is_numeric($_POST['phone'])) {
        header("Location: register.php?error=invalid_phone");
        exit();
    }

    // ID number validation - must be 8 digits
    if (strlen($_POST['id_number']) !== 8 || !is_numeric($_POST['id_number'])) {
        header("Location: register.php?error=invalid_id");
        exit();
    }

    //hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert user data into database
    $sql = "INSERT INTO users (name, email, phone, id_number, vehicle_reg, vehicle_type, password) 
            VALUES ('$name', '$email', '$phone', '$id_number', '$vehicle_reg', '$vehicle_type', '$hashed_password')";

    if (mysqli_query($conn, $sql)) {
    // Prepare user data for email
    $user_data = [
        'email' => $email,
        'name' => $name,
        'phone' => $phone,
        'id_number' => $id_number,
        'vehicle_type' => $vehicle_type,
        'vehicle_reg' => $vehicle_reg,
    ];
    
    // Send welcome email
    sendEmail('registration', $user_data);

        header("Location: user_login.php?success=registration");
        exit();
    } else {
        header("Location: register.php?error=registration_failed");
        exit();
    }
}
?>