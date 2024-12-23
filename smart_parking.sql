CREATE TABLE admin (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL,
    user_type ENUM('admin') DEFAULT 'admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP);

-- Admin table inserts (Password for Admin user: Admin1234)
INSERT INTO admin (name, email, phone, password, user_type) 
VALUES ('Admin', 'admin@smartparking.com', '0768862031', '$2y$10$QGb2qddTdpU.j/w6YQ7U3enHf9y0ELMH2lkKY5aN5UIrVL.7dAFz.', 'admin');


CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20) NOT NULL,
    id_number VARCHAR(20) NOT NULL,
    vehicle_reg VARCHAR(20) NOT NULL,
    vehicle_type VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL,
    user_type ENUM('user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
-- Users table inserts (Password for all users: password123)
INSERT INTO users (name, email, phone, id_number, vehicle_reg, vehicle_type, password, user_type, created_at) VALUES
('Elizabeth Wairimu', 'lizwairimu@gmail.com', '0722123456', '29876543', 'KDD 123A', 'Sedan', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', NOW()),
('Michael Kiprono', 'mkiprono@yahoo.com', '0733234567', '29765432', 'KDE 456B', 'SUV', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', NOW()),
('Jane Atieno', 'jatieno@gmail.com', '0744345678', '29654321', 'KDF 789C', 'Hatchback', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', NOW()),
('Samuel Mwangi', 'smwangi@outlook.com', '0755456789', '29543210', 'KDG 012D', 'Pickup', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', NOW()),
('Catherine Mutua', 'cmutua@gmail.com', '0766567890', '29432109', 'KDH 345E', 'Sedan', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', NOW());


CREATE TABLE attendants (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20) NOT NULL,
    id_number VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL,
    employment_date DATE NOT NULL,
    user_type ENUM('attendant') DEFAULT 'attendant',
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Attendants table inserts (Password for all attendants: password123)
INSERT INTO attendants (name, email, phone, id_number, password, employment_date, status) VALUES
('John Kamau', 'jkamau@smartparking.com', '0712345678', '32145678', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2024-01-15', 'active'),
('Mary Wanjiku', 'mwanjiku@smartparking.com', '0723456789', '32156789', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2024-02-20', 'active'),
('Peter Ochieng', 'pochieng@smartparking.com', '0734567890', '32167890', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2024-03-10', 'active'),
('Sarah Muthoni', 'smuthoni@smartparking.com', '0745678901', '32178901', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2024-04-05', 'active'),
('David Kipchoge', 'dkipchoge@smartparking.com', '0756789012', '32189012', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2024-05-12', 'active'),
('Grace Akinyi', 'gakinyi@smartparking.com', '0767890123', '32190123', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2024-06-18', 'active'),
('Daniel Njoroge', 'dnjoroge@smartparking.com', '0778901234', '32101234', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2024-07-22', 'active'),
('Faith Wambui', 'fwambui@smartparking.com', '0789012345', '32112345', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2024-08-30', 'active'),
('James Omondi', 'jomondi@smartparking.com', '0790123456', '32123456', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2024-09-14', 'active'),
('Lucy Nyambura', 'lnyambura@smartparking.com', '0701234567', '32134567', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2024-10-25', 'active');


CREATE TABLE parking_slots (
    id INT PRIMARY KEY AUTO_INCREMENT,
    slot_number VARCHAR(10) UNIQUE NOT NULL,
    status ENUM('available', 'occupied', 'reserved') DEFAULT 'available',
    price DECIMAL(10,2) NOT NULL,
    location_description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- parking_slots table inserts
INSERT INTO parking_slots (slot_number, status, price, location_description) VALUES
('A1', 'available', 200.00, 'Ground Floor - Near Entrance'),
('A2', 'available', 200.00, 'Ground Floor - Near Elevator'),
('A3', 'available', 200.00, 'Ground Floor - Corner Spot'),
('B1', 'available', 200.00, 'Ground Floor - Near Exit'),
('B2', 'available', 200.00, 'Ground Floor - Central Area'),
('B3', 'available', 200.00, 'Ground Floor - Near Wall'),
('C1', 'available', 200.00, 'Ground Floor - Wide Space'),
('C2', 'available', 200.00, 'Ground Floor - Easy Access'),
('C3', 'available', 200.00, 'Ground Floor - Premium Spot');


CREATE TABLE bookings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    slot_id INT,
    attendant_id INT,
    start_time DATETIME NOT NULL,
    end_time DATETIME,
    amount DECIMAL(10,2),
    status ENUM('active', 'completed', 'cancelled') DEFAULT 'active',
    payment_status ENUM('paid', 'not_paid') DEFAULT 'not_paid',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (slot_id) REFERENCES parking_slots(id) ON DELETE CASCADE,
    FOREIGN KEY (attendant_id) REFERENCES attendants(id) ON DELETE CASCADE
);

-- insert into bookings table
INSERT INTO bookings (user_id, slot_id, attendant_id, start_time, end_time, amount, status, payment_status) VALUES
(1, 1, 1, '2023-11-15 09:00:00', '2023-11-15 11:00:00', 400.00, 'active', 'not_paid'),
(2, 3, 2, '2023-11-15 10:00:00', '2023-11-15 13:00:00', 600.00, 'active', 'not_paid'),
(3, 5, 3, '2023-11-15 11:00:00', '2023-11-15 14:00:00', 600.00, 'active', 'not_paid'),
(4, 7, 4, '2023-11-15 12:00:00', '2023-11-15 15:00:00', 600.00, 'active', 'not_paid'),
(5, 9, 5, '2023-11-15 13:00:00', '2023-11-15 16:00:00', 600.00, 'active', 'not_paid');


CREATE TABLE password_resets (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL,
    token VARCHAR(255) NOT NULL,
    expiry DATETIME NOT NULL,
    used TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE vehicles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    vehicle_reg VARCHAR(50) NOT NULL,
    vehicle_type VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
)
