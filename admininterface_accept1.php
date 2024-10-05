<?php
session_start();
include('config.php');

// Retrieve and sanitize form data
$accept_id = $_POST['accept_id'];

// Use prepared statements to prevent SQL injection
$sql = "DELETE FROM accept WHERE accept_id = '$accept_id'";

if(mysqli_query($connection, $sql)){
    echo '<script language="javascript">';
    echo 'alert("User deleted successfully!");';
    echo 'window.location="admininterface_accept.php";';
    echo '</script>';   
} else {
    echo '<script language="javascript">';
    echo 'alert("Error Deleting!");';
    echo 'window.location="admininterface_accept.php";';
    echo '</script>';
}
?>