<?php
session_start();

// Include database connection file
include('config.php');  // You'll need to replace this with your actual database connection code

// Redirect to the login page if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location index.php");
    exit;
}

// Fetch user information based on ID
$user_id = $_SESSION['user_id'];

// Fetch user information from the database based on the user's ID
// Replace this with your actual database query
$query = "SELECT * FROM user WHERE user_id = '$user_id'";
// Execute the query and fetch the user data
$result = mysqli_query($connection, $query);
$userData = mysqli_fetch_assoc($result);

// Close the database connection
mysqli_close($connection);
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

        /*main content*/
        .user-details-section {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        background-color: #96afc7;
        padding: 40px; /* Adjusted padding for better spacing */
        border-radius: 10px;
        margin-top: 10px; /* Adjusted margin-top to make it more adjustable */
        height: 438px;
        }

        .right-section {
        width: 65%;
        padding-top: 20px; /* Adjusted padding-top for better spacing */
        }

        .section-title {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 20px;
        margin-top: -30px; /* Adjusted margin-top to move it more on top */
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
        margin-bottom: 5px;
        margin-top: -10px; /* Adjusted margin-top to move it more on top */
        }

        .form-section input {
            width: calc(100% - 20px); /* Adjusted width for better spacing */
            padding: 10px;
            margin-bottom: 20px;
            box-sizing: border-box;
        }

        .save-changes-btn {
        background-color: #1b91ff;
        color: #fff;
        padding: 13px; /* Increased padding for more space */
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 50px; /* Adjusted margin-top to move it more below */
        margin-left: 490px; /* Adjusted margin-right to move it more to the right */
        }

        .user-details-profile-box {
        border: 1px solid #777;
        border-radius: 1px;
        padding: 70px;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        }

        .user-details-profile-image {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        }

        .choose-file-btn {
        background-color: #1b91ff;
        color: #fff;
        padding: 5px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 20px;
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
            <!-- Profile display goes here -->
            <img src="<?php echo $userData['photo']; ?>" alt="Profile Image" class="profile-image">
            <div class="profile-name"><?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?></div>
        </div>
        <div class="section-line"></div> <!-- Added section line -->

        <!-- Navigation links -->
        <a href="profile.php">Profile</a>
        <a href="reqservice.html">Request Service</a>
        <a href="notif.html">Notification</a>
        <a href="message.html">Message</a>
        <a href="progress.html">Progress</a>
        <div class="dropdown">
        <button class="dropbtn">Apply As</button>
        <div class="dropdown-content">
            <a href="registerowner.php">Apply as Owner</a>
            <a href="registerrepairman.php">Apply as Repairman</a>
            <a href="registerpersonnel.php">Apply as Personnel</a>
        </div>
    </div>
        <a href="logout.php">Logout</a>
    </nav>

    <section>
        <!-- User account details edit section -->
        <form action="edit_picture.php" method="POST" enctype="multipart/form-data">
            
            <div class="user-details-section">
                <div class="left-section">  
                    <div class="user-details-profile-box">
                        <img src="<?php echo $userData['photo']; ?>" alt="" class="user-details-profile-image" id="">
                        <input type="hidden" name="user_id" id="user_id" value="<?php echo $userData['user_id'];?>">
                        <label for="fileInput" class="choose-file-btn">Upload Picture</label>
                        <input type="file" class="form-control" accept="image/*" id="fileInput" name="photo" style="display:none;"/>
                        <button type="submit" class="choose-file-btn">Save Photo</button>
                    </div>
                </div>
        </form>    
            <div class="right-section">
                <div class="section-title">User Account Details</div>
                <div class="line-separator"></div>

                <form class="details-form" action="tfix_update.php" method="POST">
                    <div class="form-section">
                        <label for="firstname">First Name:</label>
                        <input type="text" id="firstname" name="firstname" value="<?php echo $userData['firstname'];?>">

                        <label for="contact">Phone Number:</label>
                        <input type="text" id="contact" name="contact" value="<?php echo $userData['contact'];?>">
                        
                    </div>

                    <div class="form-section">
                        <label for="lastname">Last Name:</label>
                        <input type="text" id="lastname" name="lastname" value="<?php echo $userData['lastname'];?>">
                        
                        <label for="address">Complete Home Address:</label>
                        <input type="text" id="address" name="address" value="<?php echo $userData['address'];?>">
                    </div>

                    <div class="form-section">
                        <label for="email">Email Address:</label>
                        <input type="email" id="email" name="email" value="<?php echo $userData['email'];?>">
                    </div>
                    <div class="form-section">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" value="<?php echo $userData['username'];?>">
                    </div>

                    <div class="form-section">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" value="<?php echo $userData['password'];?>">
                    </div>
                    
                    <!-- Save Changes button added here -->
                    <button class="save-changes-btn">Save Changes</button>
                    
                </form>
            </div>
        </div>
    </section>

    <script>
        // Check if there's a saved image in local storage
        var savedImage = localStorage.getItem('userDetailsImage');
        if (savedImage) {
            document.getElementById('userDetailsImage').src = savedImage;
            document.querySelector('.profile-image').src = savedImage;
        }

        function updateProfileImages(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    var imageSrc = e.target.result;

                    // Set the image source
                    document.getElementById('userDetailsImage').src = imageSrc;
                    document.querySelector('.profile-image').src = imageSrc;

                    // Save the image source to local storage
                    localStorage.setItem('userDetailsImage', imageSrc);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

         // Add click event listener to the "Save Changes" button
        document.querySelector('.save-changes-btn').addEventListener('click', function () {
        // Redirect to another page (replace 'yourNewPage.html' with the actual URL)
        window.location.href = 'reqservice.html';
        });
    </script>



</body>
</html>
