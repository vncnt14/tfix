<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database connection file
    include('config.php');

    // Retrieve form data
    $part_id = $_POST['part_id'];
    $unit_id = $_POST['unit_id'];
    $unit_brand = $_POST['unit_brand'];
    $parts_name = $_POST['parts_name'];
    $stocks = $_POST['stocks'];
    $price = $_POST['price'];

    // Prepare SQL statement to update parts table
    $sql = "UPDATE parts SET parts_name=?, stocks=?, price=? WHERE part_id=?";

    // Prepare and bind parameters
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("sdsi", $parts_name, $stocks, $price, $part_id);

    // Execute the update statement
    if ($stmt->execute()) {
        // Redirect to a success page or display a success message
        header("Location: ownerinventory_add1.php?unit_id=" . urlencode($unit_id) . "&part_id=" . urlencode($part_id). "&unit_brand=" . urlencode($unit_brand));
        exit;
    } else {
        // Redirect to an error page or display an error message
        header("Location: ownerinventory_edit.php?error=1");
        exit;
    }

    // Close the statement and database connection
    $stmt->close();
    $connection->close();
} else {
    // Redirect to an error page or display an error message if form is not submitted
    header("Location: ownerinventory_edit.php?error=1");
    exit;
}
?>
