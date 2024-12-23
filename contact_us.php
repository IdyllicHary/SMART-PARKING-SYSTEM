<?php
include 'config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Smart Parking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            background-image: url('assets/images/parking-bg.jpeg');
            background-size: cover;
            min-height: 100vh;
        }
        .contact-container {
            background: rgba(255,255,255,0.95);
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 0 20px rgba(0,0,0,0.2);
            margin-top: 50px;
            margin-bottom: 50px;
        }
        .contact-info {
            background: #3498db;
            color: white;
            padding: 30px;
            border-radius: 10px;
            height: 100%;
        }
        .contact-form input, .contact-form textarea {
            padding: 12px;
            border-radius: 8px;
            border: 2px solid #e0e0e0;
            transition: all 0.3s ease;
            margin-bottom: 20px;
        }
        .contact-form input:focus, .contact-form textarea:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }
        .contact-icon {
            font-size: 24px;
            margin-right: 15px;
            color: white;
        }
        .info-item {
            margin-bottom: 25px;
        }
        .btn-submit {
            background: #3498db;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }
        .btn-submit:hover {
            background: #2980b9;
            transform: translateY(-2px);
        }
        .section-title {
            color: #2c3e50;
            margin-bottom: 30px;
            font-weight: 600;
        }
        .map-container {
            border-radius: 10px;
            overflow: hidden;
            margin-top: 20px;
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
                        <a class="nav-link text-white" href="user_dashboard.php">
                        <i class="fas fa-home"></i> Home
                    </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="about.php">
                            <i class="fas fa-info-circle"></i> About
                    </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="contact-container">
            <div class="row">
                <!-- Contact Form -->
                <div class="col-lg-7 pe-lg-5">
                    <h2 class="section-title">Get In Touch</h2>
                    <form class="contact-form" id="contactForm">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Your Name" required>
                            </div>
                            <div class="col-md-6">
                                <input type="email" class="form-control" placeholder="Your Email" required>
                            </div>
                        </div>
                        <input type="text" class="form-control" placeholder="Subject" required>
                        <textarea class="form-control" rows="5" placeholder="Your Message" required></textarea>
                        <button type="submit" class="btn btn-submit">
                            <i class="fas fa-paper-plane me-2"></i>Send Message
                        </button>
                    </form>
                </div>

                <!-- Contact Information -->
                <div class="col-lg-5 mt-4 mt-lg-0">
                    <div class="contact-info">
                        <h3 class="mb-4">Contact Information</h3>
                        <div class="info-item">
                            <i class="fas fa-map-marker-alt contact-icon"></i>
                            <span>123 Parking Street, Nairobi, Kenya</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-phone contact-icon"></i>
                            <span>+254 712 345 678</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-envelope contact-icon"></i>
                            <span>info@smartparking.co.ke</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-clock contact-icon"></i>
                            <span>24/7 Operation Hours</span>
                        </div>
                        <div class="social-links mt-4">
                            <h4 class="mb-3">Follow Us</h4>
                            <a href="#" class="text-white me-3"><i class="fab fa-facebook-f fa-lg"></i></a>
                            <a href="#" class="text-white me-3"><i class="fab fa-twitter fa-lg"></i></a>
                            <a href="#" class="text-white me-3"><i class="fab fa-instagram fa-lg"></i></a>
                            <a href="#" class="text-white"><i class="fab fa-linkedin-in fa-lg"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Google Maps -->
            <div class="map-container mt-5">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.819917806928!2d36.8170146!3d-1.2830973!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMcKwMTYnNTkuMiJTIDM2wrA0OScwMS4zIkU!5e0!3m2!1sen!2ske!4v1635444444444!5m2!1sen!2ske" 
                    width="100%" 
                    height="400" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy">
                </iframe>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#contactForm').on('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Thank You!',
                    text: 'Your message has been sent successfully.',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                });
                this.reset();
            });
        });
    </script>
</body>
</html>
