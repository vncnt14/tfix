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

      /* Registration Form */
      .request-service-section {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        background-color: #96afc7;
        padding: 40px; /* Adjusted padding for better spacing */
        border-radius: 10px;
        margin-top: 10px; /* Adjusted margin-top to make it more adjustable */
        height: 512px;
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
        margin-top: -12px;
        margin-left: -42px
      }

      .submit-btn {
        background-color: #1b91ff;
        color: #fff;
        padding: 13px; /* Increased padding for more space */
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin: 0 10px;
        margin-left: 830px;
        
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
        <!-- Profile display goes here -->
        <img
          src="<?php echo $userData['photo']; ?>"
          alt="Profile Image"
          class="profile-image"
        />
        <div class="profile-name">
          <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?>
        </div>
      </div>
      <div class="section-line"></div>
      <!-- Added section line -->

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
      <a href="logout.php">Logout</a>
    </nav>
    <section>
      <!-- Registration Form Section -->
    
      <div class="request-service-section">
        <div class="right-section">
          <div class="section-title">Registration Form</div>
          <div class="line-separator"></div>

          <form class="details-form" action="registerpersonnel1.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="user_id" id="user_id" value="<?php echo $userData['user_id'];?>">
                <input type="hidden" name="is_deleted" id="is_deleted" value="">

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
            <label for="computer_skills">Computer Skills:</label>
                            <input type="text" id="computer_skills" name="computer_skills" required>
                        </div>

                        <!-- Second Form Section:  -->
                        <div class="form-section">
                        <label for="availability_for_work">Availability for Work:</label>
                            <select id="availability_for_work" name="availability" required>
                            <option value="Choose">Choose</option>
                                <option value="Full Time">Full Time</option>
                                <option value="Part Time">Part Time</option>
                            </select>
                        </div>

                       

              <!-- Fourth Form Section:  -->
            <div class="form-section certification-section">
              <label for="certification" class="file-upload">Certifications or Training</label>
              <div class="section-box">
                <input type="file" id="certification" name="certification" accept="image/*" required style="position: relative; top: -15px;">
              </div>
            </div>

               
                <!-- Submit and Cancel buttons added here -->
                  <button class="submit-btn" type="submit">Next</button></a>
                  <button class="cancel-btn" type="button">Cancel</button>
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
