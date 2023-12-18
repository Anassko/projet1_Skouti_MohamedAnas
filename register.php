<?php
include("db.php"); // Include the database connection file at the beginning
include("head.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect user registration data
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

    // Insert address into the address table
    $insertAddressQuery = "INSERT INTO `address` (`street_name`, `street_nb`, `city`, `province`, `zip_code`, `country`) VALUES ('$streetName', $streetNumber, '$city', '$province', '$zipCode', '$country')";
    
    if ($con->query($insertAddressQuery) === TRUE) {
        // Retrieve the generated address ID
        $addressId = $con->insert_id;

        // Insert user information into the user table
        $insertUserQuery = "INSERT INTO `user` (`user_name`, `email`, `pwd`, `fname`, `lname`, `billing_address_id`, `shipping_address_id`, `role_id`) VALUES ('$userName', '$email', '$password', '$firstName', '$lastName', $addressId, $addressId, 3)";
        
        if ($con->query($insertUserQuery) === TRUE) {
            // Redirect to login page or any other page after successful registration
            header("Location: login.php");
            exit();
        } else {
            echo "Error inserting user: " . $con->error;
        }
    } else {
        echo "Error inserting address: " . $con->error;
    }
}
?>


<!DOCTYPE html>
	<head>
		

		<!-- MATERIAL DESIGN ICONIC FONT -->
		<link rel="stylesheet" href="fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">
		
		<!-- STYLE CSS -->
		<link rel="stylesheet" href="Rcss/style.css">
	</head>
<html>
	<body>
        <?php
         include("header.php")
         ?>
			<div class="wrapper" style="background-image: url('Rimages/bg-registration-form-2.jpg'); ">
			<div class="inner">
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
					<h3>Register Now</h3>
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
						<input type="number" name="zipcode" class="form-control" required>
					</div>
					<button>Register Now</button>
				</form>
			</div>
		</div>
		
	</body>
</html>