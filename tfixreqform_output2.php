<?php
session_start();

// Include database connection file
include('config.php');  // You'll need to replace this with your actual database connection code

if (!isset($_SESSION['user_id'])) {
    header("Location index.php");
    exit;
}


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

    // Fetch service data based on user_id and car_id
} else {
    die('User ID and Reqform ID not specified.');
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

        /* Request Service Form */
        .request-service-section {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            background-color: #96afc7;
            padding: 40px; /* Adjusted padding for better spacing */
            border-radius: 10px;
            margin-top: 10px; /* Adjusted margin-top to make it more adjustable */
            height: 640px;
        }

        .right-section {
            width: 100%; /* Adjusted width to fill the entire right section */
            padding-top: 20px; /* Adjusted padding-top for better spacing */
        }

        .section-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 20px;
            margin-top: -30px; /* Adjusted margin-top to move it more on top */
            margin-left: 380px;
            color: #fff;
        }

        .line-separator {
            border-top: 1px solid #ccc;
            margin-bottom: 20px;
            margin-top: -10px; /* Adjusted margin-top to move it more on top */
        }

        .details-form {
            display: flex;
            flex-wrap: wrap;
        }

        .form-section {
            width: 48%;
            margin-bottom: 10px;
        }

        .form-section label {
            display: block;
            margin-bottom: 5px;
        }

        .form-section input,
        .form-section select,
        .form-section textarea {
            width: calc(100% - 20px); /* Adjusted width for better spacing */
            padding: 15px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        .form-section textarea {
            height: 50px; /* Set a fixed height for consistency */
        }

        .button-container {
            text-align: center;
            margin-top: 15px;
            
        }

        .submit-btn {
            background-color: #1b91ff;
            color: #fff;
            padding: 13px; /* Increased padding for more space */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 0 10px;
            margin-left: 775px;
        }

        .cancel-btn {
            background-color: #1b91ff;
            color: #fff;
            padding: 13px; /* Increased padding for more space */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 0 10px;
        }

        .user-details-profile-box {
            display: none; /* Removed the user details profile box */
        }
        
    </style>
    <title>SIA AND ITSMAP</title>
</head>
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
        <a href="tfixpersonnel_accept.php">Progress</a>
        <a href="logout.php">Logout</a>
    </nav>

    <section>
        

        <div class="request-service-section">
            <div class="right-section">
                <div class="section-title">Request Service Form</div>
                <div class="line-separator"></div>

                <form class="details-form" action="tfixpersonnel_accept1.php" method="POST">
                    <div class="form-section">
                        <input type="hidden" id="user_id" name="user_id" value="<?php echo $userData['user_id'];?>">
                        <label for="firstname">First Name:</label>
                        <input type="text" id="firstname" name="firstname"  value="<?php echo $userData['firstname'];?>" readonly>
            

                        <label for="contact">Phone Number:</label>
                        <input type="text" id="contact" name="contact" value="<?php echo $userData['contact'];?>" readonly>
                    </div>

                    <div class="form-section">
                        <label for="lastname">Last Name:</label>
                        <input type="text" id="lastname" name="lastname"  value="<?php echo $userData['lastname'];?>" readonly>

                        <label for="address">Complete Home Address:</label>
                        <input type="text" id="address" name="address"  value="<?php echo $userData['address'];?>" readonly>
                    </div>

                   <!-- reqform table in database  -->

                   <div class="form-section">
                       <label for="date_requested">Date Requested:</label>
                       <input type="text" id="date_requested" name="date_requested"  value="<?php echo $reqformData['date_requested'];?>" readonly>
                   </div>

                    <div class="form-section">
                        <label for="unit_type">Unit Type:</label>
                        <input type="text" id="unit_type" name="unit_type"  value="<?php echo $reqformData['unit_type'];?>" readonly>
                    </div>

                    <div class="form-section">
                        <label for="unit_brand">Unit Brand:</label>
                        <input type="text" id="unit_brand" name="unit_brand"  value="<?php echo $reqformData['unit_brand'];?>" readonly>
                    </div>

                    <div class="form-section">
                        <label for="unit_brand">Unit Model:</label>
                        <input type="text" id="unit_model" name="unit_model"  value="<?php echo $reqformData['unit_model'];?>" readonly>
                    </div>
                    
                    <div class="form-section">
                        <label for="type_service">Service Type:</label>
                        <input type="text" id="type_service" name="type_service"  value="<?php echo $reqformData['type_service'];?>" readonly>
                    </div>

                    <div class="form-section">
                        <input type="hidden" id="reqform_id" name="reqform_id" value="<?php echo $reqformData['reqform_id'];?>">
                        <label for="unit_problem">Unit Problem:</label>
                        <input type="text" id="unit_problem" name="unit_problem"  value="<?php echo $reqformData['unit_problem'];?>" readonly>
                    </div>

                    <div class="form-section">
                        <label for="othert_problem">Other Problem:</label>
                        <input type="text" id="other_problem" name="other_problem"  value="<?php echo $reqformData['other_problem'];?>" readonly>
                    </div>



                    <div class="button-container">
                        <!-- Submit and Cancel buttons added here -->
                        <button class="submit-btn" type="submit">Accept</button>
                        <a href="tfixpersonnel_decline.php?reqform_id=<?php echo (isset($userData['user_id']) ? $userData['user_id'] : ''); ?>&reqform_id=<?php echo (isset($reqformData['reqform_id']) ? $reqformData['reqform_id'] : ''); ?>"><button class="cancel-btn" type="button">Decline</button></a>
                    </div>

                </form>
            </div>
        </div>
        <br>
        <br>
        <br>
    </section>


    
</body>
</html>