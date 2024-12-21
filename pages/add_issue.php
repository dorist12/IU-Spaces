<?php
include '../includes/db_connect.php'; // Include the database connection
include '../includes/header.php';    // Include the header

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $building_name = htmlspecialchars($_POST['building_name']);
    $room_number = htmlspecialchars($_POST['room_number']);
    $issue_description = htmlspecialchars($_POST['issue_description']);
    $priority = htmlspecialchars($_POST['priority']);

    // Validate inputs
    $errors = [];
    if (empty($building_name) || strlen($building_name) > 50 || !preg_match('/^[A-Za-z0-9\s]+$/', $building_name)) {
        $errors[] = "Building name must be under 50 characters and contain only letters, numbers, and spaces.";
    }
    if (empty($room_number) || strlen($room_number) > 10 || !is_numeric($room_number)) {
        $errors[] = "Room number must be a number and under 10 characters.";
    }
    if (empty($issue_description) || strlen($issue_description) > 255) {
        $errors[] = "Issue description must be under 255 characters.";
    }
    if (empty($priority) || !in_array($priority, ["Low", "Medium", "High"])) {
        $errors[] = "Priority is invalid.";
    }

    // If no errors, insert into the database
    if (empty($errors)) {
        $sql = "INSERT INTO issues (building_name, room_number, issue_description, priority)
                VALUES ('$building_name', '$room_number', '$issue_description', '$priority')";

        if ($conn->query($sql) === TRUE) {
            // Redirect to a success page or show a success message
            header("Location: success_page.php"); // redirect to a success page
            exit(); // Ensure that no other code is executed after the redirect
        } else {
            echo "<p style='color: red; text-align: center;'>Error: " . $conn->error . "</p>";
        }
    } else {
        // Display validation errors
        echo "<ul style='color: red; text-align: center;'>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
    }
}
?>

<!-- Add this HTML block to display success message instead of form after submission -->
<?php if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($errors)): ?>
    <div style="text-align: center; margin-top: 20px; color: green; background-color: #f4f4f4; padding: 15px; border-radius: 5px;">
        <h2>Thank you for submitting your issue!</h2>
        <p>Your issue has been successfully reported.</p>
    </div>
<?php endif; ?>

<h2 style="color: white; text-align: center; margin-top: 0; padding: 20px; background-color: #4CAF50; border-radius: 5px;">
    Report an Issue
</h2>

<form action="add_issue.php" method="POST" style="width: 60%; margin: 20px auto; padding: 20px; background-color: #f9f9f9; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
    <label for="building_name" style="font-weight: bold; display: block; margin-bottom: 5px;">Building Name:</label>
    <input type="text" id="building_name" name="building_name" required maxlength="50" 
           pattern="[A-Za-z0-9\s]+" 
           title="Building name should only contain letters, numbers, and spaces."
           style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 5px;">

    <label for="room_number" style="font-weight: bold; display: block; margin-bottom: 5px;">Room Number:</label>
    <input type="text" id="room_number" name="room_number" required maxlength="10" 
           pattern="\d+" 
           title="Room number should only contain digits."
           style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 5px;">

    <label for="issue_description" style="font-weight: bold; display: block; margin-bottom: 5px;">Issue Description:</label>
    <textarea id="issue_description" name="issue_description" required maxlength="255" 
              style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 5px;"></textarea>

    <label for="priority" style="font-weight: bold; display: block; margin-bottom: 5px;">Priority:</label>
    <select id="priority" name="priority" required style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 5px;">
        <option value="">-- Select Priority --</option>
        <option value="Low">Low</option>
        <option value="Medium">Medium</option>
        <option value="High">High</option>
    </select>

    <button type="submit" style="width: 100%; padding: 10px; background-color: #4CAF50; color: white; font-weight: bold; border: none; border-radius: 5px; cursor: pointer;">
        Submit Issue
    </button>
</form>

<?php include '../includes/footer.php'; // Include the footer ?> 
