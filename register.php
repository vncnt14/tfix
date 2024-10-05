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
		$role = $_POST["role"];
		$photo = isset($_POST["photo"]) ? $_POST["photo"] : 'Edit your Photo';
	
	$query = "INSERT INTO user (firstname, lastname, contact, address, email, username,  password, role, photo) VALUES ('$firstname','$lastname', '$contact', '$address', '$email', '$username','$password', '$role', '$photo')";
	
	if (mysqli_query($connection, $query)) {
		echo "<script>alert('Registration Successful!'); ";
        echo "window.location.href = 'tfixlogin.php';</script>";
	}	else {
		echo "ERROR: " . $query ."<br>" . mysqli_error($connection);
	}
}

mysqli_close($connection);
?>