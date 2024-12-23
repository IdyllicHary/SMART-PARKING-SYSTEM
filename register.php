<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Smart Parking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4/bootstrap-4.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('assets/images/parking-bg.jpeg');
            background-size: cover;
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 40px 0;
        }
        .register-container {
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
        .btn-register {
            padding: 12px 30px;
            font-size: 1.1rem;
            border-radius: 8px;
            background: #3498db;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        .btn-register:hover {
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
        .input-group {
            position: relative;
        }

        .input-group label {
            position: absolute;
            left: 45px;
            top: 12px;
            transition: all 0.2s ease;
            color: #6c757d;
            padding: 2px 5px;
            pointer-events: none;
            font-size: 16px;
            z-index: 4;
            line-height: 1;
        }

        .input-group input:focus ~ label,
        .input-group input:not(:placeholder-shown) ~ label {
            top: -18px;
            left: 45px;
            font-size: 14px;
            color: #007bff;
            background: none;
            z-index: 4;
            padding: 2px 5px;
            line-height: 1;
        }
        .input-group select:focus ~ label,
        .input-group select:valid ~ label {
            top: -18px;
            left: 45px;
            font-size: 14px;
            color: #007bff;
            background: none;
            z-index: 4;
            padding: 2px 5px;
            line-height: 1;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="register-container">
                <div class="text-center welcome-text">
                        <h2><i class="fas fa-user-plus fa-2x mb-3"></i></h2>
                        <h3>Create Account</h3>
                        <p>Join our parking community today</p>
                </div>    
                    <form action="register_process.php" method="POST">
                    <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input type="text" name="name" class="form-control" placeholder="" required>
                                <label>Full Name</label>
                            </div>
                    </div>
                    <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input type="email" name="email" class="form-control" placeholder="" required>
                                <label>Email Address</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-phone"></i>
                                </span>
                                <input type="tel" name="phone" class="form-control" placeholder="" required>
                                <label>Phone Number</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-id-card"></i>
                                </span>
                                <input type="text" name="id_number" class="form-control" placeholder="" required>
                                <label>ID Number</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-car"></i>
                                </span>
                                <input type="text" name="vehicle_reg" class="form-control" placeholder="" required>
                                <label>Vehicle Registration Number</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-truck"></i>
                                </span>
                                <select class="form-control" name="vehicle_type" required>
                                    <option value="" selected disabled></option>
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
                                <label>Vehicle Type</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" name="password" class="form-control" id="password" placeholder="" required>
                                <label>Password</label>
                                <span class="input-group-text border-start-0" style="background: transparent; cursor: pointer; margin-left: -40px; z-index: 10;" onclick="togglePassword('password')">
                                    <i class="fas fa-eye" id="password-eye"></i>
                                </span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" name="confirm_password" class="form-control" id="confirmpassword" placeholder="" required>
                                <label>Confirm Password</label>
                                <span class="input-group-text border-start-0" style="background: transparent; cursor: pointer; margin-left: -40px; z-index: 10;" onclick="togglePassword('confirmpassword')">
                                    <i class="fas fa-eye" id="confirm_password-eye"></i>
                                </span>
                            </div>
                        </div>

                        <div class="d-grid gap-2 mb-4">
                            <button type="submit" name="register" class="btn btn-primary btn-register">
                                <i class="fas fa-user-plus"></i> Create Account
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-3">
                        <p>Already have an account? <a href="user_login.php">Login here</a></p>
                        <a href="login.php" class="btn btn-primary btn-lg">
                            <i class="fas fa-arrow-left"></i> Back to Login Options
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
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

    <?php if(isset($_GET['error'])): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Registration Failed',
                text: <?php 
                    if($_GET['error'] === 'passwords_dont_match') {
                        echo '"Passwords do not match!"';
                    } elseif($_GET['error'] === 'email_exists') {
                        echo '"This email is already registered!"';
                    } elseif($_GET['error'] === 'invalid_phone') {
                        echo '"Please enter a valid phone number! \n Phone number must be 10 digits!"';
                    } elseif($_GET['error'] === 'invalid_id') {
                        echo '"Please enter a valid ID number! \n ID number must be 8 digits!"';
                    } else {
                        echo '"Registration failed. Please try again."';
                    } 
                ?>,
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false,
            }).then(function() {
                window.location = 'register.php';
            });
        </script>
    <?php endif; ?>

    <?php if(isset($_GET['success'])): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Registration Successful!',
                text: 'You can now login to your account',
                timer: 2000,
                timerProgressBar: true,
                showConfirmButton: false,
                position: 'top-end',
                toast: true
            }).then(function() {
                window.location = 'user_login.php';
            });
        </script>
    <?php endif; ?>
   
</body>
</html>
