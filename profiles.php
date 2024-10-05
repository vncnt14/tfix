<?php
include ('config.php');

$applianceType = $_GET['appliance'];


// Check the connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Prepare and execute the SQL query to get profiles based on the appliance type
$sql = "SELECT * FROM repair_shops WHERE expertise LIKE '%$applianceType%'";
$result = $connection->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <!-- Add your header styles and other meta tags here -->
</head>
<body>
    <!-- Add your header section here -->

    <div class="refrigerator-brands">
        <ul>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<li>';
                    echo '<div class="profile-box">';
                    echo '<div class="profile-image" style="background-image: url(\'https://cdn-icons-png.flaticon.com/512/4752/4752566.png\');"></div>';
                    echo '<div class="profile-details">';
                    echo '<span class="profile-name">' . $row["shop_name"] . '</span>';
                    echo '<div class="profile-info">';
                    echo '<a href="prof2.php" class="profile-location">Location: ' . $row["location"] . '</a>';
                    echo '<a href="prof2.php" class="profile-rating">Rating: ' . $row["rating"] . '</a>';
                    echo '</div>';
                    echo '<div class="profile-info">';
                    echo '<span class="profile-expertise">Expertise: ' . $row["expertise"] . '</span>';
                    echo '<span class="profile-availability">Availability: ' . $row["availability"] . '</span>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</li>';
                }
            } else {
                echo '<li>No repair shops found for ' . $applianceType . '.</li>';
            }

            // Close the database connection
            $conn->close();
            ?>
        </ul>
    </div>

    <!-- Add your footer section here -->
</body>
</html>
