<?php
session_start();
include('config.php');

// Retrieve and sanitize form data
$user_id = $_POST['user_id'];
$role = $_POST['role'];

// Use prepared statements to prevent SQL injection
$sql = "DELETE FROM user WHERE user_id = '$user_id'";

if(mysqli_query($connection, $sql)){
    echo '<script language="javascript">';
    echo 'alert("User deleted successfully!");';
    echo 'window.location="admininterface_user.php";';
    echo '</script>';   
} else {
    echo '<script language="javascript">';
    echo 'alert("Error Deleting!");';
    echo 'window.location="admininterface_user.php";';
    echo '</script>';
}
?>