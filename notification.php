<?php
session_start();

// Include database connection file
include('config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}


$user_id = $_SESSION['user_id'];

// Fetch owner information based on user ID
$query = "SELECT * FROM owner WHERE user_id = '$user_id'";
$result = mysqli_query($connection, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $ownerData = mysqli_fetch_assoc($result);
} else {
    // Handle error if owner data cannot be retrieved
    echo "Error fetching owner data";
    exit;
}

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

        .notification button {
    background-color: #3490dc;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 4px;
    cursor: pointer;
}
/*notif*/

.notification button:hover {
    background-color: #2779bd;
}

.modal {
    display: none;
    align-items: center;
    justify-content: center;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 9999;
}

.modal-content {
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
}

.modal-details {
    margin-bottom: 20px;
}

.modal-close-button {
    background-color: #3490dc;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 4px;
    cursor: pointer;
}

.modal-close-button:hover {
    background-color: #2779bd;
}

#petResultModal .modal-content {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

#petResultModal .modal-content p {
    margin-bottom: 10px;
}

#petResultModal .modal-content button {
    background-color: #3490dc;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 4px;
    cursor: pointer;
}

#petResultModal .modal-content button:hover {
    background-color: #2779bd;
}

#bookingDetailsModal .modal-content {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
      
#petResultModal .modal-content button.modal-close-button:hover {
    background-color: #cc0000; /* Darker red on hover */
}  

</style>
    <title>SIA AND ITSMAP</title>
</head>
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
            <a href="tfixshopowner_reqservice1.php">Request Application</a>
            <a href="notif.php">Notification</a>
            <a href="message.php">Message</a>
            <a href="tfixshopowner_progress.php">Progress</a>
            <a href="tfixshopowner_inventory.php">Inventory</a>
            <a href="tfixshopowner_records.php">Sales Record</a>
            <a href="logout.php">Logout</a>
        </nav>




<div class="main-content">
    <center><h1 class="text-2xl font-bold">Notifications</h1></center>


   

    <div id="bookingDetailsModal" class="modal" style="display: none;">
        <!-- Modal content for booking details -->
    </div>

                <p>View Progress </p>
                <p></p>
                <button class="text-blue-500" onclick="viewProgress(
                   
                )">View Pet Result</button>
            </div>
    

</body>
</html>
