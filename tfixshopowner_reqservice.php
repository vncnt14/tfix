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

// Fetch owner information based on user ID
$query = "SELECT * FROM owner WHERE user_id = '$user_id'";
$result = mysqli_query($connection, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $ownerData = mysqli_fetch_assoc($result);
} else {
    // Handle error if owner data cannot be retrieved
    echo "Error fetching owner data";
    exit;
}

// Fetch user information based on ID
$userID = $_SESSION['user_id'];

// Fetch user information from the database based on the user's ID
// Replace this with your actual database query
$query = "SELECT * FROM user WHERE user_id = '$userID'";
// Execute the query and fetch the user data
$result = mysqli_query($connection, $query);
$userData = mysqli_fetch_assoc($result);

// Close the database connection
mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
        background-color: #9d9b9b;
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


        .home-section {
  padding: 20px;
}

.carousel {
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.row {
  display: flex;
  justify-content: space-between;
  margin-bottom: 10px;
}

.box {
  flex-basis: calc(33.33% - 10px);
  background-color: #fff;
  border: 1px solid #ddd;
  border-radius: 5px;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 10px;
  margin-right: 10px; /* Add margin for spacing between image boxes */
}

.box a {
  display: block;
  text-decoration: none;
  color: black;
}

.box img {
  width: 100%;
  height: 165px;
  margin-top: 10px;
  object-fit: contain;
}

.box p {
  text-align: center;
  margin-top: 10px;
}

.box:hover {
  box-shadow: 0 0 5px rgba(7, 7, 7, 0.3); /* Add hover effect */
}

.home-section {
  padding: 20px;
  
  text-align: center;
  overflow: hidden; /* Prevent scrolling */
}

.title-wrapper {
  display: flex;
  justify-content: center;
  align-items: flex-end;
  position: relative;
  color: #fff;
  
 

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
    <title>SIA AND ITSMAP</title>
</head>
<body>

    <header>
        
    </header>

    <nav>
        <div class="profile-section">
        <img src="<?php echo $ownerData['photo']; ?>" alt="Profile Image" class="profile-image">
        <div class="profile-name"><?php echo isset($ownerData['shop_name']) ? $ownerData['shop_name'] : ''; ?></div>
    </div>
    <div class="section-line"></div> <!-- Added section line -->

        <!-- Navigation links -->
        <a href="tfixshopowner_profile.php">Profile</a>
            <a href="tfixshopowner_reqservice.php">Request Service</a>
            <a href="tfixshopowner_reqservice1.php">Request Application</a>
            <a href="notif.php">Notification</a>
            <a href="message.php">Message</a>
            <a href="tfixshopowner_progress.php">Progress</a>
            <a href="tfixshopowner_inventory.php">Inventory</a>
            <a href="tfixshopowner_records.php">Sales Record</a>
            <a href="logout.php">Logout</a>
        </nav>

    <section>
        <!-- main content -->
        <div class="main-profile-section">
          <div class="profile-details">
              <img src="https://t3.ftcdn.net/jpg/01/77/73/64/360_F_177736425_bP66D31xlmnSD0DnGFgw8owfYzXP507W.jpg" alt="Profile Image" class="profile-image-main">
              <div class="profile-info">
              <div class="profile-name-main">Appliance Repair Services</div>
                  <!-- <a href="editprofile.php" class="edit-profile-btn-main">Edit Profile</a>-->
              </div>
          </div>
          <br>
          <div class="section-line2"></div> <!-- Added section line -->
<!--
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
          <br>
          <br>
-->

          <div class="home-section">
    <div class="title-wrapper">
      <span class="underline"><b>Available Services<b></span>
    </div>
        <div class="carousel">
        <div class="row">
            <div class="box">
            <a href="reqform.php">
                <img src="https://www.fixitapplianceservice.com/uploads/upload/images/refrigerator-repair.jpg" alt="Washing Machine">
                <p>Repair</p>
            </a>
            </div>
            <div class="box">
            <a href="next-page-url">
                <img src="https://static.wixstatic.com/media/204960_d2359f524654407aa9a4e1d618040b15~mv2.jpeg/v1/fill/w_323,h_215,al_c,q_80,usm_0.66_1.00_0.01,enc_auto/AdobeStock_432275658.jpeg" alt="Toaster">
                <p>Maintenance</p>
            </a>
            </div>
            <div class="box">
            <a href="next-page-url">
                <img src="https://media-content.angi.com/c904d74a-b6ca-4a6a-8b75-c81e137c3e20.jpg" alt="Microwave">
                <p>Installing</p>
            </a>
            </div>
