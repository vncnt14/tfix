<?php
session_start();
require_once "config.php";

// Redirect to the login page if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user ID from the session
    $user_id = $_SESSION['user_id']; // Assuming the user_id is stored in the session
    $owner_id = $_POST['owner_id'];

    $unit_problem = $_POST["unit_problem"];
    $is_deleted = $_POST["is_deleted"];
    $unit_type = $_POST["unit_type"];
    $unit_brand = $_POST["unit_brand"];
    $unit_model = $_POST["unit_model"];
    $date_requested = $_POST["date_requested"];
    $type_service = $_POST["type_service"];
    $service = $_POST["service"];
    $other_problem = isset($_POST["other_problem"]) ? $_POST["other_problem"] : null;

    // Insert car details into the vehicles table
    $query = "INSERT INTO reqform (user_id, owner_id, unit_problem, other_problem, unit_type, unit_brand, unit_model, date_requested, type_service, service, is_deleted) 
              VALUES ('$user_id', '$owner_id', '$unit_problem', '$other_problem', '$unit_type', '$unit_brand','$unit_model', '$date_requested', '$type_service', '$service', '$is_deleted')";

    try {
        // Execute the insert query
        if (mysqli_query($connection, $query)) {
            echo '<script>alert("Repair request successful!"); window.location.href = "reqform_output.php?user_id=' . $user_id . '";</script>';
            exit;
        } else {
            throw new Exception("Error inserting record: " . mysqli_error($connection));
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

mysqli_close($connection);
?>
