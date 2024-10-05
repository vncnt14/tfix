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
    $unit_name = $_POST['unit_name'];
    $parts_description = $_POST['parts_description'];
    $inspect = $_POST['inspect'];
    $start_date = $_POST['start_date'];
    $finish_date = $_POST['finish_date'];
    $duration = $_POST['duration'];
    $assign_tech = $_POST['assign_tech'];



    // Construct the SQL insert query
    $insert_query = "INSERT INTO assignfan (user_id, reqform_id, repairman_id, findings, unit_name, parts_description, inspect, start_date, finish_date, duration, assign_tech) 
                     VALUES ('$user_id', '$reqform_id', '$repairman_id', '$findings', '$unit_name', '$parts_description', '$inspect', '$start_date', '$finish_date', '$duration', '$assign_tech')";
    
    // Execute the query
    if (mysqli_query($connection, $insert_query)) {

        $select_query = "SELECT *FROM assignfan";
        $result = mysqli_query($connection, $select_query);
        $assignData = mysqli_fetch_assoc($result);
        // Data successfully inserted into the accept table
        echo '<script>window.location.href = "tfixpersonnel_assign1.php?user_id=' . (int)$assignData['user_id'] . '&reqform_id=' . (int)$assignData['reqform_id'] . '&repairman_id=' . (int)$assignData['repairman_id'] . '";</script>';
    } else {
        // Error occurred
        echo "Error: " . $query . "<br>" . mysqli_error($connection);
    }

    // Close database connection
    mysqli_close($connection);
}
?>
