<?php
session_start();
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
	
    


    $query = "SELECT * FROM repairman WHERE username = '$username'";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        if ($password === $row['password']) {
            // Set user details in the session
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['reqform_id'] = $row['reqform_id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['repairman_id'] = $row['repairman_id'];
            $_SESSION['firstname'] = $row['firstname'];
            $_SESSION['lastname'] = $row['lastname'];

            // Redirect to the main page or any other authenticated page
            header("Location: tfixrepairman_reqservice.php");
            exit;
        } else {
            echo "<script>alert('Invalid password. Please try again.');</script>";
            echo "<script>
                    setTimeout(function() {
                        window.location.href = 'tfixrepairman_login.php';
                    }, 100); // Redirect after 1 second
                  </script>";
            exit;
        }
    } else {
        echo "<script>alert('User not found. Please try again.');</script>";
        echo "<script>
                setTimeout(function() {
                    window.location.href = 'tfixrepairman_login.php';
                }, 1000); // Redirect after 1 second
              </script>";
        exit;
    }
}

mysqli_close($connection);
?>