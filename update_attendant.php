<?php
include 'config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $attendant_id = mysqli_real_escape_string($conn, $_POST['attendant_id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $id_number = mysqli_real_escape_string($conn, $_POST['id_number']);
    
    $query = "UPDATE attendants SET 
              name = '$name',
              email = '$email',
              phone = '$phone',
              id_number = '$id_number'
              WHERE id = '$attendant_id'";
              
    if(mysqli_query($conn, $query)) {
        die(json_encode(['success' => true]));
    } else {
        die(json_encode(['error' => mysqli_error($conn)]));
    }
}

die(json_encode(['error' => 'Invalid request']));
?>
