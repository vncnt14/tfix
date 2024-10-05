<?php
session_start();

// Include database connection file
include('config.php');  // You'll need to replace this with your actual database connection code

// Redirect to the login page if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $experience = $_POST['experience'];
    $expertise = $_POST['expertise'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate the form data (you may add more robust validation)
    if (empty($firstname) || empty($lastname) || empty($email) || empty($experience)) {
        echo "All fields are required.";
        exit;
    }

    // Assuming you have a user ID stored in the session
    $userID = $_SESSION['repairman_id'];

    // Update the user's profile in the database
    $query = "UPDATE repairman SET firstname='$firstname', lastname='$lastname', email='$email', experience='$experience', expertise='$expertise',  username='$username', password='$password' WHERE repairman_id='$userID'";

    if (mysqli_query($connection, $query)) {
	echo "<script>alert('Profile updated successfully.');</script>";
	    echo "<script>
        	setTimeout(function() {
            		window.location.href = 'tfixrepairman_editprofile.php';
        	}, 1000); // Redirect after 1 seconds
      		</script>";
	    exit;
    } else {
        echo "Error updating profile: " . mysqli_error($connection);
        
    }

    // Close the database connection
    mysqli_close($connection);
} else {
    // If the request method is not POST, redirect to the edit profile page
    header("Location: tfixrepairman_editprofile1.php");
    exit;
}
?>
