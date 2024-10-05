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

// Fetch owner information based on user ID
$query = "SELECT * FROM owner WHERE user_id = '$user_id'";
$result = mysqli_query($connection, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $ownerData = mysqli_fetch_assoc($result);
}

// Fetch data from assignref table joined with user table and reqform table
$query = "SELECT ar.*, rf.user_id, u.firstname, u.lastname
          FROM assignref ar
          JOIN reqform rf ON ar.reqform_id = rf.reqform_id
          JOIN repairman r ON ar.repairman_id = r.repairman_id
          JOIN user u ON rf.user_id = u.user_id WHERE ar.is_deleted = '0'";
$result = mysqli_query($connection, $query);
$progressData = mysqli_fetch_assoc($result);



$query1 = "SELECT *FROM repairman WHERE appliance = 'refrigerator'";
$result1 = mysqli_query($connection, $query1);
$repairmanData = mysqli_fetch_assoc($result1);



// Close the database connection
mysqli_close($connection);

// Output the fetched data
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
        .v-2{
            background-color: #7C8E9E;
        }
        .v-3{
            padding-bottom: 390px;
        }
        .btn-cancel{

        margin-left: 90%;
        margin-top: 20%;
        }
        .btn-back{

        margin-left: 80%;
        margin-top: -6%;
        }


        /*main content*/
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
        <img src="<?php echo $ownerData['photo']; ?>" alt="Profile Image" class="profile-image">
        <div class="profile-name"><?php echo isset($ownerData['shop_name']) ? $ownerData['shop_name'] : ''; ?></div>
    </div>
    <div class="section-line"></div><!-- Added section line -->

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
            <a href="tfixshopowner_notif.php">Notification</a>
            <a href="message.php">Message</a>
            <a href="tfixshopowner_progress.php">Progress</a>
            <a href="tfixshopowner_inventory.php">Inventory</a>
            <a href="tfixshopowner_records.php">Sales Record</a>
            <a href="logout.php">Logout</a>
            </nav>
    <section class="v-3">
        <div class="col-md-12 mb-4 text-dark  text-center"> <!-- Adjusted the column size for better visibility -->
        
            <h1 class="text-white">Payment Details</h1>
            <table class="table bg-white">
                <thead class="v-2 text-light">
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Start Date</th>
                        <th scope="col">Finish Date</th>
                        <th scope="col">Duration</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody class="v-2 text-light">
                    <?php
                    if ($result) {
                        foreach ($result as $progressData) {
                            echo '<tr>';
                            echo '<td>' . (isset($progressData['firstname']) ? $progressData['firstname'] . ' ' : '') . (isset($progressData['lastname']) ? $progressData['lastname'] : 'N/A') . '</td>';
                            echo '<td>' . (isset($progressData['start_date']) ? $progressData['start_date'] : 'N/A') . '</td>';
                            echo '<td>' . (isset($progressData['finish_date']) ? $progressData['finish_date'] : 'N/A') . '</td>';
                            echo '<td>' . (isset($progressData['duration']) ? $progressData['duration'] : 'N/A') . '</td>';
                            echo '<td>' . (isset($progressData['unit_status']) ? $progressData['unit_status'] : 'N/A') . '</td>';
                            
                            // Check if unit status is "Completed"
                            if ($progressData['unit_status'] != 'Waiting for payment') {
                                // If not completed, render the clickable "View" button
                                echo '<td><a href="tfixshopowner_progress2.php?user_id=' . $progressData['user_id'] . '&reqform_id=' . $progressData['reqform_id'] . '&repairman_id=' . $progressData['repairman_id'] . '" class="btn btn-primary">View</a></td>';
                            } else {
                                // If completed, render a disabled "View" button
                                echo '<td><button class="btn btn-primary" disabled>View</button></td>';
                            }

                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="4">Error: ' . mysqli_error($connection) . '</td></tr>';
                    }
                    ?>
                </tbody>
            </table>

        </div>
        
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
