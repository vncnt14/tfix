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

        // Check if owner_id is provided in the URL
        if (isset($_GET['owner_id'])) {
            $ownerID = $_GET['owner_id'];

            // Retrieve shop details based on owner_id
            $shopQuery = "SELECT owner_id, shop_name, photo, services FROM owner WHERE owner_id = '$ownerID' AND shop_status = 'approved'";
            $shopResult = mysqli_query($connection, $shopQuery);

            if ($shopResult && mysqli_num_rows($shopResult) > 0) {
                $ownerData = mysqli_fetch_assoc($shopResult);
                $shopName = $ownerData['shop_name'];
                $photo = $ownerData['photo'];

               // Retrieve selected services
            $selectedServices = isset($ownerData['services']) ? explode(", ", $ownerData['services']) : [];
            } else {
                // Shop not found or not approved
                header("Location: shop_not_found.php");
                exit;
            }
        } else {
            // Redirect if owner_id is not provided
            header("Location: shop_not_found.php");
            exit;
        }

        // Close the database connection
        mysqli_close($connection);
        ?>


        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
            <style>
                body {
                    margin: 0;
                    font-family: Arial, sans-serif;
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

                nav {
                    width: 220px;
                    height: 100%;
                    background-color: #9D9B9B;
                    position: fixed;
                    z-index: 2;
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
            padding: 10px;
            margin-top: 45px; /* Adjusted margin-top to account for the height of the header */
            background-color: #cacaca;
            min-height: calc(100vh - 65px); /* Ensure the section fills the viewport height minus header height */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        
                /*main content*/
                /* HOMEOAGE STYLE*/
        .home-section {
            width: 100%; /* Ensure the home-section fills the entire width */
            padding: 20px;
            text-align: center;
            overflow: hidden; /* Prevent scrolling */
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
                    padding: 50px;
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
                    margin-top: 15px;
                    color: #fff; /* Changed profile name color to #fff */
                }

                .edit-profile-btn-main {
                    background-color: #cacaca;
                    color: #cacaca;
                    padding: 8px;
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
                    margin-left: 750px; /* Adjusted margin for better spacing */
                    text-decoration: none; /* Removed underline */
                    
                }

                

                .section-line2 {
                    border-top: 1px solid #fff; /* Added border style and color */
                    margin-bottom: 35px; /* Adjusted margin for better spacing */
                }

                .timeline-section {
        height: 310px;
        border-radius: 5px;
        padding: 20px; /* Add padding for better spacing inside the timeline section */
        background-color: #cacaca; /* Match background color */
        margin-top: 20px; /* Adjust margin top for spacing */
    }

    .timeline-title {
        color: #fff;
        font-size: 18px;
        text-align: center;
        font-weight: bold;
        margin-bottom: 20px; /* Add margin bottom for better spacing below title */
    }

            
            /* services section */
    /* Services section */
.carousel {
    display: flex;
    flex-direction: column;
}

.row {
    display: flex;
    flex-wrap: wrap;
    justify-content: center; /* Center align items */
}

.box {
    flex-basis: calc(33.33% - 20px); /* Calculate width for three boxes in a row */
    margin: 10px; /* Adjust margin for spacing between boxes */
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 5px;
    overflow: hidden;
    padding: 15px;
    text-align: center;
    box-sizing: border-box; /* Include padding in box sizing */
}

.box p {
    margin-top: 10px;
    margin-bottom: 10px;
}


    .box a {
    display: block;
    text-decoration: none;
    color: black;
    }
    /*
    .box img {
    width: 100%;
    height: 165px;
    margin-top: 10px;
    object-fit: contain;
    } 

    .box p {
    text-align: center;
    margin-top: 10px;
    }*/

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
            <!-- Main content section -->
            <?php if (isset($ownerData)) : ?>
                <div class="main-profile-section">
                    <div class="profile-details">
                    <img src="<?php echo $ownerData['photo']; ?>" alt="Profile Image" class="profile-image-main">
                    <div class="profile-info">
                    <div class="profile-name-main"><?php echo isset($ownerData['shop_name']) ? $ownerData['shop_name'] : ''; ?></div>
                    <a href="" class="edit-profile-btn-main">Edit Profile</a>
                    </div>
                    </div>
                    <div class="section-line2"></div> <!-- Added section line -->

                    <!-- Timeline section -->
                    <div class="timeline-section">
                    <div class="timeline-title">AVAILABLE SERVICES</div>

                    
                    <div class="row">
                            <?php
                            // Loop through selected services to generate service boxes
                            foreach ($selectedServices as $service) {
                                // Capitalize the first letter of the service name
                                $serviceName = ucfirst($service);
                                ?>
                                <div class="box">
            <!-- Display the service name as a clickable link -->
            <a href="reqform.php?service=<?php echo urlencode($service); ?>&owner_id=<?php echo $ownerData['owner_id']; ?>"><?php echo htmlspecialchars($serviceName); ?></a>
        </div>
    <?php } ?>
                        </div>
                    </div>
                </div>
        
                            
                        <?php else : ?>
                            <p>No services available.</p>
                        <?php endif; ?>
                    </div>
            
        </section>

        </body>
        </html>
