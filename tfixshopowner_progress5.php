<?php
// Include the database configuration file
include('config.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the necessary form fields are set and not empty
    if(isset($_POST['user_id'], $_POST['is_deleted'], $_POST['reqform_id'], $_POST['repairman_id'])) {
        // Sanitize POST data to prevent SQL injection
        $user_id = mysqli_real_escape_string($connection, $_POST['user_id']);
        $is_deleted = mysqli_real_escape_string($connection, $_POST['is_deleted']);
        $reqform_id = mysqli_real_escape_string($connection, $_POST['reqform_id']);
        $repairman_id = mysqli_real_escape_string($connection, $_POST['repairman_id']);

        // Update the is_deleted field in the database
        $query = "UPDATE assignref SET is_deleted = 1 WHERE user_id = '$user_id' AND reqform_id = '$reqform_id' AND repairman_id = '$repairman_id'";

        // Execute the query
        $result = mysqli_query($connection, $query);

        // Check if the update was successful
        if($result) {
            // Update successful
            echo '<script>alert("Payment Confirmed.");</script>';
            echo '<script>window.location.href = "tfixshopowner_notif1.php?user_id='.$user_id.'&reqform_id='.$reqform_id.'&repairman_id='.$repairman_id.'";</script>';
        } else {
            // Update failed
            echo '<p class="text-danger">Error: Failed to update record.</p>';
        }
    } else {
        // Required form fields are missing
        echo '<p class="text-danger">Error: Required form fields are missing.</p>';
    }
}
?>
