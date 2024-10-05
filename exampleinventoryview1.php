<?php
// Assuming this is exampleinventoryview1.php
include('config.php');

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : null;
    $stocks = isset($_POST['stocks']) ? $_POST['stocks'] : null;
    $price = isset($_POST['price']) ? $_POST['price'] : null;

    // Validate and sanitize input (not shown here for brevity)

    // Update the product in the database

    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prepare update query
    $update_query = "UPDATE product SET stocks = '$stocks', price = '$price' WHERE product_id = '$product_id'";

    if (mysqli_query($connection, $update_query)) {
        // Redirect to a success page or display a success message
        echo '<script>alert("Product updated successfully!");</script>';
        echo '<script>window.location.href = "exampleinventory.php";</script>';
    } else {
        // Handle update failure (e.g., display error message)
        echo '<script>alert("Error updating product: ' . mysqli_error($connection) . '");</script>';
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
