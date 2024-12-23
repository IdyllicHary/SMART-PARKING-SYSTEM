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

if(isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $query = "SELECT * FROM attendants WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    
    if($attendant = mysqli_fetch_assoc($result)) {
        die(json_encode($attendant));
    }
}

die(json_encode(['error' => 'Not found']));
?>
