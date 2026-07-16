<?php
require_once 'config.php';
requireLogin();

$totalDonors = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM donors"))['count'];
$bloodGroups = mysqli_query($conn, "SELECT blood_group, COUNT(*) as count FROM donors GROUP BY blood_group ORDER BY blood_group");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar">
        <h1>🩸Blood Donor Admin Panel</h1>
        <div class="navbar-right">
            <span>Welcome, <?= $_SESSION['admin_username'] ?></span>
            <a href="logout.php" class="logout-link">Logout</a>
        </div>
    </nav>
    
    <div class="container">
        <div class="card">
            <h2>Total Donors</h2>
            <div class="stat-number"><?= $totalDonors ?></div>
        </div>
        
        <div class="card">
            <h2>Blood Group Distribution</h2>
            <div class="blood-stats">
                <?php while ($group = mysqli_fetch_assoc($bloodGroups)): ?>
                    <div class="blood-item">
                        <strong><?= $group['blood_group'] ?></strong>
                        <span><?= $group['count'] ?> donors</span>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
        
        <div class="card">
            <h2>Quick Actions</h2>
            <div class="menu-links">
                <a href="add_donor.php" class="menu-link">➕ Add New Donor</a>
                <a href="view_donors.php" class="menu-link">👥 View All Donors</a>
                <a href="index.php" class="menu-link" target="_blank">🌐 View Public Site</a>
            </div>
        </div>
    </div>
    
    <script src="script.js"></script>
</body>
</html>