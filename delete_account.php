<?php
include("db.php"); // Include the database connection file
include("header.php");
include("head.php");
if (!session_id()) session_start();
// Check if the user is logged in 
// For simplicity, you may use a session variable to check if the user is logged in.

// Example:
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

$userId = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Perform deletion and update database
    $deleteAddressQuery = "DELETE FROM `address` WHERE `id` IN (SELECT `billing_address_id` FROM `user` WHERE `id` = $userId OR `shipping_address_id` = $userId)";
    $deleteUserQuery = "DELETE FROM `user` WHERE `id` = $userId";

    $con->query($deleteAddressQuery);
    $con->query($deleteUserQuery);

    // Redirect to a  deletion page
   echo '<script>window.location.href = "account_deleted.php";</script>';
    exit();
}
?>
<body>
   <div class="container mt-5">
        <h2 class="mb-4">Delete My Account</h2>
        <p>Are you sure you want to delete your account?</p>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <button type="submit" class="btn btn-danger">Delete Account</button>
        </form>
    </div>
</body>
</html>
