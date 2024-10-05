<?php
// Include the database configuration file
include('config.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the necessary form fields are set and not empty
    if(isset($_FILES['qrcode']) && !empty($_FILES['qrcode']['name']) && isset($_POST['user_id']) && !empty($_POST['user_id'])) {
        // Retrieve the G-Cash QR code from the form submission
        $user_id = mysqli_real_escape_string($connection, $_POST['user_id']);

        // File handling
        $file_name = $_FILES['qrcode']['name'];
        $file_tmp = $_FILES['qrcode']['tmp_name'];

        // Read file data
        $file_data = file_get_contents($file_tmp);

        // Prepare and execute the SQL query to insert the G-Cash QR code into the database
        $query = "INSERT INTO qr_code (qrcode, user_id) VALUES ('$file_name', '$user_id')";
        $result = mysqli_query($connection, $query);

        $query1= "UPDATE receipt SET payment = 'G CASH' WHERE user_id = '$user_id'";
        $result1 = mysqli_query($connection, $query1);

        $query2 = "UPDATE assignref SET unit_status = 'Payment Recieved' WHERE user_id = '$user_id'";
        $result2 = mysqli_query($connection, $query2);

        // Check if the insertion was successful
        if($result) {
            // Insertion successful
            echo '<script>alert("G-Cash QR code sent successfully.");</script>';
            echo '<script>window.location.href = "tfixuserprogress4.php?user_id=' . $user_id . '";</script>';
        } else {
            // Insertion failed
            echo '<p class="text-danger">Error: Failed to insert G-Cash QR code data.</p>';
        }
    } else {
        // Required form fields are missing
        echo '<p class="text-danger">Error: Please provide the G-Cash QR code and user ID.</p>';
    }
}
?>
