<?php
session_start();

// Include database connection file
include('config.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming form fields are named accordingly
    $user_id = $_POST['user_id'] ?? "";
    $reqform_id = $_POST['reqform_id'] ?? "";
    $faultythermo = $_POST['faultythermo'] ?? "";
    $defective = $_POST['defective'] ?? "";
    $clogged = $_POST['clogged'] ?? "";
    $faultydef = $_POST['faultydef'] ?? "";
    $low = $_POST['low'] ?? "";
    $malfunctioning = $_POST['malfunctioning'] ?? "";
    $gasket = $_POST['gasket'] ?? "";
    $vent = $_POST['vent'] ?? "";
    $thermostat = $_POST['thermostat'] ?? "";
    $coils = $_POST['coils'] ?? "";
    $charge = $_POST['charge'] ?? "";
    $condenser = $_POST['condenser'] ?? "";
    $repairstatusYES = $_POST['repairstatusYES'] ?? "";
    $repairstatusNO = $_POST['repairstatusNO'] ?? "";

    // SQL query to insert data into refrigerator table
    $insert_query = "INSERT INTO refrigerator (user_id, reqform_id, faultythermo, defective, clogged, faultydef, low, malfunctioning, gasket, vent, thermostat, coils, charge, condenser, repairstatusYES, repairstatusNO) 
                     VALUES ('$user_id', '$reqform_id', '$faultythermo', '$defective', '$clogged', '$faultydef', '$low', '$malfunctioning', '$gasket', '$vent', '$thermostat', '$coils', '$charge', '$condenser', '$repairstatusYES', '$repairstatusNO')";
    
    // Execute query
    $insert_result = mysqli_query($connection, $insert_query);

    if ($insert_result) {
        // Redirect to success page or any other desired page
        header("Location: tfixpersonnel_endorse2.php?user_id=$user_id&reqform_id=$reqform_id");
        exit;
    } else {
        // Handle error, maybe redirect to error page or display error message
        echo "Error: " . mysqli_error($connection);
    }
} else {
    die('Form not submitted.');
}
?>
