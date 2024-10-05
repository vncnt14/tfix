<?php
	require 'config.php';
	
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$firstname = $_POST["firstname"];
		$lastname = $_POST["lastname"];
		$email = $_POST["email"];
        $appliance = $_POST["appliance"];
        $expertise = $_POST["expertise"];
        $username = $_POST["username"];
		$password = $_POST["password"];
	
	$query = "INSERT INTO repairman (firstname, lastname, email, appliance, expertise, username,  password) VALUES ('$firstname','$lastname', '$email', '$appliance', '$expertise', '$username',  '$password')";
	
	if (mysqli_query($connection, $query)) {
        echo "<script>alert('Registration Successful!'); ";
        echo "window.location.href = 'tfixrepairman_login.php';</script>";

    } else {
        echo "ERROR: " . $query . "<br>" . mysqli_error($connection);
    
        echo "<script>alert('Error: " . mysqli_error($connection) . "'); </script>";
}
    }
mysqli_close($connection);
?>