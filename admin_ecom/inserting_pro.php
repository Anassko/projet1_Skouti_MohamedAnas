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
        $productImageUrl = $_POST['product_image_url'];
        $productDescription = $_POST['product_description'];
        $productImagePath = $_POST['product_image_path'];

        // Validate the data 
        if (empty($productName) || empty($productQuantity) || empty($productPrice)) {
            $errorMessage = "Please fill in all required fields.";
        } else {
            // Insert the new product into the database using a prepared statement
            $insertProductQuery = "INSERT INTO `product` (`name`, `quantity`, `price`, `img_url`, `description`, `img_path`) 
                                   VALUES (?, ?, ?, ?, ?, ?)";

            $stmt = $con->prepare($insertProductQuery);
            $stmt->bind_param("siisss", $productName, $productQuantity, $productPrice, $productImageUrl, $productDescription, $productImagePath);

            if ($stmt->execute()) {
                // Product inserted successfully, you can also add additional logic if needed
                $successMessage = "Product added successfully.";
            } else {
                $errorMessage = "Error adding the product: " . $stmt->error;
            }

            $stmt->close();
        }
    }
  // Process the image upload
    if (isset($_FILES['product_image'])) {
        $uploadDir = './images/';
        $uploadFile = $uploadDir . basename($_FILES['product_image']['name']);

        if (move_uploaded_file($_FILES['product_image']['tmp_name'], $uploadFile)) {
            // File uploaded successfully
            echo "Image uploaded successfully.";
        } else {
            // Handle the case when the file upload fails
            echo "Error uploading image.";
        }
    }
?>


<head>
    <!-- MATERIAL DESIGN ICONIC FONT -->
    <link rel="stylesheet" href="fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="../Rcss/style.css">
   
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
                  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
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
                         <label for="product_image_url" class="form-label">Image URL:</label>
                <input type="file" name="product_image_url" class="form-control" required>
                    </div>
                        <div class="form-wrapper">
                         <label for="product_description" class="form-label">Description:</label>
                <textarea name="product_description" class="form-control" rows="4" required></textarea>
                    </div>
                    <div class="form-wrapper">
                         <label for="product_image_path" class="form-label">Image Path:</label>
                <input type="text" name="product_image_path" class="form-control" required>
                    </div>
                    
                    <button>Add product</button>
                    <a href="../admin_ecom/" class="btn btn-secondary return-btn">Return</a>
                </form>
            </div>
        </div>
        </div>
        </form>
    </div>
</body>
</html>
