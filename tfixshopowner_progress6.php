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
$user_ID = $_SESSION['user_id'];
$reqform_ID = $_SESSION['reqform_id'];

$query = "SELECT ar.*, u.firstname, u.lastname, rf.date_requested, ar.unit_status
          FROM assignref ar
          JOIN user u ON ar.user_id = u.user_id
          JOIN reqform rf ON ar.reqform_id = rf.reqform_id WHERE ar.is_deleted = '0'";



$result = mysqli_query($connection, $query);




// Execute the query


// Output or process the fetched data


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
        .v-2{
            background-color: #7C8E9E;
        }
        .v-3{
            padding-bottom: 390px;
        }


        /*main content*/
        



        

        
    </style>

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
        <a href="tfixshopwoner_profile.php">Profile</a>
        <a href="tfixshopwoner_reqservice.php">Request Service</a>
        <a href="tfixshopwoner_notif.php">Notification</a>
        <a href="tfixshopwoner_message.php">Message</a>
        <a href="tfixshopwoner_progress3.php">Progress</a>
        <a href="logout.php">Log out</a>
    </nav>
    <section class="v-3">
        <div class="col-md-12 mb-4 text-dark  text-center"> <!-- Adjusted the column size for better visibility -->
            <table class="table bg-white">
                <thead class="v-2 text-light">
                    <tr>
                        <th scope="col">Full Name</th>
                        <th scope="col">Start Date</th>
                        <th scope="col">Finish Date</th>
                        <th scope="col">Duration</th>
                        <th scope="col">Status</th>
                        <th scope="col" colspan="4">Action</th> <!-- Set colspan to widen the "Action" column -->
                    </tr>
                </thead>
                <tbody class="v-2 text-light">
                    <!-- Inside the <tbody> section -->
                    <?php
                    if ($result) {
                        foreach ($result as $row) {
                            echo '<tr>';
                            echo '<td>' . (isset($row['firstname']) ? $row['firstname'] : 'N/A') .' '. (isset($row['lastname']) ? $row['lastname'] : 'N/A') .'</td>';
                            echo '<td>' . (isset($row['start_date']) ? $row['start_date'] : 'N/A') . '</td>';
                            echo '<td>' . (isset($row['finish_date']) ? $row['finish_date'] : 'N/A') . '</td>';
                            echo '<td>' . (isset($row['duration']) ? $row['duration'] : 'N/A') . '</td>';
                           echo '<td>' . (isset($row['unit_status']) ? $row['unit_status'] : 'N/A') . '</td>';
                            echo '<td>';
                           if ($row['unit_status'] != 'Waiting for payment') {
                                // If not completed, render the clickable "View" button
                                echo '<td><a href="tfixshopowner_progress2.php?user_id=' . $row['user_id'] . '&reqform_id=' . $row['reqform_id'] . '&repairman_id=' . $row['repairman_id'] . '" class="btn btn-primary">View</a></td>';
                            } else {
                                // If completed, render a disabled "View" button
                                echo '<td><button class="btn btn-primary" disabled>View</button></td>';
                            }
                            echo '</td>';

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
