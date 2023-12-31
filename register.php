<?php
include("db.php");
include("head.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userName = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $firstName = $_POST['firstname'];
    $lastName = $_POST['lastname'];
    $streetName = $_POST['streetname'];
    $streetNumber = $_POST['streetnumber'];
    $city = $_POST['city'];
    $province = $_POST['province'];
    $zipCode = $_POST['zipcode'];
    $country = $_POST['country'];

    // Check if the username already exists
    $checkUsernameQuery = mysqli_prepare($con, "SELECT * FROM `user` WHERE `user_name` = ?");
    mysqli_stmt_bind_param($checkUsernameQuery, "s", $userName);
    mysqli_stmt_execute($checkUsernameQuery);
    $result = mysqli_stmt_get_result($checkUsernameQuery);

    if (mysqli_num_rows($result) > 0) {
        $registrationError = "Username already exists. Please choose a different username.";
    } else {
        // Insert address into the address table using prepared statement
        $insertAddressQuery = mysqli_prepare($con, "INSERT INTO `address` (`street_name`, `street_nb`, `city`, `province`, `zip_code`, `country`) VALUES (?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($insertAddressQuery, "sissis", $streetName, $streetNumber, $city, $province, $zipCode, $country);

        if (mysqli_stmt_execute($insertAddressQuery)) {
            // Retrieve the generated address ID
            $addressId = mysqli_insert_id($con);

            // Insert user information into the user table using prepared statement
            $insertUserQuery = mysqli_prepare($con, "INSERT INTO `user` (`user_name`, `email`, `pwd`, `fname`, `lname`, `billing_address_id`, `shipping_address_id`, `role_id`) VALUES (?, ?, ?, ?, ?, ?, ?, 3)");
            mysqli_stmt_bind_param($insertUserQuery, "sssssii", $userName, $email, $password, $firstName, $lastName, $addressId, $addressId);

            if (mysqli_stmt_execute($insertUserQuery)) {
                // Redirect to login page or any other page after successful registration
                header("Location: login.php");
                exit();
            } else {
                $registrationError = "Error inserting user: " . mysqli_error($con);
            }
        } else {
            $registrationError = "Error inserting address: " . mysqli_error($con);
        }

        // Close prepared statements
        mysqli_stmt_close($insertAddressQuery);
        mysqli_stmt_close($insertUserQuery);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="Rcss/style.css">
</head>

<body>
    <?php include("header.php"); ?>
    <div class="wrapper" style="background-image: url('Rimages/bg-registration-form-2.jpg'); ">
        <div class="inner">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <h3>Register Now</h3>
                <?php if (isset($registrationError)) : ?>
                    <div class="error-message"><?php echo $registrationError; ?></div>
                <?php endif; ?>
                <div class="form-group">
                    <div class="form-wrapper">
                        <label for="firstname">First Name</label>
                        <input type="text" name="firstname" class="form-control" required>
                    </div>
                    <div class="form-wrapper">
                        <label for="lastname">Last Name</label>
                        <input type="text" name="lastname" class="form-control" required>
                    </div>
                </div>
                <div class="form-wrapper">
                    <label for="username">Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="form-wrapper">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" required>
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
                <button>Register Now</button>
            </form>
        </div>
    </div>
</body>
</html>
