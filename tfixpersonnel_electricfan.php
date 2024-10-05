<?php
session_start();

// Include database connection file
include('config.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming form fields are named accordingly
    $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : "";
    $reqform_id = isset($_POST['reqform_id']) ? $_POST['reqform_id'] : "";
    $motor = isset($_POST['motor']) ? $_POST['motor'] : "";
    $loose = isset($_POST['loose']) ? $_POST['loose'] : "";
    $jamming = isset($_POST['jamming']) ? $_POST['jamming'] : "";
    $faulty = isset($_POST['faulty']) ? $_POST['faulty'] : "";
    $lubrication = isset($_POST['lubrication']) ? $_POST['lubrication'] : "";
    $worn = isset($_POST['worn']) ? $_POST['worn'] : "";
    $electrical = isset($_POST['electrical']) ? $_POST['electrical'] : "";
    $capacitor = isset($_POST['capacitor']) ? $_POST['capacitor'] : "";
    $stuck = isset($_POST['stuck']) ? $_POST['stuck'] : "";
    $overheating = isset($_POST['overheating']) ? $_POST['overheating'] : "";
    $defective = isset($_POST['defective']) ? $_POST['defective'] : "";
    $damaged = isset($_POST['damaged']) ? $_POST['damaged'] : "";
    $repairstatusYES = isset($_POST['repairstatusYES']) ? $_POST['repairstatusYES'] : "";
    $repairstatusNO = isset($_POST['repairstatusNO']) ? $_POST['repairstatusNO'] : "";

    // SQL query to insert data into refrigerator table
    $insert_query = "INSERT INTO electricfan (user_id, reqform_id, motor, loose, jamming, faulty, lubrication, worn, electrical, capacitor, stuck, overheating, defective, damaged, repairstatusYES, repairstatusNO) 
                     VALUES ('$user_id', '$reqform_id', '$motor', '$loose', '$jamming', '$faulty', '$lubrication', '$worn', '$electrical', '$capacitor', '$stuck', '$overheating', '$defective', '$damaged', '$repairstatusYES', '$repairstatusNO')";
    
    // Execute query
    $insert_result = mysqli_query($connection, $insert_query);
    
    if ($insert_result) {
        // Redirect to success page or any other desired page
        header("Location: tfixpersonnel_endorse2-2.php?user_id=$user_id&reqform_id=$reqform_id");
        exit;
    } else {
        // Handle error, maybe redirect to error page or display error message
        echo "Error: " . mysqli_error($connection);
    }
}
?>
