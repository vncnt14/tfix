<?php
	session_start();
	require_once "config.php";

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$username = $_POST["username"];
		$password = $_POST["password"];
		
		$query = "SELECT * FROM user WHERE username = '$username'";
		$result = mysqli_query($connection, $query);
		
		if(mysqli_num_rows($result) > 0){
			$row = mysqli_fetch_assoc($result);
		
			if($password === $row['password']) {
				$_SESSION['firstname'] = $row['firstname'];
				$_SESSION['lastname'] = $row['lastname'];
				$_SESSION['email'] = $row['email'];
				$_SESSION['contact'] = $row['contact'];
				$_SESSION['username'] = $row['username'];
				$_SESSION['password'] = $row['password'];
				$_SESSION['id'] = $row['id'];
				
				if ($row['role'] == 'Administrator') {
					$_SESSION['is_admin'] = true;
					header("Location: admin.php");
				} else {
					$_SESSION['is_admin'] = false;
					header("Location: profile.php");
				}
				
			} else{
				echo '<script>alert("Invalid password. Please try again."); window.location.href = "tfixlogin.php";</script>';
			}
		} else{
			echo '<script>alert("User not found. Please try again."); window.location.href = "tfixlogin.php";</script>';
		}
	}

	mysqli_close($connection);
	?>
