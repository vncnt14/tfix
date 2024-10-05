<?php
session_start();

// Include database connection file
include('config.php');  // You'll need to replace this with your actual database connection code

// Redirect to the login page if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location index.php");
    exit;
}


$user_id = $_GET['user_id'];

// Fetch owner information based on user ID
$query = "SELECT * FROM owner WHERE user_id = '$user_id'";
$result = mysqli_query($connection, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $ownerData = mysqli_fetch_assoc($result);
}


// Fetch user information based on ID


// Fetch data from assignref table joined with user table and reqform table
$query = "SELECT ar.*, rf.user_id, u.firstname, u.lastname, u.address, u.contact, rc.labor, rc.parts, rc.payment
FROM assignref ar
JOIN reqform rf ON ar.reqform_id = rf.reqform_id
JOIN repairman r ON ar.repairman_id = r.repairman_id
JOIN user u ON rf.user_id = u.user_id
JOIN receipt rc ON u.user_id = rc.user_id AND rf.reqform_id = rc.reqform_id WHERE u.user_id= '$user_id'";
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.3/jspdf.umd.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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
            height: 700px;
        }

        .timeline-buttons {
            display: flex;
            margin-bottom: 10px;
            justify-content: flex-start;
            /* Align buttons to the start of the container */
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

        .vc1 {
            background-color: #617695;
            /* Change the background color for the active button */
        }

        .timeline-content {
            color: #555;
            padding: 20px;
            margin-top: 10px;
        }

        /* Added styling for checkboxes */
        .checkbox-container {
            display: flex;
            justify-content: space-between;
            /* Adjusted to create two columns */
            margin-top: 10px;
        }

        .checkbox-group {
            display: flex;
            flex-direction: column;
            margin-bottom: 10px;
        }

        .checkbox-label {
            margin-right: 10px;
            font-size: 18px;
            /* Increased font size */
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
            background-color: #bebebe;
            /* Added background color */
            border: none;
            /* Removed border for a cleaner look */
            border-radius: 5px;
            /* Added border radius for a rounded look */
        }


        /* Updated styling for cancel and next buttons */
        .button-container {
            display: flex;
            justify-content: flex-end;
            /* Align buttons to the end of the container */
            margin-top: 20px;
        }

        .cancel-button,
        .next-button {
            padding: 10px;
            background-color: #1b91ff;
            /* Changed color to blue */
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .next-button {
            margin-left: 10px;
            /* Added margin to separate the buttons */
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
            width: 90%;
            /* Adjusted width to 25% for four columns per row */
            box-sizing: border-box;
            /* Added to include padding and border in the box's total width */
        }

        .column-box1 {
            padding: 14px;
            background-color: #6d7c8a;
            border-radius: 5px;
            color: #fff;
            width: 100%;
            /* Adjusted width to 25% for four columns per row */
            box-sizing: border-box;
            /* Added to include padding and border in the box's total width */
        }

        .column-box-input input {
            width: 94%;
            /* Set the width to 100% for input and select elements */
            margin-top: 5px;
            padding: 15px;
            font-size: 16px;
            background-color: #6d7c8a;
            border: none;
            border-radius: 5px;
            color: #fff;
        }

        .column-box-input select {
            width: 100%;
            /* Set the width to 100% for input and select elements */
            margin-top: 5px;
            padding: 15px;
            font-size: 16px;
            background-color: #6d7c8a;
            border: none;
            border-radius: 5px;
            color: #fff;
        }

        .button-container {
            display: flex;
            justify-content: flex-end;
            /* Align buttons to the end of the container */
            margin-top: 20px;
            width: 200%;
            /* Set the width to 100% */
            box-sizing: border-box;
            /* Include padding and border in the box's total width */
        }


        .cancel-button,
        .next-button {
            padding: 10px;
            background-color: #1b91ff;
            /* Changed color to blue */
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
            /* Adjusted margin-right to create space between buttons */
        }


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

        .receipt {
            color: #fff;
            font-size: 30px;
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
            <div class="profile-name"><?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?></div>
        </div>
        <div class="section-line"></div><!-- Added section line -->

        <!-- Navigation links -->
        <a href="profile.php">Profile</a>
        <a href="reqservice.php">Request Service</a>
        <a href="notif.php">Notification</a>
        <a href="message.php">Message</a>
        <a href="tfixuserprogress5.php">Progress</a>
        <a href="logout.php">Logout</a>
    </nav>

    <section>
        <!-- MAIN CONTENT -->
        <div class="timeline-section">
            <center>
                <h1 class="receipt">RECEIPT</h1>
            </center>

            <div class="timeline-buttons">
                <button class="timeline-button" onclick="showDIAGNOSIS()">DIAGNOSIS</button>
                <button class="timeline-button" onclick="showPendingRequest()">SERVICE</button>
                <button class="timeline-button vc1" onclick="showCompletedRequest()">PAYMENT</button>
            </div>

            <div class="timeline-content">
                <div class="content-box">
                    <form action="tfixshopowner_progress5.php" method="POST">
                        <input type="hidden" id="user_id" name="user_id" value="<?php echo $progressData['user_id']; ?>">
                        <input type="hidden" id="is_deleted" name="is_deleted" value="<?php echo $progressData['is_deleted']; ?>">
                        <input type="hidden" id="reqform_id" name="reqform_id" value="<?php echo $progressData['reqform_id']; ?>">
                        <input type="hidden" id="reqform_id" name="repairman_id" value="<?php echo $progressData['repairman_id']; ?>">
                        <div class="content-columns">
                            <!-- COLUMN NAME FINDINGS -->
                            <div class="column-box">
                                <div>Full Name:</div>
                            </div>

                            <!-- Input Column for findings -->
                            <div class="column-box-input">
                                <input type="text" id="findings" name="fullname" class="repair-input" value="<?php echo $progressData['firstname']; ?> <?php echo $progressData['lastname']; ?>" readonly>
                            </div>

                            <!-- COLUMN NAME INSPECTED BY -->
                            <div class="column-box">
                                <div>Phone Number:</div>
                            </div>

                            <div class="column-box-input">
                                <input type="text" id="unit_brand" name="contact" class="repair-input" value="<?php echo $progressData['contact']; ?>" readonly>
                            </div>

                            <div class="column-box">
                                <div>Address:</div>
                            </div>

                            <div class="column-box-input">
                                <input type="text" id="unit_brand" name="address" class="repair-input" value="<?php echo $progressData['address']; ?>" readonly>
                            </div>

                            <div class="column-box">
                                <div>Unit Name:</div>
                            </div>

                            <div class="column-box-input">
                                <input type="text" id="inspect" name="unit_name" class="repair-input" value="Rrefrigerator" readonly>
                            </div>

                            <!-- COLUMN NAME INSPECTED BY -->
                            <div class="column-box">
                                <div>Assigned Technician:</div>
                            </div>

                            <div class="column-box-input">
                                <input type="text" id="inspect" name="assign_tech" class="repair-input" value="<?php echo $repairmanData['firstname']; ?> <?php echo $repairmanData['lastname']; ?>" readonly>
                            </div>


                            <!-- COLUMN NAME DATE REQUESTED -->
                            <div class="column-box">
                                <div>Parts Amount:</div>
                            </div>

                            <div class="column-box-input">
                                <input type="text" id="inspect" name="parts" class="repair-input" value="<?php echo $progressData['parts']; ?>.00" readonly>
                            </div>

                            <div class="column-box">
                                <div>Labor Amount:</div>
                            </div>

                            <div class="column-box-input">
                                <input type="text" id="inspect" name="assign_tech" class="repair-input" value="<?php echo $progressData['labor']; ?>.00" readonly>
                            </div>

                            <div class="column-box">
                                <div>Mode of Payment:</div>
                            </div>

                            <div class="column-box-input">
                                <input type="text" id="inspect" name="payment" class="repair-input" value="<?php echo $progressData['payment']; ?>" readonly>
                            </div>

                            <!-- Cancel and Next buttons -->
                            <div class="button-container">
                            </div>
                        </div>
                    </form>

                </div>
            </div>
    </section>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.3/jspdf.umd.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script>
        // Function to generate PDF and trigger print
        function generatePDFAndPrint() {
            generatePDF(); // Call the function to generate PDF
            window.print(); // Trigger the print dialog
        }

        // Function to generate PDF
        function generatePDF() {
            // Toggle visibility of elements
            toggleElements();

            // Trigger the print dialog
            window.print();
        }

        // Add event listener for Ctrl+P key press
        document.addEventListener('keydown', function(event) {
            if (event.ctrlKey && event.key === 'p') {
                generatePDFAndPrint(); // Call function to generate PDF and print
                event.preventDefault(); // Prevent default Ctrl+P behavior (printing the webpage)
            }
        });

        function toggleElements() {
            // Toggle visibility of the print button
            var printButton = document.getElementById("print-button");
            printButton.style.display = "none";

            // Toggle visibility of the nav links
            var navLinks = document.getElementById("nav-links");
            navLinks.style.display = "none";
        }

        // Function to show the hidden elements when print is cancelled
        window.onafterprint = function() {
            // Show the print button
            var printButton = document.getElementById("print-button");
            printButton.style.display = "block";

            // Show the nav links
            var navLinks = document.getElementById("nav-links");
            navLinks.style.display = "block";
        };
    </script>


</body>

</html>