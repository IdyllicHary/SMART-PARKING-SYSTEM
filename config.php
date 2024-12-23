<?php
date_default_timezone_set('Africa/Nairobi');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$host = "localhost";
$username = "root";
$password = "";
$database = "smart_parking";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Email configuration constants
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_USERNAME', 'hillarymalova1@gmail.com');
define('SMTP_PASSWORD', 'qisy avsq rlxl buin');
define('SMTP_PORT', 587);

?>
