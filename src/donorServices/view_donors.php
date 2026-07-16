<?php
require_once 'config.php';
requireLogin();

$sql = "SELECT * FROM donors ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Donors</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar">
        <h1>All Donors</h1>
        <a href="dashboard.php" class="btn-back">← Back</a>
    </nav>
    
    <div class="container">
        <div class="table-card">
            <h2>📋 Registered Donors</h2>
            
            <div class="stats">
                Total Donors: <strong><?= mysqli_num_rows($result) ?></strong>
            </div>
            
            <?php if (mysqli_num_rows($result) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Blood</th>
                            <th>Age</th>
                            <th>Gender</th>
                            <th>Contact</th>
                            <th>City</th>
                            <th>Last Donation</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($donor = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?= $donor['id'] ?></td>
                                <td><strong><?= htmlspecialchars($donor['name']) ?></strong></td>
                                <td><span class="blood-badge"><?= $donor['blood_group'] ?></span></td>
                                <td><?= $donor['age'] ?></td>
                                <td><?= $donor['gender'] ?></td>
                                <td><?= $donor['contact'] ?></td>
                                <td><?= $donor['city'] ?></td>
                                <td><?= $donor['last_donation_date'] ?: 'N/A' ?></td>
                                <td>
                                    <a href="edit_donor.php?id=<?= $donor['id'] ?>" class="action-btn btn-edit">Edit</a>
                                    <a href="delete_donor.php?id=<?= $donor['id'] ?>" class="action-btn btn-delete">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="no-data">No donors found.</div>
            <?php endif; ?>
        </div>
    </div>
    
    <script src="script.js"></script>
</body>
</html>