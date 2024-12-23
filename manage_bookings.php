<?php
include 'config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Handle booking cancellation
if(isset($_POST['cancel_booking'])) {
    $booking_id = mysqli_real_escape_string($conn, $_POST['cancel_booking']);
    
    // Get the slot_id before updating the booking status
    $slot_query = mysqli_query($conn, "SELECT slot_id FROM bookings WHERE id = $booking_id");
    $slot = mysqli_fetch_assoc($slot_query);
    
    // Update booking status to cancelled
    $update_booking = mysqli_query($conn, "UPDATE bookings SET status = 'cancelled' WHERE id = $booking_id");
    
    // Update slot status to available
    $update_slot = mysqli_query($conn, "UPDATE parking_slots SET status = 'available' WHERE id = ".$slot['slot_id']);
    
    // Add debugging output
    echo "<script>
        if(" . ($update_booking && $update_slot ? 'true' : 'false') . ") {
            showSuccess('Booking cancelled successfully');
        } else {
            showError('Error updating status: " . mysqli_error($conn) . "');
        }
    </script>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings - Smart Parking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4/bootstrap-4.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
 
    <style>
        body {
            background-image: url('assets/images/parking-bg.jpeg');
            background-size: cover;
            min-height: 100vh;
        }
        .dashboard-container {
            background: rgba(255,255,255,0.95);
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }
        .nav-link.text-danger {
            color: #fff !important;
            background-color: #dc3545;
            padding: 8px 15px !important;
            border-radius: 5px;
            margin-left: 10px;
            transition: background-color 0.3s ease;
        }

        .nav-link.text-danger:hover {
            background-color: #c82333;
            color: #fff !important;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg" style="background-color: #3498db;">>
        <div class="container">
            <a class="navbar-brand text-white" href="admin_dashboard.php">
                <i class="fas fa-user-shield"></i> Admin Dashboard
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="admin_dashboard.php">
                            <i class="fas fa-home"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="manage_users.php">
                            <i class="fas fa-users"></i>Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="manage_attendants.php">
                            <i class="fas fa-user-tie"></i>Attendants</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="manage_slots.php">
                            <i class="fas fa-parking"></i>Parking Slots
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="manage_bookings.php">
                            <i class="fas fa-ticket-alt"></i> Bookings
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="logout.php">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="dashboard-container">
            <h2>Manage Bookings</h2>
            
            <div class="table-responsive mt-4">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Slot</th>
                            <th>Attendant</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $bookings = mysqli_query($conn, "
                            SELECT b.*, u.name as user_name, p.slot_number, a.name as attendant_name 
                            FROM bookings b 
                            JOIN users u ON b.user_id = u.id 
                            JOIN parking_slots p ON b.slot_id = p.id 
                            JOIN attendants a ON b.attendant_id = a.id 
                            ORDER BY b.created_at DESC
                        ");
                        
                        while($booking = mysqli_fetch_assoc($bookings)) {
                            echo "<tr>
                                <td>".$booking['id']."</td>
                                <td>".$booking['user_name']."</td>
                                <td>".$booking['slot_number']."</td>
                                <td>".$booking['attendant_name']."</td>
                                <td>".date('Y-m-d H:i', strtotime($booking['start_time']))."</td>
                                <td>".($booking['end_time'] ? date('Y-m-d H:i', strtotime($booking['end_time'])) : '-')."</td>
                                <td>KES ".$booking['amount']."</td>
                                <td>".$booking['status']."</td>
                                <td>";
                            if($booking['status'] == 'active') {
                                echo "<form method='POST' style='display:inline;'>
                                    <input type='hidden' name='cancel_booking' value='".$booking['id']."'>
                                    <button type='submit' class='btn btn-danger btn-sm'
                                            onclick='return confirm(\"Are you sure you want to cancel this booking?\")'>
                                        Cancel
                                    </button>
                                </form>";
                            }
                            echo "</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
