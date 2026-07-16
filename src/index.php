<?php
require_once 'config.php';

$searchBlood = isset($_GET['blood']) ? clean($_GET['blood']) : '';
$searchCity = isset($_GET['city']) ? clean($_GET['city']) : '';
$searchName = isset($_GET['name']) ? clean($_GET['name']) : '';

$sql = "SELECT * FROM donors WHERE 1=1";
if ($searchBlood) $sql .= " AND blood_group = '$searchBlood'";
if ($searchCity) $sql .= " AND city LIKE '%$searchCity%'";
if ($searchName) $sql .= " AND name LIKE '%$searchName%'";
$sql .= " ORDER BY created_at DESC";

$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Donor Finder</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="home-container">
    <div class="container">
        <header class="home-header">
            <h1>🩸Blood Donor Finder</h1>
            <p class="tagline">Find blood donors in your city instantly</p>
            <a href="login.php" class="admin-link">Admin Login</a>
        </header>
        
        <div class="search-box">
            <h2>Search Donors</h2>
            <form method="GET" class="search-form">
                <select name="blood">
                    <option value="">All Blood Groups</option>
                    <option value="A+" <?= $searchBlood == 'A+' ? 'selected' : '' ?>>A+</option>
                    <option value="A-" <?= $searchBlood == 'A-' ? 'selected' : '' ?>>A-</option>
                    <option value="B+" <?= $searchBlood == 'B+' ? 'selected' : '' ?>>B+</option>
                    <option value="B-" <?= $searchBlood == 'B-' ? 'selected' : '' ?>>B-</option>
                    <option value="O+" <?= $searchBlood == 'O+' ? 'selected' : '' ?>>O+</option>
                    <option value="O-" <?= $searchBlood == 'O-' ? 'selected' : '' ?>>O-</option>
                    <option value="AB+" <?= $searchBlood == 'AB+' ? 'selected' : '' ?>>AB+</option>
                    <option value="AB-" <?= $searchBlood == 'AB-' ? 'selected' : '' ?>>AB-</option>
                </select>
                
                <input type="text" name="city" placeholder="City" value="<?= $searchCity ?>">
                <input type="text" name="name" placeholder="Donor Name" value="<?= $searchName ?>">
                
                <button type="submit" class="btn btn-search">🔍 Search</button>
                <a href="index.php" class="btn btn-reset">Reset</a>
            </form>
        </div>
        
        <div class="donors-grid">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($donor = mysqli_fetch_assoc($result)): ?>
                    <div class="donor-card">
                        <div class="blood-badge"><?= $donor['blood_group'] ?></div>
                        <div class="donor-name"><?= htmlspecialchars($donor['name']) ?></div>
                        <div class="donor-info">👤 <?= $donor['age'] ?> years • <?= $donor['gender'] ?></div>
                        <div class="donor-info">📍 <?= $donor['city'] ?></div>
                        
                        <div class="donor-contact">
                            <div class="donor-info">📞 <?= $donor['contact'] ?></div>
                            <?php if ($donor['email']): ?>
                                <div class="donor-info">📧 <?= $donor['email'] ?></div>
                            <?php endif; ?>
                            <a href="tel:<?= $donor['contact'] ?>" class="contact-btn">Call Now</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="no-results">
                    <h2>No donors found</h2>
                    <p>Try adjusting your search filters</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <script src="script.js"></script>
</body>
</html>