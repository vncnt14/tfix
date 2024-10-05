<?php
	require 'config.php';
	
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$firstname = $_POST["firstname"];
		$lastname = $_POST["lastname"];
		$username = $_POST["username"];
		$email = $_POST["email"];
		$password = $_POST["password"];
		$contact = $_POST["contact"];
		$address = $_POST["address"];
	
		$query = "INSERT INTO shopowner (firstname, lastname, contact, address, email, username,  password) VALUES ('$firstname','$lastname', '$contact', '$address', '$email', '$username','$password')";
	
	if (mysqli_query($connection, $query)) {
		echo "<script>alert('Registration Successful!'); ";
        echo "window.location.href = 'tfixshopowner_login.php';</script>";
	}	else {
		echo "ERROR: " . $query ."<br>" . mysqli_error($connection);
	}
}

mysqli_close($connection);
?>