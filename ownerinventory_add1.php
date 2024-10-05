                            <?php
                            session_start();

                            // Include database connection file
                            include('config.php');

                            if (!isset($_SESSION['user_id'])) {
                                header("Location: index.php");
                                exit;
                            }

                            $user_id = $_SESSION['user_id'];
                            $unit_brand = $_GET['unit_brand'];

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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
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
        height: 550px;
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
                                

    .action-icons {
                display: flex;
                justify-content: center;
            }

            .action-icons button {
                background-color: transparent;
                border: none;
                cursor: pointer;
                margin: 0 5px;
            }
                                    
            .action-icons button:hover {
                color: #1b91ff;
            }
            .btn-container {
    display: inline-block;
    margin-left: 750px;
}

.btn-container .vc-1 {
    margin-left: 20px; /* Adjust as needed */
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
            <table class="table bg-white">
    <thead class="v-2 text-light">
        <tr>
            <th scope="col">Parts Name</th>
            <th scope="col">Stocks</th>
            <th scope="col">Price</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody class="v-2 text-light">
        <h1 class="text-light"><?php echo $unit_brand;?></h1>
        <?php
        // Fetch parts data based on unit ID (assuming from URL query params)
        if (isset($_GET['unit_id'])) {
            $unit_id = mysqli_real_escape_string($connection, $_GET['unit_id']);

            $query = "SELECT * FROM parts WHERE unit_id = '$unit_id'";
            $result = mysqli_query($connection, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['parts_name']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['stocks']) . '</td>';
                    echo '<td>₱' . htmlspecialchars($row['price']) . '</td>';
                    echo '<td>';
                    echo '<form action="process_parts_delete.php" method="POST">';
                    echo '<input type="hidden" name="part_id" value="' . htmlspecialchars($row['part_id']) . '">';
                    echo '<input type="hidden" name="unit_brand" value="' . htmlspecialchars($row['unit_brand']) . '">';
                    echo '<input type="hidden" name="unit_id" value="' . htmlspecialchars($row['unit_id']) . '">';
                    echo '<a href="ownerinventory_edit.php?part_id=' . htmlspecialchars($row['part_id']) . '&unit_id=' . htmlspecialchars($row['unit_id']) . '" class="btn btn-primary">Edit</a>';
                    echo '<button type="submit" class="btn btn-primary ms-3">Delete</button>';
                    echo '</form>';
                    echo '</td>';
                    echo '</tr>';
                }
                
            } else {
                echo '<tr><td colspan="4">No parts found for this unit.</td></tr>';
            }
        } else {
            echo '<tr><td colspan="4">Unit ID not provided.</td></tr>';
        }
        ?>
    </tbody>
</table>




            <div class="btn-container">
            <button class="btn btn-primary" onclick="showAddPartsForm()">Add</button>
        </div>
                                                
            <div id="addPartsForm" class="popup-form" style="display: none;">
                <h2 class="text-white">Add Parts</h2>
                <form id="partsForm" action="process_parts_add.php" method="post" class="form-container">
                    <div class="form-group mb-3 me-5">
                        <label for="parts_name" class="text-white">Parts Name:</label>
                        <input type="text"  id="parts_name" name="parts_name" required>
                    </div>

                    <div class="form-group mb-3 me-3">
                        <label for="stocks" class="text-white">Stocks:</label>
                        <input type="number"  id="stocks" name="stocks" required>
                    </div>

                    <div class="form-group mb-3 me-2">
                        <label for="price" class="text-white">Price:</label>
                        <input type="text"  id="price" name="price" required>
                    </div>

                    <input type="hidden" class="me-3" name="unit_id" id="unit_id" value="<?php echo $unit_id; ?>">
                    <input type="hidden" name="unit_brand" id="unit_brand" value="<?php echo $unit_brand; ?>">

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

            </div>

            
        </section>

                            


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
            <script>
                // Function to display the add parts form
                function showAddPartsForm() {
                    $('#addPartsForm').show();
                }

            // Function to add parts (submit form)
            function addParts() {
                var unitId = <?php echo isset($_GET['unit_id']) ? $_GET['unit_id'] : 'null'; ?>;
                var unitType = '<?php echo isset($_GET['unit_type']) ? $_GET['unit_type'] : ''; ?>';
                var unitBrand = '<?php echo isset($_GET['unit_brand']) ? $_GET['unit_brand'] : ''; ?>';

                var partsName = $('#partsName').val();
                var stocks = $('#stocks').val();
                var price = $('#price').val();

                // Submit form data using AJAX
                $.ajax({
                    type: 'POST',
                    url: 'process_parts_add.php',
                    data: {
                        unitId: unitId,
                        unitType: unitType,
                        unitBrand: unitBrand,
                        partsName: partsName,
                        stocks: stocks,
                        price: price
                    },
                    success: function(response) {
                        // Handle success (e.g., show success message)
                        alert('Parts added successfully!');
                        // Update the table with the added parts' details
                        updatePartsTable(partsName, stocks, price);
                    },
                    error: function(xhr, status, error) {
                        // Handle error (e.g., show error message)
                        alert('Error adding parts: ' + error);
                    }
                });
            }
        </script>
         <script>
                // Function to display the add parts form
                function showEditPartsForm() {
                    $('#editPartsForm').show();
                }

            // Function to add parts (submit form)
            function editParts() {
                var unitId = <?php echo isset($_GET['unit_id']) ? $_GET['unit_id'] : 'null'; ?>;
                var unitType = '<?php echo isset($_GET['unit_type']) ? $_GET['unit_type'] : ''; ?>';
                var unitBrand = '<?php echo isset($_GET['unit_brand']) ? $_GET['unit_brand'] : ''; ?>';

                var partsName = $('#partsName').val();
                var stocks = $('#stocks').val();
                var price = $('#price').val();

                // Submit form data using AJAX
                $.ajax({
                    type: 'POST',
                    url: 'process_parts_add.php',
                    data: {
                        unitId: unitId,
                        unitType: unitType,
                        unitBrand: unitBrand,
                        partsName: partsName,
                        stocks: stocks,
                        price: price
                    },
                    success: function(response) {
                        // Handle success (e.g., show success message)
                        alert('Parts added successfully!');
                        // Update the table with the added parts' details
                        updatePartsTable(partsName, stocks, price);
                    },
                    error: function(xhr, status, error) {
                        // Handle error (e.g., show error message)
                        alert('Error adding parts: ' + error);
                    }
                });
            }
        </script>

    </body>
</html>