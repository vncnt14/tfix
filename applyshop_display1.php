<?php
// Define your alert message
$alert_message = "Application submitted succesfully.";

// Define the URL to redirect to
$redirect_url = "applyshop_display.php";

// Generate the JavaScript code for the alert message and redirection
$js_code = "<script>";
$js_code .= "alert('" . addslashes($alert_message) . "');";
$js_code .= "window.location.href = '" . $redirect_url . "';";
$js_code .= "</script>";

// Output the JavaScript code
echo $js_code;
?>
