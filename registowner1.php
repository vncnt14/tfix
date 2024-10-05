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
        $shop_name = $_POST['shop_name'];
        $shop_location = $_POST['shop_location'];
        $shop_type = $_POST['shop_type'];
        $shop_permit = $_FILES['shop_permit']['name']; // Assuming you're storing file name in the database
        $shop_payment = implode(', ', $_POST['shop_payment']); // Corrected variable name
        $shop_status = 'pending'; // Default status set to 'pending'
        $photo = isset($_POST["photo"]) ? $_POST["photo"] : 'Edit your Photo';
        $services = isset($_POST["services"]) ? $_POST["services"] : '';

        
        // Move uploaded file to a directory
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["shop_permit"]["name"]);
        move_uploaded_file($_FILES["shop_permit"]["tmp_name"], $target_file);
        
        // Prepare and bind parameters
        $stmt = $connection->prepare("INSERT INTO owner (user_id, firstname, lastname, contact, address, email, shop_name, shop_location, shop_type, shop_permit, shop_payment, shop_status, photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)");
        $stmt->bind_param("issssssssssss", $user_id, $firstname, $lastname, $contact, $address, $email, $shop_name, $shop_location, $shop_type, $shop_permit, $shop_payment, $shop_status, $photo);
        
        // Execute the statement
        if ($stmt->execute()) {
            echo '<script>';
            echo 'alert("Application submitted.");';
            echo 'window.location.href = "registerowner.php";';
            echo '</script>';
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
