<?php
// add_user.php

session_start();
require_once "config.php";

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validate and sanitize the input data
    $lastname = $_POST['add_lastname'] ?? '';
    $firstname = $_POST['add_firstname'] ?? '';
    $username = $_POST['add_username'] ?? '';
	$password = $_POST['add_password'] ?? '';
    $email = $_POST['add_email'] ?? '';
    $role = $_POST['add_role'] ?? '';

    // Perform additional validation as needed (e.g., checking if required fields are not empty)

    // Prepare and execute the INSERT query
    $query = "INSERT INTO user (lastname, firstname, username, password, email, role, id) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "ssssssi", $lastname, $firstname, $username, $password, $email, $role, $userId);

    $response = array();

    if (mysqli_stmt_execute($stmt)) {
        // Insertion successful
        $response['success'] = true;
    } else {
        // Insertion failed
        $response['success'] = false;
        $response['message'] = "Error: " . mysqli_error($connection);
    }

    // Close the statement
    mysqli_stmt_close($stmt);

    // Send the JSON response back to the client
    header("Content-Type: application/json");
    echo json_encode($response);
}
?>
