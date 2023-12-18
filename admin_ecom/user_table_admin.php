<?php
include("../db.php");
include("../head.php");

// Fetch all users using a prepared statement
$userQuery = "SELECT * FROM `user`";
$stmt = $con->prepare($userQuery);
$stmt->execute();
$userResult = $stmt->get_result();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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

        .change-role-btn {
            padding: 5px 10px;
            background-color: #007bff;
            color: #ffffff;
            border: none;
            cursor: pointer;
        }

        .change-role-btn:hover {
            background-color: #0056b3;
        }
    </style>
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
                while ($user = $userResult->fetch_assoc()) {
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
                            <!-- Inside the form in superadmin.php -->
                            <form action="change_role.php" method="post">
                                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">

                                <?php if ($user['role_id'] == 1) : ?>
                                    <strong>Superadmin</strong>
                                <?php elseif ($user['role_id'] == 2) : ?>
                                    <strong>Admin</strong>
                                <?php elseif ($user['role_id'] == 3) : ?>
                                    <h4 value="2">Admin</h4>
                                    <button type="submit" class="btn btn-primary change-role-btn">Change Role</button>
                                <?php else : ?>
                                    <strong>Unknown Role</strong>
                                <?php endif; ?>
                            </form>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>

</body>

</html>
