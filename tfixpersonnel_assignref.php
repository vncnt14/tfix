<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection file
    include('config.php');

    // Gather form data
    $user_id = $_POST['user_id'];
    $reqform_id = $_POST['reqform_id'];
    $repairman_id = $_POST['repairman_id'];
    $findings = $_POST['findings'];
    $unit_type = $_POST['unit_type'];
    $unit_brand = $_POST['unit_brand'];
    $unit_model = $_POST['unit_model'];
    $parts_name = $_POST['parts_name'];
    $inspect = $_POST['inspect'];
    $start_date = $_POST['start_date'];
    $assign_tech = $_POST['assign_tech'];
    $quantity = $_POST['quantity'];
    $is_deleted = $_POST['is_deleted'];
    $unit_status = isset($_POST['unit_status']) ? $_POST['unit_status'] : null;




    // Construct the SQL insert query
    $insert_query = "INSERT INTO assignref (user_id, reqform_id, repairman_id, findings, unit_type, unit_brand, unit_model, parts_name, inspect, start_date,  assign_tech, quantity, is_deleted, unit_status) 
                     VALUES ('$user_id', '$reqform_id', '$repairman_id', '$findings', '$unit_type', '$unit_brand', '$unit_model', '$parts_name', '$inspect', '$start_date', '$assign_tech' , '$quantity', '$is_deleted', '$unit_status')";
    
    // Execute the query
    if (mysqli_query($connection, $insert_query)) {
        $select_query = "SELECT * FROM assignref WHERE user_id = '$user_id' AND reqform_id = '$reqform_id' AND repairman_id = '$repairman_id'";
        $result = mysqli_query($connection, $select_query);
        $reqformData = mysqli_fetch_assoc($result);
        
        // Data successfully inserted into the assignref table
        echo '<script>alert("Assigning succesfully!");</script>';
        echo '<script>window.location.href = "tfixpersonnel_assign2.php?user_id=' . (int)$reqformData['user_id'] . '&reqform_id=' . (int)$reqformData['reqform_id'] . ' &repairman_id=' . (int)$reqformData['repairman_id'] . '";</script>';
    } else {
        // Error occurred
        echo "Error: " . $query . "<br>" . mysqli_error($connection);
    }
    

    // Close database connection
    mysqli_close($connection);
}
?>
