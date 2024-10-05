<?php
session_start();
include('config.php');

// Retrieve and sanitize form data
$reqform_id = $_POST['reqform_id'];

// Use prepared statements to prevent SQL injection
$sql = "DELETE FROM reqform WHERE reqform_id = '$reqform_id'";

if(mysqli_query($connection, $sql)){
    echo '<script language="javascript">';
    echo 'alert("User deleted successfully!");';
    echo 'window.location="admininterface_reqform.php";';
    echo '</script>';   
} else {
    echo '<script language="javascript">';
    echo 'alert("Error Deleting!");';
    echo 'window.location="admininterface_reqform.php";';
    echo '</script>';
}
?>