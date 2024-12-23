<?php
include 'config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if(!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Handle attendant addition
if(isset($_POST['add_attendant'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $id_number = mysqli_real_escape_string($conn, $_POST['id_number']);
    $password = password_hash($_POST['password123'], PASSWORD_DEFAULT);
    
    mysqli_query($conn, "INSERT INTO attendants (name, email, phone, id_number, password, employment_date) 
                        VALUES ('$name', '$email', '$phone', '$id_number', '$password', NOW())");
}

// Handle attendant deletion
if(isset($_POST['delete_attendant'])) {
    $attendant_id = mysqli_real_escape_string($conn, $_POST['delete_attendant']);
    $query = "DELETE FROM attendants WHERE id = '$attendant_id'";
    mysqli_query($conn, $query);
    header("Location: manage_attendants.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Attendants - Smart Parking</title>
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
                            <i class="fas fa-ticket-alt"></i> My Bookings
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
            <h2>Manage Attendants</h2>
            
            <button class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#addAttendantModal">
                Add New Attendant
            </button>
            
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>ID Number</th>
                            <th>Employment Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $attendants = mysqli_query($conn, "SELECT * FROM attendants ORDER BY created_at DESC");
                        while($attendant = mysqli_fetch_assoc($attendants)) {
                            echo "<tr>
                                <td>".$attendant['id']."</td>
                                <td>".$attendant['name']."</td>
                                <td>".$attendant['email']."</td>
                                <td>".$attendant['phone']."</td>
                                <td>".$attendant['id_number']."</td>
                                <td>".date('Y-m-d', strtotime($attendant['employment_date']))."</td>
                                <td>
                                    <button class='btn " . ($attendant['status'] == 'active' ? 'btn-success' : 'btn-danger') . " btn-sm toggle-status' 
                                            data-id='" . $attendant['id'] . "' 
                                            data-status='" . $attendant['status'] . "'>
                                        " . ucfirst($attendant['status']) . "
                                    </button>
                                </td>
                                <td>
                                    <form method='POST' style='display:inline;'>
                                        <input type='hidden' name='delete_attendant' value='".$attendant['id']."'>
                                        <button type='submit' class='btn btn-danger btn-sm delete-btn'
                                                onclick='return confirm(\"Are you sure you want to delete this attendant?\")'>
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

    <!-- Add Attendant Modal -->
    <div class="modal fade" id="addAttendantModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Attendant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST">
                        <input type="hidden" name="add_attendant" value="1">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                        <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="tel" class="form-control" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">ID Number</label>
                            <input type="text" class="form-control" name="id_number" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Attendant</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Attendant Modal -->
    <div class="modal fade" id="editAttendantModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Attendant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editAttendantForm">
                        <input type="hidden" id="edit_attendant_id" name="attendant_id">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" id="edit_email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="tel" class="form-control" id="edit_phone" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">ID Number</label>
                            <input type="text" class="form-control" id="edit_id_number" name="id_number" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Attendant</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
$(document).ready(function() {
    $('.toggle-status').click(function() {
        var button = $(this);
        var attendantId = button.data('id');
        var currentStatus = button.data('status');
        
        $.ajax({
            url: 'toggle_attendant_status.php',
            method: 'POST',
            data: {
                attendant_id: attendantId,
                current_status: currentStatus
            },
            success: function(response) {
                const data = JSON.parse(response);
                if(data.status === 'success') {
                    button.data('status', data.new_status);
                    button.text(data.new_status.charAt(0).toUpperCase() + data.new_status.slice(1));
                    button.toggleClass('btn-success btn-danger');
                    eval(data.script);
                }
            }
        });
    });
});
</script>

    </body>
</html>
