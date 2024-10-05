<?php
include('config.php'); // Include your database connection

// Retrieve POST data from the form
$unit_id = $_POST['unit_id'];
$unit_brand = $_POST['unit_brand'];// Assuming you're passing this value from JavaScript
$parts_name = $_POST['parts_name'];
$stocks = $_POST['stocks'];
$price = $_POST['price'];

// Check if the parts already exist
$checkQuery = "SELECT * FROM parts WHERE unit_id = ? AND unit_brand = ? AND parts_name = ?";
$checkStmt = mysqli_prepare($connection, $checkQuery);
mysqli_stmt_bind_param($checkStmt, 'iss', $unit_id, $unit_brand, $parts_name);
mysqli_stmt_execute($checkStmt);
mysqli_stmt_store_result($checkStmt);

if (mysqli_stmt_num_rows($checkStmt) > 0) {
    // Parts already exist, show alert message
    echo '<script>alert("These parts already exist!"); window.location.href = "ownerinventory_add1.php?unit_id=' . $unit_id . '&unit_brand=' . $unit_brand . '";</script>';
    exit;
}

// Prepare an SQL statement to insert data into the parts table
$query = "INSERT INTO parts (unit_id, unit_brand, parts_name, stocks, price) VALUES (?, ?, ?, ?, ?)";

// Use prepared statements to prevent SQL injection
$stmt = mysqli_prepare($connection, $query);

if ($stmt) {
    // Bind parameters to the prepared statement as strings and integers
    mysqli_stmt_bind_param($stmt, 'isssd', $unit_id, $unit_brand, $parts_name, $stocks, $price);

    // Execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
        echo '<script>alert("Parts added successfully!"); window.location.href = "ownerinventory_add1.php?unit_id=' . $unit_id . '&unit_brand=' . $unit_brand . '";</script>';
    } else {
        echo "Error adding parts: " . mysqli_stmt_error($stmt);
    }

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    echo "Error preparing statement: " . mysqli_error($connection);
}

// Close the database connection
mysqli_close($connection);
?>
