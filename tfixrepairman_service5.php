<?php

include('config.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $user_id = $_POST['user_id'];
    $reqform_id = $_POST['reqform_id'];
    $unit_status = $_POST['unit_status'];
    $unit_brand = $_POST['unit_brand'];
    $parts_name = $_POST['parts_name'];

    // Subtract quantity from stocks in parts table
    $sql_subtract_stocks = "UPDATE parts p
                            JOIN assignref ar ON p.unit_brand = ar.unit_brand AND p.parts_name = ar.parts_name
                            SET p.stocks = p.stocks - ar.quantity
                            WHERE p.unit_brand = ? AND p.parts_name=?";
    
    $stmt_subtract_stocks = $connection->prepare($sql_subtract_stocks);
    $stmt_subtract_stocks->bind_param("ss", $unit_brand, $parts_name);
    $stmt_subtract_stocks->execute();
    $stmt_subtract_stocks->close();

    // Prepare and bind parameters for updating assignref table
    $sql_update_assignref = "UPDATE assignref SET unit_status=? WHERE user_id=? AND reqform_id=?";
    $stmt_update_assignref = $connection->prepare($sql_update_assignref);
    $stmt_update_assignref->bind_param("sii", $unit_status, $user_id, $reqform_id);

    // Execute the update
    if ($stmt_update_assignref->execute()) {
        // Show alert message
        echo "<script>alert('Records updated successfully.');";
        // Redirect to another page after alert is closed
        echo "window.location = 'tfixrepairman_endorse3.php';";
        echo "</script>";
    } else {
        echo "Error updating record: " . $stmt_update_assignref->error;
    }

    // Close the statement
    $stmt_update_assignref->close();
}

// Close the connection
$connection->close();
?>
