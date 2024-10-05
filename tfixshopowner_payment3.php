<?php
// Include database connection file
include('config.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $user_id = $_POST['user_id'];
    $repairman_id = $_POST['repairman_id'];
    $unit_status = $_POST['unit_status'];
    $reqform_id = $_POST['reqform_id'];

    // Check if unit_status is "in progress"
    if ($unit_status == "In Progress") {
        // Update unit_status to "finished"
        $sql = "UPDATE assignref SET unit_status = 'Complete' WHERE user_id = '$user_id' AND reqform_id = '$reqform_id'";

        if (mysqli_query($connection, $sql)) {
            // Unit status updated successfully
            echo "<script>alert('Service finished successfully.'); window.location = 'tfixshopowner_progress1.php?repairman_id=" . $repairman_id . "';</script>";
            exit; // Stop further execution
        } else {
            // Error in updating unit status
            echo "<script>alert('Error updating unit status: " . mysqli_error($connection) . "');</script>";
        }
    } else {
        // Unit status is not "in progress"
        echo "<script>alert('Unit status is not in progress.');</script>";
    }

    // Close the database connection
    mysqli_close($connection);
}
?>
