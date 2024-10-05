<?php
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$findings = $_POST["findings"];
	$description = $_POST["description"];
	$inspect = $_POST["inspect"];
	$repairstatus = $_POST["repairstatus"];
	$assigned = $_POST["assigned"];

	
	$query = "INSERT INTO endorse (findings, description, inspect, repairstatus, assigned) 
	VALUES ('$findings',  '$description', '$inspect', '$repairstatus', '$assigned')";

	
	if (mysqli_query($connection, $query)) {
		echo '<script>alert("Endorsement completed!"); window.location.href = "tfixrepairman_endorse.php";</script>';
		exit;
	} else{
		echo "Error: " . $query . "<br>" . mysqli_error($connection);
	}
}	
mysqli_error ($connection);
?>