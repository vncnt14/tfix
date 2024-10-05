<?php
// Include your database connection file
include('config.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the necessary data is provided
    if (isset($_POST['user_id'])) {
        // Prepare an update statement for user role
        $user_id = $_POST['user_id'];
        $updateUserRoleQuery = "UPDATE user SET role = 'shopowner' WHERE user_id = ?";
        $stmtUserRole = $connection->prepare($updateUserRoleQuery);
        $stmtUserRole->bind_param("i", $user_id);

        // Prepare an update statement for shop status
        $updateShopStatusQuery = "UPDATE owner SET shop_status = 'approved' WHERE user_id = ?";
        $stmtShopStatus = $connection->prepare($updateShopStatusQuery);
        $stmtShopStatus->bind_param("i", $user_id);

        // Execute the user role update statement
        if ($stmtUserRole->execute()) {
            // Execute the shop status update statement
            if ($stmtShopStatus->execute()) {
                echo '<script>';
                echo 'alert("Shop approved.");';
                echo 'window.location.href = "admininterface.php";';
                echo '</script>';
            } else {
                echo "Error updating shop status: " . $stmtShopStatus->error;
            }
        } else {
            echo "Error updating role: " . $stmtUserRole->error;
        }

        // Close statements
        $stmtUserRole->close();
        $stmtShopStatus->close();
    } else {
        echo "Please provide user ID.";
    }
}

// Close connection
$connection->close();
?>
