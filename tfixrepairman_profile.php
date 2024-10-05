<?php
session_start();

// Include database connection file
include('config.php');  // You'll need to replace this with your actual database connection code

// Redirect to the login page if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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

        /* main content */
        .main-profile-section {
            padding: 55px;
        }

        .profile-details {
            display: flex;
            align-items: center;
        }

        .profile-info {
            margin-left: 15px;
        }

        .profile-image-main {
            width: 85px; /* Adjusted size of the profile picture */
            height: 85px; /* Adjusted size of the profile picture */
            border-radius: 50%;
            border: 2px solid #fff; /* Add border style and color */
        }

        .profile-name-main {
            font-size: 18px;
            margin-top: 30px;
            color: #fff; /* Changed profile name color to #fff */
        }

        .edit-profile-btn-main {
            background-color: #1b91ff;
            color: #fff;
            padding: 8px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-left: 750px; /* Adjusted margin for better spacing */
            text-decoration: none; /* Removed underline */
        }

        .edit-profile-btn-main:hover {
            background-color: #165bb5; /* Change the background color on hover if needed */
        }

        .section-line2 {
            border-top: 1px solid #fff; /* Added border style and color */
            margin-bottom: 30px; /* Adjusted margin for better spacing */
        }

        /* Timeline section */
        .timeline-section {
            background-color: #8394A4;
            border-radius: 5px;
            padding: 0px;
            height: 310px;
        }

        .timeline-buttons {
            display: flex;
            margin-bottom: 10px;
            justify-content: flex-start; /* Align buttons to the start of the container */
        }

        .timeline-button {
            background-color: #8394A4;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
            flex: 1; /* Make buttons equally share the container width */
        }

        .timeline-button.active {
            background-color: #617695; /* Change the background color for the active button */
        }

        .timeline-content {
            color: #555;
            padding: 20px;
            margin-top: 10px;
        }

        .content-box {
            display: flex;
            justify-content: space-between;
            border: 2px solid #617695;
            border-radius: 5px;
            padding: 20px;
        }

        
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
        <a href="tfixrepairman_profile.php">Profile</a>
        <a href="tfixrepairman_reqservice.php">Request Service</a>
        <a href="tfixrepairman_notif.php">Notification</a>
        <a href="tfixrepairman_message.php">Message</a>
        <a href="tfixrepairman_progress3.php">Progress</a>
        <a href="logout.php">Logout</a>
    </nav>

    <section>
        <!-- main content -->
        <div class="main-profile-section">
          <div class="profile-details">
              <img src="https://isl.org.pk/wp-content/uploads/2020/03/dummy-avatar-300x300.jpg" alt="Profile Image" class="profile-image-main">
              <div class="profile-info">
                  <div class="profile-name-main"></div>
                  <a href="tfixrepairman_editprofile.php" class="edit-profile-btn-main">Edit Profile</a>
              </div>
          </div>
          <div class="section-line2"></div> <!-- Added section line -->

          <!-- Timeline section -->
          <div class="timeline-section">
              <div class="timeline-buttons">
                  <button class="timeline-button" onclick="showRecentRequest()">Recent Request</button>
                  <button class="timeline-button" onclick="showPendingRequest()">Pending Request</button>
                  <button class="timeline-button" onclick="showCompletedRequest()">Completed Request</button>
              </div>
              
              <div class="timeline-content">
                  <!-- Your timeline content goes here -->
                  
              </div>
          </div>
        </div>
    </section>

    <script>
        function showRecentRequest() {
            resetTimelineButtons();
            document.querySelector('.timeline-button:nth-child(1)').classList.add('active');
            document.querySelector('.timeline-content').innerHTML = 'Recent request content goes here.';
        }

        function showPendingRequest() {
            resetTimelineButtons();
            document.querySelector('.timeline-button:nth-child(2)').classList.add('active');
            document.querySelector('.timeline-content').innerHTML = 'Pending request content goes here.';
        }

        function showCompletedRequest() {
            resetTimelineButtons();
            document.querySelector('.timeline-button:nth-child(3)').classList.add('active');
            // Adding content box with name and example date
            document.querySelector('.timeline-content').innerHTML = `
                <div class="content-box">
                    <div>John Doe</div>
                    <div>01-24-23</div>
                </div>
                .`;
        }

        function resetTimelineButtons() {
            const buttons = document.querySelectorAll('.timeline-button');
            buttons.forEach(button => button.classList.remove('active'));
        }
    </script>

</body>
</html>
