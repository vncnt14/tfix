<?php
session_start();

// Include database connection file (replace this with your actual database connection code)
include('config.php');

// Redirect to the login page if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $shop_name = $_POST['shop_name'];
    $shop_contact = $_POST['shop_contact'];
    $shop_location = $_POST['shop_location'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Assuming you have an owner ID stored in the session
    $ownerID = $_SESSION['user_id'];
    
    // Update the owner's profile in the database
    $query = "UPDATE owner SET shop_name='$shop_name', contact='$shop_contact', shop_location='$shop_location', email='$email' WHERE user_id=$ownerID";

    if (mysqli_query($connection, $query)) {
        // Update selected services if checkboxes are submitted
        if (isset($_POST['service']) && is_array($_POST['service'])) {
            $selectedServices = $_POST['service'];
            $servicesString = implode(", ", $selectedServices); // Convert array to comma-separated string
            
            // Update services column in the owner table
            $updateServicesQuery = "UPDATE owner SET services='$servicesString' WHERE user_id=$ownerID";
            mysqli_query($connection, $updateServicesQuery); // Execute query to update services
        }

        echo "<script>alert('Profile and services updated successfully.');</script>";
        echo "<script>
            setTimeout(function() {
                window.location.href = 'editprofileowner.php';
            }, 1000); // Redirect after 1 second
        </script>";
        exit;
    } else {
        echo "Error updating profile: " . mysqli_error($connection);
    }

    // Close the database connection
    mysqli_close($connection);
} else {
    // If the request method is not POST, redirect to the edit profile page
    header("Location: editprofileowner1.php");
    exit;
}
?>
