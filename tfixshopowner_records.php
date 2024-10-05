<?php
session_start();

// Include database connection file
include('config.php');  // You'll need to replace this with your actual database connection code

// Redirect to the login page if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location index.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch owner information based on user ID
$query = "SELECT * FROM owner WHERE user_id = '$user_id'";
$result = mysqli_query($connection, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $ownerData = mysqli_fetch_assoc($result);
}

// Initialize search parameters
$whereClause = '';

// Check if the search form is submitted
if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
    // Get the start date and end date from the form
    $start_date = $_GET['start_date'];
    $end_date = $_GET['end_date'];

    // Add the date range filter to the WHERE clause
    $whereClause .= " WHERE rf.date_requested BETWEEN '$start_date' AND '$end_date'";
} elseif (isset($_GET['start_date'])) {
    // Get only the start date from the form if end date is not provided
    $start_date = $_GET['start_date'];

    // Add the start date filter to the WHERE clause
    $whereClause .= " WHERE rf.date_requested >= '$start_date'";
} elseif (isset($_GET['end_date'])) {
    // Get only the end date from the form if start date is not provided
    $end_date = $_GET['end_date'];

    // Add the end date filter to the WHERE clause
    $whereClause .= " WHERE rf.date_requested <= '$end_date'";
}


// Fetch data from assignref table joined with user table and reqform table
$query = "SELECT u.*, rf.*, rc.*, qr.*, rc.parts, rc.labor, rf.date_requested
          FROM user u
          JOIN reqform rf ON u.user_id = rf.user_id
          JOIN receipt rc ON u.user_id = rc.user_id
          JOIN qr_code qr ON u.user_id = qr.user_id
          $whereClause"; // Append the WHERE clause if applicable

$result = mysqli_query($connection, $query);

// Close the database connection
mysqli_close($connection);

// Output the fetched data
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/vfs_fonts.js"></script>
    <title>TFIX</title>
</head>
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

    .container {

        margin-left: 1%;
    }

    .v-1 {

        background-color: #8FA2B4;
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

    .btn-cancel {

        margin-left: 90%;
        margin-top: 20%;
    }

    .btn-back {

        margin-left: 80%;
        margin-top: -6%;
    }


    /*main content*/

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
    @media print {
            .no-print {
                display: none;
            }
        }
</style>

<body>

    <header>

    </header>

    <nav class="no-print">
        <div class="profile-section">
            <img src="<?php echo $ownerData['photo']; ?>" alt="Profile Image" class="profile-image">
            <div class="profile-name"><?php echo isset($ownerData['shop_name']) ? $ownerData['shop_name'] : ''; ?></div>
        </div>
        <div class="section-line"></div><!-- Added section line -->

        <!-- Navigation links -->
        <a href="tfixshopowner_profile.php">Profile</a>
        <a href="tfixshopowner_reqservice.php">Request Service</a>
        <div class="dropdown">
            <button class="dropbtn">Request Application</button>
            <div class="dropdown-content">
                <a href="tfixshopowner_reqservice1.php">Repairman</a>
                <a href="tfixshopowner_reqservice2.php">Personnel</a>
            </div>
        </div>
        <a href="tfixshopowner_notif.php">Notification</a>
        <a href="message.php">Message</a>
        <a href="tfixshopowner_progress.php">Progress</a>
        <a href="tfixshopowner_inventory.php">Inventory</a>
        <a href="tfixshopowner_records.php">Sales Record</a>
        <a href="logout.php">Logout</a>
    </nav>
    <section class="v-3">
        <div class="col-md-12 mb-4 text-dark text-center"> <!-- Adjusted the column size for better visibility -->
            <h1 class="text-white">Sales Report</h1>
            <form action="" method="GET">
    <div class="input-group mb-3 no-print">
        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date">
        
        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date">
        
        <button id="searchButton" class="btn btn-primary no-print" type="submit">Search</button>
    </div>
</form>


            <table id="salesTable" class="table container-fluid bg-white">
                <thead class="v-2 text-light">
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Name</th>
                        <th scope="col">Type of Service</th>
                        <th scope="col">Labor Price</th>
                        <th scope="col">Parts Price</th>
                        <th scope="col">Total</th>
                        <th scope="col">Transaction Status</th>
                    </tr>
                </thead>
                <tbody class="v-2 text-light">
                    <?php
                    if ($result) {
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
                            echo '<td>' . (isset($progressData['date_requested']) ? $progressData['date_requested'] : 'N/A') . '</td>';
                            echo '<td>' . (isset($progressData['firstname']) ? $progressData['firstname'] : 'N/A') . ' ' . (isset($progressData['lastname']) ? $progressData['lastname'] : 'N/A') . '</td>';
                            echo '<td>' . (isset($progressData['service']) ? $progressData['service'] : 'N/A') . '</td>';
                            echo '<td>₱' . $labor . '.00</td>';
                            echo '<td>₱' . $parts . '.00</td>';
                            echo '<td>₱' . $total . '.00</td>'; // Display total
                            echo '<td>' . (isset($progressData['status']) ? $progressData['status'] : 'Completed') . '</td>';
                            echo '</tr>';
                        }
                        // Display total amount row
                        echo '<tr>';
                        echo '<td colspan="5"></td>'; // Empty cells for alignment
                        echo '<td style="font-weight: bold;">TOTAL AMOUNT:</td>'; // Total amount label aligned to the right
                        echo '<td style=" font-weight: bold;">₱' . $totalAmount . '.00</td>'; // Total amount aligned to the right
                        echo '</tr>';
                    } else {
                        echo '<tr><td colspan="6">Error: No records found.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
            <button class="btn btn-primary no-print" onclick="generatePDF(<?php echo $totalAmount; ?>)">Download Sales</button>
            <button id="printButton" class="btn btn-primary no-print">Print Sales</button>

        </div>
    </section>

    <script>
function generatePDF(totalAmount) {
    var tableRows = document.querySelectorAll('#salesTable tbody tr');
    var rowsData = [];

    var tableHeaders = [];
    var thElements = document.querySelectorAll('#salesTable thead th');
    thElements.forEach(function(th) {
        tableHeaders.push(th.textContent.trim());
    });
    rowsData.push(tableHeaders);
    
    // Loop through table rows
    tableRows.forEach(function(row) {
        var rowData = [];
        var cells = row.querySelectorAll('td');
        cells.forEach(function(cell) {
            // Extract text content of cells
            rowData.push(cell.textContent.trim());
        });
        // Exclude the total amount row
        if (rowData.length > 0 && !rowData.includes('TOTAL AMOUNT:')) {
            rowsData.push(rowData);
        }
    });
    
    // Add total amount row
    var totalAmountRow = ["", "", "", "", "", "TOTAL AMOUNT:", "₱" + totalAmount + ".00"];
    rowsData.push(totalAmountRow);
    
    // Define PDF document definition
    var docDefinition = {
        content: [
            { text: 'Sales Report', style: 'header' },
            {
                table: {
                    body: rowsData
                }
            }
        ],
        styles: {
            header: {
                fontSize: 18,
                bold: true,
                margin: [0, 0, 0, 10]
            }
        }
    };

    // Generate PDF
    pdfMake.createPdf(docDefinition).download("sales.pdf");
}
</script>

<script>
        document.getElementById('printButton').addEventListener('click', function() {
            window.print();
        });
    </script>






    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.2/dist/chart.min.js"></script>
    <script src="./js/jquery-3.5.1.js"></script>
    <script src="./js/jquery.dataTables.min.js"></script>
    <script src="./js/dataTables.bootstrap5.min.js"></script>
    <script src="./js/script.js"></script>

</body>

</html>