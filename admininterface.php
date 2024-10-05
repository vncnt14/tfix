<?php

include('config.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location index.php");
    exit;
}

// Query to select all data from the 'owner' table
$query = "SELECT owner.*, user.firstname, user.lastname, user.role
          FROM owner 
          INNER JOIN user ON owner.user_id = user.user_id";

// Perform the query
$result = mysqli_query($connection, $query);
$ownersData = mysqli_fetch_assoc($result);

// Close the database connection
mysqli_close($connection);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>SIA AND ITSMAP</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #fff; /* Set background color to white */
            color: #333; /* Set text color to dark gray */
        }

        header {
            background-color: #1b91ff; /* Set header background color to blue */
            color: #fff;
            padding: 5px; /* Adjusted padding for the header */
            text-align: center;
            position: fixed;
            width: 100%;
            top: 0;
            border-bottom: 2px solid white; /* Add white border to the bottom of the header */
            display: flex; /* Make the header flex container */
            justify-content: space-between; /* Align items with space between */
            align-items: center; /* Align items vertically */
        }

        nav {
            background-color: #1b91ff; /* Set navigation background color to blue */
            color: #fff;
            padding: 20px; /* Adjusted padding for the navigation */
            display: flex; /* Make the navigation flex container */
            justify-content: center; /* Align items horizontally */
        }
        
        .nav-links {
            margin-left: 20px; /* Add some margin to the left of the navigation links */
        }

        .nav-links a {
            padding: 10px; /* Adjusted padding for the navigation links */
            text-decoration: none;
            color: #fff; /* Set text color to white */
            margin-right: 20px; /* Add some margin to the right of each navigation link */
        }

        .nav-links a:hover {
            background-color: #165bb5; /* Change background color on hover */
        }

        .admin-text {
            margin-left: 20px; /* Add margin to the left of the "Admin" text */
            font-weight: bold; /* Make the text bold */
            font-size: 25px;
        }

        /* Additional styles for the "NEW REQUESTS" text */
        .new-requests-text {
            text-align: center; /* Align text to the center */
            margin-top: 100px; /* Adjust top margin for spacing */
            font-size: 25px; /* Adjust font size */
            font-weight: bold; /* Make text bold */
            margin-right: 30px;
        }

        /* Table styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
        }

        

        /* Button styles */
        .action-button {
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .accept-button {
            background-color: #28a745;
            color: #fff;
        }

        .decline-button {
            background-color: #dc3545;
            color: #fff;
        }

        .accept-button:hover,
        .decline-button:hover {
            background-color: #165bb5;
        }

    </style>
</head>
  
<body>

    <header>
        <!-- Admin Section -->
        <div class="admin-text">Admin</div>

        <!-- Navigation links -->
        <nav>
            <div class="nav-links" style="display: flex;">
                <a href="admininterface.php">Home</a>
                <a href="admininterface_user.php">User</a>
                <a href="admininterface_reqform.php">Request Form</a>
                <a href="#">Request</a>
                <a href="#">Settings</a>
                <a href="logout.php">Logout</a>
            </div>
        </nav>
    </header>

    <section>
        <!-- main content -->
        <div class="new-requests-text">NEW REQUESTS</div>

        <!-- Table for new requests -->
        <table>
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Shop Number</th>
                    <th>Address</th>
                    <th>Shop Name</th>
                    <th>Shop Location</th>
                    <th>Shop Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
                // Loop through each owner data and display it in a table row
                foreach ($result as $ownersData) {
                    echo "<tr>";
                    echo "<td>" . $ownersData['firstname'] . " " . $ownersData['lastname'] . "</td>";
                    echo "<td>" . $ownersData['email'] . "</td>";
                    echo "<td>" . $ownersData['contact'] . "</td>";
                    echo "<td>" . $ownersData['address'] . "</td>";
                    echo "<td>" . $ownersData['shop_name'] . "</td>";
                    echo "<td>" . $ownersData['shop_location'] . "</td>";
                    echo "<td>" . $ownersData['shop_status'] . "</td>";
                    // Assuming you want an 'Edit' link for each owner
                    echo "<td style='text-align:center;'>";
                    echo "<form action='admininterface1.php' method='post'>";
                    echo "<input type='hidden' name='user_id' value='" . $ownersData['user_id'] . "'>";
                    echo "<input type='hidden' name='role' value='" . $ownersData['role'] . "'>";
                    echo "<button type='submit' name='approve' class='btn btn-primary'>Approve</button>";
                    echo "<button type='submit' name='decline' class='btn btn-danger'>Decline</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
            ?>
            </tbody>
        </table>


    </section>

</body>
</html>
