<?php
include("../db.php");
include("../head.php");
session_start();

// Check if the user is logged in and is a superadmin 
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_product_id'])) {
    $product_id = $_POST['delete_product_id'];

    // Prepare the delete query
    $deleteProductQuery = "DELETE FROM `product` WHERE `id` = ?";
    $stmt = mysqli_prepare($con, $deleteProductQuery);
    mysqli_stmt_bind_param($stmt, "i", $product_id);

    // Execute the delete query
    if (mysqli_stmt_execute($stmt)) {
        $successMessage = "Product deleted successfully.";
    } else {
        $errorMessage = "Error deleting the product: " . mysqli_error($con);
    }

    mysqli_stmt_close($stmt);
}

// Fetch the list of products
$productQuery = "SELECT * FROM `product`";
$productResult = mysqli_query($con, $productQuery);
?>

<!DOCTYPE html>
<html lang="en">

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

        <h3>Product List</h3>

        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($product = mysqli_fetch_assoc($productResult)) : ?>
                    <tr>
                        <td><?php echo $product['id']; ?></td>
                        <td><?php echo $product['name']; ?></td>
                        <td><?php echo $product['quantity']; ?></td>
                        <td><?php echo $product['price']; ?></td>
                        <td>
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <input type="hidden" name="delete_product_id" value="<?php echo $product['id']; ?>">
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="../admin_ecom/" class="btn btn-secondary return-btn">Return</a>
    </div>
</body>

</html>
