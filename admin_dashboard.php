<?php
include 'config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(!isset($_SESSION['admin_id'])) {
    header("admin_login.php");
    exit();
}

// Fetch statistics
$users_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM users"))['count'];
$attendants_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM attendants"))['count'];
$active_bookings = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM bookings WHERE status='active'"))['count'];
$total_slots = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM parking_slots"))['count'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Smart Parking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4/bootstrap-4.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        .stat-card {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
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
    <nav class="navbar navbar-expand-lg" style="background-color: #3498db;">
        <div class="container">
            <a class="navbar-brand text-white" href="admin_dashboard.php">
                <i class="fas fa-user-shield"></i>Admin Dashboard
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
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
            <h2 class="mb-4">Dashboard Overview</h2>
            
            <div class="row">
                <div class="col-md-3">
                    <div class="stat-card text-center">
                        <i class="fas fa-users fa-3x mb-3 text-primary"></i>
                        <h3><?php echo $users_count; ?></h3>
                        <p>Total Users</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card text-center">
                        <i class="fas fa-user-tie fa-3x mb-3 text-success"></i>
                        <h3><?php echo $attendants_count; ?></h3>
                        <p>Total Attendants</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card text-center">
                        <i class="fas fa-car fa-3x mb-3 text-warning"></i>
                        <h3><?php echo $active_bookings; ?></h3>
                        <p>Active Bookings</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card text-center">
                        <i class="fas fa-parking fa-3x mb-3 text-info"></i>
                        <h3><?php echo $total_slots; ?></h3>
                        <p>Total Parking Slots</p>
                    </div>
                </div>
            </div>

            <!-- Recent Activities Section -->
            <div class="mt-5">
                <h3>Recent Activities</h3>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>User</th>
                                <th>Activity</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $recent_activities = mysqli_query($conn, "
                                SELECT b.created_at, u.name, b.status, p.slot_number 
                                FROM bookings b 
                                JOIN users u ON b.user_id = u.id 
                                JOIN parking_slots p ON b.slot_id = p.id 
                                ORDER BY b.created_at DESC LIMIT 5
                            ");
                            while($activity = mysqli_fetch_assoc($recent_activities)) {
                                echo "<tr>
                                    <td>".date('Y-m-d H:i', strtotime($activity['created_at']))."</td>
                                    <td>".$activity['name']."</td>
                                    <td>Booked slot ".$activity['slot_number']."</td>
                                    <td>".$activity['status']."</td>
                                </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
   
<?php if(isset($_GET['success']) && $_GET['success'] === 'login'): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Welcome Admin!',
            text: 'Login Successful',
            timer: 2500,
            showConfirmButton: false,
            position: 'top',
            toast: true
        }).then(function() {
            window.location.href = 'admin_dashboard.php';
        });
    </script>
<?php endif; ?>

</body>
</html>
