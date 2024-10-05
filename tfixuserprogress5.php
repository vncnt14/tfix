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
$user_id = $_GET['user_id'];
$owner_id = $_GET['owner_id'];



$query = "SELECT *FROM repairman WHERE appliance= 'Refrigerator'";
$result = mysqli_query($connection, $query);
$repaimanData = mysqli_fetch_assoc($result);

$query1 = "SELECT *FROM refrigerator WHERE user_id = '$user_id'";
$result1 = mysqli_query($connection, $query1);
$findingsData = mysqli_fetch_assoc($result1);

$query2 = "SELECT reqform.*, assignref.*
FROM reqform
LEFT JOIN assignref ON reqform.reqform_id = assignref.reqform_id
WHERE reqform.user_id = '$user_id';";
$result2 = mysqli_query($connection, $query2);
$reqformData = mysqli_fetch_assoc($result2);

$query3 = "SELECT ar.*, rf.user_id, u.firstname, u.lastname, u.address, u.contact, rc.labor, rc.parts, rc.payment
FROM assignref ar
JOIN reqform rf ON ar.reqform_id = rf.reqform_id
JOIN repairman r ON ar.repairman_id = r.repairman_id
JOIN user u ON rf.user_id = u.user_id
JOIN receipt rc ON u.user_id = rc.user_id AND rf.reqform_id = rc.reqform_id WHERE u.user_id = '$user_id'";
$result3 = mysqli_query($connection, $query3);
$progressData = mysqli_fetch_assoc($result3);



$query4 = "SELECT *FROM repairman WHERE appliance = 'refrigerator'";
$result4 = mysqli_query($connection, $query4);
$repairmanData = mysqli_fetch_assoc($result4);



mysqli_close($connection);



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            height: 700px;
        }

        .timeline-buttons {
            display: flex;
            margin-bottom: 10px;
            justify-content: flex-start; /* Align buttons to the start of the container */
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

.button-container { 
    display: flex;
    justify-content: flex-end; /* Align buttons to the end of the container */
    margin-top: 20px;
    width: 200%; /* Set the width to 100% */
    box-sizing: border-box; /* Include padding and border in the box's total width */
}


.cancel-button, .next-button {
    padding: 10px;
    background-color: #1b91ff; /* Changed color to blue */
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-right: 10px; /* Adjusted margin-right to create space between buttons */
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
            <img src="https://isl.org.pk/wp-content/uploads/2020/03/dummy-avatar-300x300.jpg" alt="Profile Image" class="profile-image">
            <div class="profile-name"><?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?></div>
        </div>
        <div class="section-line"></div> <!-- Added section line -->

        <!-- Navigation links -->
        <a href="tfixrepairman_profile.php">Profile</a>
        <a href="tfixrepairman_reqservice.php">Request Service</a>
        <a href="tfixrepairman_notif.php">Notification</a>
        <a href="tfixrepairman_message.php">Message</a>
        <a href="tfixrepairman_progress.php">Progress</a>
        <a href="logout.php">Log out</a>
    </nav>

    <section>
        <!-- MAIN CONTENT -->
        <div class="timeline-section">
            <div class="timeline-buttons">
                <button class="timeline-button" onclick="showDIAGNOSIS()">DIAGNOSIS</button>
                <button class="timeline-button" onclick="showPendingRequest()">SERVICE</button>
                <button class="timeline-button" onclick="showCompletedRequest()">PAYMENT</button>
            </div>

            <div class="timeline-content">
                <!-- Your timeline content goes here -->

            </div>
        </div>
        <br>
        <br>
        
    </section>

    <script>


       // Variable to store problem description
       let problemDescription = "";

        function showDIAGNOSIS() {
            resetTimelineButtons();
            document.querySelector('.timeline-button:nth-child(1)').classList.add('active');

            // Adding content box with checkboxes and input box
            document.querySelector('.timeline-content').innerHTML = `
            <div class="content-box">
            <form action="tfixpersonnel_assignref.php" method="POST">
    <input type="hidden" id="user_id" name="user_id" value="<?php echo isset($findingsData['user_id']) ? htmlspecialchars($findingsData['user_id']) : ''; ?>">
    
    <div class="content-columns">
        <!-- COLUMN NAME FINDINGS -->
        <div class="column-box">
            <div>Findings:</div>
        </div>

        <!-- Input Column for findings -->
        <div class="column-box-input">
            <input type="text" id="findings" name="findings" class="repair-input" 
            value="<?php echo isset($findingsData['faultythermo']) ? htmlspecialchars($findingsData['faultythermo']) . ' ' : ''; ?><?php echo isset($findingsData['defective']) ? htmlspecialchars($findingsData['defective']) . ' ' : ''; ?><?php echo isset($findingsData['clogged']) ? htmlspecialchars($findingsData['clogged']) . ' ' : ''; ?><?php echo isset($findingsData['faultydef']) ? htmlspecialchars($findingsData['faultydef']) . ' ' : ''; ?><?php echo isset($findingsData['low']) ? htmlspecialchars($findingsData['low']) . ' ' : ''; ?><?php echo isset($findingsData['malfunctioning']) ? htmlspecialchars($findingsData['malfunctioning']) . ' ' : ''; ?><?php echo isset($findingsData['gasket']) ? htmlspecialchars($findingsData['gasket']) . ' ' : ''; ?><?php echo isset($findingsData['vent']) ? htmlspecialchars($findingsData['vent']) . ' ' : ''; ?><?php echo isset($findingsData['thermostat']) ? htmlspecialchars($findingsData['thermostat']) . ' ' : ''; ?><?php echo isset($findingsData['coils']) ? htmlspecialchars($findingsData['coils']) . ' ' : ''; ?><?php echo isset($findingsData['charge']) ? htmlspecialchars($findingsData['charge']) . ' ' : ''; ?><?php echo isset($findingsData['condenser']) ? htmlspecialchars($findingsData['condenser']) . ' ' : ''; ?>">
        </div>

        <!-- COLUMN NAME INSPECTED BY -->
        <div class="column-box">
            <div>Unit Type:</div>
        </div>

        <div class="column-box-input">
            <input type="text" id="unit_type" name="unit_type" class="repair-input" value="Refrigerator" readonly>
        </div>

        <div class="column-box">
            <div>Unit Brand:</div>
        </div>

        <div class="column-box-input">
            <input type="text" id="unit_brand" name="unit_brand" class="repair-input" value="<?php echo isset($reqformData['unit_brand']) ? htmlspecialchars($reqformData['unit_brand']) : ''; ?>" readonly>
        </div>

        <div class="column-box">
            <div>Unit Model:</div>
        </div>

        <div class="column-box-input">
            <input type="text" id="unit_model" name="unit_model" class="repair-input" value="<?php echo isset($reqformData['unit_model']) ? htmlspecialchars($reqformData['unit_model']) : ''; ?>" readonly>
        </div>

        <!-- COLUMN NAME INSPECTED BY -->
        <div class="column-box">
            <div>Inspected By:</div>
        </div>

        <div class="column-box-input">
            <input type="text" id="inspect" name="inspect" class="repair-input" value="<?php echo isset($reqformData['inspect']) ? htmlspecialchars($reqformData['inspect']) : ''; ?>" readonly>
        </div>

        <!-- COLUMN NAME DATE REQUESTED -->
        <div class="column-box">
            <div>Start Date:</div>
        </div>

        <div class="column-box-input">
            <input type="text" id="repairstatus" name="start_date" class="repair-input" value="<?php echo isset($reqformData['start_date']) ? htmlspecialchars($reqformData['start_date']) : ''; ?>">
        </div>

        <!-- COLUMN NAME DATE REQUESTED -->
        <div class="column-box">
            <div>Assign Technician:</div>
        </div>

        <div class="column-box-input">
            <input type="text" id="repairstatus" name="assign_tech" class="repair-input" value="<?php echo isset($repaimanData['firstname']) ? htmlspecialchars($repaimanData['firstname']) : ''; ?><?php echo isset($repaimanData['lastname']) ? htmlspecialchars($repaimanData['lastname']) : ''; ?>" readonly>
        </div>

        <!-- Updated column box for Part Description -->
        <div class="column-box">
            <div>Parts Description:</div>
        </div>

        <div class="column-box-input">
            <input type="text" id="quantity" name="parts_name" class="repair-input" min="1" required value="<?php echo isset($reqformData['parts_name']) ? htmlspecialchars($reqformData['parts_name']) : ''; ?>">
        </div>

        <!-- New column box for Quantity -->
        <div class="column-box">
            <div>Quantity:</div>
        </div>

        <div class="column-box-input">
            <input type="text" id="quantity" name="quantity" class="repair-input" min="1" required value="<?php echo isset($reqformData['quantity']) ? htmlspecialchars($reqformData['quantity']) : ''; ?>">
        </div>

        <!-- Cancel and Next buttons -->
        <div class="button-container">
            <button class="cancel-button" onclick="cancelDiagnosis()">CANCEL</button>
            <button type="button" class="next-button">NEXT</button>
        </div>
    </div>
</form>
`;
        }
        

        // Automatically show DIAGNOSIS content when the page loads
        window.onload = function() {
            showDIAGNOSIS();
        };

        

                

        function showPendingRequest() {
            resetTimelineButtons();
            document.querySelector('.timeline-button:nth-child(2)').classList.add('active');
            document.querySelector('.timeline-content').innerHTML = `<div class="content-box">
            <form action="tfixrepairman_service5.php" method="GET">
           
                <div class="content-columns">
                    <!-- COLUMN NAME FINDINGS -->
                    <div class="column-box">
                        <div>Date Requested:</div>
                    </div>

                    <!-- Input Column for findings -->
                    <div class="column-box-input">

                    <input type="text" id="findings" name="findings" class="repair-input" 
                    value="<?php echo isset($reqformData['date_requested']) ? htmlspecialchars($reqformData['date_requested']) : ''; ?>" readonly>  
                    </div>

                    <!-- COLUMN NAME INSPECTED BY -->
                    <div class="column-box">
                        <div>Unit Status:</div>
                    </div>

                    <div class="column-box-input">
                    <input type="text" id="unit_brand" name="assign_tech" class="repair-input" value="<?php echo $reqformData['unit_status'];?>" readonly>
                    </div>


                    <div class="column-box">
                        <div>Assigned Technician:</div>
                    </div>

                    <div class="column-box-input">
                    <input type="text" id="unit_brand" name="assign_tech" class="repair-input" value="<?php echo isset($reqformData['assign_tech']) ? htmlspecialchars($reqformData['assign_tech']) : ''; ?>" readonly>
                    </div>

                    <div class="column-box">
                        <div>Changed Technician:</div>
                    </div>

                    <div class="column-box-input">
                        <input type="text" id="description" name="description" class="repair-input" value="<?php echo isset($reqformData['change_tech']) ? htmlspecialchars($reqformData['change_tech']) : ''; ?>" readonly>
                    </div>
                    
                    <!-- COLUMN NAME INSPECTED BY -->
                    <div class="column-box">
                    <div>Start Date:</div>
                    </div>
                    
                    <div class="column-box-input">
                    <input type="text" id="inspect" name="start_date" class="repair-input" value="<?php echo isset($reqformData['start_date']) ? htmlspecialchars($reqformData['start_date']) : ''; ?>" readonly >
                    </div>
                    
                    
                    <!-- COLUMN NAME DATE REQUESTED -->
                    <div class="column-box">
                    <div>Finish Date:</div>
                    </div>
                    
                    <div class="column-box-input">
                        <input type="text" id="description" name="description" class="repair-input" value="<?php echo isset($reqformData['finish_date']) ? htmlspecialchars($reqformData['finish_date']) : ''; ?>" readonly>
                    </div>
                    
                    <div class="column-box">
                        <div>Duration:</div>
                    </div>

                    <div class="column-box-input">
                        <input type="text" id="description" name="description" class="repair-input"value="<?php echo isset($reqformData['duration']) ? htmlspecialchars($reqformData['duration']) : ''; ?>" readonly>
                    </div>

                    <!-- Cancel and Next buttons -->
                        <div class="button-container">
                            <button class="cancel-button" onclick="cancelDiagnosis()">BACK</button>
                            <button type="button" class="next-button">PAY</button>
                        </div>
                </div>
            </form>`;
        }

        function showCompletedRequest() {
            resetTimelineButtons();
            document.querySelector('.timeline-button:nth-child(3)').classList.add('active');
            // Adding content box with name and example date
            document.querySelector('.timeline-content').innerHTML =  `
    <div class="content-box">
        <form action="" method="POST">
            <input type="hidden" id="user_id" name="user_id" value="<?php echo isset($progressData['user_id']) ? htmlspecialchars($progressData['user_id']) : ''; ?>">
            <input type="hidden" id="unit_status" name="unit_status" value="<?php echo isset($progressData['unit_status']) ? htmlspecialchars($progressData['unit_status']) : ''; ?>">
            <input type="hidden" id="reqform_id" name="reqform_id" value="<?php echo isset($progressData['reqform_id']) ? htmlspecialchars($progressData['reqform_id']) : ''; ?>">
            <input type="hidden" id="reqform_id" name="repairman_id" value="<?php echo isset($progressData['repairman_id']) ? htmlspecialchars($progressData['repairman_id']) : ''; ?>">
            <div class="content-columns">
                <!-- COLUMN NAME FINDINGS -->
                <div class="column-box">
                    <div>Full Name:</div>
                </div>

                <!-- Input Column for findings -->
                <div class="column-box-input">
                    <input type="text" id="findings" name="fullname" class="repair-input" 
                    value="<?php echo isset($progressData['firstname']) ? htmlspecialchars($progressData['firstname']) : ''; ?><?php echo isset($progressData['lastname']) ? htmlspecialchars($progressData['lastname']) : ''; ?>" readonly>  
                </div>

                <!-- COLUMN NAME INSPECTED BY -->
                <div class="column-box">
                    <div>Phone Number:</div>
                </div>

                <div class="column-box-input">
                    <input type="text" id="unit_brand" name="contact" class="repair-input" value="<?php echo isset($progressData['contact']) ? htmlspecialchars($progressData['contact']) : ''; ?>" readonly>
                </div>

                <div class="column-box">
                    <div>Address:</div>
                </div>

                <div class="column-box-input">
                    <input type="text" id="unit_brand" name="address" class="repair-input" value="<?php echo isset($progressData['address']) ? htmlspecialchars($progressData['address']) : ''; ?>" readonly>
                </div>

                <div class="column-box">
                    <div>Unit Name:</div>
                </div>

                <div class="column-box-input">
                    <input type="text" id="inspect" name="unit_name" class="repair-input" value="<?php echo isset($progressData['unit_type']) ? htmlspecialchars($progressData['unit_type']) : ''; ?>" readonly >
                </div>
                
                <!-- COLUMN NAME INSPECTED BY -->
                <div class="column-box">
                    <div>Assigned Technician:</div>
                </div>
                
                <div class="column-box-input">
                    <input type="text" id="inspect" name="assign_tech" class="repair-input" value="<?php echo isset($repairmanData['firstname']) ? htmlspecialchars($repairmanData['firstname']) : ''; ?><?php echo isset($repairmanData['lastname']) ? htmlspecialchars($repairmanData['lastname']) : ''; ?>" readonly >
                </div>
                
                
                <!-- COLUMN NAME DATE REQUESTED -->
                <div class="column-box">
                    <div>Parts Amount (₱):</div>
                </div>
                
                <div class="column-box-input">
                    <input type="text" id="inspect" name="parts" class="repair-input" value="<?php echo isset($progressData['parts']) ? htmlspecialchars($progressData['parts']) : ''; ?>.00" readonly >
                </div>
                
                <div class="column-box">
                    <div>Labor Amount (₱):</div>
                </div>

                <div class="column-box-input">
                    <input type="text" id="inspect" name="assign_tech" class="repair-input" value="<?php echo isset($progressData['labor']) ? htmlspecialchars($progressData['labor']) : ''; ?>.00" readonly >
                </div>

                <div class="column-box">
                    <div>Mode of Payment:</div>
                </div>

                <div class="column-box-input">
                    <select id="inspect" name="payment" class="repair-input">
                        <option value="GCASH">G CASH</option>
                        <option value="CASH">CASH</option>
                        <option value="PAYMAYA">PAYMAYA</option>
                        <option value="PAYPAL">PAYPAL</option>
                    </select>
                </div>

                <!-- Cancel and Next buttons -->
                <div class="button-container">
                    <button class="cancel-button" onclick="cancelDiagnosis()">BACK</button>
                    <?php
                        // Embedding the user_id in the anchor tag
                        echo '<a href="tfixuserprogress1.php?user_id=' . (isset($user_id) ? htmlspecialchars($user_id) : '') . '"><button type="button" class="next-button">VERIFY</button></a>';
                    ?>
                </div>
            </div>
        </form>
    </div>`;

        }

        function resetTimelineButtons() {
            const buttons = document.querySelectorAll('.timeline-button');
            buttons.forEach(button => button.classList.remove('active'));
        }

        function nextDiagnosis() {
    // Get the problem description from the input field
    problemDescription = document.getElementById("findings").value;

    // Create a form element
    const diagnosisForm = document.createElement("form");
    diagnosisForm.action = "tfixrepairman_endorse1.php"; // Replace with your actual PHP script
    diagnosisForm.method = "POST";

    // Create a hidden input for problemDescription
  

    // Create hidden inputs for checkboxes
    const checkboxes = document.querySelectorAll(".checkbox-input");
    checkboxes.forEach((checkbox) => {
        if (checkbox.checked) {
            const checkboxInput = document.createElement("input");
            checkboxInput.type = "hidden";
            checkboxInput.name = checkbox.name;
            checkboxInput.value = checkbox.value;
            diagnosisForm.appendChild(checkboxInput);
        }
    });

    // Append the form to the document body
    document.body.appendChild(diagnosisForm);

    // Submit the form
    diagnosisForm.submit();

    // Update content for the next "DIAGNOSIS" section 
    document.querySelector('.timeline-content').innerHTML = `
        <div class="content-box">
            <div class="content-columns">
                <!-- COLUMN NAME FINDINGS -->
                <div class="column-box">
                    <div>Findings:</div>
                </div>

                <!-- Input Column for findings -->
                <div class="column-box1">
                    <div>${problemDescription}</div>
                </div>

                <!-- COLUMN NAME UNIT NAME -->
                <div class="column-box">
                    <div>Unit Name:</div>
                </div>

                <div class="column-box-input">
                    <select id="unit_name" name="unit_name" class="repair-input">
                        <option value="refrigerator">Refrigerator</option>
                        <option value="electricfan">Electric Fan</option>
                        <!-- Add more options as needed -->
                    </select>
                </div>

                <!-- COLUMN NAME PARTS DESCRIPTION -->
                    <div class="column-box">
                        <div>Parts Description:</div>
                    </div>

                    <div class="column-box-input">
                        <input type="text" id="description" name="description" class="repair-input">
                    </div>

                <!-- COLUMN NAME INSPECTED BY -->
                <div class="column-box">
                    <div>Inspected By:</div>
                </div>

                <div class="column-box-input">
                    <select id="inspectedBy" name="inspectedBy" class="repair-input">
                        <option value="KAKASHI HATAKE">KAKASHI HATAKE</option>
                        <option value="MIGHT GUY">MIGHT GUY</option>
                        <!-- Add more options as needed -->
                    </select>
                </div>

                <!-- COLUMN NAME DATE REQUESTED -->
                <div class="column-box">
                    <div>Repair Status</div>
                </div>

                <div class="column-box-input">
                    <select id="repairstatus" name="repairstatus" class="repair-input">
                        <option value="Yes">Can repair</option>
                        <option value="No">Cannot be repaired</option>
                        <!-- Add more options as needed -->
                    </select>
                </div>


                <!-- COLUMN NAME ASSIGNED TECHNICIAN -->
                    <div class="column-box">
                        <div>Assigned Technician:</div>
                    </div>

                    <div class="column-box-input">
                        <select id="assigned" name="assigned" class="repair-input">
                            <option value="None">Choose</option>
                            <option value="MIGHT GUY">Might Guy</option>
                            
                            <!-- Add more options as needed -->
                        </select>
                    </div>

                <!-- Cancel and Next buttons -->
                    <div class="button-container">
                        <button class="cancel-button" onclick="cancelDiagnosis()">CANCEL</button>
                        <button class="next-button" onclick="nextDiagnosis()">NEXT</button>
                    </div>
                </div>`;
        }

        // Automatically show DIAGNOSIS content when the page loads
        window.onload = function() {
            showDIAGNOSIS();
        };


        function updateOptions() {
    let unitType = document.getElementById("unit_type").value;
    let partDescriptionSelect = document.getElementById("part_description");
    
    // Clear existing options
    partDescriptionSelect.innerHTML = "";
    assignedTechnicianSelect.innerHTML = "";
    
    // Add "Choose" option as default
    partDescriptionSelect.appendChild(new Option("Choose", "Choose"));
    assignedTechnicianSelect.appendChild(new Option("Choose", "Choose"));
    
    if (unitType === "Refrigerator") { // Check if unitName is "Refrigerator"
        // Add options for Refrigerator
        let refrigeratorOptions = [
            { value: "Refrigerant", text: "Refrigerant" },
            { value: "Compressor", text: "Compressor" }
            // Add more options as needed
        ];
        refrigeratorOptions.forEach(option => {
            partDescriptionSelect.appendChild(new Option(option.text, option.value));
        });
    } else {
        // Add default options for other units
        // You can add more conditions and options here as needed
        partDescriptionSelect.appendChild(new Option("Default Part 1", "DefaultPart1"));
        partDescriptionSelect.appendChild(new Option("Default Part 2", "DefaultPart2"));
        // Add more default options as needed
    }
}


    
</script>


</body>
</html>
