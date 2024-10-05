<?php
// Include your database connection file
include "config.php"; // Change "config.php" to your actual file name

// Assuming you have retrieved the values from the form submission
$user_id = $_POST['user_id']; // Assuming you have a hidden input field for user_id in your form

// Update role in the user table
$user_role_update_query = "UPDATE user SET role = 'personnel' WHERE user_id = ?";
$user_role_stmt = $connection->prepare($user_role_update_query);
$user_role_stmt->bind_param("i", $user_id);
if ($user_role_stmt->execute()) {
    // Set is_deleted to 1 in the personnel table
    $is_deleted_update_query = "UPDATE personnel SET is_deleted = 1 WHERE user_id = ?";
    $is_deleted_stmt = $connection->prepare($is_deleted_update_query);
    $is_deleted_stmt->bind_param("i", $user_id);
    if ($is_deleted_stmt->execute()) {
        // Close statements
        $user_role_stmt->close();
        $is_deleted_stmt->close();
        $connection->close();
        
        // Display alert message and redirect
        echo "<script>alert('Application is accepted.'); window.location.href = 'tfixshopowner_reqservice2.php';</script>";
        exit(); // Stop further execution
    } else {
        echo "<script>alert('Error setting is_deleted to 1 in the personnel table: " . $is_deleted_stmt->error . "');</script>";
    }
} else {
    echo "<script>alert('Error updating role in the user table: " . $user_role_stmt->error . "');</script>";
    $user_role_stmt->close(); // Close statement
    $connection->close(); // Close database connection
}
?>
