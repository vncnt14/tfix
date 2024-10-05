<?php
session_start();

// Include database connection file
include('config.php');

// Redirect to the login page if the user is not logged in
if (isset($_GET['user_id']) && isset($_GET['reqform_id'])) {
    $user_id = $_GET['user_id'];
    $reqform_id = $_GET['reqform_id'];

    // Fetch user data based on user_id
    $userData = mysqli_query($connection, "SELECT * FROM user WHERE user_id = '$user_id'");
    $userData = ($userData) ? mysqli_fetch_assoc($userData) : die('Error fetching user data: ' . mysqli_error($connection));

    // Fetch reqform data based on user_id and reqform_id
    $reqformData = mysqli_query($connection, "SELECT * FROM reqform WHERE user_id = '$user_id' AND reqform_id = '$reqform_id'");
    $reqformData = ($reqformData) ? mysqli_fetch_assoc($reqformData) : die('Error fetching reqform data: ' . mysqli_error($connection));

    // Fetch result data based on your requirements
    // Replace the following query with your actual query
    $result = mysqli_query($connection, "SELECT user.user_id, user.firstname, user.lastname, reqform_id, date_requested
    FROM user
    JOIN reqform ON reqform.user_id = user.user_id");
    
    // Check if the query was successful
    if ($result) {
        // Fetch associative array
        while ($row = mysqli_fetch_assoc($result)) {
            // Your existing table row rendering code here

        }
    } else {
        echo '<tr><td colspan="4">Error: ' . mysqli_error($connection) . '</td></tr>';
    }
} else {
    die('User ID and Reqform ID not specified.');
}
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
            height: 510px;
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
        <a href="tfixpersonnel_progress3.php">Progress</a>
        <a href="logout.php">Logout</a>
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
    </section>

    <script>


       // Variable to store problem description
       let problemDescription = "";

        function showDIAGNOSIS() {
            resetTimelineButtons();
            document.querySelector('.timeline-button:nth-child(1)').classList.add('active');

            // Adding content box with checkboxes and input box
            document.querySelector('.timeline-content').innerHTML = `
            <form action="tfixpersonnel_electricfan.php" method="POST">
                <input type="hidden" name="user_id" id="user_id" value="<?php echo $userData['user_id'];?>">
                <input type="hidden" name="reqform_id" id="reqform_id" value="<?php echo $reqformData['reqform_id'];?>">
                <div class="content-box">
                    <div class="checkbox-container">
                        <div class="checkbox-group">
                            <label class="checkbox-label">
                                <input type="checkbox" id="motor" name="motor" class="checkbox-input" value="Motor Failure">
                                Motor Failure
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" id="loose" name="loose" class="checkbox-input" value="Loose or Broken Fan Belt">
                                Loose or Broken Fan Belt
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" id="jamming" name="jamming" class="checkbox-input" value="Jamming or Obstruction">
                                Jamming or Obstruction
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" id="faulty" name="faulty" class="checkbox-input" value="Faulty Fan Switch">
                                Faulty Fan Switch
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" id="lubrication" name="lubrication" class="checkbox-input" value="Lubrication Issues">
                                Lubrication Issues
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" id="worn" name="worn" class="checkbox-input" value="Worn Out Bearings">
                                Worn Out Bearings
                            </label>
                        </div>
                        <div class="checkbox-group">
                            <label class="checkbox-label">
                                <input type="checkbox" id="electrical" name="electrical" class="checkbox-input" value="Electrical Wiring Issues">
                                Electrical Wiring Issues
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" id="capacitor" name="capacitor" class="checkbox-input" value="Faulty Capacitor">
                                Faulty Capacitor
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" id="stuck" name="stuck" class="checkbox-input" value="Stuck Blade Hub">
                                Stuck Blade Hub
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" id="overheating" name="overheating" class="checkbox-input" value="Motor Overheating">
                                Motor Overheating
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" id="defective" name="defective" class="checkbox-input" value="Defective Oscillation Mechanism">
                                Defective Oscillation Mechanism
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" id="damaged" name="damaged" class="checkbox-input" value="Damaged or Warped Blades">
                                Damaged or Warped Blades
                            </label>
                            
                        </div>
                    </div>

                    <div class="checkbox-container">
                        <div class="checkbox-group">
                            <label class="checkbox-label">Is the unit repairable?</label>
                            <label class="checkbox-label">
                                <input type="radio" id="repairstatusYES" name="repairstatusYES" value="YES" class="checkbox-input">
                                Yes
                            </label>
                            <label class="checkbox-label">
                                <input type="radio" id="repairstatusNO" name="repairstatusNO" value="NO" class="checkbox-input">
                                No
                            </label>
                        </div>
                    </div>

                  

                
                    <!-- Cancel and Next buttons -->
                    <div class="button-container">
                         <button class="cancel-button" onclick="cancelDiagnosis()">CANCEL</button>
                         <button type="submit" class="next-button">NEXT</button>
                    </div>
                </div>
            </form>`;    
        }

                

        function showPendingRequest() {
            resetTimelineButtons();
            document.querySelector('.timeline-button:nth-child(2)').classList.add('active');
            document.querySelector('.timeline-content').innerHTML = 'Pending request content goes here.';
        }

        function showCompletedRequest() {
            resetTimelineButtons();
            document.querySelector('.timeline-button:nth-child(3)').classList.add('active');
            // Adding content box with name and example date
            document.querySelector('.timeline-content').innerHTML = `
                <div class="content-box">
                    <div>John Doe</div>
                    <div>01-24-23</div>
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
    diagnosisForm.action = ""; // Replace with your actual PHP script
    diagnosisForm.method = "";

    // Create a hidden input for problemDescription
    const problemDescriptionInput = document.createElement("input");
    problemDescriptionInput.type = "hidden";
    problemDescriptionInput.name = "problemDescription";
    problemDescriptionInput.value = problemDescription;
    diagnosisForm.appendChild(problemDescriptionInput);

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
                    <input type="text" id="partsdescrip" name="partsdescrip" class="repair-input" placeholder="Parts Description" >
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
                    <select id="assigntech" name="assigntech" class="repair-input">
                        <option value="KAKASHI HATAKE">KAKASHI HATAKE</option>
                        <option value="MIGHT GUY">MIGHT GUY</option>
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
    </script>
    

</body>
</html>
