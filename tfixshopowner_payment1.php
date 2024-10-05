<?php
// Include database connection file
include('config.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $user_id = $_POST['user_id'];
    $assign_id = $_POST['assign_id'];
    $reqform_id = $_POST['reqform_id'];
    $fullname = $_POST['fullname'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $unit_name = $_POST['unit_name'];
    $assign_tech = $_POST['assign_tech'];
    $parts = $_POST['parts'];
    $labor = $_POST['labor'];
    $payment = $_POST['payment'];

    // Prepare and bind parameters for UPDATE query
    $update_query = "UPDATE assignref SET unit_status = 'Waiting for payment' WHERE assign_id = ?";
    $update_stmt = $connection->prepare($update_query);
    $update_stmt->bind_param("i", $assign_id); // Assuming assign_id is an integer

    // Execute the UPDATE query
    if ($update_stmt->execute()) {
        // Prepare and bind parameters for INSERT query
        $insert_query = "INSERT INTO receipt (user_id, reqform_id, fullname, contact, address, unit_name, assign_tech, parts, labor, payment) 
                         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $insert_stmt = $connection->prepare($insert_query);
        $insert_stmt->bind_param("iisssssdds", $user_id, $reqform_id, $fullname, $contact, $address, $unit_name, $assign_tech, $parts, $labor, $payment);

        // Execute the INSERT query
        if ($insert_stmt->execute()) {
            // Show alert message
            echo "<script>alert('Service verify successfully.');</script>";
            // Redirect to another page
            $query1 = "SELECT * FROM repairman WHERE appliance = 'refrigerator'";
            $result1 = mysqli_query($connection, $query1);
            $repairmanData = mysqli_fetch_assoc($result1);
            echo "<script>window.location = 'tfixshopowner_progress1.php?repairman_id=" . $repairmanData['repairman_id'] . "';</script>";
            exit();
        } else {
            // Error in data insertion
            echo "Error: " . $insert_query . "<br>" . mysqli_error($connection);
        }
        // Close INSERT statement
        $insert_stmt->close();
    } else {
        // Error in update
        echo "Error: " . $update_query . "<br>" . mysqli_error($connection);
    }
    // Close UPDATE statement
    $update_stmt->close();

    // Close the database connection
    $connection->close();
}
?>
