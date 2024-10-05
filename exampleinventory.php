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

// Fetch inventory items associated with the logged-in user's unit_id and order by unit_type
$inventoryQuery = "SELECT unit_id, unit_type, unit_brand FROM inventory WHERE unit_id IN (SELECT unit_id FROM owner WHERE user_id = '$user_id') ORDER BY unit_type";
$inventoryResult = mysqli_query($connection, $inventoryQuery);

// Check if inventory query executed successfully
if (!$inventoryResult) {
    die('Inventory query failed: ' . mysqli_error($connection));
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" />
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
            color: #fff;
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
            justify-content: flex-start;
            /* Align buttons to the start of the container */
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
            flex: 1;
            /* Make buttons equally share the container width */
        }

        .timeline-button.active {
            background-color: #617695;
            /* Change the background color for the active button */
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

        .container {

            margin-left: 1%;
        }

        .v-1 {

            margin-left: 86%;
        }

        .click-request {
            color: #fff;
        }

        .notif-word {
            margin-left: 5%;
        }

        .v-2 {
            background-color: #7C8E9E;
        }

        .v-3 {
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
            <div class="col-md-12 mb-4 text-dark text-center">
                <!-- Search Form -->
                <form id="searchForm" method="GET">
                    <div class="input-group mb-3">
                        <label for="start_month">Start Month: </label>
                        <input type="date" id="start_month" name="start_month">
                        <label for="end_month">End Month: </label>
                        <input type="date" id="end_month" name="end_month">
                        <button id="searchButton" class="btn btn-primary" type="submit">Search</button>
                    </div>
                </form>

                <!-- Display Inventory -->
                <?php
                // Check if the search form is submitted
                if (isset($_GET['search'])) {
                    // Get the search query from the form
                    $search_query = isset($_GET['search_query']) ? $_GET['search_query'] : '';

                    // Prepare SQL query to fetch inventory items based on search query
                    $query = "SELECT * FROM qr_code 
                WHERE created_at LIKE '%" . mysqli_real_escape_string($connection, $search_query) . "%'";

                    // Execute the query
                    $result = mysqli_query($connection, $query);

                    // Display search results in a table
                    if ($result && mysqli_num_rows($result) > 0) {
                        echo '<table id="salesTable" class="table bg-white">';
                        echo '<thead class="v-2 text-light">
                            <tr>
                                <th scope="col">Date</th>
                                <th scope="col">Name</th>
                                <th scope="col">Service</th>
                                <th scope="col">Labor</th>
                                <th scope="col">Parts</th>
                                <th scope="col">Total</th>
                            </tr>
                        </thead>';
                        echo '<tbody class="v-2 text-light">';

                        $totalAmount = 0;
                        foreach ($result as $progressData) {
                            // Convert parts to numeric type
                            $parts = floatval($progressData['parts']); // Convert parts to float

                            // Display labor
                            $labor = isset($progressData['labor']) ? $progressData['labor'] : 'N/A';

                            // Compute total
                            $total = is_numeric($parts) ? floatval($labor) + $parts : $labor;

                            $totalAmount += $total;

                            echo '<tr>';
                            echo '<td>' . (isset($progressData['created_at']) ? $progressData['created_at'] : 'N/A') . '</td>';
                            echo '<td>' . (isset($progressData['firstname']) ? $progressData['firstname'] : 'N/A') . ' ' . (isset($progressData['lastname']) ? $progressData['lastname'] : 'N/A') . '</td>';
                            echo '<td>' . (isset($progressData['service']) ? $progressData['service'] : 'N/A') . '</td>';
                            echo '<td>₱' . $labor . '</td>';
                            echo '<td>₱' . $parts . '.00</td>';
                            echo '<td>₱' . $total . '.00</td>'; // Display total
                            echo '</tr>';
                        }
                        // Display total amount row
                        echo '<tr>';
                        echo '<td colspan="5" style="text-align: right; font-weight: bold;">TOTAL AMOUNT:</td>';
                        echo '<td style=" font-weight: bold;">₱' . $totalAmount . '.00</td>';
                        echo '</tr>';

                        echo '</tbody>';
                        echo '</table>';
                    } else {
                        echo '<p>No inventory items found.</p>';
                    }
                }
                ?>
                <button class="btn btn-primary btn-md v-1" onclick="location.href='exampleinventoryadd.php'">Add Brand</button>
            </div>
        </div>
    </section>

</body>

</html>