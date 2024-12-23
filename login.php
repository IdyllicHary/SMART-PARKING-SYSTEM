<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Selection - Smart Parking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4/bootstrap-4.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 
    <link href="assets/css/notifications.css" rel="stylesheet">
    <script src="assets/js/notifications.js"></script>
    <style>
        body {
            background-image: url('assets/images/parking-bg.jpeg');
            background-size: cover;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .login-container {
            background: rgba(255,255,255,0.95);
            border-radius: 15px;
            padding: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.2);
        }
        .login-option {
            border: 2px solid #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin: 10px 0;
            transition: all 0.3s ease;
            background: rgba(173, 216, 230, 0.5);
        }
        .login-option:hover {
            border-color: #3498db;
            transform: translateY(-5px);
            background: rgba(52, 152, 219, 0.5);
        }
        .icon-container {
            font-size: 2.5rem;
            color: #3498db;
            margin-bottom: 15px;
        }
        .info-box {
        padding: 20px;
        background: rgba(52, 152, 219, 0.1);
        border-radius: 8px;
        margin-bottom: 20px;
        }
        .info-box i {
            font-size: 2rem;
            color: #3498db;
        }
        .info-box h5 {
            color: #2c3e50;
        }
        .info-box p {
            font-size: 0.9rem;
            color: #7f8c8d;
        }
        .btn-lg {
            padding: 12px 30px;
            font-size: 1.1rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .btn-lg:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="login-container">
                    <h2 class="text-center mb-4">Welcome Back!</h2>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="login-option text-center">
                                <div class="icon-container">
                                    <i class="fas fa-user-circle"></i>
                                </div>
                                <h4>User Login</h4>
                                <p>Find and book your parking spot</p>
                                <a href="user_login.php" class="btn btn-primary">
                                    <i class="fas fa-sign-in-alt"></i> Login as User
                                </a>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="login-option text-center">
                                <div class="icon-container">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                                <h4>Attendant Login</h4>
                                <p>Manage parking operations</p>
                                <a href="attendant_login.php" class="btn btn-primary">
                                    <i class="fas fa-sign-in-alt"></i> Login as Attendant
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="additional-info mt-5">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="info-box text-center">
                                    <i class="fas fa-shield-alt mb-3"></i>
                                    <h5>Smart Parking</h5>
                                    <p>Advanced technology for seamless parking experience</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-box text-center">
                                    <i class="fas fa-clock mb-3"></i>
                                    <h5>Quick Booking</h5>
                                    <p>Reserve your spot in less than 60 seconds</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-box text-center">
                                    <i class="fas fa-headset mb-3"></i>
                                    <h5>24/7 Support</h5>
                                    <p>Our team is always here to help you</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <p>Don't have an account? <a href="register.php">Register Now</a></p>
                        <a href="index.php" class="btn btn-primary btn-lg mt-2">
                            <i class="fas fa-home"></i> Back to Home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if(isset($_GET['success']) && $_GET['success'] === 'password_updated'): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Password Updated Successfully!',
                text: 'You can now login with your new password',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false
            }).then(function() {
                window.location.href = 'login.php';
            });
        </script>
    <?php endif; ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Clear URL parameters
            window.history.replaceState(null, null, window.location.pathname);
            
            // Remove any existing error alerts
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.remove();
                }, 100);
            });
        });
    </script>

    <?php if(isset($_GET['success']) && $_GET['success'] === 'account_deleted'): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Account Deleted Successfully',
                text: 'Thank you for using Smart Parking. You are welcome to create a new account anytime!',
                timer: 5000,
                timerProgressBar: true
            });
        </script>
    <?php endif; ?>
</body>
</html>
