<?php
// Assuming you have a MySQL database
include('config.php');

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Process the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve values from the form
    $faultythermo = isset($_POST["faultythermo"]) ? "Checked" : "";
    $defective = isset($_POST["defective"]) ? "Checked" : "";
    $clogged = isset($_POST["clogged"]) ? "Checked" : "";
    $faultydef = isset($_POST["faultydef"]) ? "Checked" : "";
    $low = isset($_POST["low"]) ? "Checked" : "";
    $malfunctioning = isset($_POST["malfunctioning"]) ? "Checked" : "";
    $gasket = isset($_POST["gasket"]) ? "Checked" : "";
    $vent = isset($_POST["vent"]) ? "Checked" : "";
    $thermostat = isset($_POST["thermostat"]) ? "Checked" : "";
    $coils = isset($_POST["coils"]) ? "Checked" : "";
    $charge = isset($_POST["charge"]) ? "Checked" : "";
    $condenser = isset($_POST["condenser"]) ? "Checked" : "";
    $repairstatusYES = isset($_POST["repairstatusYES"]) ? "Yes" : "";
    $repairstatusNO = isset($_POST["repairstatusNO"]) ? "No" : "";
    $findings = isset($_POST["findings"]) ? $_POST["findings"] : "";

    // Add more checkboxes as needed

    // Use a prepared statement to insert data into the database
    $stmt = $connection->prepare("INSERT INTO refrigerator (faultythermo, defective, clogged, faultydef, low, malfunctioning, gasket, vent, thermostat, coils, charge, condenser,  repairstatusYES, repairstatusNO ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssssss", $faultythermo, $defective, $clogged, $faultydef, $low, $malfunctioning, $gasket, $vent, $thermostat, $coils, $charge, $condenser, $repairstatusYES, $repairstatusNO);

    if ($stmt->execute()) {
        // Direct JavaScript redirect after successful insertion
        echo "<script>window.location.href = 'tfixrepairman_endorse.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$connection->close();
?>
