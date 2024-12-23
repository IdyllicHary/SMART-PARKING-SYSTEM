<?php
include 'config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(isset($_SESSION['admin_id'])) {
    header("Location: admin_dashboard.php");
    exit();
}

if(isset($_GET['error'])) {
    $message = "<script>showError('" . htmlspecialchars($_GET['error']) . "');</script>";
} else if(isset($_GET['success'])) {
    $message = "<script>showSuccess('" . htmlspecialchars($_GET['success']) . "');</script>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Smart Parking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4/bootstrap-4.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        body {
            background-image: url('assets/images/parking-bg.jpeg');
            background-size: cover;
            height: 100vh;
            display: flex;
            align-items: center;
        }
        .login-container {
            background: rgba(255,255,255,0.95);
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 0 20px rgba(0,0,0,0.2);
        }
        .form-control {
            padding: 12px;
            border-radius: 8px;
            border: 2px solid #e0e0e0;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }
        .btn-login {
            padding: 12px 30px;
            font-size: 1.1rem;
            border-radius: 8px;
            background: #3498db;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2);
            background: #2980b9;
        }
        .input-group-text {
            background: rgba(173, 216, 230, 0.2);
            border: 2px solid #e0e0e0;
            border-right: none;
        }
        .welcome-text {
            color: #2c3e50;
            margin-bottom: 30px;
        }
        .admin-icon {
            color: #3498db;
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        .login-form {
            background: rgba(255,255,255,0.9);
            padding: 30px;
            border-radius: 10px;
            margin-top: 100px;
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
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="login-container">
                    <div class="text-center welcome-text">
                        <i class="fas fa-user-shield admin-icon"></i>
                        <h3>Admin Portal</h3>
                        <p>Enter your credentials to access the dashboard</p>
                    </div>

                    <form action="admin_login_process.php" method="POST">
                        <div class="mb-4">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input type="email" name="email" class="form-control" placeholder="Enter admin email" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
                                <span class="input-group-text border-start-0" style="background: transparent; cursor: pointer; margin-left: -40px; z-index: 10;" onclick="togglePassword('password')">
                                    <i class="fas fa-eye" id="password-eye"></i>
                                </span>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" name="login" class="btn btn-primary btn-login">
                                <i class="fas fa-sign-in-alt"></i> Access Dashboard
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <a href="login.php" class="btn btn-primary btn-lg">
                            <i class="fas fa-arrow-left"></i>Login as Other
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <?php if(isset($_GET['error'])): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Login Failed',
            text: <?php
                if($_GET['error'] === 'invalid_password') {
                    echo '"The password you entered is incorrect!"';
                } elseif($_GET['error'] === 'admin_not_found') {
                    echo '"No admin account found with this email!"';
                } else {
                    echo '"Login failed. Please try again."';
                }
            ?>,
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false
        });
    </script>
    <?php endif; ?>

    <?php if(isset($_GET['success'])): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Welcome Admin!',
            text: 'Login successful',
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false
        });
    </script>
    <?php endif; ?>

    <script>
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const eye = document.getElementById(inputId + '-eye');
        
        if (input.type === 'password') {
            input.type = 'text';
            eye.classList.remove('fa-eye');
            eye.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            eye.classList.remove('fa-eye-slash');
            eye.classList.add('fa-eye');
        }
    }
    </script>

</body>
</html>
