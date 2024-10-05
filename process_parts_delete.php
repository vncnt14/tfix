<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['part_id'])) {
    // Include database connection file
    include('config.php');

    // Retrieve part ID from the form
    $part_id = $_POST['part_id'];
    $unit_brand = $_POST['unit_brand'];
    $unit_id = $_POST['unit_id'];

    // Prepare SQL statement to delete the part
    $sql = "DELETE FROM parts WHERE part_id = ?";

    // Prepare and bind parameters
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $part_id);

    // Execute the delete query
    if ($stmt->execute()) {
        // Redirect to a success page or display a success message
        header("Location: ownerinventory_add1.php?unit_id=" . urlencode($unit_id) . "&unit_brand=" . urlencode($unit_brand));

        exit;
    } else {
        // Redirect to an error page or display an error message
        header("Location: ownerinventory.php?error=1");
        exit;
    }

    // Close the statement
    $stmt->close();

    // Close the connection
    $connection->close();
}
?>
