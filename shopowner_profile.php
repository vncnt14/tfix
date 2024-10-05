<?php
session_start();

// Include database connection file
include('config.php');  // You'll need to replace this with your actual database connection code

// Redirect to the login page if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location index.php");
    exit;
}

$user_id = $_SESSION['user_id'];


$query = "SELECT *FROM user WHERE user_id = '$user_id'";
$result = mysqli_query($connection, $query);
$userData = mysqli_fetch_assoc($result);

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

       /* Additional style for the permanent text */
       .permanent-text {
            text-align: center;
            font-size: 15px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #fff; /* Set text color to white */
        }

        /* Style for service boxes */
    .service-box {
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 10px;
        margin-bottom: 10px;
    }

    </style>
  
<body>

    <header>
        
    </header>

    <nav>
        <div class="profile-section">
            <!-- Profile display goes here -->
            <img src="<?php echo $userData['photo']; ?>" alt="Profile Image" class="profile-image">
            <div class="profile-name"><?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?></div>
        </div>
        <div class="section-line"></div> <!-- Added section line -->

       <!-- Navigation links -->
    <a href="profile.php">Profile</a>
    <a href="reqservice.php">Request Service</a>
    <a href="notif.php">Notification</a>
    <a href="message.html">Message</a>
    <a href="progress.html">Progress</a>
    <a href="progress.html">Inventory</a>
    <a href="progress.html">Finance</a> 
    <a href="logout.php">Log out</a>
</nav>

    <section>
        <!-- main content -->
        <div class="main-profile-section">
          <div class="profile-details">
              <img src="<?php echo $userData['photo']; ?>" alt="Profile Image" class="profile-image-main">
              <div class="profile-info">
                  <div class="profile-name-main"></div>
                  <a href="shopowner_editprofile.php" class="edit-profile-btn-main">Edit Profile</a>
              </div>
          </div>
          <div class="section-line2"></div> <!-- Added section line -->


          <!-- Permanent text -->
          <div class="permanent-text">AVAILABLE SERVICES</div>

          <!-- Your main content goes here -->
        <div id="services-container"></div>
    </div>
</section>

<!-- JavaScript to handle checkbox selection -->
<script>
    // Function to update main content based on selected services
    function updateMainContent() {
        // Get all checked checkboxes
        var checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
        
        // Clear previous content
        var servicesContainer = document.getElementById('services-container');
        servicesContainer.innerHTML = '';
        
        // Iterate through checked checkboxes and create service boxes
        checkboxes.forEach(function(checkbox) {
            var service = checkbox.value;
            var serviceBox = document.createElement('div');
            serviceBox.classList.add('service-box');
            serviceBox.textContent = service;
            servicesContainer.appendChild(serviceBox);
        });
    }
</script>

</body>
</html>
