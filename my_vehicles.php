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

// Get vehicles with their current status
// Get both registered vehicles and the initial vehicle from user registration
$vehicles = mysqli_query($conn, "SELECT 
    CASE 
        WHEN v.vehicle_reg IS NOT NULL THEN v.vehicle_reg 
        ELSE u.vehicle_reg 
    END as vehicle_reg,
    CASE 
        WHEN v.vehicle_type IS NOT NULL THEN v.vehicle_type 
        ELSE u.vehicle_type 
    END as vehicle_type,
    CASE
        WHEN b.status = 'active' AND b.start_time <= NOW() THEN 'Currently Parked'
        WHEN b.status = 'active' AND b.start_time > NOW() THEN 'Scheduled for Parking'
        ELSE 'Not Parked'
    END as parking_status
    FROM users u 
    LEFT JOIN vehicles v ON u.id = v.user_id
    LEFT JOIN bookings b ON u.id = b.user_id AND b.status = 'active'
    WHERE u.id = $user_id");$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = $user_id"));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Vehicles - Smart Parking</title>
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
    <!-- Navigation Bar -->
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
                        <a class="nav-link text-white" href="contact_us.php">
                            <i class="fas fa-envelope"></i> Contact Us
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="user_profile.php">
                            <i class="fas fa-user"></i> My Profile
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="view_bookings.php">
                            <i class="fas fa-ticket-alt"></i> My Bookings
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="my_vehicles.php">
                            <i class="fas fa-car"></i> My Vehicles
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

    <!-- Main Content -->
    <div class="container">
        <div class="dashboard-container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-car"></i> My Vehicles</h2>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addVehicleModal">
                    <i class="fas fa-plus"></i> Add New Vehicle
                </button>
            </div>

            <!-- Vehicles Table -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Vehicle Registration</th>
                            <th>Vehicle Type</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($vehicle = mysqli_fetch_assoc($vehicles)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($vehicle['vehicle_reg']); ?></td>
                            <td><?php echo htmlspecialchars($vehicle['vehicle_type']); ?></td>
                            <td>
                                <?php 
                                    $badgeClass = 'bg-secondary';
                                    if($vehicle['parking_status'] == 'Currently Parked') {
                                        $badgeClass = 'bg-success';
                                    } else if($vehicle['parking_status'] == 'Scheduled for Parking') {
                                        $badgeClass = 'bg-warning';
                                    }
                                ?>
                                <span class="badge <?php echo $badgeClass; ?>">
                                    <?php echo htmlspecialchars($vehicle['parking_status']); ?>
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-warning edit-vehicle" 
                                        data-reg="<?php echo htmlspecialchars($vehicle['vehicle_reg']); ?>"
                                        data-type="<?php echo htmlspecialchars($vehicle['vehicle_type']); ?>"
                                        data-status="<?php echo htmlspecialchars($vehicle['parking_status']); ?>">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button class="btn btn-sm btn-danger delete-vehicle" 
                                        data-reg="<?php echo htmlspecialchars($vehicle['vehicle_reg']); ?>"
                                        data-status="<?php echo htmlspecialchars($vehicle['parking_status']); ?>">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Vehicle Modal -->
    <div class="modal fade" id="addVehicleModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-plus"></i> Add New Vehicle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addVehicleForm">
                        <div class="mb-3">
                            <label>Vehicle Registration</label>
                            <input type="text" class="form-control" name="vehicle_reg" required>
                        </div>
                        <div class="mb-3">
                            <label>Vehicle Type</label>
                            <select class="form-control" name="vehicle_type" required>
                                <option value="" selected disabled>Select Vehicle Type</option>
                                <option value="Sedan">Sedan</option>
                                <option value="SUV">SUV</option>
                                <option value="Van">Van</option>
                                <option value="Truck">Truck</option>
                                <option value="Hatchback">Hatchback</option>
                                <option value="Coupe">Coupe</option>
                                <option value="Compact Car">Compact Car</option>
                                <option value="Mini Cooper">Mini Cooper</option>
                                <option value="Smart Car">Smart Car</option>
                                <option value="Crossover">Crossover</option>
                                <option value="Station Wagon">Station Wagon</option>
                                <option value="Pickup Truck">Pickup Truck</option>
                                <option value="Minivan">Minivan</option>
                                <option value="Light Commercial Vehicle">Light Commercial Vehicle</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add Vehicle
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    $(document).ready(function() {
        // Add Vehicle
        $('#addVehicleForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: 'vehicle_operations.php',
                data: $(this).serialize() + '&action=add',
                dataType: 'json',
                success: function(response) {
                    if(response.success) {
                        $('#addVehicleModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Vehicle added successfully',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function() {
                            location.reload();
                        });
                    }
                },
                error: function(xhr) {
                    const response = JSON.parse(xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.error || 'Failed to add vehicle'
                    });
                }
            });
        });
        // Delete Vehicle
        $('.delete-vehicle').click(function() {
            const status = $(this).data('status');
            const vehicleReg = $(this).data('reg');

            if(status === 'Currently Parked' || status === 'Scheduled for Parking') {
                Swal.fire({
                    icon: 'error',
                    title: 'Cannot Delete',
                    text: 'Vehicle cannot be deleted while parked or scheduled'
                });
                return;
            }

            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: 'vehicle_operations.php',
                        data: {
                            action: 'delete',
                            vehicle_reg: vehicleReg,
                            user_id: <?php echo $user_id; ?>
                        },
                        dataType: 'json',
                        success: function(response) {
                            if(response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: 'Vehicle has been removed',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(function() {
                                    location.reload();
                                });
                            }
                        },
                        error: function(xhr) {
                            const response = JSON.parse(xhr.responseText);
                            Swal.fire({
                                icon: 'error',
                                title: 'Delete Failed',
                                text: response.error || 'Please try again'
                            });
                        }
                    });
                }
            });
        });

        // Edit Vehicle
        $('.edit-vehicle').click(function() {
            const status = $(this).data('status');
            if(status === 'Currently Parked' || status === 'Scheduled for Parking') {
                Swal.fire({
                    icon: 'error',
                    title: 'Cannot Edit',
                    text: 'Vehicle cannot be edited while parked or scheduled'
                });
                return;
            }

            const vehicleReg = $(this).data('reg');
            const vehicleType = $(this).data('type');
            
            Swal.fire({
                title: 'Edit Vehicle',
                html: `
                    <form id="editVehicleForm">
                        <div class="mb-3">
                            <label>Vehicle Registration</label>
                            <input type="text" class="form-control" id="edit_vehicle_reg" value="${vehicleReg}" required>
                        </div>
                        <div class="mb-3">
                            <label>Vehicle Type</label>
                            <select class="form-control" id="edit_vehicle_type" required>
                                <option value="Sedan" ${vehicleType === 'Sedan' ? 'selected' : ''}>Sedan</option>
                                <option value="SUV" ${vehicleType === 'SUV' ? 'selected' : ''}>SUV</option>
                                <option value="Van" ${vehicleType === 'Van' ? 'selected' : ''}>Van</option>
                                <option value="Truck" ${vehicleType === 'Truck' ? 'selected' : ''}>Truck</option>
                                <option value="Hatchback" ${vehicleType === 'Hatchback' ? 'selected' : ''}>Hatchback</option>
                                <option value="Coupe" ${vehicleType === 'Coupe' ? 'selected' : ''}>Coupe</option>
                                <option value="Compact Car" ${vehicleType === 'Compact Car' ? 'selected' : ''}>Compact Car</option>
                                <option value="Mini Cooper" ${vehicleType === 'Mini Cooper' ? 'selected' : ''}>Mini Cooper</option>
                                <option value="Smart Car" ${vehicleType === 'Smart Car' ? 'selected' : ''}>Smart Car</option>
                                <option value="Crossover" ${vehicleType === 'Crossover' ? 'selected' : ''}>Crossover</option>
                                <option value="Station Wagon" ${vehicleType === 'Station Wagon' ? 'selected' : ''}>Station Wagon</option>
                                <option value="Pickup Truck" ${vehicleType === 'Pickup Truck' ? 'selected' : ''}>Pickup Truck</option>
                                <option value="Minivan" ${vehicleType === 'Minivan' ? 'selected' : ''}>Minivan</option>
                                <option value="Light Commercial Vehicle" ${vehicleType === 'Light Commercial Vehicle' ? 'selected' : ''}>Light Commercial Vehicle</option>
                            </select>
                        </div>
                    </form>
                `,
                showCancelButton: true,
                confirmButtonText: 'Update',
                preConfirm: () => {
                    return {
                        oldReg: vehicleReg,
                        newReg: document.getElementById('edit_vehicle_reg').value,
                        newType: document.getElementById('edit_vehicle_type').value
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: 'vehicle_operations.php',
                        data: {
                            action: 'edit',
                            old_reg: result.value.oldReg,
                            new_reg: result.value.newReg,
                            new_type: result.value.newType,
                            user_id: <?php echo $user_id; ?>
                        },
                        dataType: 'json',
                        success: function(response) {
                            if(response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Updated!',
                                    text: 'Vehicle details updated successfully',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(function() {
                                    location.reload();
                                });
                            }
                        },
                        error: function(xhr) {
                            const response = JSON.parse(xhr.responseText);
                            Swal.fire({
                                icon: 'error',
                                title: 'Update Failed',
                                text: response.error || 'Please try again'
                            });
                        }
                    });
                }
            });
        });
    });
    </script>
</body>
</html>
