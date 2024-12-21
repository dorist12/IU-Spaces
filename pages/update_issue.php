<?php
include '../includes/db_connect.php'; // Include the database connection

// Check if an ID is provided
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Ensure ID is an integer

    // Update the status of the issue
    $sql = "UPDATE issues SET status='Closed' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        // Redirect back to the view issues page
        header("Location: view_issues.php");
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    echo "No issue ID provided.";
}
?>
