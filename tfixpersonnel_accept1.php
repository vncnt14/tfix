<?php
// Include your database connection file here
include 'config.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    $user_id = $_POST['user_id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $unit_type = $_POST['unit_type'];
    $unit_brand = $_POST['unit_brand'];
    $unit_model = $_POST['unit_model'];
    $unit_problem = $_POST['unit_problem'];
    $other_problem = $_POST['other_problem'];
    $date_requested = $_POST['date_requested'];
    $type_service = $_POST['type_service'];
    $reqform_id = $_POST['reqform_id'];

    // Insert data into the accept table
    $query = "INSERT INTO accept (user_id, firstname, lastname, contact, address, unit_type, unit_brand, unit_model, unit_problem, other_problem, date_requested, type_service, reqform_id) 
              VALUES ('$user_id', '$firstname', '$lastname', '$contact', '$address', '$unit_type', '$unit_brand', '$unit_model', '$unit_problem', '$other_problem', '$date_requested', '$type_service', '$reqform_id')";
    
    if (mysqli_query($connection, $query)) {

        $select_query = "SELECT *FROM reqform WHERE reqform_id = '$reqform_id' AND user_id = '$user_id'";
        $result = mysqli_query($connection, $select_query);
        $reqformData = mysqli_fetch_assoc($result);
        // Data successfully inserted into the accept table
        echo '<script>window.location.href = "tfixpersonnel_accept.php?user_id=' . (int)$reqformData['user_id'] . '&reqform_id=' . (int)$reqformData['reqform_id'] . '";</script>';
    } else {
        // Error occurred
        echo "Error: " . $query . "<br>" . mysqli_error($connection);
    }
    
    

    // Optionally, you can delete the data from the reqform table after it's moved to the accept table
    // Remember to handle this deletion carefully as it permanently removes data
    $reqform_id = $_POST['reqform_id'];
    $user_id = $_POST['user_id'];

     $delete_query = "DELETE FROM reqform WHERE user_id = '$reqform_id' AND '$user_id'";
     mysqli_query($connection, $delete_query);

    // Close the database connection
    mysqli_close($connection);
}
?>
