<?php
require_once 'config.php';
requireLogin();

if (!isset($_GET['id'])) {
    header("Location: view_donors.php");
    exit();
}

$donor_id = clean($_GET['id']);

$sql = "DELETE FROM donors WHERE id = '$donor_id'";

if (mysqli_query($conn, $sql)) {
    $_SESSION['message'] = 'Donor deleted successfully!';
} else {
    $_SESSION['error'] = 'Error deleting donor: ' . mysqli_error($conn);
}

header("Location: view_donors.php");
exit();
?>