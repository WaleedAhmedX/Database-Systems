<?php
require_once 'config.php';
requireLogin();

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = clean($_POST['name']);
    $blood_group = clean($_POST['blood_group']);
    $age = clean($_POST['age']);
    $gender = clean($_POST['gender']);
    $contact = clean($_POST['contact']);
    $email = clean($_POST['email']);
    $city = clean($_POST['city']);
    $address = clean($_POST['address']);
    $last_donation = !empty($_POST['last_donation']) ? clean($_POST['last_donation']) : NULL;
    

    $admin_id = $_SESSION['admin_id'];
    
    if ($last_donation === NULL) {
        $sql = "INSERT INTO donors (name, blood_group, age, gender, contact, email, city, address, admin_id) 
                VALUES ('$name', '$blood_group', '$age', '$gender', '$contact', '$email', '$city', '$address', '$admin_id')";
    } else {
        $sql = "INSERT INTO donors (name, blood_group, age, gender, contact, email, city, address, last_donation_date, admin_id) 
                VALUES ('$name', '$blood_group', '$age', '$gender', '$contact', '$email', '$city', '$address', '$last_donation', '$admin_id')";
    }
    
    if (mysqli_query($conn, $sql)) {
        $message = showSuccess('Donor added successfully!');
    } else {
        $message = showError('Error: ' . mysqli_error($conn));
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Donor</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar">
        <h1>Add New Donor</h1>
        <a href="dashboard.php" class="btn-back">← Back</a>
    </nav>
    
    <div class="container">
        <div class="form-card">
            <h2>➕ Donor Registration Form</h2>
            
            <?= $message ?>
            
            <form method="POST">
                <div class="form-grid">
                    <div class="form-group full-width">
                        <label>Full Name *</label>
                        <input type="text" name="name" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Blood Group *</label>
                        <select name="blood_group" required>
                            <option value="">Select</option>
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Age *</label>
                        <input type="number" name="age" min="18" max="65" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Gender *</label>
                        <select name="gender" required>
                            <option value="">Select</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Contact Number *</label>
                        <input type="text" name="contact" placeholder="0300-1234567" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" placeholder="example@email.com">
                    </div>
                    
                    <div class="form-group">
                        <label>City *</label>
                        <input type="text" name="city" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Last Donation Date</label>
                        <input type="date" name="last_donation">
                    </div>
                    
                    <div class="form-group full-width">
                        <label>Address *</label>
                        <textarea name="address" required></textarea>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-submit">Add Donor</button>
            </form>
        </div>
    </div>
    
    <script src="script.js"></script>
</body>
</html>