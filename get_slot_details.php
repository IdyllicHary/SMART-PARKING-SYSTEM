<?php
include 'config.php';

if(isset($_POST['slot_id'])) {
    $slot_id = mysqli_real_escape_string($conn, $_POST['slot_id']);
    $slot = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM parking_slots WHERE id = $slot_id"));
    echo json_encode($slot);
}
?>
