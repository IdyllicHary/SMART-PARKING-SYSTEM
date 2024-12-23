<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Parking System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4/bootstrap-4.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('assets/images/parking-bg.jpeg');
            background-size: cover;
            color: white;
            padding: 80px 0;
            text-align: center;
            min-height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hero-content {
            max-width: 800px;
            margin: 0 auto;
        }

        .hero-section h1 {
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
            text-transform: uppercase;
            font-weight: bold;
        }

        .hero-section p {
            font-size: 1.5rem;
            margin-bottom: 2rem;
        }

        .cta-buttons .btn {
            margin: 0 10px;
            padding: 12px 30px;
            font-size: 1.2rem;
            text-transform: uppercase;
            font-weight: 500;
        }

        .stats-section {
            background: rgba(173, 216, 230, 1);
            padding: 12px 0;
        }

        .stats-section h2 {
            font-size: 2.5rem;
            font-weight: bold;
            color: #3498db;
            margin-bottom: 10px;
        }

        .stats-section p {
            font-size: 1.2rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #003366;
            font-weight: bold;
        }
        .parking-loader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('assets/images/parking-bg.jpeg');
    background-size: cover;
    background-position: center;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 99999;
}

.modern-car {
    position: relative;
    width: 120px;
    height: 40px;
    animation: carParking 2.5s infinite;
}

.car-body {
    background: #2c3e50;
    height: 100%;
    border-radius: 25px;
    position: relative;
}

.windshield {
    position: absolute;
    width: 40%;
    height: 60%;
    background: #3498db;
    top: -30%;
    left: 30%;
    border-radius: 10px;
    transform: skew(-15deg);
}

.headlight {
    position: absolute;
    width: 8px;
    height: 8px;
    background: #f1c40f;
    border-radius: 50%;
    top: 40%;
}

.headlight.left { left: 5px; }
.headlight.right { right: 5px; }

.wheel {
    position: absolute;
    width: 20px;
    height: 20px;
    background: #34495e;
    border: 3px solid #95a5a6;
    border-radius: 50%;
    bottom: -10px;
    animation: wheelRotate 1s infinite linear;
}

.wheel.front { left: 15px; }
.wheel.rear { right: 15px; }

.parking-spot {
    position: absolute;
    width: 200px;
    height: 100px;
    border: 4px solid #ff0000;
    border-radius: 10px;
}

.p-sign {
    position: absolute;
    top: -50px;
    left: 50%;
    transform: translateX(-50%);
    color: #ff0000;
    font-size: 30px;
    font-weight: bold;
    animation: signGlow 1.5s infinite;
}

@keyframes carParking {
    0% { transform: translateX(-150px); }
    45% { transform: translateX(0); }
    50% { transform: translateX(5px); }
    55% { transform: translateX(0); }
    100% { transform: translateX(0); }
}

@keyframes wheelRotate {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

@keyframes signGlow {
    0%, 100% { text-shadow: 0 0 10px #ff0000; }
    50% { text-shadow: 0 0 20px #ff0000, 0 0 30px #ff0000; }
}

    </style>
</head>
<body onload="showLoader()">
    <div class="parking-loader" style="display:flex;">
        <div class="modern-car">
            <div class="car-body">
                <div class="windshield"></div>
                <div class="hood"></div>
                <div class="roof"></div>
                <div class="trunk"></div>
                <div class="headlight left"></div>
                <div class="headlight right"></div>
                <div class="taillight left"></div>
                <div class="taillight right"></div>
            </div>
            <div class="wheel front"></div>
            <div class="wheel rear"></div>
        </div>
        <div class="parking-spot">
            <div class="lines"></div>
            <div class="p-sign">P</div>
        </div>
    </div>

    <div class="hero-section">
        <div class="hero-content">
            <h1>Smart Parking Solutions</h1>
            <h2>Welcome to Smart Parking</h2>
            <p>Find and reserve your parking spot in seconds</p>
            <div class="cta-buttons">
                <a href="user_login.php" class="btn btn-primary btn-lg">Book Now</a>
                <a href="attendant_login.php" class="btn btn-primary btn-lg">Attend Booking</a><br><br>
                <a href="learn_more.php" class="btn btn-outline-light btn-lg">Learn More</a>
            </div>
        </div>
    </div>

    <section class="stats-section text-white">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3">
                    <h2><span class="parking-count">0</span>+</h2>
                    <p>Parking Spots</p>
                </div>
                <div class="col-md-3">
                    <h2><span class="customer-count">0</span>+</h2>
                    <p>Happy Customers</p>
                </div>
                <div class="col-md-3">
                    <h2><span class="attendant-count">0</span>+</h2>
                    <p>Parking Attendants</p>
                </div>
                <div class="col-md-3">
                    <h2><span class="support-count">0</span>/7</h2>
                    <p>Customer Support</p>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function animateValue(element, start, end, duration) {
        let current = start;
        const range = end - start;
        const increment = end > start ? 1 : -1;
        const stepTime = Math.abs(Math.floor(duration / range));
        
        const timer = setInterval(() => {
            current += increment;
            element.textContent = current + (element.dataset.suffix || '');
            if (current == end) {
                clearInterval(timer);
            }
        }, stepTime);
    }

    document.addEventListener('DOMContentLoaded', () => {
        // Parking Spots counter
        animateValue(document.querySelector('.parking-count'), 0, 100, 2000);
        
        // Happy Customers counter
        animateValue(document.querySelector('.customer-count'), 0, 600, 2000);
        
        // Parking Attendants counter
        animateValue(document.querySelector('.attendant-count'), 0, 100, 2000);
        
        // 24/7 counter
        animateValue(document.querySelector('.support-count'), 0, 24, 1000);
    });
    
    </script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const loader = document.querySelector('.parking-loader');
    loader.style.display = 'flex';
    
    setTimeout(function() {
        loader.style.opacity = '0';
        loader.style.transition = 'opacity 1s ease-out';
        
        setTimeout(function() {
            loader.style.display = 'none';
        }, 1000);
    }, 3000);
});
</script>
</body>
</html>
