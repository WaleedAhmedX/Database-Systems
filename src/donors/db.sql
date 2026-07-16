CREATE DATABASE blood_donor_system;
USE blood_donor_system;

-- Admins Table
CREATE TABLE admins (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Donors Table
CREATE TABLE donors (
    id INT PRIMARY KEY AUTO_INCREMENT,
    admin_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    blood_group VARCHAR(5) NOT NULL,
    age INT NOT NULL CHECK (age >= 18),
    gender VARCHAR(10) NOT NULL CHECK (gender IN ('Male','Female','Other')),
    contact VARCHAR(15) NOT NULL,
    email VARCHAR(100),
    city VARCHAR(50) NOT NULL,
    address TEXT NOT NULL,
    last_donation_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (admin_id) REFERENCES admins(id)
);


INSERT INTO admins (username, password) VALUES 
('admin', 'admin123');


INSERT INTO donors (name, blood_group, age, gender, contact, email, city, address, last_donation_date, admin_id) VALUES
('Ahmed Ali', 'A+', 28, 'Male', '0300-1234567', 'ahmed@email.com', 'Rawalpindi', 'Satellite Town, Rawalpindi', '2024-10-15', 1),
('Fatima Khan', 'B+', 25, 'Female', '0301-2345678', 'fatima@email.com', 'Islamabad', 'F-7, Islamabad', '2024-09-20', 1),
('Hassan Raza', 'O+', 32, 'Male', '0302-3456789', 'hassan@email.com', 'Rawalpindi', 'Saddar, Rawalpindi', '2024-11-01', 1),
('Ayesha Malik', 'AB+', 29, 'Female', '0303-4567890', 'ayesha@email.com', 'Islamabad', 'G-11, Islamabad', '2024-08-10', 1),
('Usman Sheikh', 'A-', 35, 'Male', '0304-5678901', 'usman@email.com', 'Rawalpindi', 'Commercial Market, Rawalpindi', '2024-10-25', 1);