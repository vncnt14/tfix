<?php
// edit_user.php

session_start();
if (!isset($_SESSION['username']) || !$_SESSION['is_admin']) {
    header("Location: index.php");
    exit;
}

require_once "config.php";

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validate and sanitize the input data
    $userId = $_POST['edit_id'] ?? '';
    $firstname = $_POST['edit_firstname'] ?? '';
    $lastname =$_POST['edit_lastname'] ?? '';
    $username = $_POST['edit_username'] ?? '';
    $password = $_POST['edit_password'] ?? '';
    $email = $_POST['edit_email'] ?? '';
    $role = $_POST['edit_role'] ?? '';

    // Perform additional validation as needed (e.g., checking if required fields are not empty)

    // Prepare and execute the UPDATE query using parameterized statements
    $query = "UPDATE user SET firstname = ?, lastname = ?, username = ?, password = ?, email = ?, role = ? WHERE id = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "ssssssi", $firstname, $lastname, $username, $password, $email, $role, $userId);

    $response = array();

    if (mysqli_stmt_execute($stmt)) {
        // Update successful
        $response['success'] = true;
    } else {
        // Update failed
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
