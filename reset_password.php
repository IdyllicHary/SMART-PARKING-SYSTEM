<?php
include 'config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_GET['token'])) {
    header("Location: login.php");
    exit();
}

$token = $_GET['token'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Set New Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-5">
                    <div class="card-body">
                        <h3 class="text-center">Set New Password</h3>
                        <form action="update_password.php" method="POST">
                            <input type="hidden" name="token" value="<?php echo $token; ?>">
                            <div class="mb-3">
                                <label>New Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Confirm Password</label>
                                <input type="password" name="confirm_password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Password</button>
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
                title: 'Password Reset Failed',
                text: <?php
                    if($_GET['error'] === 'passwords_dont_match') {
                        echo '"The passwords you entered do not match!"';
                    } elseif($_GET['error'] === 'token_expired') {
                        echo '"This reset link has expired. Please request a new one."';
                    } else {
                        echo '"Password reset failed. Please try again."';
                    }
                ?>,
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false
            }).then(function() {
                window.location.href = 'reset_password.php?token=<?php echo $_GET["token"]; ?>';
            });
        </script>
    <?php endif; ?>

</body>
</html>
