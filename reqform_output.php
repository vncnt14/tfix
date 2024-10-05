<?php
session_start();

// Include database connection file
include('config.php');

// Redirect to the login page if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Assuming you have a user ID stored in the session
$user_id = $_GET['user_id'];

// Fetch user information from both tables using a SQL JOIN
$query = "SELECT reqform.*, user.*
          FROM reqform
          JOIN user ON user.user_id = reqform.user_id
          WHERE user.user_id = '$user_id'";

$result = mysqli_query($connection, $query);

// Check if the query was successful
if ($result) {
    $userData = mysqli_fetch_assoc($result);

    // Display the user data

    // You can continue to display other fields as needed

    // Close the database connection
    mysqli_close($connection);
} else {
    // Handle the error or log it
    echo "Error: " . mysqli_error($connection);
    // Close the database connection
    mysqli_close($connection);
    exit;
}
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

      /* Request Service Form */
      .request-service-section {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        background-color: #96afc7;
        padding: 40px; /* Adjusted padding for better spacing */
        border-radius: 10px;
        margin-top: 10px; /* Adjusted margin-top to make it more adjustable */
        height: 550px;
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
        margin-top: 20px;
        margin-left: -20px;
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
      <!-- Request Service Form Section -->
      <div class="request-service-section">
        <div class="right-section">
          <div class="section-title">Request Service Form</div>
          <div class="line-separator"></div>

          <form class="details-form" action="" method="POST">
            <div class="form-section">
              <label for="firstName">First Name:</label>
              <input
                type="text"
                id="firstName"
                name="firstName"
                value="<?php echo $userData['firstname'];?>"
                disabled
              />

              <label for="contact">Phone Number:</label>
              <input
                type="text"
                id="contact"
                name="contact"
                value="<?php echo $userData['contact'];?>"
                disabled
              />
            </div>

            <div class="form-section">
              <label for="lastname">Last Name:</label>
              <input
                type="text"
                id="lastname"
                name="lastname"
                value="<?php echo $userData['lastname'];?>"
                disabled
              />

              <label for="address">Complete Home Address:</label>
              <input
                type="text"
                id="address"
                name="address"
                value="<?php echo $userData['address'];?>"
                disabled
                />
              </div>
              
              <!-- reqform table in database  -->
              <div class="form-section">
                <label for="date_requested">Date Requested:</label>
                <input
                  type="text"
                  id="date_requested"
                  name="date_requested"
                  value="<?php echo $userData['date_requested'];?>"
                  disabled
                />
              </div>
              
            <div class="form-section">
              <label for="unit_name">Unit Type:</label>
              <input
                type="text"
                id="unit_type"
                name="unit_type"
                value="<?php echo $userData['unit_type'];?>"
                disabled
              />
            </div>

            <div class="form-section">
              <label for="unit_brand">Unit Brand:</label>
              <input
                type="text"
                id="unit_brand"
                name="unit_brand"
                value="<?php echo $userData['unit_brand'];?>"
                disabled
              />
            </div>
            <div class="form-section">
              <label for="unit_model">Unit Model:</label>
              <input
                type="text"
                id="unit_model"
                name="unit_model"
                value="<?php echo $userData['unit_model'];?>"
                disabled
              />
            </div>

            <div class="form-section">
              <label for="unit_problem">Unit Problem:</label>
              <input
                type="text"
                id="unit_problem"
                name="unit_problem"
                value="<?php echo $userData['unit_problem'];?>"
                disabled
              />
            </div>

            <div class="form-section other-problems-section">
              <label for="other_problem">Other Problems:</label>
              <input
                type="text"
                id="other_problem"
                name="other_problem"
                value="<?php echo $userData['other_problem'];?>"
                disabled
              />
            </div>


            <div class="form-section">
              <label for="type_service">Service Type:</label>
              <input
                type="text"
                id="type_service"
                name="type_service"
                value="<?php echo $userData['type_service'];?>"
                disabled
              />
            </div>

            <div class="button-container">
              <!-- Submit and Cancel buttons added here -->
              <a href="notif.php"><button class="submit-btn" type="button">Proceed</button></a>
              <a href="reqservice.php"
                ><button type="button" class="cancel-btn" type="button">
                  Cancel
                </button></a
              >
            </div>
          </form>
        </div>
      </div>
      <br>
      <br>
      <br>
      <br>
    </section>

    <script>
      document.addEventListener("DOMContentLoaded", function () {
        // Get the "Other Problems" input element
        var otherProblemInput = document.getElementById("other_problem");

        // Get the value of the "Other Problems" input
        var otherProblemValue = otherProblemInput.value.trim();

        // Check if the value is not empty
        if (otherProblemValue !== "") {
          // Display the "Other Problems" section
          var otherProblemSection = document.querySelector(
            ".form-section[label='Other Problems']"
          );
          otherProblemSection.style.display = "block";
        }
      });
    </script>
  </body>
</html>
