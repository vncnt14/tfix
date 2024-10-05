<?php

include('config.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $user_id = $_POST['user_id'];
    $assign_id = $_POST['assign_id'];
    $reqform_id = $_POST['reqform_id'];
    $unit_status = $_POST['unit_status'];
    $change_tech = $_POST['change_tech'];
    $finish_date = $_POST['finish_date'];
    $duration = $_POST['duration'];

    // Prepare and bind parameters
    $sql = "UPDATE assignref SET unit_status=?, change_tech=?, finish_date=?, duration=? WHERE assign_id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ssssi", $unit_status, $change_tech, $finish_date, $duration, $assign_id);

    // Execute the update
    if ($stmt->execute()) {
        // Show alert message
        echo "<script>alert('Records updated successfully.');";
        // Redirect to another page after alert is closed
        echo "window.location = 'tfixrepairman_endorse3.php';";
        echo "</script>";
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$connection->close();
?>
