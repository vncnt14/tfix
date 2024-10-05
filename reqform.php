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
$service = $_GET['service'];
$owner_id = $_GET['owner_id'];

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
      padding: 5px;
      /* Adjusted padding for the profile section */
    }

    .profile-image {
      width: 65px;
      height: 65px;
      border-radius: 50%;
      border: 2px solid #fff;
      /* Add border style and color */
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
      border-top: 1px solid #fff;
      /* Added border style and color */
      margin-bottom: 10px;
      /* Adjusted margin for better spacing */
    }

    section {
      margin-left: 220px;
      /* Adjusted margin to match the width of the nav */
      padding: 20px;
      margin-top: 65px;
      /* Adjusted margin-top to account for the height of the header */
      background-color: #cacaca;
    }

    /* Request Service Form */
    .request-service-section {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      background-color: #96afc7;
      padding: 40px;
      /* Adjusted padding for better spacing */
      border-radius: 10px;
      margin-top: 10px;
      /* Adjusted margin-top to make it more adjustable */
      height: 630px;
    }

    .right-section {
      width: 100%;
      /* Adjusted width to fill the entire right section */
      padding-top: 20px;
      /* Adjusted padding-top for better spacing */
    }

    .section-title {
      font-size: 20px;
      font-weight: bold;
      margin-bottom: 20px;
      margin-top: -30px;
      /* Adjusted margin-top to move it more on top */
      margin-left: 380px;
      color: #fff;
    }

    .line-separator {
      border-top: 1px solid #ccc;
      margin-bottom: 20px;
      margin-top: -10px;
      /* Adjusted margin-top to move it more on top */
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
      width: calc(100% - 20px);
      /* Adjusted width for better spacing */
      padding: 15px;
      margin-bottom: 10px;
      box-sizing: border-box;
    }

    .form-section textarea {
      height: 50px;
      /* Set a fixed height for consistency */
    }

    .button-container {
      text-align: center;
      margin-top: -12px;
      margin-left: -42px
    }

    .submit-btn {
      background-color: #1b91ff;
      color: #fff;
      padding: 13px;
      /* Increased padding for more space */
      border: none;
      border-radius: 5px;
      cursor: pointer;
      margin: 0 10px;
      margin-left: 830px;
    }

    .cancel-btn {
      background-color: #1b91ff;
      color: #fff;
      padding: 13px;
      /* Increased padding for more space */
      border: none;
      border-radius: 5px;
      cursor: pointer;
      margin: 0 10px;
      margin-top: 20px;
    }

    .user-details-profile-box {
      display: none;
      /* Removed the user details profile box */
    }

    /* APPLY AS Dropdown styles */
    /* Dropdown styles */
    .dropdown {
      position: relative;
      display: inline-block;
    }

    .dropbtn {
      background-color: #9D9B9B;
      color: #fff;
      /* Set font color to white to match other navigation links */
      padding: 15px;
      font-size: 18px;
      /* Set font size to match other navigation links */
      font-family: Arial, sans-serif;
      /* Set font family to match other navigation links */
      border: none;
      cursor: pointer;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      background-color: #9D9B9B;
      min-width: 160px;
      box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
      z-index: 1;
    }

    .dropdown-content a {
      color: #fff;
      /* Set font color to white to match other navigation links */
      padding: 12px 16px;
      text-decoration: none;
      display: block;
      font-size: 18px;
      /* Set font size to match other navigation links */
      font-family: Arial, sans-serif;
      /* Set font family to match other navigation links */
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
      <img src="<?php echo $userData['photo']; ?>" alt="Profile Image" class="profile-image" />
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
    <!-- Request Service Form Section -->
    <div class="request-service-section">
      <div class="right-section">
        <div class="section-title">Request Service Form</div>
        <div class="line-separator"></div>

        <form class="details-form" action="reqform1.php" method="POST">
          <input type="hidden" name="user_id" id="user_id" value="<?php echo $userData['user_id']; ?>">
          <input type="hidden" name="owner_id" id="owner_id" value="<?php echo $owner_id; ?>">
          <input type="hidden" name="service" id="service" value="<?php echo $service; ?>">
          <input type="hidden" name="is_deleted" id="is_deleted" value="0">

          <div class="form-section">
            <label for="firstname">First Name:</label>
            <input type="text" id="firstname" name="firstname" disabled value="<?php echo $userData['firstname']; ?>" />

            <label for="contact">Phone Number:</label>
            <input type="tel" id="contact" name="contact" disabled value="<?php echo $userData['contact']; ?>" />
          </div>

          <div class="form-section">
            <label for="lastname">Last Name:</label>
            <input type="text" id="lastname" name="lastname" disabled value="<?php echo $userData['lastname']; ?>" />

            <label for="address">Complete Home Address:</label>
            <input type="text" id="address" name="address" disabled value="<?php echo $userData['address']; ?>" />
          </div>

          <div class="form-section">
            <label for="date_requested">Date Requested:</label>
            <input type="date" id="date_requested" name="date_requested" />
          </div>

          <div class="form-section">
            <label for="unit_type">Unit Type:</label>
            <select id="unit_type" name="unit_type">
              <option value="None" selected>Choose</option>
              <option value="Refrigerator">Refrigerator</option>
              <option value="Electricfan">Electric Fan</option>
            </select>
          </div>

          <!-- Add this HTML block for "Other Problem Description" -->
          <div class="form-section">
            <label for="unit_brand">Unit Brand:</label>
            <select id="unit_brand" name="unit_brand">
              <option value="" selected>Choose</option>

            </select>
          </div>

          <div class="form-section">
            <label for="unit_model">Unit Model:</label>
            <input type="text" id="unit_model" name="unit_model" />
          </div>

          <div class="form-section">
            <label for="type_service">Service Type:</label>
            <select id="type_service" name="type_service">
              <option value="None" selected>Choose</option>
              <option value="inShopService">In-Shop Service</option>
              <option value="homeService">Home Service</option>
            </select>
          </div>

          <div class="form-section">
            <label for="unit_problem">Unit Problem:</label>
            <select id="unit_problem" name="unit_problem">
              <option value="None" selected>Choose</option>
              <option value="Freezer Not Cooling">Freezer Not Cooling</option>
              <option value="Making Noise">Making Noise</option>
              <option value="Leaking Water">Leaking Water</option>
              <option value="Excessive Frost Buildup in the Frezzer">
                Excessive Frost Buildup in the Freezer
              </option>
              <option value="Door Seal/Gasket Problems">
                Door Seal/Gasket Problems
              </option>
              <option value="Ice Maker Not Working">
                Ice Maker Not Working
              </option>
              <option value="Other">Other</option>
            </select>
          </div>

          <div id="otherProblemSection" class="form-section" style="display: none">
            <label for="otherProblem">Other Unit Problem:</label>
            <textarea id="other_problem" name="other_problem"></textarea>
          </div>
          <div class="button-container">
            <!-- Submit and Cancel buttons added here -->
            <a href="reqservice.php"><button class="submit-btn" type="button">Cancel</button></a>
            <button class="cancel-btn" type="submit">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </section>

  <script>
    document.getElementById('unit_type').addEventListener('change', function() {
      var unitType = this.value;
      var unitBrandSelect = document.getElementById('unit_brand');
      unitBrandSelect.innerHTML = ''; // Clear previous options

      if (unitType === 'Refrigerator') {
        var refrigeratorBrands = ['Choose', 'Samsung', 'LG', 'Sony', 'Sharp', 'Haier', 'Electrolux', 'Whirlpool', 'Mabe', 'Dowell'];
        populateBrands(refrigeratorBrands);
      } else if (unitType === 'Electricfan') {
        var electricFanBrands = ['Choose', 'Hanabishi', 'Asahi', 'Panasonic', 'Union', 'Dowell', 'Imarflex', 'Fujidenzo', 'Kyowa', 'Sharp'];
        populateBrands(electricFanBrands);
      }
    });

    function populateBrands(brands) {
      var unitBrandSelect = document.getElementById('unit_brand');
      brands.forEach(function(brand) {
        var option = document.createElement('option');
        option.value = brand;
        option.textContent = brand;
        unitBrandSelect.appendChild(option);
      });
    }
  </script>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // Add change event listener to the "Unit Problem" dropdown
      document
        .getElementById("unit_problem")
        .addEventListener("change", function() {
          // Get the selected unit problem
          var selectedUnitProblem = this.value;

          // Get the "Other Problem Description" form section
          var otherProblemSection = document.getElementById(
            "otherProblemSection"
          );

          // Show/hide "Other Problem Description" form section
          if (selectedUnitProblem === "Other") {
            otherProblemSection.style.display = "block";
          } else {
            otherProblemSection.style.display = "none";
          }
        })

      // Add change event listener to the "Unit Name" dropdown
      document
        .getElementById("unit_name")
        .addEventListener("change", function() {
          // Get the selected unit name
          var selectedUnit = this.value;

          // Get the "Unit Problem" dropdown
          var unitProblemDropdown = document.getElementById("unit_problem");

          // Get the "Other Problem Description" form section
          var otherProblemSection = document.getElementById(
            "otherProblemSection"
          );

          // Remove existing options
          unitProblemDropdown.innerHTML =
            '<option value="None" selected>Choose</option>';

          // Add options based on the selected unit name
          switch (selectedUnit) {
            case "refrigerator":
              unitProblemDropdown.innerHTML += `
                    <option value="Freezer Not Cooling">Freezer Not Cooling</option>
                    <option value="Making Noise">Making Noise</option>
                    <option value="Leaking Water">Leaking Water</option>
                    <option value="Excessive Frost Buildup in the Freezer">Excessive Frost Buildup in the Freezer</option>
                    <option value="Door Seal/Gasket Problems">Door Seal/Gasket Problems</option>
                    <option value="Ice Maker Not Working">Ice Maker Not Working</option>
                    <option value="Other">Other</option>
                `;
              break;
            case "electricfan":
              unitProblemDropdown.innerHTML += `
                    <option value="Not Oscillating">Not Oscillating</option>
                    <option value="Strange Noise">Strange Noise</option>
                    <option value="Blades Not Rotating">Blades Not Rotating</option>
                    <option value="Overheating">Overheating</option>
                    <option value="Power Issues">Power Issues</option>
                    <option value="Other">Other</option>
                `;
              break;
              // Add more cases for other unit names if needed
          }

          // Show/hide "Other Problem Description" form section
          if (selectedUnit === "Other") {
            otherProblemSection.style.display = "block";
          } else {
            otherProblemSection.style.display = "none";
          }
        });

      // Add click event listener to the "Cancel" button
      document
        .querySelector(".cancel-btn")
        .addEventListener("click", function() {
          // Navigate to the previous page
          window.history.back();
        });
    });
  </script>


</body>

</html>