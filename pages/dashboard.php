<?php
include '../includes/db_connect.php'; // Include the database connection
include '../includes/header.php';    // Include the header

// Fetch issue statistics
$total_issues = $conn->query("SELECT COUNT(*) AS count FROM issues")->fetch_assoc()['count'];
$open_issues = $conn->query("SELECT COUNT(*) AS count FROM issues WHERE status='Open'")->fetch_assoc()['count'];
$closed_issues = $conn->query("SELECT COUNT(*) AS count FROM issues WHERE status='Closed'")->fetch_assoc()['count'];
?>

<h2 style="color: #4CAF50; text-align: center; margin-top: 20px;">Dashboard</h2>

<div style="width: 90%; margin: 20px auto; display: flex; justify-content: space-around; gap: 20px; flex-wrap: wrap;">
    <!-- Total Issues Card -->
    <div style="flex: 1; min-width: 250px; padding: 20px; background-color: #f1f1f1; text-align: center; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        <h3 style="color: #333;">Total Issues</h3>
        <p style="font-size: 2em; font-weight: bold; color: #4CAF50;"><?= $total_issues ?></p>
    </div>

    <!-- Open Issues Card -->
    <div style="flex: 1; min-width: 250px; padding: 20px; background-color: #f1f1f1; text-align: center; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        <h3 style="color: #333;">Open Issues</h3>
        <p style="font-size: 2em; font-weight: bold; color: #ff9800;"><?= $open_issues ?></p>
    </div>

    <!-- Closed Issues Card -->
    <div style="flex: 1; min-width: 250px; padding: 20px; background-color: #f1f1f1; text-align: center; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        <h3 style="color: #333;">Closed Issues</h3>
        <p style="font-size: 2em; font-weight: bold; color: #f44336;"><?= $closed_issues ?></p>
    </div>
</div>

<?php include '../includes/footer.php'; // Include the footer ?>
