<?php
session_start();

// Include database connection file
include('config.php');

if (!isset($_SESSION['user_id'])) { 
    header("Location: index.php");
    exit;
}


$user_id = $_SESSION['user_id'];
$unit_id = $_GET['unit_id'];

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

// Fetch owner information based on user ID
$query1 = "SELECT * FROM inventory WHERE unit_id = '$unit_id'";
$result1 = mysqli_query($connection, $query1);

if ($result1 && mysqli_num_rows($result1) > 0) {
    $productData = mysqli_fetch_assoc($result1);
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

/* INVENTORY*/
.form-group {
    margin-bottom: 15px;
}

.form-group label {
    color: #fff; /* Set label text color to white */
    margin-bottom: 5px; /* Add margin below labels for spacing */
}

.form-control,
select {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.btn-primary {
    background-color: #1b91ff;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.btn-primary:hover {
    background-color: #0a6cce;
}
.submit-btn {
        background-color: #1b91ff;
        color: #fff;
        padding: 13px; /* Increased padding for more space */
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin: 0 10px;
        margin-left: 830px;
      }

      .cancel-btn {
        background-color: #1b91ff;
        color: #fff;
        padding: 13px; /* Increased padding for more space */
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin: 0 10px;
        margin-top: 20px;
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
    <form action="exampleinventoryview1.php" method="POST">
        <input type="hidden" name="product_id" id="product_id" value="<?php echo $productData['product_id'];?>">
        <div class="form-group">
            <label for="unit_type">Unit Type:</label>
            <input type="text" id="unit_type" name="unit_type" class="form-control" readonly value="<?php echo $productData['unit_type'];?>">
                </div>
        <div class="form-group">
        <label for="unit_brand">Unit Brand:</label>
            <input type="text" id="unit_brand" name="unit_brand" class="form-control" readonly value="<?php echo $productData['unit_brand'];?>">
                </div>  
        <div class="form-group">
            <label for="product_name">Product Name:</label>
            <input type="text" id="product_name" name="product_name" class="form-control" readonly value="<?php echo $productData['product_name'];?>">
        </div>
        <div class="form-group">
            <label for="stocks">Stocks:</label>
            <input type="number" id="stocks" name="stocks" class="form-control" required value="<?php echo $productData['stocks'];?>">
        </div>
        <div class="form-group">
            <label for="price">Price(₱):</label>
            <input type="text" id="price" name="price" class="form-control" required value="<?php echo $productData['price'];?>">
        </div>
        <a href="exampleinventory.php"><button class="submit-btn" type="button">Back</button></a>
                <button class="cancel-btn" type="submit">Update</button>
    </form>
</div>

           
            
        </div>
       
        
    </section>

    <script>
      document.getElementById('unit_type').addEventListener('change', function() {
          var unitType = this.value;
          var unitBrandSelect = document.getElementById('unit_brand');
          unitBrandSelect.innerHTML = ''; // Clear previous options

          if (unitType === 'Refrigerator') {
              var refrigeratorBrands = ['Choose', 'Samsung', 'LG', 'Sony', 'Sharp', 'Haier', 'Electrolux', 'Whirlpool', 'Mabe', 'Dowell'];
              populateBrands(refrigeratorBrands);
          } else if (unitType === 'Electricfan') {
              var electricFanBrands = ['Choose', 'Hanabishi', 'Asahi', 'Panasonic', 'Union', 'Dowell', 'Imarflex', 'Fujidenzo', 'Kyowa', 'Sharp'];
              populateBrands(electricFanBrands);
          }
      });

      function populateBrands(brands) {
          var unitBrandSelect = document.getElementById('unit_brand');
          brands.forEach(function(brand) {
              var option = document.createElement('option');
              option.value = brand;
              option.textContent = brand;
              unitBrandSelect.appendChild(option);
          });
      }
    </script>
    


</body>
</html>
