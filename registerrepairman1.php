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
}
$repairman_id = $_GET['repairman_id'];

// Fetch user information from the database based on the user's ID
// Replace this with your actual database query
$query = "SELECT repairman.*, user.firstname, user.lastname, user.role, user.photo, repairman.availability, 
          repairman.experience, repairman.appliance, repairman.expertise, repairman.appliance
          FROM repairman 
          INNER JOIN user ON repairman.user_id = user.user_id WHERE repairman_id ='$repairman_id'";
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

      /* Registration Form */
      .request-service-section {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        background-color: #96afc7;
        padding: 40px; /* Adjusted padding for better spacing */
        border-radius: 10px;
        margin-top: 10px; /* Adjusted margin-top to make it more adjustable */
        height: 800px;
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
        
        display: flex; /* Use flexbox to align items horizontally */
        justify-content: center; /* Center the buttons horizontally */
      }

      .form-section {
        width: 50%;
        margin-bottom: 20px;
      }

      .form-section label {
        display: block;
        margin-bottom: 5px;
      }

      .form-section input[type="text"] {
    width: calc(100% - 20px); /* Adjusted width for better spacing */
    padding: 15px;
    margin-bottom: 10px;
    box-sizing: border-box;
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
        margin-top: -12px;
        margin-left: -42px
      }

      

      .submit-btn,
      .cancel-btn {
        background-color: #1b91ff;
        color: #fff;
        padding: 13px; /* Increased padding for more space */
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin: 0 10px;
      }

      /* You can adjust the margin between the buttons if needed */
      .cancel-btn {
        margin-left: 759px; /* Adjust as needed */
      }


      .user-details-profile-box {
        display: none; /* Removed the user details profile box */
      }

 /* File Upload Styling */
 .section-box {
  background-color: #fff;
  border-radius: 0px;
  width: calc(100% - 20px); /* Adjusted width for better spacing */
    padding: 15px;
       height: 50px;
        box-sizing: border-box;
  
}

.skill-expertise,
.type-appliance {
            margin-top: 30px;
            margin-right: 550px;
            
        }

        .skill-expertise label,
        .type-appliance label {
            display: block;
            margin-bottom: 10px;
        }

        .skill-expertise input[type="checkbox"]
        .type-appliance  input[type="checkbox"]{
            margin-right: 5px; /* Adjust margin for checkboxes */
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
    <header></header>

    <nav>
        <div class="profile-section">
        <img src="<?php echo $ownerData['photo']; ?>" alt="Profile Image" class="profile-image">
        <div class="profile-name"><?php echo isset($ownerData['shop_name']) ? $ownerData['shop_name'] : ''; ?></div>
    </div>
    <div class="section-line"></div>
      <!-- Added section line -->

      <!-- Navigation links -->
      <a href="tfixshopowner_profile.php">Profile</a>
            <a href="tfixshopowner_reqservice.php">Request Service</a>
            <div class="dropdown">
                <button class="dropbtn">Request Application</button>
                <div class="dropdown-content">
                    <a href="tfixshopowner_reqservice1.php">Repairman</a>
                    <a href="tfixshopowner_reqservice2.php">Personnel</a>
                </div>
                </div>
            <a href="notif.php">Notification</a>
            <a href="message.php">Message</a>
            <a href="tfixshopowner_progress.php">Progress</a>
            <a href="tfixshopowner_inventory.php">Inventory</a>
            <a href="tfixshopowner_records.php">Sales Record</a>
            <a href="logout.php">Logout</a>
        </nav>
    <section>
      <!-- Registration Form Section -->
    
      <div class="request-service-section">
        <div class="right-section">
          <div class="section-title">Registration Form</div>
          <div class="line-separator"></div>

              <form class="details-form" action="registerrepairman3.php" method="POST" enctype="multipart/form-data">
                  <input type="hidden" name="user_id" id="user_id" value="<?php echo $userData['user_id'];?>">
                  <input type="hidden" name="role" id="role" value="<?php echo $userData['role'];?>">
                  <input type="hidden" name="is_deleted" id="is_deleted" value="<?php echo $userData['is_deleted'];?>">

                  <div class="form-section">
                      <label for="firstname">First Name:</label>
                      <input type="text" id="firstname" name="firstname" readonly value="<?php echo $userData['firstname'];?>">
                  </div>

                  <div class="form-section">
                      <label for="lastname">Last Name:</label>
                      <input type="text" id="lastname" name="lastname" readonly value="<?php echo $userData['lastname'];?>">
                  </div>

                  <div class="form-section">
                      <label for="contact">Phone Number:</label>
                      <input type="tel" id="contact" name="contact" readonly value="<?php echo $userData['contact'];?>">
                  </div>

                  <div class="form-section">
                      <label for="address">Complete Home Address:</label>
                      <input type="text" id="address" name="address" readonly value="<?php echo $userData['address'];?>">
                  </div>

                  <!-- Email Address -->
                  <div class="form-section">
                      <label for="email">Email Address:</label>
                      <input type="email" id="email" name="email" readonly value="<?php echo $userData['email'];?>">
                  </div>

                <!-- First Form Section: -->
                <div class="form-section">
                      <label for="experience">Years of Experience:</label>
                      <input type="text" id="years_of_experience" name="experience" readonly value="<?php echo $userData['experience'];?>">
                  </div>

                  <!-- Second Form Section:  -->
                  <div class="form-section">
                      <label for="availability">Availability for Work:</label>
                      <input type="text" id="availability_for_work" name="availability" readonly value="<?php echo $userData['availability'];?>">
                  </div>

                 <!-- Second Form Section:  -->
                 <div class="form-section">
                      <label for="certification">Certification:</label>
                      <input type="text" id="certification" name="certification" readonly value="<?php echo $userData['certification'];?>">
                  </div>


                  <!-- Fourth Form Section:  -->
                  <div class="form-section">
                    <label for="expertise">Skills/Expertise:</label>
                    <?php foreach ($result as $userData): ?>
                        <input type="text" class="input-field" id="expertise" name="expertise[]" readonly value="<?php echo $userData['expertise']; ?>">
                    <?php endforeach; ?>
                  </div>

                  <div class="form-section">
                <label for="appliance">Appliance:</label>
                <?php foreach ($result as $userData): ?>
                    <input type="text" class="input-field" id="appliance" name="appliance[]" readonly value="<?php echo $userData['appliance']; ?>">
                <?php endforeach; ?>
            </div>

                    <!-- Submit and Cancel buttons added here -->
                    <button type="button" class="cancel-btn" onclick="window.location.href = 'decline_page.php';">Decline</button>
                    <button type="submit" class="submit-btn">Approve</button>
                </div>
            </form>
          </div>
      </div>
      </section>  
   
      
    <script>
        // Add click event listener to the "Cancel" button
        document
          .querySelector(".cancel-btn")
          .addEventListener("click", function () {
            // Navigate to the previous page
            window.history.back();
          });
      
    </script>

    
  </body>
</html>
