<?php
include 'config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings - Smart Parking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4/bootstrap-4.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            background-image: url('assets/images/parking-bg.jpeg');
            background-size: cover;
            min-height: 100vh;
        }
        .bookings-container {
            background: rgba(255,255,255,0.95);
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }
        .booking_history-container {
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
        .badge {
            font-size: 14px;
            padding: 8px 12px;
        }

    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg" style="background-color: #3498db;">
        <div class="container">
            <a class="navbar-brand text-white" href="user_dashboard.php">
                <i class="fas fa-user-circle"></i> User Dashboard
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="user_dashboard.php">
                            <i class="fas fa-home"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active text-white" href="view_bookings.php">
                            <i class="fas fa-ticket-alt"></i> My Bookings
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="my_vehicles.php">
                            <i class="fas fa-car"></i> My Vehicles
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="user_profile.php">
                            <i class="fas fa-user"></i> My Profile
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
        <div class="bookings-container">
            <h2>My Bookings</h2>
            <div class="alert alert-success mb-4">
                <i class="fas fa-check-circle me-2"></i>
                These are the recent bookings made by you. Please remember to pay the parking fees on time. Any late payments may result in penalties. Thank you for choosing our parking service.
            </div>
            <div class="table-responsive mt-4">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>Slot Number</th>
                            <th>Attendant</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Payment Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $bookings = mysqli_query($conn, "
                            SELECT b.*, p.slot_number, a.name as attendant_name
                            FROM bookings b
                            JOIN parking_slots p ON b.slot_id = p.id
                            JOIN attendants a ON b.attendant_id = a.id
                            WHERE b.user_id = $user_id
                            AND (b.status = 'active')
                            ORDER BY b.created_at DESC
                        ");                   
                       
                        while($booking = mysqli_fetch_assoc($bookings)) {
                            echo "<tr>
                                <td>".$booking['id']."</td>
                                <td>".$booking['slot_number']."</td>
                                <td>".$booking['attendant_name']."</td>
                                <td>".date('Y-m-d H:i', strtotime($booking['start_time']))."</td>
                                <td>".($booking['end_time'] ? date('Y-m-d H:i', strtotime($booking['end_time'])) : '-')."</td>
                                <td>KES ".$booking['amount']."</td>
                                <td>".$booking['status']."</td>
                                <td><span class='badge ".($booking['payment_status'] == 'paid' ? 'bg-success' : 'bg-danger')."'>".ucfirst($booking['payment_status'])."</span></td>
                                <td>".($booking['status'] == 'active' ? "<button class='btn btn-danger btn-sm' onclick='cancelBooking(".$booking['id'].")'>Cancel Booking</button>" : "-")."</td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="booking_history-container">
            <h2>My Booking History</h2>
            <div class="table-responsive mt-4">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>Slot Number</th>
                            <th>Attendant</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Amount</th>
                            <th>Payment Status</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $past_bookings = mysqli_query($conn, "
                                SELECT b.*, p.slot_number, a.name as attendant_name
                                FROM bookings b
                                JOIN parking_slots p ON b.slot_id = p.id
                                JOIN attendants a ON b.attendant_id = a.id
                                WHERE b.user_id = $user_id
                                AND (b.status = 'completed' OR b.status = 'cancelled' OR b.status = 'expired')
                                ORDER BY b.created_at DESC
                            ");                       

                            while($past_booking = mysqli_fetch_assoc($past_bookings)) {
                                echo "<tr>
                                    <td>".$past_booking['id']."</td>
                                    <td>".$past_booking['slot_number']."</td>
                                    <td>".$past_booking['attendant_name']."</td>
                                    <td>".date('Y-m-d H:i', strtotime($past_booking['start_time']))."</td>
                                    <td>".($past_booking['end_time'] ? date('Y-m-d H:i', strtotime($past_booking['end_time'])) : '-')."</td>
                                    <td>KES ".$past_booking['amount']."</td>
                                    <td><span class='badge ".($past_booking['payment_status'] == 'paid' ? 'bg-success' : 'bg-danger')."'>".ucfirst($past_booking['payment_status'])."</span></td>
                                    <td>".$past_booking['status']."</td>
                                </tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function cancelBooking(bookingId) {
            Swal.fire({
                title: 'Cancel Booking',
                text: 'Are you sure you want to cancel this booking?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, cancel it!',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return $.ajax({
                        url: 'cancel_booking.php',
                        method: 'POST',
                        data: { booking_id: bookingId },
                        beforeSend: function() {
                            Swal.showLoading();
                        }
                    });
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Cancelled!',
                        text: 'Your booking has been cancelled.',
                        icon: 'success',
                        timer: 2000
                    }).then(() => {
                        location.reload();
                    });
                }
            });
        }
    </script>
</body>
</html>
