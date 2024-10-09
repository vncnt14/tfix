<?php
include("config.php");

session_start();



if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM user WHERE username=?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if ($password === $row["password"]) {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['username'] = $username;
            $_SESSION['firstname'] = $row['firstname'];
            $_SESSION['lastname'] = $row['lastname'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['appliance'] = $row['appliance'];
            $_SESSION['reqform_id'] = $row['reqform_id'];
            $_SESSION['repairman_id'] = $row['repairman_id'];

            if ($row['role'] === 'user') {
                header("Location: reqservice.php");
                exit();
            } elseif ($row['role'] === 'admin') {
                header("Location: admininterface.php");
                exit();
            } elseif ($row['role'] === 'repairman') {
                header("Location: tfixrepairman_reqservice.php");
                exit();    
            } elseif ($row['role'] === 'personnel') {
                header("Location: tfixpersonnel_reqservice.php");
                exit();
            } elseif ($row['role'] === 'shopowner') {
                header("Location: tfixshopowner_profile.php");
                exit();

                header("Location: dashboard.php");
                exit();
            }
        } else {
            echo '<script>';
            echo 'alert("Invalid Username or Password");';
            echo 'setTimeout(function() { window.location.href = "index.php"; },);';
            echo '</script>';
            exit();
        }
    } else {
        echo '<script>';
        echo 'alert("Invalid Username or Password");';
        echo 'setTimeout(function() { window.location.href = "index.php"; },);';
        echo '</script>';
        exit();
    }

    $stmt->close();
}

$connection->close();
?>