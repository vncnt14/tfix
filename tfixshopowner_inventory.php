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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $unitType = mysqli_real_escape_string($connection, $_POST['unit_type']);
    $unitBrand = mysqli_real_escape_string($connection, $_POST['unit_brand']);

    // Insert the new inventory item into the database
    $query = "INSERT INTO inventory (unit_type, unit_brand) VALUES ('$unitType', '$unitBrand')";
    
    if (mysqli_query($connection, $query)) {
        // Redirect to this same page after insertion
        header("Location: ".$_SERVER['PHP_SELF']);
        exit;
    } else {
        echo "Error: " . mysqli_error($connection);
    }
}
  // Fetch all inventory items from the database
  $inventoryQuery = "SELECT * FROM inventory ORDER BY unit_type ASC, unit_brand ASC";
  $inventoryResult = mysqli_query($connection, $inventoryQuery);

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

        
            .timeline-content .btn {
        background-color: #1b91ff;
        color: #fff;
        padding: 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-left: 980px;
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
        
    .btn-view {
            background-color: #1b91ff;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
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
        <div class="section-line"></div> <!-- Added section line -->

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
            <section>
        <!-- MAIN CONTENT -->
        <div class="timeline-section">
            <div class="timeline-content">
                <div class="col-md-12 mb-4 text-dark text-center">
                    <table class="table bg-white">
                        <h2 class="text-white">Inventory</h2>
                        <thead class="v-2 text-light">
                            <tr>
                                <th scope="col">Unit Type</th>
                                <th scope="col">Unit Brand</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody class="v-2 text-light">
                            <?php
                            if ($inventoryResult && mysqli_num_rows($inventoryResult) > 0) {
                                while ($row = mysqli_fetch_assoc($inventoryResult)) {                       
                                    echo '<tr>';
                                    echo '<td>' . htmlspecialchars($row['unit_type']) . '</td>';
                                    echo '<td>' . htmlspecialchars($row['unit_brand']) . '</td>';
                                    echo '<td>';
                                    // Check if a valid unit_id is set for the current row
                                    if (isset($row['unit_id']) && !empty($row['unit_id'])) {
                                        echo '<a href="ownerinventory_add1.php?unit_id=' . $row['unit_id'] . '&unit_type=' . urlencode($row['unit_type']) . '&unit_brand=' . urlencode($row['unit_brand']) . '" class="btn-view">View</a>';

                                    } else {
                                        echo 'No action available';
                                    }
                                    echo '</td>';
                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr><td colspan="3">No inventory items found</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <button class="btn btn-primary btn-sm" onclick="location.href='ownerinventory_add.php'">ADD</button>
            </div>
        </div>
    </section>
</body>
</html>