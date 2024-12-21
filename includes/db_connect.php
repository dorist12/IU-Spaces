<?php
$servername = "localhost";
$username = "root";
$password = ""; // Use your MySQL password if set
$dbname = "final_iuspaces"; // Correct database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Database connection successful!";
}
?>
