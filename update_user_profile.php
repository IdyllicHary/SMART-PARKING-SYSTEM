<?php
include 'config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $id_number = mysqli_real_escape_string($conn, $_POST['id_number']);
    $vehicle_model = mysqli_real_escape_string($conn, $_POST['vehicle_type']);
    $vehicle_reg = mysqli_real_escape_string($conn, $_POST['vehicle_reg']);

    $query = "UPDATE users SET 
          name = '$name',
          email = '$email',
          phone = '$phone',
          id_number = '$id_number',
          vehicle_type = '$vehicle_model',
          vehicle_reg = '$vehicle_reg'
          WHERE id = $user_id";

    if (mysqli_query($conn, $query)) {
        $_SESSION['name'] = $name;
        header("Location: user_dashboard.php?success=profile_updated");
        exit();
    }
}
