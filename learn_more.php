<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learn More - Smart Parking System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  
    <style>
        .content-section {
            padding: 80px 0;
            background: #f8f9fa;
        }
        .back-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
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
    <nav class="navbar navbar-expand-lg" style="background-color: #3498db;">
        <div class="container">
            <a class="navbar-brand text-white" href="index.php">Smart Parking System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="index.php">
                            <i class="fas fa-home"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="about_us.php">
                            <i class="fas fa-info-circle"></i> About
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="login.php">
                            <i class="fas fa-sign-in-alt"></i>Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="register.php">
                            <i class="fas fa-user-plus"></i>Register
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="content-section">
        <div class="container">
            <h2 class="mb-4">About Our Smart Parking System</h2>
            <div class="row">
                <div class="col-md-8">
                    <h4>Modern Parking Solutions</h4>
                    <p>Our smart parking system revolutionizes the way you park your vehicle. Using cutting-edge technology, we provide real-time parking availability, secure booking systems, and hassle-free payment options.</p>
                    
                    <h4>Key Benefits</h4>
                    <ul>
                        <li>Real-time parking spot availability</li>
                        <li>Secure and monitored parking areas</li>
                        <li>Easy online booking system</li>
                        <li>24/7 customer support</li>
                        <li>Multiple payment options</li>
                        <li>Automated entry and exit</li>
                    </ul>
                    
                    <h4>Technology Features</h4>
                    <p>Our system integrates IoT sensors, mobile applications, and secure payment gateways to provide a seamless parking experience. Users can easily find, book, and pay for parking spots through our user-friendly interface.</p>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Ready to Start?</h5>
                            <p class="card-text">Join our smart parking community today and experience hassle-free parking.</p>
                            <a href="register.php" class="btn btn-primary">Register Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section class="process-section py-4">
            <div class="container">
                <h2 class="text-center mb-4">How It Works</h2>
                <div class="row justify-content-between">
                    <div class="col">
                        <div class="step">
                            <span class="step-number">1</span>
                            <h5>Register</h5>
                            <small>Create account</small>
                        </div>
                    </div>
                    <div class="col">
                        <div class="step">
                            <span class="step-number">2</span>
                            <h5>Search</h5>
                            <small>Find spots</small>
                        </div>
                    </div>
                    <div class="col">
                        <div class="step">
                            <span class="step-number">3</span>
                            <h5>Book</h5>
                            <small>Reserve spot</small>
                        </div>
                    </div>
                    <div class="col">
                        <div class="step">
                            <span class="step-number">4</span>
                            <h5>Park</h5>
                            <small>Easy parking</small>
                        </div>
                    </div>
                    <div class="col">
                        <div class="step">
                            <span class="step-number">5</span>
                            <h5>Pay</h5>
                            <small>Pay securely</small>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Add this right after your process section -->
        <section class="contact-section">
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
                            <span>2046 JuaKali Street, Embakasi, Nairobi, Kenya</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-phone contact-icon"></i>
                            <span>+254 768 862 031</span>
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
                            <a href="https://wa.me/+254768195160" class="text-white me-3"><i class="fab fa-whatsapp fa-lg"></i></a>
                            <a href="#" class="text-white me-3"><i class="fab fa-facebook-f fa-lg"></i></a>
                            <a href="#" class="text-white me-3"><i class="fab fa-twitter fa-lg"></i></a>
                            <a href="#" class="text-white me-3"><i class="fab fa-instagram fa-lg"></i></a>
                            <a href="#" class="text-white me-3"><i class="fab fa-linkedin-in fa-lg"></i></a>
                            <a href="#" class="text-white me-3"><i class="fab fa-github fa-lg"></i></a>
                            <a href="#" class="text-white me-3"><i class="fab fa-discord fa-lg"></i></a>
                            <a href="https://t.me/idyllichary" class="text-white me-3"><i class="fab fa-telegram fa-lg"></i></a>
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

        </section>
    </div>

    <a href="index.php" class="btn btn-primary back-button">
        <i class="fas fa-arrow-left"></i> Back to Home
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
