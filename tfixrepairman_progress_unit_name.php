<?php
session_start();
require_once "config.php";

// Assuming you have the following line to retrieve the unit_name from the form
$unit_name = isset($_GET['unit_name']) ? trim($_GET['unit_name']) : '';

// Assuming you have the following line to retrieve the reqform_id from the form
$reqformID = isset($_GET['reqform_id']) ? $_GET['reqform_id'] : '';

// Redirect users based on unit_name
if (strcasecmp($unit_name, 'Refrigerator') === 0) {
    header("Location: tfixrepairman_progress.php?reqform_id=$reqformID");
    exit;
} elseif (strcasecmp($unit_name, 'ElectricFan') === 0) {
    header("Location: tfixrepairman_progress1.php?reqform_id=$reqformID");
    exit;
} else {
    // Handle other cases or display an error message
    echo "Invalid unit_name: $unit_name";
    exit;
}

// The rest of your form processing code goes here
// ...
?>
