<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Assuming you have user_id and reqform_id stored in variables
    $user_id = $_POST['user_id']; // Retrieve user_id from POST data
    $reqform_id = $_POST['reqform_id']; // Retrieve reqform_id from POST data

    // Perform any necessary processing here
    $query = "UPDATE reqform SET is_deleted = '1' WHERE user_id= '$user_id'";
    $result = mysqli_query($connection, $query);

    // Construct the URL with user_id and reqform_id as parameters
    $redirect_url = 'tfixshopowner_progress4.php?user_id=' . urlencode($user_id) . '&reqform_id=' . urlencode($reqform_id);

    // Redirect to the constructed URL
    echo '<script>alert("Receipt sent successfully.");</script>';
    echo '<script>window.location.href = "' . $redirect_url . '";</script>';
}
?>
