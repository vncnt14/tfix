<?php
session_start();

// Include database connection file
include('config.php');  // You'll need to replace this with your actual database connection code

// Redirect to the login page if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
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

// Query to retrieve approved shop names, photos, and owner IDs
$approvedQuery = "SELECT owner_id, shop_name, photo FROM owner WHERE shop_status = 'approved'";
$approvedResult = mysqli_query($connection, $approvedQuery);

// Check if there are results from the query
if ($approvedResult) {
    // Create an array to store approved shop details
    $approvedShops = array();
    while ($row = mysqli_fetch_assoc($approvedResult)) {
        $approvedShops[] = $row;
    }
} else {
    // Handle database query error
    echo "Error: " . mysqli_error($connection);
}

// Close the database connection
mysqli_close($connection);
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Hello, world!</title>
    <style>
        .offcanvas {
            width: 240px;
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
            color: #fff;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

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
        .nav-link{
            color: black;
        }
        .nav-link:hover{
            background-color: #9D9B9B;
            color: white;
        }
        header {
        background-color: #0385ff;
        color: #fff;
        padding: 38px;
        text-align: center;
        position: fixed;
        z-index: 1;
        width: 100%;
        top: 0;
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

    

      

      .section-line {
        border-top: 1px solid #fff;
        /* Added border style and color */
        margin-bottom: 10px;
        /* Adjusted margin for better spacing */
      }

      section {
        margin-left: 220px;
        /* Adjusted margin to match the width of the nav */
        padding: 10px;
        margin-top: 45px;
        /* Adjusted margin-top to account for the height of the header */
        background-color: #cacaca;
        min-height: calc(100vh - 65px);
        /* Ensure the section fills the viewport height minus header height */
        display: flex;
        justify-content: center;
        align-items: center;
      }

      .home-section {
        width: 100%;
        /* Ensure the home-section fills the entire width */
        padding: 20px;
        text-align: center;
        overflow: hidden;
        /* Prevent scrolling */
      }


      /*main content*/
      /* HOMEOAGE STYLE*/


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
        margin-right: 10px;
        /* Add margin for spacing between image boxes */
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
        box-shadow: 0 0 5px rgba(7, 7, 7, 0.3);
        /* Add hover effect */
      }

      .underline {
        font-size: 18px;
        padding: 8px;
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
      }

      .underline:before,
      .underline:after {
        content: "";
        position: absolute;
        width: 250%;
        height: 2px;
        background-color: #918d8d;
      }

      .underline:before {
        top: 50%;
        right: 100%;
        transform: translateY(-50%);
      }

      .underline:after {
        top: 50%;
        left: 100%;
        transform: translateY(-50%);
      }

      .carousel {
        margin-bottom: 60px;
        /* Adjust this value as needed */
      }




      /* Remove the styling for .underline as it's not needed anymore */
      .title-wrapper {
        display: flex;
        justify-content: center;
        align-items: flex-end;
        position: relative;
      }

      .search-bar-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        margin-bottom: 100px;
      }

      .search-bar {
        width: 400px;
        padding: 10px;
        font-size: 16px;
        border: none;
        border-radius: 5px;
        background-color: #fff;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        outline: none;
      }

      /* Add the following styles for the search icon */
      .search-icon {
        position: absolute;
        right: 15px;
        color: #555;
        cursor: pointer;
        font-size: 18px;
        pointer-events: none;
        /* Ensure the icon does not interfere with input focus */
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

      .c-2 {
        color: red;
      }
    </style>
</head>

<body>

    <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
        Menu
    </button>

    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Navigation</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div>
                <div class="profile-section">
                    <!-- Profile display goes here -->
                    <img src="<?php echo $userData['photo']; ?>" alt="Profile Image" class="profile-image">
                    <div class="profile-name"><?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?></div>
                </div>
                <ul class="ul-a">
                    <a href="profile.php" class="nav-link">Profile</a>
                    <a href="reqservice.php" class="nav-link">Request Service</a>
                    <a href="notif.php" class="nav-link">Notification</a>
                    <a href="message.php" class="nav-link">Message</a>
                    <a href="tfixuserprogress6.php" class="nav-link">Progress</a>
                    <div class="dropdown">
                        <button class="dropbtn nav-link">Apply As</button>
                        <div class="dropdown-content">
                            <a href="registerowner.php" class="dropdown-item">Apply as Owner</a>
                            <a href="registerrepairman.php" class="dropdown-item">Apply as Repairman</a>
                            <a href="registerpersonnel.php" class="dropdown-item">Apply as Personnel</a>
                        </div>
                    </div>
                    <a href="logout.php" class="nav-link">Logout</a>
                </ul>
            </div>

        </div>
    </div>
    <section>
      <!-- main content -->
      <!--HOME PAGE-->
      <div class="home-section">

        <div class="title-wrapper">
          <div class="search-bar-wrapper">
            <input type="text" class="search-bar" placeholder="Search Shop">
            <i class="fas fa-search search-icon"></i>

          </div>
        </div>



        <div class="carousel">
          <div class="row">
            <?php
            // Loop through approved shop details to display shop boxes
            if (!empty($approvedShops)) {
              foreach ($approvedShops as $shop) {
                echo '<div class="box">';
                echo '<a href="tfixshopprofile.php?owner_id=' . urlencode($shop['owner_id']) . '">';
                echo '<img src="' . htmlspecialchars($shop['photo']) . '" alt="Shop Image">';
                echo '<p>' . htmlspecialchars($shop['shop_name']) . '</p>';
                echo '</a>';
                echo '</div>';
              }
            } else {
              echo '<p>No approved shops found.</p>';
            }
            ?>
          </div>
        </div>
      </div>
    </section>


    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

</body>

</html>