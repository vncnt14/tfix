<?php
session_start();
include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $unit_id = $_POST['unit_id'];
    $unit_type = $_POST['unit_type'];
    $unit_brand = $_POST['unit_brand'];
    $prodcut_name = $_POST['product_name'];
    $stocks = $_POST['stocks'];
    $price = $_POST['price'];

    // Prepare and execute SQL INSERT statement
    $query = "INSERT INTO product (unit_id, unit_type, unit_brand, product_name, stocks, price) 
              VALUES ('$unit_id', '$unit_type', '$unit_brand', '$prodcut_name', $stocks, $price)";
    $result = mysqli_query($connection, $query);

    if ($result) {
        echo '<script>';
        echo 'alert("Product removed successfully!");';
        echo 'window.location.href = "exampleinventory.php";'; // Redirect to view_cart.php after alert
        echo '</script>';
    } else {
        echo "Error adding product: " . mysqli_error($connection);
    }
}
?>
