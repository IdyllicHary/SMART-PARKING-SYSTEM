<?php
include 'config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(!isset($_SESSION['attendant_id'])) {
    header("Location: attendant_login.php");
    exit();
}

// Handle AJAX requests for calculating totals
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'calculate_total') {
    $booking_id = mysqli_real_escape_string($conn, $_POST['booking_id']);
    $extended_hours = (int)$_POST['extended_hours'];
    
    $query = "SELECT amount FROM bookings WHERE id = $booking_id";
    $result = mysqli_query($conn, $query);
    $booking = mysqli_fetch_assoc($result);
    
    if($booking) {
        $base_amount = ceil($booking['amount']); // Round up base amount
        // Only calculate if hours > 0
        $extension_fee = ($extended_hours >0) ? $extended_hours * 100 : 0; // 100 KES per hour
        $total_amount = ceil($base_amount + $extension_fee); // Round up total
        
        // Only update if there are extended hours
        if($extended_hours > 0) {
        mysqli_query($conn, "UPDATE bookings 
                           SET amount = $total_amount, 
                               extended_hours = $extended_hours 
                           WHERE id = $booking_id");
        }
        
        echo json_encode([
            'base_amount' => $base_amount,
            'extension_fee' => $extension_fee,
            'total_amount' => $total_amount,
            'success' => true
        ]);
        exit;
    }
}
// Handle payment status updates
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_payment') {
    $booking_id = mysqli_real_escape_string($conn, $_POST['booking_id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $payment_method = mysqli_real_escape_string($conn, $_POST['payment_method']);
    
    $query = "UPDATE bookings 
              SET payment_status = '$status',
                  payment_method = '$payment_method',
                  payment_date = NOW() 
              WHERE id = $booking_id";
              
    if(mysqli_query($conn, $query)) {
        echo json_encode(['success' => true]);
        exit;
    } else {
        echo json_encode(['error' => 'Update failed']);
        exit;
    }
}

$attendant_id = $_SESSION['attendant_id'];
$attendant = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM attendants WHERE id = $attendant_id"));
$message = '';
if(isset($_GET['success'])) {
    $message = "<script>showSuccess('" . htmlspecialchars($_GET['success']) . "');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendant Dashboard - Smart Parking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4/bootstrap-4.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
        .attendance_history-container {
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
        .payment-option {
            border: 2px solid #e0e0e0;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            height: 100%;
        }
        .payment-option:hover {
            border-color: #3498db;
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .payment-option i {
            margin-bottom: 10px;
        }
        .payment-option h5 {
            margin-bottom: 5px;
            color: #2c3e50;
        }
        .payment-option p {
            color: #7f8c8d;
            margin-bottom: 0;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg" style="background-color: #3498db;">
        <div class="container">
            <a class="navbar-brand text-white" href="attendant_dashboard.php">
                <i class="fas fa-user-tie"></i> Attendant Dashboard
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="attendant_profile.php">
                            <i class="fas fa-user-tie"></i> My Profile
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
            <h2>Welcome, <?php echo $attendant['name']; ?></h2>
            
            <div class="row mt-4">
                <div class="col-md-12">
                    <h3>My Assigned Bookings</h3>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Booking ID</th>
                                    <th>User Name</th>
                                    <th>Vehicle Reg</th>
                                    <th>Slot Number</th>
                                    <th>Start Time</th>
                                    <th>Status</th>
                                    <th>Payment Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $bookings = mysqli_query($conn, "
                                    SELECT b.*, u.name as user_name, u.vehicle_reg, p.slot_number, b.payment_status
                                    FROM bookings b
                                    JOIN users u ON b.user_id = u.id
                                    JOIN parking_slots p ON b.slot_id = p.id
                                    WHERE b.attendant_id = $attendant_id
                                    AND b.status = 'active'
                                    ORDER BY b.created_at DESC
                                ");
                               
                                while($booking = mysqli_fetch_assoc($bookings)) {
                                    echo "<tr>
                                        <td>".$booking['id']."</td>
                                        <td>".$booking['user_name']."</td>
                                        <td>".$booking['vehicle_reg']."</td>
                                        <td>".$booking['slot_number']."</td>
                                        <td>".date('Y-m-d H:i', strtotime($booking['start_time']))."</td>
                                        <td>".$booking['status']."</td>
                                        <td>
                                            <button class='btn ".($booking['payment_status'] == 'paid' ? 'btn-success' : 'btn-danger')." btn-sm payment-badge toggle-payment'
                                                    data-booking-id='".$booking['id']."'
                                                    data-current-status='".$booking['payment_status']."'>
                                                ".ucfirst($booking['payment_status'])."
                                            </button>
                                        </td>
                                        <td>
                                            <button class='btn btn-success btn-sm' onclick='completeBooking(".$booking['id'].", \"".$booking['payment_status']."\")'>
                                                Complete
                                            </button>
                                        </td>
                                    </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="attendance_history-container">
            <h2>My Booking Attendance History</h2>
            <div class="table-responsive mt-4">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>User Name</th>
                            <th>Vehicle Reg</th>
                            <th>Slot Number</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Amount</th>
                            <th>Payment Status</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $bookings = mysqli_query($conn, "
                            SELECT b.*, p.slot_number, u.name as user_name, u.vehicle_reg, b.payment_status
                            FROM bookings b
                            JOIN parking_slots p ON b.slot_id = p.id
                            JOIN users u ON b.user_id = u.id
                            WHERE b.attendant_id = $attendant_id
                            AND b.status = 'completed'
                            ORDER BY b.created_at DESC
                        ");
                       
                        while($booking = mysqli_fetch_assoc($bookings)) {
                            echo "<tr>
                                <td>".$booking['id']."</td>
                                <td>".$booking['user_name']."</td>
                                <td>".$booking['vehicle_reg']."</td>
                                <td>".$booking['slot_number']."</td>
                                <td>".date('Y-m-d H:i', strtotime($booking['start_time']))."</td>
                                <td>".($booking['end_time'] ? date('Y-m-d H:i', strtotime($booking['end_time'])) : '-')."</td>
                                <td>KES ".$booking['amount']."</td>
                                <td><span class='badge payment-badge ".($booking['payment_status'] == 'paid' ? 'bg-success' : 'bg-danger')."'>".ucfirst($booking['payment_status'])."</span></td>
                                <td>".$booking['status']."</td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.toggle-payment').click(function() {
                const bookingId = $(this).data('booking-id');
                const currentStatus = $(this).data('current-status');
                
                // First show time extension dialog
                Swal.fire({
                    title: 'Time Extension Check',
                    html: `
                        <div class="mb-3">
                            <label class="form-label">Additional Hours (if any)</label>
                            <input type="number" 
                                   id="extended_hours" 
                                   class="form-control" 
                                   min="0" 
                                   value="0"
                                   placeholder="Enter number of extended hours">
                            <small class="text-muted">Extra hours are charged at KES 100 per hour</small>
                        </div>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Continue to Payment',
                    preConfirm: () => {
                        const hours = parseInt(document.getElementById('extended_hours').value) || 0;
                        if(hours < 0) {
                            Swal.showValidationMessage('Hours cannot be negative');
                            return false;
                        }
                        return $.ajax({
                            url: window.location.href,
                            method: 'POST',
                            data: {
                                action: 'calculate_total',
                                booking_id: bookingId,
                                extended_hours: hours
                            },
                            dataType: 'json'
                        });
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const totalAmount = result.value.total_amount;
                        const extensionFee = result.value.extension_fee;
                        const baseAmount = result.value.base_amount;
                        
                        // Show payment confirmation with breakdown
                        Swal.fire({
                            title: 'Payment Details',
                            html: `
                                <div class="payment-breakdown">
                                    <p>Base Amount: KES ${Math.ceil(baseAmount)}</p>
                                    ${extensionFee > 0 ? `<p>Extension Fee: KES ${Math.ceil(extensionFee)}</p>` : ''}
                                    <hr>
                                    <p class="fw-bold">Total Amount: KES ${Math.ceil(totalAmount)}</p>
                                </div>
                            `,
                            showCancelButton: true,
                            confirmButtonText: 'Proceed with Payment'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                showPaymentMethods({amount: totalAmount}, bookingId);
                            }
                        });
                    }
                });
            });
        });

        function showPaymentMethods(booking, bookingId) {
            Swal.fire({
                title: 'Select Payment Method',
                html: `
                    <div class="payment-methods">
                        <p class="mb-4">Amount to pay: KES ${booking.amount}</p>
                        <div class="row justify-content-center">
                            <div class="col-md-6 mb-3">
                                <div class="payment-option" onclick="handlePayment('mpesa', ${bookingId}, ${booking.amount})">
                                    <i class="fas fa-mobile-alt fa-3x mb-2 text-success"></i>
                                    <h5>M-Pesa</h5>
                                    <p class="small">Pay using M-Pesa</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="payment-option" onclick="handlePayment('cash', ${bookingId}, ${booking.amount})">
                                    <i class="fas fa-money-bill-wave fa-3x mb-2 text-primary"></i>
                                    <h5>Cash</h5>
                                    <p class="small">Pay with cash</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="payment-option" onclick="handlePayment('card', ${bookingId}, ${booking.amount})">
                                    <i class="fas fa-credit-card fa-3x mb-2 text-info"></i>
                                    <h5>Card Payment</h5>
                                    <p class="small">Pay with Visa/Mastercard</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="payment-option" onclick="handlePayment('bank', ${bookingId}, ${booking.amount})">
                                    <i class="fas fa-university fa-3x mb-2 text-warning"></i>
                                    <h5>Bank Transfer</h5>
                                    <p class="small">Pay via bank transfer</p>
                                </div>
                            </div>
                        </div>
                    </div>
                `,
                showCancelButton: true,
                showConfirmButton: false,
                width: '600px'
            });
        }

        function handlePayment(method, bookingId, amount) {
            switch(method) {
                case 'mpesa':
    Swal.fire({
        title: 'M-Pesa Payment',
        html: `
            <div class="mb-3">
                <p class="fw-bold">Amount: KES ${amount}</p>
                <div class="form-group">
                    <label for="phone" class="form-label">Enter Phone Number</label>
                    <input type="text" 
                           id="phone" 
                           class="form-control" 
                           placeholder="07XXXXXXXX"
                           pattern="^0[7][0-9]{8}$"
                           required>
                    <small class="text-muted">Format: 07XXXXXXXX</small>
                </div>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Send Payment Request',
        preConfirm: () => {
            const phone = document.getElementById('phone').value;
            if (!phone.match(/^0[7][0-9]{8}$/)) {
                Swal.showValidationMessage('Please enter a valid phone number');
                return false;
            }

            Swal.fire({
                title: 'Payment Request Sent',
                html: `
                    <p>Please check your phone and enter M-Pesa PIN</p>
                    <p>Time remaining: <span id="timer">60</span> seconds</p>
                `,
                icon: 'info',
                showConfirmButton: false,
                timer: 60000,
                timerProgressBar: true,
                allowOutsideClick: false,
                didOpen: () => {
                    const timer = setInterval(() => {
                        const timeLeft = Math.ceil(Swal.getTimerLeft() / 1000);
                        document.getElementById('timer').textContent = timeLeft;
                    }, 1000);

                    fetch('process_lipia_payment.php', {
                        method: 'POST',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        body: `phone=${phone}&amount=${amount}&booking_id=${bookingId}`
                    });

                    const checkStatus = setInterval(() => {
                        fetch(`check_payment_status.php?booking_id=${bookingId}`)
                        .then(response => response.json())
                        .then(data => {
                            if(data.status === 'paid') {
                                clearInterval(checkStatus);
                                clearInterval(timer);
                                Swal.fire({
                                    title: 'Payment Successful',
                                    text: 'Thank you for your payment',
                                    icon: 'success'
                                }).then(() => location.reload());
                            }
                        })
                        .catch(error => console.error('Status check error:', error));
                    }, 3000);

                    Swal.getPopup().addEventListener('mouseleave', () => {
                        clearInterval(timer);
                        clearInterval(checkStatus);
                    });
                }
            }).then((result) => {
                if (result.dismiss === Swal.DismissReason.timer) {
                    Swal.fire({
                        title: 'Payment Timeout',
                        text: 'Payment was not completed in time. Please try again.',
                        icon: 'error'
                    });
                }
            });
            return false;
        }
    });
    break;

                case 'cash':
                    Swal.fire({
                        title: 'Confirm Cash Payment',
                        text: 'Has the cash payment been received?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, Received',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: window.location.href,
                                method: 'POST',
                                data: {
                                    action: 'update_payment',
                                    booking_id: bookingId,
                                    payment_method: 'cash',
                                    status: 'paid'
                                },
                                success: function(response) {
                                    Swal.fire({
                                        title: 'Success!',
                                        text: 'Cash payment recorded successfully',
                                        icon: 'success'
                                    }).then(() => {
                                        location.reload();
                                    });
                                }
                            });
                        }
                    });
                    break;

                case 'card':
                    Swal.fire({
                        title: 'Card Payment',
                        html: `
                            <div class="mb-3">
                                <p class="fw-bold">Amount: KES ${amount}</p>
                                <div class="form-group mb-3">
                                    <label>Card Number</label>
                                    <input type="text" class="form-control" placeholder="1234 5678 9012 3456">
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <label>Expiry Date</label>
                                        <input type="text" class="form-control" placeholder="MM/YY">
                                    </div>
                                    <div class="col-6">
                                        <label>CVV</label>
                                        <input type="text" class="form-control" placeholder="123">
                                    </div>
                                </div>
                            </div>
                        `,
                        showCancelButton: true,
                        confirmButtonText: 'Pay Now',
                        footer: '<small>Powered by Stripe</small>'
                    });
                    break;

                case 'bank':
                    Swal.fire({
                        title: 'Bank Transfer Details',
                        html: `
                            <div class="mb-3">
                                <p class="fw-bold">Amount: KES ${amount}</p>
                                <div class="alert alert-info">
                                    <p><strong>Bank:</strong> Example Bank</p>
                                    <p><strong>Account Name:</strong> Smart Parking Ltd</p>
                                    <p><strong>Account Number:</strong> 1234567890</p>
                                    <p><strong>Branch:</strong> Main Branch</p>
                                    <p><strong>Reference:</strong> SP${bookingId}</p>
                                </div>
                                <p class="small">Please use the booking ID as reference when making the transfer</p>
                            </div>
                        `,
                        showCancelButton: true,
                        confirmButtonText: 'Transfer has been made'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            handleBankTransferConfirmation(bookingId);
                        }
                    });
                    break;
            }
        }

        function handleBankTransferConfirmation(bookingId) {
            Swal.fire({
                title: 'Transfer Confirmation',
                text: 'Your transfer will be verified by our team',
                icon: 'info',
                confirmButtonText: 'OK'
            }).then(() => {
                location.reload();
            });
        }

        function completeBooking(bookingId, paymentStatus) {
            if (paymentStatus === 'not_paid') {
                Swal.fire({
                    title: 'Cannot Complete Booking',
                    text: 'Payment must be received before completing the booking',
                    icon: 'error',
                    confirmButtonColor: '#d33'
                });
                return;
            } else if (paymentStatus === 'paid') {        
                Swal.fire({
                    title: 'Complete Booking',
                    text: 'Are you sure you want to complete this booking?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, complete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: 'complete_booking.php',
                            method: 'POST',
                            data: { booking_id: bookingId },
                            success: function(response) {
                                Swal.fire({
                                    title: 'Completed!',
                                    text: 'Booking has been completed successfully',
                                    icon: 'success',
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    location.reload();
                                });
                            }
                        });
                    }
                });
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
                window.location.href = 'attendant_dashboard.php';
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

</body>
</html>
