<?php 
 
include('config.php'); 
 
// Check if the form is submitted 
if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    // Fetching user_id and role from the form 
    $user_id = $_POST['user_id']; 
 
    // Update the is_deleted column in the repairman table 
    $sql = "UPDATE repairman SET is_deleted = 1 WHERE user_id = ?"; 
    $stmt = $connection->prepare($sql); 
    $stmt->bind_param("i", $user_id); 
    if (!$stmt->execute()) { 
        // Handle errors if the update fails 
        echo "Error updating is_deleted in repairman table: " . $stmt->error; 
        exit; 
    } 
    $stmt->close(); 
 
    // Update the role to 'repairman' in the user table 
    $sql1 = "UPDATE user SET role = 'repairman' WHERE user_id = ?"; 
    $stmt1 = $connection->prepare($sql1); 
    $stmt1->bind_param("i", $user_id); 
    if (!$stmt1->execute()) { 
        // Handle errors if the update fails 
        echo "Error updating role in user table: " . $stmt1->error; 
        exit; 
    } 
    $stmt1->close(); 
 
    // Display an alert message saying "Application Approved." 
    echo '<script>alert("Application Approved.");</script>'; 
 
    // Redirect to the desired page after updating the role 
    echo '<script>window.location.href = "tfixshopowner_reqservice1.php";</script>'; 
    exit; // Terminate the script after redirection 
} 
?>