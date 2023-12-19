<?php
include("../db.php");
include("../head.php");

session_start();

// Ensure that the user is logged in before accessing their information.
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Retrieve the user's role from the database.
    $getRoleQuery = "SELECT role_id FROM user WHERE id = ?";
    $stmt = mysqli_prepare($con, $getRoleQuery);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $current_user_role = $user['role_id'];
    } else {
        // User not found in the database. Handle accordingly.
        header("Location: login.php");
        exit;
    }
    mysqli_stmt_close($stmt);
} else {
    // Redirect to the login page 
    header("Location: login.php");
    exit;
}

// Fetch all users using a prepared statement.
$userQuery = "SELECT * FROM `user`";
$stmt = mysqli_prepare($con, $userQuery);
mysqli_stmt_execute($stmt);
$userResult = mysqli_stmt_get_result($stmt);
mysqli_stmt_close($stmt);

// Handle role change or user deletion submission.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $action = $_POST['action'];

    // Check if the user has the right to delete users.
    if ($action === 'delete_user' && $current_user_role !== 1) {
        // User not authorized to delete users.
        echo "You are not authorized to perform this action.";
        exit;
    }

    if ($action === 'change_role') {
        $new_role_id = $_POST['new_role_id'];

        // Update the user's role in the database.
        $updateQuery = "UPDATE `user` SET `role_id` = ? WHERE `id` = ?";
        $stmt = mysqli_prepare($con, $updateQuery);
        mysqli_stmt_bind_param($stmt, "ii", $new_role_id, $user_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    } elseif ($action === 'delete_user') {
        // Delete the user from the database.
        $deleteQuery = "DELETE FROM `user` WHERE `id` = ?";
        $stmt = mysqli_prepare($con, $deleteQuery);
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }

        table {
            margin-top: 20px;
        }

        th,
        td {
            text-align: center;
        }

        th {
            background-color: #343a40;
            color: #f8f9fa;
        }

        .change-role-btn,
        .delete-user-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 10px;
        }

        .change-role-btn:hover {
            background-color: #007bff;
            color: #ffffff;
        }

        .delete-user-btn:hover {
            background-color: #dc3545;
            color: #ffffff;
        }
    </style>
    <script>
        // JavaScript function to handle form submission asynchronously.
        function changeRole(user_id) {
            var new_role_id = $("#new_role_id_" + user_id).val();

            $.ajax({
                type: "POST",
                url: "user_table_admin.php",
                data: { user_id: user_id, new_role_id: new_role_id, action: 'change_role' },
                success: function (data) {
                    // Reload the page after a successful role change.
                    location.reload();
                },
                error: function (xhr, status, error) {
                    // Handle errors here.
                    console.error(xhr.responseText);
                }
            });
        }

        function deleteUser(user_id) {
            if (confirm("Are you sure you want to delete this user?")) {
                $.ajax({
                    type: "POST",
                    url: "user_table_admin.php",
                    data: { user_id: user_id, action: 'delete_user' },
                    success: function (data) {
                        // Reload the page after a successful user deletion.
                        location.reload();
                    },
                    error: function (xhr, status, error) {
                        // Handle errors here.
                        console.error(xhr.responseText);
                    }
                });
            }
        }
    </script>
</head>

<body>

    <div class="container">
        <h3>Users</h3>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($user = mysqli_fetch_assoc($userResult)) {
                ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo $user['user_name']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td>
                            <?php
                            switch ($user['role_id']) {
                                case 1:
                                    echo 'Superadmin';
                                    break;
                                case 2:
                                    echo 'Admin';
                                    break;
                                case 3:
                                    echo 'User';
                                    break;
                                default:
                                    echo 'Unknown Role';
                            }
                            ?>
                        </td>
                        <td>
                            <?php if ($user['role_id'] != 1) : ?>
                                <form class="change-role-form" onsubmit="changeRole(<?php echo $user['id']; ?>); return false;">
                                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                    <label for="new_role_id">New role:</label>
                                    <select name="new_role_id" id="new_role_id_<?php echo $user['id']; ?>">
                                        <option value="2">Admin</option>
                                        <option value="3">User</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary change-role-btn" name="change_role">Change Role</button>
                                </form>

                                <form class="delete-user-form" onsubmit="deleteUser(<?php echo $user['id']; ?>); return false;">
                                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                    <button type="submit" class="btn btn-danger delete-user-btn" name="delete_user">Delete User</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
        <a href="../admin_ecom/" class="btn btn-secondary">Return</a>
    </div>

</body>

</html>
