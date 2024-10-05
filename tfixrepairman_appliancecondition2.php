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
    $motor = isset($_POST["motor"]) ? "Checked" : "";
    $loose = isset($_POST["loose"]) ? "Checked" : "";
    $jamming = isset($_POST["jamming"]) ? "Checked" : "";
    $faulty = isset($_POST["faulty"]) ? "Checked" : "";
    $lubrication = isset($_POST["lubrication"]) ? "Checked" : "";
    $worn = isset($_POST["worn"]) ? "Checked" : "";
    $electrical = isset($_POST["electrical"]) ? "Checked" : "";
    $capacitor = isset($_POST["capacitor"]) ? "Checked" : "";
    $stuck = isset($_POST["stuck"]) ? "Checked" : "";
    $overheating = isset($_POST["overheating"]) ? "Checked" : "";
    $defective = isset($_POST["defective"]) ? "Checked" : "";
    $damaged = isset($_POST["damaged"]) ? "Checked" : "";
    $repairstatusYES = isset($_POST["repairstatusYES"]) ? "Yes" : "";
    $repairstatusNO = isset($_POST["repairstatusNO"]) ? "No" : "";
   
    // Add more checkboxes as needed

    // Use a prepared statement to insert data into the database
    $stmt = $connection->prepare ("INSERT INTO electricfan (motor, loose, jamming, faulty, lubrication, worn, electrical, capacitor, stuck, overheating, defective, damaged,  repairstatusYES, repairstatusNO  ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssssss", $motor, $loose, $jamming, $faulty, $lubrication, $worn, $electrical, $capacitor, $stuck, $overheating, $defective, $damaged, $repairstatusYES, $repairstatusNO);

    if ($stmt->execute()) {
        // Direct JavaScript redirect after successful insertion
        echo "<script>window.location.href = 'tfixrepairman_endorse.php?reqform_id=';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$connection->close();
?>
