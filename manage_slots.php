<?php
include 'config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Handle slot addition
if(isset($_POST['add_slot'])) {
    $slot_number = mysqli_real_escape_string($conn, $_POST['slot_number']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    
    mysqli_query($conn, "INSERT INTO parking_slots (slot_number, price) VALUES ('$slot_number', '$price')");
}

// Handle slot deletion
if(isset($_POST['delete_slot'])) {
    $slot_id = mysqli_real_escape_string($conn, $_POST['delete_slot']);
    mysqli_query($conn, "DELETE FROM parking_slots WHERE id = $slot_id");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Parking Slots - Smart Parking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4/bootstrap-4.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 
    <link href="assets/css/notifications.css" rel="stylesheet">
    <script src="assets/js/notifications.js"></script>
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
            <h2>Manage Parking Slots</h2>
            
            <button class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#addSlotModal">
                Add New Slot
            </button>
            
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Slot Number</th>
                            <th>Status</th>
                            <th>Price (KES/hr)</th>
                            <th>Location Description</th>
                            <th>Created On</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $slots = mysqli_query($conn, "SELECT * FROM parking_slots ORDER BY slot_number");
                        while($slot = mysqli_fetch_assoc($slots)) {
                            echo "<tr>
                                <td>".$slot['id']."</td>
                                <td>".$slot['slot_number']."</td>
                                <td>".$slot['status']."</td>
                                <td>".$slot['price']."</td>
                                <td>".$slot['location_description']."</td>
                                <td>".date('Y-m-d', strtotime($slot['created_at']))."</td>
                                <td>
                                    <form method='POST' style='display:inline;'>
                                        <input type='hidden' name='delete_slot' value='".$slot['id']."'>
                                        <button type='submit' class='btn btn-danger btn-sm'
                                                onclick='return confirm(\"Are you sure you want to delete this slot?\")'>
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Slot Modal -->
    <div class="modal fade" id="addSlotModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Parking Slot</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST">
                        <input type="hidden" name="add_slot" value="1">
                        <div class="mb-3">
                            <label class="form-label">Slot Number</label>
                            <input type="text" class="form-control" name="slot_number" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Price per Hour (KES)</label>
                            <input type="number" class="form-control" name="price" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Location Description</label>
                            <input type="text" class="form-control" name="location_description" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Slot</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
