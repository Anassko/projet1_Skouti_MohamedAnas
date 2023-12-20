<?php
include("db.php");
include("head.php");
include("header.php");

// Start the session for storing user information
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo '<meta http-equiv="refresh" content="0;url=login.php">';
    exit();
}

// Fetch the current user details from the database
$userID = $_SESSION['user_id'];
$query = "SELECT * FROM user u
          JOIN address a ON u.billing_address_id = a.id
          WHERE u.id = ?";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "i", $userID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    $userData = mysqli_fetch_assoc($result);
} else {
    // Handle the case where user data is not found
    echo "User not found";
    exit();
}

// Update user details when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newFirstName = $_POST['firstname'];
    $newLastName = $_POST['lastname'];
    $newEmail = $_POST['email'];
    $newPassword = $_POST['password'];  

    // Hash the new password
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Update user details
    $updateUserQuery = "UPDATE user
                        SET fname = ?, lname = ?, email = ?, pwd = ?
                        WHERE id = ?";
    $stmt = mysqli_prepare($con, $updateUserQuery);
    mysqli_stmt_bind_param($stmt, "ssssi", $newFirstName, $newLastName, $newEmail, $hashedPassword, $userID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Update address details
    $newStreetName = $_POST['streetname'];
    $newStreetNumber = $_POST['streetnumber'];
    $newCity = $_POST['city'];
    $newProvince = $_POST['province'];
    $newZipCode = $_POST['zipcode'];
    $newCountry = $_POST['country'];

    $updateAddressQuery = "UPDATE address
                           SET street_name = ?, street_nb = ?,
                               city = ?, province = ?,
                               zip_code = ?, country = ?
                           WHERE id = ?";
    $stmt = mysqli_prepare($con, $updateAddressQuery);
    mysqli_stmt_bind_param($stmt, "sissssi", $newStreetName, $newStreetNumber, $newCity, $newProvince, $newZipCode, $newCountry, $userData['billing_address_id']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Redirect to my_account.php after updating
    echo '<script>window.location.href = "my_account.php";</script>';
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- MATERIAL DESIGN ICONIC FONT -->
    <link rel="stylesheet" href="fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">

    <!-- STYLE CSS -->
    <link rel="stylesheet" href="Rcss/style.css">
    <style>
        body {
            font-family: "Muli-Regular";
            color: #666;
            font-size: 13px;
            margin: 0;
        }

        .form-group {
            display: flex;
            flex-wrap: wrap;
        }

        .form-wrapper {
            margin-bottom: 20px;
            flex: 0 0 calc(50% - 10px);
            max-width: calc(50% - 10px);
        }

        .form-wrapper label {
            margin-bottom: 8px;
            display: block;
        }

        .form-control {
            height: 40px;
            width: 100%;
        }

        button {
            width: 100%;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="wrapper" style="background-image: url('Rimages/bg-registration-form-2.jpg'); ">
    <div class="inner">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <h3>Edit your details</h3>
            <div class="form-group">
                <div class="form-wrapper">
                    <label for="firstname">First Name</label>
                    <input type="text" name="firstname" value="<?php echo htmlspecialchars($userData['fname']); ?>" class="form-control" required>
                </div>
                <div class="form-wrapper">
                    <label for="lastname">Last Name</label>
                    <input type="text" name="lastname" value="<?php echo htmlspecialchars($userData['lname']); ?>" class="form-control" required>
                </div>
                <div class="form-wrapper">
                    <label for="email">Email</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($userData['email']); ?>" class="form-control" required>
                </div>
                <div class="form-wrapper">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="form-wrapper">
                    <label for="streetname">Street Name</label>
                    <input type="text" name="streetname" class="form-control" required>
                </div>
                <div class="form-wrapper">
                    <label for="streetnumber">Street Number</label>
                    <input type="number" name="streetnumber" class="form-control" required>
                </div>
                <div class="form-wrapper">
                    <label for="country">Country</label>
                    <input type="text" name="country" class="form-control" required>
                </div>
                <div class="form-wrapper">
                    <label for="city">City</label>
                    <input type="text" name="city" class="form-control" required>
                </div>
                <div class="form-wrapper">
                    <label for="province">Province</label>
                    <input type="text" name="province" class="form-control" required>
                </div>
                <div class="form-wrapper">
                    <label for="zipcode">Zip Code</label>
                    <input type="text" name="zipcode" class="form-control" required>
                </div>
            </div>
            <button type="submit">Update Now</button>
        </form>
    </div>
</div>

</body>
</html>
