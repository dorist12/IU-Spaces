<?php
// Start the session and include the database connection file
session_start();
include('../includes/db_connect.php');

// Check if the user is logged in (you can implement this check as needed)
// if (!isset($_SESSION['username'])) {
//     header("Location: login.php");
//     exit();
// }

// Fetch the issues from the database
$sql = "SELECT * FROM issues"; // Modify the query if you want to apply filters
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IU Spaces - View Issues</title>
    <link rel="stylesheet" href="../assets/styles.css"> <!-- Make sure the CSS path is correct -->
</head>
<body>

    <header>
        <nav>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="add_issue.php">Report Issue</a></li>
                <li><a href="view_issues.php">View Issues</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h1>Reported Issues</h1>

        <!-- Search and Filter Section -->
        <div class="search-section">
            <form method="GET" action="view_issues.php">
                <input type="text" name="search" placeholder="Search by building, room number, or description" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                <select name="status_filter">
                    <option value="All Status" <?php if(isset($_GET['status_filter']) && $_GET['status_filter'] == 'All Status') echo 'selected'; ?>>All Status</option>
                    <option value="Open" <?php if(isset($_GET['status_filter']) && $_GET['status_filter'] == 'Open') echo 'selected'; ?>>Open</option>
                    <option value="Closed" <?php if(isset($_GET['status_filter']) && $_GET['status_filter'] == 'Closed') echo 'selected'; ?>>Closed</option>
                </select>
                <button type="submit">Apply Filters</button>
            </form>
        </div>

        <!-- Issues Table -->
        <table class="issues-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Building Name</th>
                    <th>Room Number</th>
                    <th>Issue Description</th>
                    <th>Priority</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    // Check if there are search filters and apply them
                    if (isset($_GET['search']) || isset($_GET['status_filter'])) {
                        $search = $_GET['search'];
                        $status_filter = $_GET['status_filter'];

                        // Modify the query based on search and filter
                        $sql = "SELECT * FROM issues WHERE building_name LIKE '%$search%' OR room_number LIKE '%$search%' OR issue_description LIKE '%$search%'";
                        if ($status_filter != "All Status") {
                            $sql .= " AND status = '$status_filter'";
                        }
                        $result = $conn->query($sql);
                    }

                    // Display issues
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['building_name'] . "</td>";
                        echo "<td>" . $row['room_number'] . "</td>";
                        echo "<td>" . $row['issue_description'] . "</td>";
                        echo "<td>" . $row['priority'] . "</td>";
                        echo "<td>" . $row['status'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No issues reported.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <footer>
        <p>&copy; 2024 IU Spaces. All rights reserved.</p>
    </footer>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
