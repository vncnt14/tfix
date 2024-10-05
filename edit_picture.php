<?php
include('config.php');
include('session.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];

    if (isset($_FILES['photo']['tmp_name'])) {
        $photo_name = $_FILES['photo']['name'];
        $photo_tmp = $_FILES['photo']['tmp_name'];

        // Move the uploaded file to the destination folder
        $upload_directory = "uploads/";
        $photo_path = $upload_directory . $photo_name;

        if (move_uploaded_file($photo_tmp, $photo_path)) {
            // Update the photo in the database
            $query = "UPDATE user SET photo = '$photo_path' WHERE user_id = '$user_id'";
            if ($update = mysqli_query($connection, $query)) {
                header("Location: editprofile1.php");
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
}
?>
