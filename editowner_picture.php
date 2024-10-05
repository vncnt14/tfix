<?php
session_start();

// Include database connection file
include('config.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $owner_id = $_POST['owner_id'];

    if (isset($_FILES['photo']['tmp_name'])) {
        $photo_name = $_FILES['photo']['name'];
        $photo_tmp = $_FILES['photo']['tmp_name'];

        // Move the uploaded file to the destination folder
        $upload_directory = "uploads/";
        $photo_path = $upload_directory . $photo_name;

        if (move_uploaded_file($photo_tmp, $photo_path)) {
            // Update the photo in the database
            $query = "UPDATE owner SET photo = '$photo_path' WHERE owner_id = '$owner_id'";
            if ($update = mysqli_query($connection, $query)) {
                // Set session variable with the updated profile picture URL
                $_SESSION['profile_photo'] = $photo_path;

                header("Location: tfixshopowner_profile.php");
                exit();
            } else {
                echo "Error updating photo: " . mysqli_error($connection);
            }
        } else {
            echo "Error uploading photo";
        }
    } else {
        echo "No photo uploaded";
    }
} else {
    // Redirect to the appropriate page if accessed without POST method
    header("Location: tfixlogin.php");
    exit;
}
?>
