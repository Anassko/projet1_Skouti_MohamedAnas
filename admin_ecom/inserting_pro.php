<?php
include("../db.php");
include("../head.php");
session_start();

// Check if the user is logged in and is a superadmin

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect product data
    $productName = $_POST['product_name'];
    $productQuantity = $_POST['product_quantity'];
    $productPrice = $_POST['product_price'];
    $productDescription = $_POST['product_description'];

    // Process the image upload
    if (isset($_FILES['product_image'])) {
        $uploadDir = './images/';

        // Ensure the directory exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $uploadFile = $uploadDir . basename($_FILES['product_image']['name']);

        if (move_uploaded_file($_FILES['product_image']['tmp_name'], $uploadFile)) {
            // File uploaded successfully
            $productImageUrl = $uploadFile; // Set the image URL
        } else {
            // Handle the case when the file upload fails
            $errorMessage = "Error uploading image.";
        }
    }

    // Concatenate the directory path with the image name for img_url
    $productImageUrl = './images/' . basename($_FILES['product_image']['name']);

    // Insert the new product into the database using a prepared statement
    $insertProductQuery = "INSERT INTO `product` (`name`, `quantity`, `price`, `img_url`, `description`, `img_path`) 
                           VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($con, $insertProductQuery);
    mysqli_stmt_bind_param($stmt, "siisss", $productName, $productQuantity, $productPrice, $productImageUrl, $productDescription, $uploadFile);

    if (mysqli_stmt_execute($stmt)) {
        // Product inserted successfully, you can also add additional logic if needed
        $successMessage = "Product added successfully.";
    } else {
        $errorMessage = "Error adding the product: " . mysqli_error($con);
    }

    mysqli_stmt_close($stmt);
}
?>

<head>
    <link rel="stylesheet" href="fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="../Rcss/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <?php if (isset($errorMessage)) : ?>
            <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
        <?php endif; ?>

        <?php if (isset($successMessage)) : ?>
            <div class="alert alert-success"><?php echo $successMessage; ?></div>
        <?php endif; ?>

        <div class="wrapper" style="background-image: url('Rimages/bg-registration-form-2.jpg'); ">
            <div class="inner">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                    <h3> Add a product</h3>

                    <div class="form-wrapper">
                        <label for="product_name" class="form-label">Product Name:</label>
                        <input type="text" name="product_name" class="form-control" required>
                    </div>
                    <div class="form-wrapper">
                        <label for="product_quantity" class="form-label">Quantity:</label>
                        <input type="number" name="product_quantity" class="form-control" required>
                    </div>
                    <div class="form-wrapper">
                        <label for="product_price" class="form-label">Price:</label>
                        <input type="text" name="product_price" class="form-control" required>
                    </div>
                    <div class="form-wrapper">
                        <label for="product_image" class="form-label">Image:</label>
                        <input type="file" name="product_image" class="form-control" required>
                    </div>
                    <div class="form-wrapper">
                        <label for="product_description" class="form-label">Description:</label>
                        <textarea name="product_description" class="form-control" rows="4" required></textarea>
                    </div>

                    <button type="submit">Add product</button>
                    <a href="../admin_ecom/" class="btn btn-secondary return-btn">Return</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
