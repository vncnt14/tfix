<?php

include "config.php"; // Change "db_connection.php" to your actual file name

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection file

    // Prepare and bind the SQL statement
    $stmt = $connection->prepare("INSERT INTO personnel (user_id, firstname, lastname, contact, address, email, computer_skills, availability, certification, is_deleted) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssssssi", $user_id, $firstname, $lastname, $contact, $address, $email, $computer_skills, $availability, $certification, $is_deleted);

    // Set parameters and execute
    $user_id = $_POST['user_id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $computer_skills = $_POST['computer_skills'];
    $availability = $_POST['availability'];
    $is_deleted = isset($_POST["is_deleted"]) ? $_POST["is_deleted"] : ' ';
    
    
    // Handle file upload for certification
    $target_dir = "uploads/"; // Directory where the file will be uploaded
    $target_file = $target_dir . basename($_FILES["certification"]["name"]); // Path to save the file
    move_uploaded_file($_FILES["certification"]["tmp_name"], $target_file); // Move uploaded file to the directory
    $certification = $target_file; // Set the certification path in the database
    
    // Execute the statement
    if ($stmt->execute()) {
        // Display alert message and redirect
        header("Location: applyshop_display.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and database connection
    $stmt->close();
    $connection->close();
}
?>
