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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"
    />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css" /> 
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
            color: #fff;
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
        .container{

            margin-left: 1%;
        }
        .v-1{

            background-color: #8FA2B4;
        }
        .click-request{
            color: #fff;
        }
        .notif-word{
            margin-left: 5%;
        }


        /*main content*/
        



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
            <div class="profile-name"><?php echo $userData['username'];?></div>
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
    <div class="container mt-5 me-5">
        <div class="v-1 alert alert-info" role="alert">
            <div class="d-flex align-items-center">
                <i><img src="Customer.png" class="icon-v1" alt=""></i>
                <div class="notif-word">
                    <h6 class="alert-heading text-light fw-bold">YOUR UNIT IS ALREADY REPAIRED.<i> <img src="Ellipse 12.png" class="icon-v1" alt=""></i></h6>
                        <?php
                        // Assuming you have the user_id stored in a variable called $user_id
                        $user_id = $_SESSION['user_id']; // Assuming you retrieve the user_id from the session

                        // Embedding the user_id in the anchor tag
                        echo '<a href="tfixuserprogress.php?user_id=' . $user_id . '"><p class="text-light">Click to view payment.</p></a>';
                        ?>

                    <small class="text-light">5 mins ago.</small>
                </div>
            </div>
        </div>
    </div>

    <!-- New div added -->
    <div class="container mt-5 me-5">
        <div class="v-1 alert alert-info" role="alert">
        <div class="d-flex align-items-center">
                <i><img src="Customer.png" class="icon-v1" alt=""></i>
                <div class="notif-word">
                    <h6 class="alert-heading text-light fw-bold">YOUR REPAIR REQUEST HAS BEEN ACCEPTED</h6>
                    <p class="text-light">Please prepare the appliances.</p>
                    <small class="text-light">5 mins ago.</small>
                </div>
            </div>
        </div>
    </div>
    <br>
<br>
<br>
<br>
<br>
<br>
<br>

</section>


    
    




    



    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.2/dist/chart.min.js"></script>
    <script src="./js/jquery-3.5.1.js"></script>
    <script src="./js/jquery.dataTables.min.js"></script>
    <script src="./js/dataTables.bootstrap5.min.js"></script>
    <script src="./js/script.js"></script>

</body>
</html>
