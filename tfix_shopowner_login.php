<?php
session_start();
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize user input to prevent SQL injection
    $username = mysqli_real_escape_string($connection, $_POST["username"]);
    $password = mysqli_real_escape_string($connection, $_POST["password"]);

    // Query to fetch user details based on username
    $query = "SELECT * FROM owner WHERE username = '$username'";
    $result = mysqli_query($connection, $query);

    if (!$result) {
        // Query execution failed, display error message
        die("Query failed: " . mysqli_error($connection));
    }

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        // Verify password
        if ($password === $row['password']) {
            // Password is correct, set session variables
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['reqform_id'] = $row['reqform_id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['repairman_id'] = $row['repairman_id'];
            $_SESSION['firstname'] = $row['firstname'];
            $_SESSION['lastname'] = $row['lastname'];

            // Redirect to the main page or any other authenticated page
            header("Location: tfixshopowner_reqservice.php");
            exit;
        } else {
            // Invalid password
            echo "<script>alert('Invalid password. Please try again.');</script>";
            echo "<script>
                    setTimeout(function() {
                        window.location.href = 'tfixshopowner_login.php';
                    }, 1000); // Redirect after 1 second
                  </script>";
            exit;
        }
    } else {
        // User not found
        echo "<script>alert('User not found. Please try again.');</script>";
        echo "<script>
                setTimeout(function() {
                    window.location.href = 'tfixshopowner_login.php';
                }, 1000); // Redirect after 1 second
              </script>";
        exit;
    }
}

mysqli_close($connection);
?>
