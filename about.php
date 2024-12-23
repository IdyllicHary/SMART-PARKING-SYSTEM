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
    <title>About Us - Smart Parking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            background-image: url('assets/images/parking-bg.jpeg');
            background-size: cover;
            min-height: 100vh;
        }
        .about-container {
            background: rgba(255,255,255,0.95);
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 0 20px rgba(0,0,0,0.2);
            margin: 50px auto;
        }
        .section-title {
            color: #2c3e50;
            margin-bottom: 30px;
            font-weight: 600;
            text-align: center;
        }
        .milestone-card {
            background: #3498db;
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            margin: 10px 0;
            transition: transform 0.3s ease;
        }
        .milestone-card:hover {
            transform: translateY(-5px);
        }
        .milestone-number {
            font-size: 2.5rem;
            font-weight: bold;
        }
        .testimonial-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        }
        .testimonial-img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-bottom: 15px;
        }
        .feature-icon {
            font-size: 40px;
            color: #3498db;
            margin-bottom: 15px;
        }
        .timeline {
            position: relative;
            padding: 20px 0;
        }
        .timeline-item {
            padding: 20px;
            border-left: 3px solid #3498db;
            position: relative;
            margin-bottom: 20px;
        }
        .timeline-item::before {
            content: '';
            position: absolute;
            left: -10px;
            top: 25px;
            width: 20px;
            height: 20px;
            background: #3498db;
            border-radius: 50%;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg" style="background-color: #3498db;">
        <div class="container">
            <a class="navbar-brand text-white" href="index.php">
                <i class="fas fa-parking"></i> Smart Parking
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
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="about-container">
            <!-- Company Overview -->
            <h2 class="section-title">Our Story</h2>
            <div class="row mb-5">
                <div class="col-lg-6">
                    <p>Founded in 2020, Smart Parking emerged from a vision to revolutionize urban parking management in Kenya. Our journey began when a team of innovative engineers, urban planning experts, and tech entrepreneurs came together to address the growing parking challenges in major cities.</p>

                    <p>Starting with a pilot project in Nairobi CBD, we introduced IoT-enabled parking sensors that significantly reduced traffic congestion and carbon emissions. This success caught the attention of major stakeholders, leading to rapid expansion.</p>

                    <p>By 2021, we revolutionized the industry with automated payment systems and digital receipts, earning us the "Tech Innovation of the Year" award. Our expansion in 2022 into major shopping malls and hospitals saw us serving over 100,000 vehicles monthly, reducing average parking search time from 20 minutes to just 3 minutes.</p>

                    <p>In 2023, we integrated advanced IoT sensors for real-time slot monitoring, processing over 50,000 transactions daily with 99.9% uptime. Looking ahead to 2024, we're launching our comprehensive mobile app with real-time parking management system, bringing together AI and user-friendly interfaces.</p>

                    <p>Today, our team has grown from 5 founders to over 200 professionals. We're proud to be recognized as a leader in smart city solutions, with our systems reducing urban carbon emissions by 30% in operational areas. Smart Parking continues to invest in innovation, building the foundation for smarter, more efficient cities of tomorrow.</p>
                </div>
                <div class="col-lg-6">
                    <div class="timeline">
                        <div class="timeline-item">
                            <h5>2020</h5>
                            <p>Company founded with first pilot project in Nairobi CBD</p>
                        </div>
                        <div class="timeline-item">
                            <h5>2021</h5>
                            <p>Expanded to 5 major cities with smart parking technology</p>
                        </div>
                        <div class="timeline-item">
                            <h5>2022</h5>
                            <p>Achieved 1 million successful parking sessions</p>
                        </div>
                        <div class="timeline-item">
                            <h5>2023</h5>
                            <p>Implemented automated payment systems and digital receipts</p>
                        </div>
                        <div class="timeline-item">
                            <h5>2024</h5>
                            <p>Integrated IoT sensors for real-time slot monitoring</p>
                        </div>
                        <div class="timeline-item">
                            <h5>2025</h5>
                            <p>Launching mobile app and real-time parking management system</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Milestones -->
            <h2 class="section-title">Our Impact</h2>
            <div class="row mb-5">
                <div class="col-md-3">
                    <div class="milestone-card">
                        <div class="milestone-number"><span id="milestone1">0</span></div>
                        <div>Parking Sessions</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="milestone-card">
                        <div class="milestone-number"><span id="milestone2">0</span></div>
                        <div>Happy Users</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="milestone-card">
                        <div class="milestone-number"><span id="milestone3">0</span></div>
                        <div>Cities Covered</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="milestone-card">
                        <div class="milestone-number"><span id="milestone4">0</span></div>
                        <div>Customer Satisfaction</div>
                    </div>
                </div>
            </div>

            <!-- Future Vision -->
            <h2 class="section-title">Our Vision for the Future</h2>
            <div class="row mb-5">
                <div class="col-md-4">
                    <div class="text-center">
                        <i class="fas fa-car-battery feature-icon"></i>
                        <h4>EV Integration</h4>
                        <p>Implementing electric vehicle charging stations across our parking locations</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center">
                        <i class="fas fa-robot feature-icon"></i>
                        <h4>AI-Powered Solutions</h4>
                        <p>Developing AI algorithms for predictive parking availability</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center">
                        <i class="fas fa-leaf feature-icon"></i>
                        <h4>Eco-Friendly Parking</h4>
                        <p>Implementing green technologies and sustainable practices</p>
                    </div>
                </div>
            </div>

            <!-- Testimonials -->
            <h2 class="section-title">What Our Users Say</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <img src="assets/images/user1.jpg" alt="User 1" class="testimonial-img">
                        <h5>Stephen Ayiaga</h5>
                        <p class="text-muted">Business Owner</p>
                        <p>"Smart Parking has made finding parking spots in CBD effortless. I save so much time now!"</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <img src="assets/images/user2.jpg" alt="User 2" class="testimonial-img">
                        <h5>Melvin Shiverenje</h5>
                        <p class="text-muted">Regular Commuter</p>
                        <p>"The real-time availability feature is a game-changer. No more driving around looking for parking."</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <img src="assets/images/user3.jpg" alt="User 3" class="testimonial-img">
                        <h5>Hillarry Masambaka</h5>
                        <p class="text-muted">Corporate Manager</p>
                        <p>"The mobile payment system is seamless. Best parking solution I've ever used!"</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function animateValue(element, start, end, duration, isPercentage) {
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            const currentValue = Math.floor(progress * (end - start) + start);
            element.innerHTML = currentValue.toLocaleString() + (isPercentage ? '%' : '+');
            if (progress < 1) {
                window.requestAnimationFrame(step);
            }
        };
        window.requestAnimationFrame(step);
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const milestones = [
                    { id: 'milestone1', end: 500, isPercentage: false }, // 500K+ Parking Sessions
                    { id: 'milestone2', end: 600, isPercentage: false },   // 600+ Happy Users
                    { id: 'milestone3', end: 5, isPercentage: false },      // 5 Cities
                    { id: 'milestone4', end: 99, isPercentage: true }        // 99% Satisfaction
                ];

                milestones.forEach(milestone => {
                    const element = document.getElementById(milestone.id);
                    animateValue(element, 0, milestone.end, 2000, milestone.isPercentage);
                });
                observer.disconnect();
            }
        });
    });

    observer.observe(document.querySelector('.milestone-card'));
</script>


</body>
</html>
