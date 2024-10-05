<?php
session_start();
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $unitType = mysqli_real_escape_string($connection, $_POST['unit_type']);
    $unitBrand = mysqli_real_escape_string($connection, $_POST['unit_brand']);

    // Check if the inventory item already exists
    $checkQuery = "SELECT * FROM inventory WHERE unit_type = '$unitType' AND unit_brand = '$unitBrand'";
    $checkResult = mysqli_query($connection, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        // Item already exists, show alert message
        echo "<script>alert('This unit type and brand combination already exists in inventory.');</script>";
        echo "<script>window.location.href = 'tfixshopowner_inventory.php';</script>";
        exit;
    } else {
        // Item does not exist, proceed to insert into inventory
        $insertQuery = "INSERT INTO inventory (unit_type, unit_brand) VALUES ('$unitType', '$unitBrand')";

        if (mysqli_query($connection, $insertQuery)) {
            // Successfully inserted, redirect to inventory page
            header("Location: tfixshopowner_inventory.php");
            exit;
        } else {
            // Error inserting item
            echo "Error: " . mysqli_error($connection);
        }
    }
}
?>
