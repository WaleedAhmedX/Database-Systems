<?php
require_once 'config.php';
requireLogin();

if (!isset($_GET['id'])) {
    header("Location: view_donors.php");
    exit();
}

$donor_id = clean($_GET['id']);
$message = '';

$sql = "SELECT * FROM donors WHERE id = '$donor_id'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    header("Location: view_donors.php");
    exit();
}

$donor = mysqli_fetch_assoc($result);

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
    
    if ($last_donation === NULL) {
        $sql = "UPDATE donors SET 
                name = '$name', blood_group = '$blood_group', age = '$age', 
                gender = '$gender', contact = '$contact', email = '$email', 
                city = '$city', address = '$address', last_donation_date = NULL
                WHERE id = '$donor_id'";
    } else {
        $sql = "UPDATE donors SET 
                name = '$name', blood_group = '$blood_group', age = '$age', 
                gender = '$gender', contact = '$contact', email = '$email', 
                city = '$city', address = '$address', last_donation_date = '$last_donation'
                WHERE id = '$donor_id'";
    }
    
    if (mysqli_query($conn, $sql)) {
        $message = showSuccess('Donor updated successfully!');
        $result = mysqli_query($conn, "SELECT * FROM donors WHERE id = '$donor_id'");
        $donor = mysqli_fetch_assoc($result);
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
    <title>Edit Donor</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar">
        <h1>Edit Donor</h1>
        <a href="view_donors.php" class="btn-back">← Back</a>
    </nav>
    
    <div class="container">
        <div class="form-card">
            <h2>✏️ Update Donor Details</h2>
            
            <?= $message ?>
            
            <form method="POST">
                <div class="form-grid">
                    <div class="form-group full-width">
                        <label>Full Name *</label>
                        <input type="text" name="name" value="<?= htmlspecialchars($donor['name']) ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Blood Group *</label>
                        <select name="blood_group" required>
                            <option value="">Select</option>
                            <?php
                            $groups = ['A+','A-','B+','B-','O+','O-','AB+','AB-'];
                            foreach($groups as $g) {
                                $selected = ($donor['blood_group'] == $g) ? 'selected' : '';
                                echo "<option value='$g' $selected>$g</option>";
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Age *</label>
                        <input type="number" name="age" min="18" max="65" value="<?= $donor['age'] ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Gender *</label>
                        <select name="gender" required>
                            <option value="">Select</option>
                            <option value="Male" <?= $donor['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
                            <option value="Female" <?= $donor['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
                            <option value="Other" <?= $donor['gender'] == 'Other' ? 'selected' : '' ?>>Other</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Contact Number *</label>
                        <input type="text" name="contact" value="<?= $donor['contact'] ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="<?= $donor['email'] ?>">
                    </div>
                    
                    <div class="form-group">
                        <label>City *</label>
                        <input type="text" name="city" value="<?= $donor['city'] ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Last Donation Date</label>
                        <input type="date" name="last_donation" value="<?= $donor['last_donation_date'] ?>">
                    </div>
                    
                    <div class="form-group full-width">
                        <label>Address *</label>
                        <textarea name="address" required><?= htmlspecialchars($donor['address']) ?></textarea>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-submit">Update Donor</button>
            </form>
        </div>
    </div>
    
    <script src="script.js"></script>
</body>
</html>