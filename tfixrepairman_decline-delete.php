<?php
session_start();

// Include database connection file
include('config.php');  // You'll need to replace this with your actual database connection code

// Redirect to the login page if the user is not logged in
if (!isset($_SESSION['repairman_id'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve values from the form
    $reqformID = $_POST['reqform_id'];
    $userID = $_POST['user_id'];

    // Check which checkboxes were selected
    $query = "DELETE FROM reqform WHERE reqform_id = '$reqformID' AND user_id = '$userID'";
  
    // Execute the query
    mysqli_query($connection, $query);

    // Redirect to a success page
    header("Location: tfixrepairman_reqservice.php");
    exit();
}
?>
