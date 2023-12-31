<?php
include("db.php");
include("header.php");
include("head.php");

if (!session_id()) session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Perform deletion and update database
    $deleteAddressQuery = "DELETE FROM `address` WHERE `id` IN (SELECT `billing_address_id` FROM `user` WHERE `id` = ? OR `shipping_address_id` = ?)";
    $deleteUserQuery = "DELETE FROM `user` WHERE `id` = ?";

    // Use prepared statements to prevent SQL injection
    $stmt = mysqli_prepare($con, $deleteAddressQuery);
    mysqli_stmt_bind_param($stmt, "ii", $userId, $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $stmt = mysqli_prepare($con, $deleteUserQuery);
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Redirect to a deletion page
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
