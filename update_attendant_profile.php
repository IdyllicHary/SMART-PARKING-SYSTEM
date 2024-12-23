<?php
include 'config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $attendant_id = $_SESSION['attendant_id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);

    $query = "UPDATE attendants SET 
              name = '$name',
              phone = '$phone'
              WHERE id = $attendant_id";

    if (mysqli_query($conn, $query)) {
        $_SESSION['name'] = $name;
        header("Location: attendant_dashboard.php?success=profile_updated");
        exit();
    }
}
