<?php
session_start();

// Include database connection file
include('config.php');  // You'll need to replace this with your actual database connection code

// Redirect to the login page if the user is not logged in
if (!isset($_SESSION['personnel_id'])) {
    header("Location index.php");
    exit;
}

// Fetch user information based on ID
$repairmanID = $_SESSION['personnel_id'];
$userID = $_SESSION['user_id'];
$reqformID = $_SESSION['reqform_id'];

$query = "SELECT 
          *FROM refrigerator";

// Execute the query
$result = mysqli_query($connection, $query);

// Check if the query was successful
if (!$result) {
    die("Error in SQL query: " . mysqli_error($connection));
}

// Fetch the user data
$reqformData = mysqli_fetch_assoc($result);

// Output or process the fetched data


// Close the database connection
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
            <form action="tfixpersonnel_endorse1.php" method="POST">
                <div class="content-columns">
                    <!-- COLUMN NAME FINDINGS -->
                    <div class="column-box">
                        <div>Findings:</div>
                    </div>

                    <!-- Input Column for findings -->
                    <div class="column-box-input">

                        <input type="text" id="findings" name="findings" class="repair-input" 
                        value=" <?php
                                    // Check if the checkbox values are set in the $_GET array
                                    if (isset($_GET['faultythermo'])) {
                                        echo $_GET['faultythermo']. ', '. ' ';
                                    }
                                    if (isset($_GET['defective'])) {
                                        echo $_GET['defective'] . ', '. ' ';
                                    }
                                    if (isset($_GET['clogged'])) {
                                        echo $_GET['clogged'] . ', '. ' ';
                                    }
                                    if (isset($_GET['faultydef'])) {
                                        echo $_GET['faultydef'] . ', '. ' ';
                                    }
                                    if (isset($_GET['low'])) {
                                        echo $_GET['low'] . ', '. ' ';
                                    }
                                    if (isset($_GET['malfunctioning'])) {
                                        echo $_GET['malfunctioning'] . ', '. ' ';
                                    }
                                    if (isset($_GET['gasket'])) {
                                        echo $_GET['gasket'] . ', '. ' ';
                                    }
                                    if (isset($_GET['vent'])) {
                                        echo $_GET['vent'] . ', '. ' ';
                                    }
                                    if (isset($_GET['thermostat'])) {
                                        echo $_GET['thermostat'] . ', '. ' ';
                                    }
                                    if (isset($_GET['coils'])) {
                                        echo $_GET['coils'] . ', '. ' ';
                                    }
                                    if (isset($_GET['charge'])) {
                                        echo $_GET['charge'] . ', '. ' ';
                                    }
                                    if (isset($_GET['condenser'])) {
                                        echo $_GET['condenser'] . ', '. ' ';
                                    }
                                    if (isset($_GET['motor'])) {
                                        echo $_GET['motor'] . ', '. ' ';
                                    }
                                    if (isset($_GET['jamming'])) {
                                        echo $_GET['jamming'] . ', '. ' ';
                                    }
                                    if (isset($_GET['faulty'])) {
                                        echo $_GET['faulty'] . ', '. ' ';
                                    }
                                    if (isset($_GET['lubrication'])) {
                                        echo $_GET['lubrication'] . ', '. ' ';
                                    }
                                    if (isset($_GET['worn'])) {
                                        echo $_GET['worn'] . ', '. ' ';
                                    }
                                    if (isset($_GET['electrical'])) {
                                        echo $_GET['electrical'] . ', '. ' ';
                                    }
                                    if (isset($_GET['capacitor'])) {
                                        echo $_GET['capacitor'] . ', '. ' ';
                                    }
                                    if (isset($_GET['stuck'])) {
                                        echo $_GET['stuck'] . ', '. ' ';
                                    }
                                    if (isset($_GET['overheating'])) {
                                        echo $_GET['overheating'] . ', '. ' ';
                                    }
                                    if (isset($_GET['defective'])) {
                                        echo $_GET['defective'] . ', '. ' ';
                                    }
                                    if (isset($_GET['damaged'])) {
                                        echo $_GET['damaged'] . ', '. ' ';
                                    }
                                    if (isset($_GET['loose'])) {
                                        echo $_GET['loose'] . ', '. ' ';
                                    }
                                    // Add more checkboxes as needed
                                ?>">
                    </div>

                    <div class="column-box">
    <div>Unit Name:</div>
</div>

<div class="column-box-input">
    <select id="unit_name" name="unitname" class="repair-input" onchange="updateOptions()">
        <option value="None">Choose</option>
        <option value="Refrigerator">Refrigerator</option>
        <option value="Electric Fan">Electric Fan</option>
        <!-- Add more options as needed -->
    </select>
</div>

<!-- Updated column box for Part Description -->
<div class="column-box">
    <div>Parts Description:</div>
</div>

<div class="column-box-input">
    <select id="part_description" name="description" class="repair-input">
        <option value="None">Choose</option>
        <!-- Options for Part Description will be updated dynamically based on Unit Name -->
    </select>
</div>



                    <!-- COLUMN NAME INSPECTED BY -->
                    <div class="column-box">
                        <div>Inspected By:</div>
                    </div>

                    <div class="column-box-input">
                    <input type="text" id="inspect" name="inspect" class="repair-input" value="<?php echo isset($_SESSION['firstname']) ? $_SESSION['firstname'] : ''; ?> <?php echo isset($_SESSION['lastname']) ? $_SESSION['lastname'] : ''; ?>" >
                    </div>

                    <!-- COLUMN NAME DATE REQUESTED -->
                    <div class="column-box">
                        <div>Completion Date</div>
                    </div>

                    <div class="column-box-input">
                        <input type="date" id="repairstatus" name="repairstatus" class="repair-input" placeholder="Parts Description" >
                    </div>


                    <!-- Updated column box for Assigned Technician -->
<div class="column-box">
    <div>Assigned Technician:</div>
</div>

<div class="column-box-input">
    <select id="assigned_technician" name="assigned" class="repair-input">
        <option value="None">Choose</option>
        <!-- Options for Assigned Technician will be updated dynamically based on Unit Name -->
    </select>
</div>

                    <!-- Cancel and Next buttons -->
                        <div class="button-container">
                            <button class="cancel-button" onclick="cancelDiagnosis()">CANCEL</button>
                            <button type="submit" class="next-button">NEXT</button>
                        </div>
                </div>
            </form>`;
        }
        

        // Automatically show DIAGNOSIS content when the page loads
        window.onload = function() {
            showDIAGNOSIS();
        };

        

                

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
    let unitName = document.getElementById("unit_name").value;
    let partDescriptionSelect = document.getElementById("part_description");
    let assignedTechnicianSelect = document.getElementById("assigned_technician");
    
    // Clear existing options
    partDescriptionSelect.innerHTML = "";
    assignedTechnicianSelect.innerHTML = "";
    
    // Add "Choose" option as default
    partDescriptionSelect.appendChild(new Option("Choose", "Choose"));
    assignedTechnicianSelect.appendChild(new Option("Choose", "Choose"));
    
    if (unitName === "Refrigerator") {
        // Add options for Refrigerator
        let refrigeratorOptions = [
            { value: "Refrigerant", text: "Refrigerant" },
            { value: "Compressor", text: "Compressor" },
            // Add more options as needed
        ];
        refrigeratorOptions.forEach(option => {
            partDescriptionSelect.appendChild(new Option(option.text, option.value));
        });
        
         // Add options for Assigned Technician for Refrigerator
         let refrigeratorTechnicians = [
            { value: "kakashi hatake", text: "kakashi hatake" },
            { value: "Jane Smith", text: "Jane Smith" },
            // Add more options as needed
        ];
        refrigeratorTechnicians.forEach(option => {
            assignedTechnicianSelect.appendChild(new Option(option.text, option.value));
        });
    } else if (unitName === "Electric Fan") {
        // Add options for Electric Fan
        let electricFanOptions = [
            { value: "Fan Blade", text: "Fan Blade" },
            { value: "Fan Motor", text: "Fan Motor" },
            // Add more options as needed
        ];
        electricFanOptions.forEach(option => {
            partDescriptionSelect.appendChild(new Option(option.text, option.value));
        });

        // Add options for Assigned Technician for Electric Fan
        let electricFanTechnicians = [
            { value: "Might Guy", text: "Might Guy" },
            { value: "Bob Williams", text: "Bob Williams" },
            // Add more options as needed
        ];
        electricFanTechnicians.forEach(option => {
            assignedTechnicianSelect.appendChild(new Option(option.text, option.value));
        });
    }
    // Add more else if statements for other unit names
}

    
</script>


</body>
</html>
