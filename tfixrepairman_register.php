<?php

include('config.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are filled
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        // Set parameters
        $user_id = $_POST['user_id'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $contact = $_POST['contact'];
        $address = $_POST['address'];
        $email = $_POST['email'];
        $experience = $_POST['experience'];
        $availability = $_POST['availability'];
        $certification = $_FILES['certification']['name']; // Assuming you're storing file name in the database
        $expertise = implode(', ', $_POST['expertise']); // Corrected variable name
        $appliance = implode(', ', $_POST['appliance']); // Corrected variable name
        $is_deleted = isset($_POST["is_deleted"]) ? $_POST["is_deleted"] : ' ';

        
        // Move uploaded file to a directory
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["certification"]["name"]);
        move_uploaded_file($_FILES["certification"]["tmp_name"], $target_file);
        
        // Prepare and bind parameters
        $stmt = $connection->prepare("INSERT INTO repairman (user_id, firstname, lastname, contact, address, email, experience, availability, certification, expertise, appliance, is_deleted) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssssssssi", $user_id, $firstname, $lastname, $contact, $address, $email, $experience, $availability, $certification, $expertise, $appliance, $is_deleted);

        
        // Execute the statement
        if ($stmt->execute()) {
            echo '<script>alert("Records inserted successfully.");</script>';
            // Redirect to another page after showing the alert
            header("Location: applyshop_display.php");
            exit; // Make sure to exit after the redirect to prevent further execution
        } else {
            echo "Error: " . $stmt->error;
        }
        
        // Close statement and connection
        $stmt->close();
        $connection->close();
    } else {
        echo "All fields are required.";
    }
}
?>
