<?php
session_start();

// Include database connection file
include('config.php');

// Redirect to the login page if the user is not logged in
if (isset($_GET['user_id']) && isset($_GET['reqform_id'])) {
    $user_id = $_GET['user_id'];
    $reqform_id = $_GET['reqform_id'];

    // Fetch user data based on user_id
    $userData = mysqli_query($connection, "SELECT * FROM user WHERE user_id = '$user_id'");
    $userData = ($userData) ? mysqli_fetch_assoc($userData) : die('Error fetching user data: ' . mysqli_error($connection));

    // Fetch reqform data based on user_id and reqform_id
    $reqformData = mysqli_query($connection, "SELECT * FROM reqform WHERE user_id = '$user_id' AND reqform_id = '$reqform_id'");
    $reqformData = ($reqformData) ? mysqli_fetch_assoc($reqformData) : die('Error fetching reqform data: ' . mysqli_error($connection));

    // Fetch result data based on your requirements
    // Replace the following query with your actual query
    $result = mysqli_query($connection, "SELECT user.user_id, user.firstname, user.lastname, reqform_id, date_requested, unit_name
    FROM user
    JOIN reqform ON reqform.user_id = user.user_id");
    
    // Check if the query was successful
    if ($result) {
        // Fetch associative array
        while ($row = mysqli_fetch_assoc($result)) {
            // Your existing table row rendering code here

        }
    } else {
        echo '<tr><td colspan="4">Error: ' . mysqli_error($connection) . '</td></tr>';
    }
} else {
    die('User ID and Reqform ID not specified.');
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"
    />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css" /> 
       <title>SIA AND ITSMAP</title>
</head>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        header {
            background-color: #1b91ff;
            color: #fff;
            padding: 38px;
            text-align: center;
            position: fixed;
            width: 100%;
            top: 0;
        }

        nav {
            width: 220px;
            height: 100%;
            background-color: #9D9B9B;
            position: fixed;
            top: 0;
            left: 0;
            overflow-x: hidden;
            padding-top: 20px;
        }
        
        /*dashboard profile*/
        .profile-section {
            text-align: center;
            padding-bottom: 10px;
            color: #fff;
            padding: 5px; /* Adjusted padding for the profile section */
        }

        .profile-image {
            width: 65px;
            height: 65px;
            border-radius: 50%;
            border: 2px solid #fff; /* Add border style and color */
        }

        .profile-name {
            font-size: 18px;
            margin-top: 10px;
        }

        .profile-picture-btn {
            background-color: #1b91ff;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        nav a {
            padding: 15px;
            text-decoration: none;
            font-size: 18px;
            color: #fff;
            display: block;
        }

        nav a:hover {
            background-color: #727374;
            color: #fff;
        }

        .section-line {
            border-top: 1px solid #fff; /* Added border style and color */
            margin-bottom: 10px; /* Adjusted margin for better spacing */
        }

        section {
            margin-left: 220px; /* Adjusted margin to match the width of the nav */
            padding: 20px;
            margin-top: 65px; /* Adjusted margin-top to account for the height of the header */
            background-color: #cacaca;
        }
        .container{

            margin-left: 1%;
        }
        .v-1{

            background-color: #8FA2B4;
        }
        .click-request{
            color: #fff;
        }
        .notif-word{
            margin-left: 5%;
        }
        .v-2{
            background-color: #7C8E9E;
        }
        .v-3{
            padding-bottom: 430px;
        }


        /*main content*/
        



        

        
    </style>

<body>

    <header>
        
    </header>

    <nav>
        <div class="profile-section">
            <!-- Profile display goes here -->
            <img src="https://isl.org.pk/wp-content/uploads/2020/03/dummy-avatar-300x300.jpg" alt="Profile Image" class="profile-image">
            <div class="profile-name"><?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?></div>
        </div>
        <div class="section-line"></div> <!-- Added section line -->

        <!-- Navigation links -->
        <a href="tfixpersonnel_profile.php">Profile</a>
        <a href="tfixpersonnel_reqservice.php">Request Service</a>
        <a href="tfixpersonnel_notif.php">Notification</a>
        <a href="tfixpersonnel_message.php">Message</a>
        <a href="tfixpersonnel_progress3.php">Progress</a>
        <a href="logout.php">Log out</a>
    </nav>
    <section class="v-3">
        
        <div class="col-md-12 mb-4 text-dark  text-center"> <!-- Adjusted the column size for better visibility -->
            <table class="table">
                <thead class="">
                  
                </thead>
                <tbody class="v-2 text-light">
                    <!-- Inside the <tbody> section -->
                    <?php
                    if ($reqformData) {
                        foreach ($result as $row) {
                            echo '<tr>';
                            echo '<td>' . (isset($row['firstname']) ? $row['firstname'].' ' : 'N/A') . (isset($row['lastname']) ? $row['lastname'] : 'N/A') . '</td>';
                            echo '<td>' . (isset($row['date_requested']) ? $row['date_requested'].' ' : 'N/A') . '</td>';
                            echo '<td>';
                            if (isset($row['user_id']) && isset($row['reqform_id'])) {
                                echo '<button class="btn btn-primary" onclick="redirectToDiagnose(' . (int)$row['user_id'] . ', ' . (int)$row['reqform_id'] . ', \'' . strtolower($row['unit_name']) . '\')">Diagnose</button>';
                            } else {
                                echo 'Invalid data'; // or any other fallback behavior
                            }
                            echo '</td>';

                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="4">Error: ' . mysqli_error($connection) . '</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        
        
    </section>
    <script>
        function redirectToDiagnose(userId, reqformId, unitName) {
            if (unitName === 'refrigerator') {
                window.location.href = "tfixrepairman_progress.php?user_id=" + userId + "&reqform_id=" + reqformId;
            } else if (unitName === 'electricfan') {
                window.location.href = "tfixrepairman_progress1.php?user_id=" + userId + "&reqform_id=" + reqformId;
            } else {
                console.error("Invalid unit_name: " + unitName);
            }
        }
    </script>

    



    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.2/dist/chart.min.js"></script>
    <script src="./js/jquery-3.5.1.js"></script>
    <script src="./js/jquery.dataTables.min.js"></script>
    <script src="./js/dataTables.bootstrap5.min.js"></script>
    <script src="./js/script.js"></script>

</body>
</html>
