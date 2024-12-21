<?php
include 'db_connect.php'; // No need for 'includes/' prefix
if ($conn) {
    echo "Database connection successful!";
} else {
    echo "Database connection failed!";
}
?>
