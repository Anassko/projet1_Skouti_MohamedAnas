<?php
include("db.php");
include("head.php");
include("header.php");
 // Include the database connection file at the beginning
 // Start the session for storing user information

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
   echo '<meta http-equiv="refresh" content="0;url=login.php">';
    exit();
}

// Fetch the current user details from the database
$userID = $_SESSION['user_id'];
$query = "SELECT * FROM user u
          JOIN address a ON u.billing_address_id = a.id
          WHERE u.id = $userID";
$result = $con->query($query);

if ($result->num_rows > 0) {
    $userData = $result->fetch_assoc();
} else {
    // Handle the case where user data is not found
    echo "User not found";
    exit();
}

// Update user details when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newFirstName = $_POST['firstname'];
    $newLastName = $_POST['lastname'];
    $newStreetName = $_POST['streetname'];
    $newStreetNumber = $_POST['streetnumber'];
    $newCity = $_POST['city'];
    $newProvince = $_POST['province'];
    $newZipCode = $_POST['zipcode'];
    $newCountry = $_POST['country'];

    // Update user details
    $updateUserQuery = "UPDATE user
                        SET fname = '$newFirstName', lname = '$newLastName'
                        WHERE id = $userID";
    $con->query($updateUserQuery);

    // Update address details
    $updateAddressQuery = "UPDATE address
                           SET street_name = '$newStreetName', street_nb = $newStreetNumber,
                               city = '$newCity', province = '$newProvince',
                               zip_code = '$newZipCode', country = '$newCountry'
                           WHERE id = {$userData['billing_address_id']}";
    $con->query($updateAddressQuery);

    // Redirect to my_account.php after updating
   echo '<script>window.location.href = "my_account.php";</script>';
exit();
   
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
      
			<div class="wrapper" style="background-image: url('Rimages/bg-registration-form-2.jpg'); ">
			<div class="inner">
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
					<h3>Edit your details</h3>
					<div class="form-group">
						<div class="form-wrapper">
							<label for="firstname">First Name</label>
							<input type="text" name="firstname" 
                            value="<?php echo $userData['fname']; ?>"  class="form-control" required>
						</div>
						<div class="form-wrapper">
							<label for="lastname">Last Name</label>
						<input type="text" name="lastname"
                        value="<?php echo $userData['lname']; ?>"  class="form-control" required>
						</div>
					</div>
					<div class="form-wrapper">
						<label for="streetname">Street Name</label>
						<input type="text" name="streetname" accept="value="<?php echo $userData['street_name']; ?> class="form-control" required>
					</div>
						<div class="form-wrapper">
						<label for="streetnumber">Street Number</label>
						<input type="number" name="streetnumber" 
                        value="<?php echo $userData['street_nb']; ?>" class="form-control" required>
					</div>
                  
						<div class="form-wrapper">
						<label for="country">Country</label>
						<input type="text" name="country" 
                        value="<?php echo $userData['fname']; ?>" class="form-control" required>
					</div>
						<div class="form-wrapper">
						<label for="city">City</label>
						<input type="text" name="city" 
                        value="<?php echo $userData['city']; ?>" class="form-control" required>
					</div>
						<div class="form-wrapper">
						<label for="province">Province</label>
						<input type="text" name="province" 
                        value="<?php echo $userData['province']; ?>" class="form-control" required>
					</div>
				
						<div class="form-wrapper">
						<label for="zipcode">Zip Code</label>
						<input type="number" name="zipcode" 
                        value="<?php echo $userData['zip_code']; ?>" class="form-control" required>
					</div>
                  
					<button>Update Now</button>
                    
				</form>
			</div>
		</div>
		
	</body>
</html>