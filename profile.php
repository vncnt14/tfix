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

$query1 = "SELECT *FROM owner";
$result1 = mysqli_query($connection, $query1);
$ownerData = mysqli_fetch_assoc($result1);

$query2 = "SELECT *FROM qr_code WHERE user_id = '$user_id'";
$result2 = mysqli_query($connection, $query2);
$qrData = mysqli_fetch_assoc($result2);

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
            background-color: #617695;
            border-radius: 5px;
            padding: 20px;
            color: white;
        }

        /* APPLY AS Dropdown styles */
/* Dropdown styles */
.dropdown {
    position: relative;
    display: inline-block;
}

.dropbtn {
    background-color: #9D9B9B;
    color: #fff; /* Set font color to white to match other navigation links */
    padding: 15px;
    font-size: 18px; /* Set font size to match other navigation links */
    font-family: Arial, sans-serif; /* Set font family to match other navigation links */
    border: none;
    cursor: pointer;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #9D9B9B;
    min-width: 160px;
    box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
    z-index: 1;
}

.dropdown-content a {
    color: #fff; /* Set font color to white to match other navigation links */
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    font-size: 18px; /* Set font size to match other navigation links */
    font-family: Arial, sans-serif; /* Set font family to match other navigation links */
}

.dropdown-content a:hover {
    background-color: #727374;
}

.dropdown:hover .dropdown-content {
    display: block;
}

.dropdown:hover .dropbtn {
    background-color: #727374;
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
        <a href="message.php">Message</a>
        <a href="progress.php">Progress</a>
        <div class="dropdown">
            <button class="dropbtn">Apply As</button>
            <div class="dropdown-content">
                <a href="registerowner.php">Apply as Owner</a>
                <a href="registerrepairman.php">Apply as Repairman</a>
                <a href="registerpersonnel.php">Apply as Personnel</a>
            </div>
        </div>
        <a href="logout.php">Log out</a>
    </nav>


    <section>
        <!-- main content -->
        <div class="main-profile-section">
          <div class="profile-details">
              <img src="<?php echo $userData['photo']; ?>" alt="Profile Image" class="profile-image-main">
              <div class="profile-info">
                  <div class="profile-name-main"></div>
                  <a href="editprofile.php" class="edit-profile-btn-main">Edit Profile</a>
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
                    <div><?php echo $ownerData['shop_name'];?></div>
                    <div><?php echo $qrData['created_at'];?></div>
                    <div><a href="tfixuserreciept.php?user_id=<?php echo $user_id; ?>"><button type="button" class="btn btn-primary">View Receipt</button></a></div>
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
