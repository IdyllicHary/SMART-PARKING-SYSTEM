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
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = $user_id"));

$vehicles_query = mysqli_query($conn, "
    SELECT DISTINCT vehicle_reg, vehicle_type 
    FROM (
        SELECT vehicle_reg, vehicle_type FROM vehicles WHERE user_id = $user_id
        UNION
        SELECT vehicle_reg, vehicle_type FROM users WHERE id = $user_id AND vehicle_reg IS NOT NULL
    ) AS all_vehicles
");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Smart Parking</title>
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
            padding: 60px;
            border-radius: 10px;
            margin: 10px 0;
        }
        .parking-slot {
            border: 1px solid #ddd;
            padding: 5px;
            margin: 5px;
            border-radius: 2px;
            cursor: pointer;
        }
        .available {
            background-color: #d4edda;
        }
        .occupied {
            background-color: #f8d7da;
        }
        select.form-control {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 1em;
            padding-right: 2.5rem;
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
            color: #fff;
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
                        <a class="nav-link text-white" href="contact_us.php">
                            <i class="fas fa-envelope"></i> Contact Us
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="user_profile.php">
                            <i class="fas fa-user"></i>My Profile  
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="view_bookings.php">
                            <i class="fas fa-ticket-alt"></i>My Bookings
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

    <div class="container">
        <div class="dashboard-container">
            <h2>Welcome, <?php echo $user['name']; ?></h2>
            <h3>Available Parking Slots</h3>
            <div class="row" id="parkingSlots">
                <?php
                    $slots = mysqli_query($conn, "SELECT * FROM parking_slots");
                    
                    while($slot = mysqli_fetch_assoc($slots)) {
                        // Check if slot has active booking
                        $booking_check = mysqli_query($conn, "SELECT * FROM bookings WHERE slot_id = {$slot['id']} AND status = 'active'");
                        $is_booked = mysqli_num_rows($booking_check) > 0;
                        
                        $status_class = !$is_booked ? 'available' : 'occupied';
                        $slot['status'] = !$is_booked ? 'available' : 'occupied';
                        ?>
                        <div class="col-md-3">
                            <div class="parking-slot <?php echo $status_class; ?>"
                                data-slot-id="<?php echo $slot['id']; ?>"
                                onclick="<?php echo (!$is_booked ? 'bookSlot('.$slot['id'].')' : 'handleSlotClick('.$slot['id'].', \''.$slot['status'].'\')'); ?>">
                                <h6>Slot <?php echo $slot['slot_number']; ?>: <?php echo $slot['price']; ?>/hr</h6>
                                <p>Status: <?php echo ucfirst($slot['status']); ?></p>
                            </div>
                        </div>
                    <?php } ?>
            </div>
        </div>
    </div>
</div>

<!-- Booking Modal -->
<div class="modal fade" id="bookingModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Book Parking Slot</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="bookingForm">
                    <input type="hidden" id="slot_id" name="slot_id">
                    <div class="mb-3">
                        <label class="form-label">Selected Slot: <span id="selected_slot"></span></label>
                        <p class="card-text">Description: <span id="location_description"></span></p>
                        <p>Price per hour: KES <span id="price_per_hour"></span></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Start Time</label>
                        <div class="input-group">
                            <input type="time" class="form-control" name="start_time" id="start_time" required 
                                min="<?php echo date('H:i:s'); ?>" 
                                value="<?php echo date('H:i:s'); ?>"
                                step="900">
                            <select class="form-select" id="quick_time" style="max-width: 150px;">
                                <option value="">Quick Select</option>
                                <?php
                                    $current_time = strtotime('now');
                                    $current_hour = date('H', $current_time);
                                    $current_minute = date('i', $current_time);
                                    
                                    // Round up to next half hour
                                    if ($current_minute > 30) {
                                        $start_time = strtotime(date('Y-m-d H:00:00', strtotime('+1 hour')));
                                    } elseif ($current_minute > 0) {
                                        $start_time = strtotime(date('Y-m-d H:30:00'));
                                    } else {
                                        $start_time = $current_time;
                                    }
                                    
                                    // Generate future time slots only
                                    for ($i = 0; $i < 48; $i++) {
                                        $slot_time = strtotime("+". ($i * 30) ." minutes", $next_slot);
                                        if ($slot_time > $current_time) {
                                            echo '<option value="' . date('H:i', $slot_time) . '">' . date('h:i A', $slot_time) . '</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Duration</label>
                        <div class="row">
                            <div class="col-6">
                                <select class="form-control" name="hours" id="hours" required>
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">19</option>
                                    <option value="19">20</option>
                                    <option value="20">21</option>
                                    <option value="21">22</option>
                                    <option value="22">23</option>
                                    <option value="23">24</option>
                                    <option value="24">24</option>
                                </select>
                                <small class="text-muted">Hours</small>
                            </div>
                            <div class="col-6">
                                <select class="form-control" name="minutes" id="minutes" required>
                                    <option value="0">00</option>
                                    <option value="5">05</option>
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                    <option value="20">20</option>
                                    <option value="25">25</option>
                                    <option value="30">30</option>
                                    <option value="35">35</option>
                                    <option value="40">40</option>
                                    <option value="45">45</option>
                                    <option value="50">50</option>
                                    <option value="55">55</option>
                                </select>
                                <small class="text-muted">Minutes</small>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Select Vehicle</label>
                        <select class="form-control" name="vehicle_reg" required>
                            <option value="">Choose Vehicle</option>
                            <?php while($vehicle = mysqli_fetch_assoc($vehicles_query)): ?>
                                <option value="<?php echo $vehicle['vehicle_reg']; ?>">
                                    <?php echo $vehicle['vehicle_reg'] . ' (' . $vehicle['vehicle_type'] . ')'; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Select Attendant</label>
                        <select class="form-control" name="attendant_id" required>
                        <option value="" selected disabled>Select Attendant</option>
                            <?php
                            $active_attendants = mysqli_query($conn, "SELECT * FROM attendants WHERE status = 'active'");
                            while($attendant = mysqli_fetch_assoc($active_attendants)) {
                                echo "<option value='".$attendant['id']."'>".$attendant['name']."</option>";
                            }
                            ?>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="confirmBooking()">Book Now</button>
            </div>
        </div>
    </div>
</div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function bookSlot(slotId) {
            $.ajax({
                url: 'get_slot_details.php',
                method: 'POST',
                data: { slot_id: slotId },
                success: function(response) {
                    const slot = JSON.parse(response);
                    $('#slot_id').val(slotId);
                    $('#selected_slot').text(slot.slot_number);
                    $('#location_description').text(slot.location_description);
                    $('#price_per_hour').text(slot.price);
                    calculateTotal();
                    $('#bookingModal').modal('show');
                }
            });
        }

        function calculateTotal() {
            const hours = parseInt($('#hours').val() || 0);
            const minutes = parseInt($('#minutes').val() || 0);
            const pricePerHour = parseFloat($('#price_per_hour').text());
            const total = (hours + minutes / 60) * pricePerHour;
            $('#total_cost').text(total.toFixed(2));
        }

        function confirmBooking() {
            // Check if attendant is selected
            if (!$('select[name="attendant_id"]').val()) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Select Attendant',
                    text: 'Please select an attendant before booking'
                });
                return;
            }

            // Check if time period is selected
            if ($('#hours').val() === '0' && $('#minutes').val() === '0') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Select Time Period',
                    text: 'Please select a parking duration'
                });
                return;
            }

            var formData = {
                slot_id: $('#slot_id').val(),
                attendant_id: $('select[name="attendant_id"]').val(),
                hours: $('#hours').val(),
                minutes: $('#minutes').val()
            };
            
            // Show loading spinner immediately
            Swal.fire({
                title: 'Processing...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });

            $.ajax({
                type: 'POST',
                url: 'process_booking.php',
                data: formData,
                success: function(response) {
                    $('#bookingModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Booking Successful!',
                        text: 'Your parking slot has been booked.',
                        timer: 3000,
                        timerProgressBar: true
                    }).then(function() {
                        location.reload(true);
                    });
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Booking Failed',
                        text: 'Please try again'
                    });
                }
            });
        }

        $(document).ready(function() {
            $('#hours, #minutes').change(calculateTotal);
        });

        function handleSlotClick(slotId, status) {
            if (status === 'occupied') {
                Swal.fire({
                    title: 'Slot Unavailable',
                    text: 'This parking slot is currently occupied. Please select an available slot.',
                    icon: 'warning',
                    confirmButtonColor: '#3498db',
                    confirmButtonText: 'OK'
                });
                return false;
            }
        }

    </script>

    <?php if(isset($_GET['success']) && $_GET['success'] === 'login'): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Welcome <?php echo $_SESSION['name']; ?>!',
            text: 'You have successfully logged in',
            timer: 2500,
            showConfirmButton: false,
            position: 'top',
            toast: true
        }).then(function() {
            window.location.href = 'user_dashboard.php';
        });
    </script>
    <?php endif; ?>

    <?php if(isset($_GET['success']) && $_GET['success'] === 'profile_updated'): ?>
        <script>
            Swal.fire({
                title: 'Success!',
                text: 'Your profile has been updated successfully',
                icon: 'success',
                timer: 2000,
                timerProgressBar: true,
                showConfirmButton: false,
                position: 'top',
                toast: true
            }).then(() => {
                window.history.replaceState({}, document.title, window.location.pathname);
            });
        </script>
    <?php endif; ?>

    <script>
        document.getElementById('quick_time').addEventListener('change', function() {
            if (this.value) {
                document.getElementById('start_time').value = this.value;
            }
        });
        document.getElementById('start_time').addEventListener('change', function() {
    let selectedTime = new Date('2000-01-01 ' + this.value);
    let currentTime = new Date();
    currentTime.setFullYear(2000, 0, 1);

    if (selectedTime < currentTime) {
        Swal.fire({
            icon: 'warning',
            title: 'Invalid Time Selection',
            text: 'Please select a future time slot'
        });
        this.value = currentTime.toTimeString().slice(0,5);
    }
});

</script>
</body>
</html>

</body>
</html>
