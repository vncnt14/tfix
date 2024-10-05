<?php
session_start();
if (!isset($_SESSION['username']) || !$_SESSION['is_admin']) {
    header("Location: smtfix.php");
    exit;
}

require_once "config.php";

// Function to get all users or filtered users based on search query
function getUsers($search = '')
{
    global $connection;
    $query = "SELECT * FROM user";
    
    if (!empty($search)) {
        $search = mysqli_real_escape_string($connection, $search);
        $query .= " WHERE lastname LIKE '%$search%' OR firstname LIKE '%$search%' OR username LIKE '%$search%' OR email LIKE '%$search%' OR role LIKE '%$search%'";
    }
    
    $result = mysqli_query($connection, $query);
    $users = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }

    return $users;
}

// Handle delete user request
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["delete_user"])) {
    // Get the user ID from the form submission
    $userId = $_POST["id"];

    // Validate the user ID (e.g., check if it's an integer)

    // Perform the deletion
    $query = "DELETE FROM user WHERE id = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "i", $userId);

    if (mysqli_stmt_execute($stmt)) {
        echo"Deletion successful";
    } else {
        echo"Deletion failed";
    }

    // Close the statement
    mysqli_stmt_close($stmt);

    // Redirect back to the users.php page after deletion
    header("Location: user.php");
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Manage Users</title>
    <!-- Use online hosted versions of Bootstrap and CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"
    />
    <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>
     <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="smusers.php">Users Data</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#"></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="admin.php">Home</a>
                    </li>
                    <!-- Add more navigation links as needed -->
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <h2>Manage Users</h2>
        
        <!-- Search functionality -->
        <form method="get">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Search users" name="search">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </div>
        </form>
        
        <!-- Display user table -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>First Name </th>
                    <th>Last Name</th>
                    <th>Username</th>
                    <th>Password</th>
					<th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Handle search query
                $search = isset($_GET['search']) ? $_GET['search'] : '';
                $users = getUsers($search);

                foreach ($users as $user) {
                    echo "<tr>";
					echo "<td>{$user['firstname']}</td>";
                    echo "<td>{$user['lastname']}</td>";
                    echo "<td>{$user['username']}</td>";
                    echo "<td>{$user['password']}</td>";
                    echo "<td>{$user['email']}</td>";
                    echo "<td>{$user['role']}</td>";
                    echo "<td>
                            <button class='btn btn-sm btn-primary' data-bs-toggle='modal' data-bs-target='#editModal{$user['id']}'>Edit</button>
                            <form method='post' style='display: inline'>
                                <input type='hidden' name='id' value='{$user['id']}'>
                                <button type='submit' name='delete_user' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure you want to delete this user?\")'>Delete</button>
                            </form>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Add new user button -->
<button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addModal">Add User</button>


<!-- Modal for adding a user -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Add User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Add the form for adding a user here -->
                <form id="addUserForm">
                    
                    <div class="mb-3">
                        <label for="add_firstname" class="form-label">Firstname</label>
                        <input type="text" class="form-control" id="add_firstname" name="add_firstname" required>
                    </div>
                    <div class="mb-3">
                        <label for="add_lastname" class="form-label">Lastname</label>
                        <input type="text" class="form-control" id="add_lastname" name="add_lastname" required>
                    </div>
                    <div class="mb-3">
                        <label for="add_username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="add_username" name="add_username" required>
                    </div>
					 <div class="mb-3">
                        <label for="add_password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="add_password" name="add_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="add_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="add_email" name="add_email" required>
                    </div>
                    <div class="mb-3">
						<label for="add_role" class="form-label">Role</label>
						<select class="form-select" id="add_role" name="add_role" required>
							<option value="Administrator">Administrator</option>
							<option value="User">User</option>
						</select>
					</div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="addUser()">Add User</button>
            </div>
        </div>
    </div>
</div>

<script>
    function addUser() {
        // Get the form data
        const form = document.getElementById('addUserForm');
        const formData = new FormData(form);

        // Send an AJAX request to add the user
        fetch('add_user.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show a success message to the user
                alert('User added successfully!');
                // Reload the page to see the updated user table
                location.reload();
            } else {
                // Show an error message if something went wrong
                alert(data.message);
            }
        })
        .catch(error => {
            alert('An error occurred while adding the user.');
            console.error(error);
        });
    }
</script>

<!-- Modals for editing users -->
<?php
// Retrieve the users again for the edit modals
$users = getUsers($search);

foreach ($users as $user) {
    $userId = $user['id'];
?>
    <div class="modal fade" id="editModal<?php echo $userId; ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Add the form for editing the user here -->
                    <form id="editUserForm<?php echo $userId; ?>">
                        <input type="hidden" name="edit_id" value="<?php echo $userId; ?>">
                        
                        <div class="mb-3">
                            <label for="edit_firstname" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="edit_firstname" name="edit_firstname" value="<?php echo $user['firstname']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_lastname" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="edit_lastname" name="edit_lastname" value="<?php echo $user['lastname']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="edit_username" name="edit_username" value="<?php echo $user['username']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_password" class="form-label">Password</label>
                            <input type="text" class="form-control" id="edit_password" name="edit_password" value="<?php echo $user['username']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="edit_email" name="edit_email" value="<?php echo $user['email']; ?>" required>
                        </div>
                        <div class="mb-3">
							<label for="edit_role" class="form-label">Role</label>
							<select class="form-select" id="edit_role" name="edit_role" required>
								<option value="Administrator" <?php if ($user['role'] === 'Administrator') echo 'selected'; ?>>Administrator</option>
								<option value="User" <?php if ($user['role'] === 'User') echo 'selected'; ?>>User</option>
								<!-- Display the current value from the database as the default option -->
								<?php if ($user['role'] !== 'Administrator' && $user['role'] !== 'User') : ?>
									<option value="<?php echo htmlspecialchars($user['role']); ?>" selected><?php echo htmlspecialchars($user['role']); ?></option>
								<?php endif; ?>
							</select>
						</div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="updateUser(<?php echo $userId; ?>)">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
    
<?php
}
?>

<script>function updateUser(userId) {
        // Get the form data
        const form = document.getElementById(`editUserForm${userId}`);
        const formData = new FormData(form);

        // Send an AJAX request to update the user
        fetch('edit_user.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show a success message to the user
                alert('User updated successfully!');
                // Reload the page to see the updated user table
                location.reload();
            } else {
                // Show an error message if something went wrong
                alert(data.message);
            }
        })
        .catch(error => {
            alert('An error occurred while updating the user.');
            console.error(error);
        });
    }</script>
        
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>