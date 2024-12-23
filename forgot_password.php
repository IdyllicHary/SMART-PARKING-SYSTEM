<?php
include 'config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password - Smart Parking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4/bootstrap-4.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-5">
                    <div class="card-body">
                        <h3 class="text-center">Reset Password</h3>
                        <form action="send_reset_link.php" method="POST">
                            <div class="mb-3">
                                <label>Email Address</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Send Reset Link</button>
                            <a href="javascript:history.back()" class="btn btn-secondary">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if(isset($_GET['error'])): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Reset Failed',
                text: <?php
                    if($_GET['error'] === 'email_not_found') {
                        echo '"No account found with this email address!"';
                    } elseif($_GET['error'] === 'invalid_token') {
                        echo '"Invalid or expired reset link. Please try again."';
                    } else {
                        echo '"Password reset failed. Please try again."';
                    }
                ?>,
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false
            }).then(function() {
            window.location.href = 'forgot_password.php';
        });
        </script>
    <?php endif; ?>

    <?php if(isset($_GET['success']) && $_GET['success'] === 'email_sent'): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Reset Link Sent',
                text: 'Please check your email for password reset instructions',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false
            }).then(function() {
            window.location.href = 'login.php';
        });
        </script>
    <?php endif; ?>  

</body>
</html>
