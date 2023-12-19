<?php
include("../db.php");

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect login data
    $userName = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if either username or email is provided
    if (!empty($userName) || !empty($email)) {
        // Use username or email based on which one is provided
        $field = !empty($userName) ? 'user_name' : 'email';
        $value = !empty($userName) ? $userName : $email;

        // Retrieve user information from the database based on username or email using a prepared statement
        $getUserQuery = "SELECT * FROM `user` WHERE `$field` = ?";
        $stmt = $con->prepare($getUserQuery);
        $stmt->bind_param("s", $value);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Verify the password
            if (password_verify($password, $user['pwd'])) {
                // Password is correct, store user information in the session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['user_name'];
                $_SESSION['user_role'] = $user['role_id'];

                // Redirect based on user role
                if ($_SESSION['user_role'] == 1) {
                    // Superadmin
                    header("Location: index.php");
                    exit();
                } elseif ($_SESSION['user_role'] == 2) {
                    // Admin
                    header("Location: admin_ecom/index.php");
                    exit();
                } elseif ($_SESSION['user_role'] == 3) {
                    // Regular user
                    header("Location: index.php");
                    exit();
                } else {
                    $loginError = "Unidentified Role";
                }
            } else {
                $loginError = "Incorrect password";
            }
        } else {
            $loginError = "User not found";
        }
    } else {
        $loginError = "Please enter a username or email";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- MATERIAL DESIGN ICONIC FONT -->
    <link rel="stylesheet" href="fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">
    
    <!-- STYLE CSS -->
    <link rel="stylesheet" href="../Rcss/style.css">
</head>
<body>
    <div class="wrapper" style="background-image: url('Rimages/bg-registration-form-2.jpg'); ">
        <div class="inner">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <h3>Login Form</h3>
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
                <button>Login Now</button>
            </form>
        </div>
    </div>
    <?php if (isset($loginError)) : ?>
        <script>
            alert("<?php echo $loginError; ?>");
        </script>
    <?php endif; ?>
</body>
</html>
