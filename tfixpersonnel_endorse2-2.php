<?php
session_start();

// Include database connection file
include('config.php');

if (!isset($_SESSION['personnel_id'])) {
    header("Location: index.php");
    exit;
}

// Fetch user information based on ID
$appliance = $_SESSION['appliance'];
$user_id = $_GET['user_id'];
$reqform_id = $_GET['reqform_id'];

$userData = mysqli_query($connection, "SELECT * FROM user WHERE user_id = '$user_id'");
$userData = ($userData) ? mysqli_fetch_assoc($userData) : die('Error fetching user data: ' . mysqli_error($connection));

// Fetch reqform data based on user_id and reqform_id
$reqformData = mysqli_query($connection, "SELECT * FROM reqform WHERE user_id = '$user_id' AND reqform_id = '$reqform_id'");
$reqformData = ($reqformData) ? mysqli_fetch_assoc($reqformData) : die('Error fetching reqform data: ' . mysqli_error($connection));

// Fetch result data based on your requirements
// Replace the following query with your actual query
$result = mysqli_query($connection, "SELECT user.user_id, user.firstname, user.lastname, reqform_id, date_requested, unit_name
FROM user
JOIN reqform ON reqform.user_id = user.user_id");

$query = "SELECT *FROM repairman WHERE appliance = 'Electric Fan'";
$result = mysqli_query($connection, $query);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css" /> 
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"
    />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    
    
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

        /*main content*/

        /* Timeline section */
        .timeline-section {
            background-color: #8394A4;
            border-radius: 5px;
            padding: 0px;
            height: 510px;
        }

        .timeline-buttons {
            display: flex;
            margin-bottom: 10px;
            justify-content: flex-start; /* Align buttons to the start of the container */
            font-size: 13px;
        }

        .timeline-button {
            background-color: #8394A4;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
            flex: 1; /* Make buttons equally share the container width */
        }

        .timeline-button.active {
            background-color: #617695; /* Change the background color for the active button */
        }

        .timeline-content {
            color: #555;
            padding: 20px;
            margin-top: 10px;
        }

        /* Added styling for checkboxes */
        .checkbox-container {
            display: flex;
            justify-content: space-between; /* Adjusted to create two columns */
            margin-top: 10px;
        }

        .checkbox-group {
            display: flex;
            flex-direction: column;
            margin-bottom: 10px;
        }

        .checkbox-label {
            margin-right: 10px;
            font-size: 18px; /* Increased font size */
        }

        /* Adjusted checkbox size */
        .checkbox-input {
            width: 30px;
            height: 30px;
        }

        /* Added styling for text and input box */
        .repair-description {
        margin-top: 20px;
        font-size: 18px;
        color: #fff;
    }

    .repair-input {
        width: 95%;
        padding: 25px;
        margin-top: 10px;
        font-size: 16px;
        background-color: #bebebe; /* Added background color */
        border: none; /* Removed border for a cleaner look */
        border-radius: 5px; /* Added border radius for a rounded look */
    }


    /* Updated styling for cancel and next buttons */
    .button-container {
            display: flex;
            justify-content: flex-end; /* Align buttons to the end of the container */
            margin-top: 20px;
        }

        .cancel-button, .next-button {
            padding: 10px;
            background-color: #1b91ff; /* Changed color to blue */
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .next-button {
            margin-left: 10px; /* Added margin to separate the buttons */
        }

    /* Container for columns */
.content-columns {
    display: flex;
}

/* Next Content Diagnosis */
.content-columns {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        /* Updated styling for column boxes in the content */
        .column-box {
    padding: 14px;
    background-color: #78838d;
    border-radius: 5px;
    color: #fff;
    width: 90%; /* Adjusted width to 25% for four columns per row */
    box-sizing: border-box; /* Added to include padding and border in the box's total width */
}

.column-box1 {
    padding: 14px;
    background-color: #6d7c8a;
    border-radius: 5px;
    color: #fff;
    width: 100%; /* Adjusted width to 25% for four columns per row */
    box-sizing: border-box; /* Added to include padding and border in the box's total width */
}

.column-box-input input{
    width: 94%; /* Set the width to 100% for input and select elements */
    margin-top: 5px;
    padding: 15px;
    font-size: 16px;
    background-color: #6d7c8a;
    border: none;
    border-radius: 5px;
    color: #fff;
}

.column-box-input select {
    width: 100%; /* Set the width to 100% for input and select elements */
    margin-top: 5px;
    padding: 15px;
    font-size: 16px;
    background-color: #6d7c8a;
    border: none;
    border-radius: 5px;
    color: #fff;
}
.diagnosis-button {
    background-color: #617695; /* Highlight color for DIAGNOSIS button */
    color: #fff;
}
.btn-cancel{

    margin-left: 90%;
    margin-top: 20%;
}

/* Updated styling for cancel and next buttons in DIAGNOSIS section 
.new-button-container {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
}

.new-cancel-button, .new-next-button {
    padding: 10px;
    background-color: #1b91ff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    
}

.new-next-button {
    margin-left: 10px; /* Added margin to separate the buttons 
}*/




    
    </style>
    <title>SIA AND ITSMAP</title>
</head>
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
        <a href="tfixpersonnel_profile.php">Profile</a>
        <a href="tfixpersonnel_reqservice.php">Request Service</a>
        <a href="tfixpersonnel_notif.php">Notification</a>
        <a href="tfixpersonnel_message.php">Message</a>
        <a href="tfixpersonnel_progress.php">Progress</a>
        <a href="logout.php">Logout</a>
        
    </nav>

    <section>
        <!-- MAIN CONTENT -->
        <div class="timeline-section">
            <div class="timeline-buttons">
                <button class="timeline-button diagnosis-button">DIAGNOSIS</button>
                <button class="timeline-button" onclick="showPendingRequest()">SERVICE</button>
                <button class="timeline-button" onclick="showCompletedRequest()">PAYMENT</button>
            </div>

            <div class="timeline-content">
            <div class="col-md-12 mb-4 text-dark  text-center"> <!-- Adjusted the column size for better visibility -->
            <table class="table">
                <thead class="v-2 text-light">
                 <input type="hidden" name="user_id" id="user_id" value="<?php echo $reqformData['user_id'];?>">
                 <input type="hidden" name="reqform_id" id="reqform_id" value="<?php echo $reqformData['reqform_id'];?>">   
                </thead>
                <tbody class="text-light">
                    <!-- Inside the <tbody> section -->
                    <?php
                        if ($result) {
                            foreach ($result as $row) {
                                echo '<tr>';
                                echo '<td>' . (isset($row['firstname']) ? $row['firstname'] : 'N/A') . '</td>';
                                echo '<td>' . (isset($row['lastname']) ? $row['lastname'] : 'N/A') . '</td>';

                                echo '<td>';
                                echo '<a href="tfixpersonnel_endorse4.php?repairman_id=' . (int)$row['repairman_id'] . '&user_id=' . (int)$userData['user_id'] . '&reqform_id=' . (int)$reqformData['reqform_id'] .'" class="btn btn-primary">View Assign</a>';;
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
            <button type="button" class="btn btn-cancel btn-primary col-md-1">Cancel</button> 
            </div>
        </div>
       

        <br>
        
        
    </section>

    
    


</body>
</html>
