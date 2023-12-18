<?php
include("db.php");

if (!session_id()) session_start();

// Start the session for storing user information

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Retrieve user information using prepared statement
$userId = $_SESSION['user_id'];
$getUserQuery = $con->prepare("SELECT * FROM `user` WHERE `id` = ?");
$getUserQuery->bind_param("i", $userId);
$getUserQuery->execute();
$result = $getUserQuery->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    // Redirect to login page if user not found
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: rgb(214, 214, 214);
            color: black;
        }

        nav {
            width: 200px;
            height: 100vh;
            background-color: rgb(0, 44, 62);
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 20px;
        }

        nav a {
            display: block;
            padding: 10px;
            text-decoration: none;
            color: #fff;
            margin-bottom: 5px;
            border-bottom: 1px solid #ccc;
        }

        .content {
            margin-left: 220px;
            padding: 20px;
        }

        h2 {
            color: rgb(0, 44, 62);
        }

        p {
            margin: 10px 0;
        }
    </style>
</head>

<body>

    <nav>
        <a href="my_account.php">My Account</a>
        <a href="edit_account.php">Edit Account</a>
        <a href="delete_account.php">Delete Account</a>
        <a href="product.php">Continue Shopping</a>
        <a href="index.php">Home page</a>
        <a href="logout.php">Logout</a>
    </nav>

    <div class="content">
        <h2>Welcome, <?php echo htmlspecialchars($user['user_name']); ?>!</h2>
        <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
        <p>First Name: <?php echo htmlspecialchars($user['fname']); ?></p>
        <p>Last Name: <?php echo htmlspecialchars($user['lname']); ?></p>
    </div>

</body>

</html>
