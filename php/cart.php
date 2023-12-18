<?php
include("db.php");
include("head.php");
include("header.php");
if (!session_id()) session_start();

// Function to update the cart button badge
function updateCartBadge() {
    $_SESSION['cart_count'] = count($_SESSION['cart']);
}

// Add Product to Cart
if (isset($_GET['add_to_cart']) && isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Check if the product is already in the cart
    if (!isset($_SESSION['cart'][$product_id])) {
        // If not, add it to the cart with a quantity of 1
        $_SESSION['cart'][$product_id] = 1;
    } else {
        // If yes, increment the quantity by 1
        $_SESSION['cart'][$product_id]++;
    }

    // Update the cart button badge
    updateCartBadge();
   echo '<script type="text/javascript">window.location.href="cart.php";</script>';

    exit();
}

// Remove Product from Cart
if (isset($_GET['remove_from_cart']) && isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Remove the product from the cart
    unset($_SESSION['cart'][$product_id]);

    // Update the cart button badge
    updateCartBadge();
    echo '<script type="text/javascript">window.location.href="cart.php";</script>';
    exit();
}

// Update Cart
if (isset($_POST['update_cart'])) {
    foreach ($_POST['quantity'] as $product_id => $new_quantity) {
        // Validate and update the quantity
        if ($new_quantity > 0) {
            $_SESSION['cart'][$product_id] = $new_quantity;
        } else {
            // If quantity is 0 or negative, remove the product from the cart
            unset($_SESSION['cart'][$product_id]);
        }
    }

    // Update the cart button badge
    updateCartBadge();
   echo '<script type="text/javascript">window.location.href="cart.php";</script>';
    exit();
}

// Clear Cart
if (isset($_GET['clear_cart'])) {
    // Clear the entire cart
    $_SESSION['cart'] = array();

    // Update the cart button badge
    updateCartBadge();
   echo '<script type="text/javascript">window.location.href="cart.php";</script>';
    exit();
}

// Checkout Process
if (isset($_GET['checkout'])) {
    // Insert order details into the user_order table
    $user_id = $_SESSION['user_id']; // Assuming you have the user's ID in the session
    $ref = 'ORDER-' . uniqid(); // Generate a unique reference for the order
    $date = date('Y-m-d');
    $total = $totalPrice;

    // Insert the order into the user_order table
    $insertOrderQuery = "INSERT INTO user_order (ref, date, total, user_id) VALUES ('$ref', '$date', $total, $user_id)";
    mysqli_query($con, $insertOrderQuery);

    // Get the ID of the newly inserted order
    $order_id = mysqli_insert_id($con);

    // Insert items into the order_has_product table
    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        $productQuery = "SELECT * FROM `product` WHERE `id` = $product_id";
        $result = $con->query($productQuery);

        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
            $price = $product['price'];
            $insertOrderItemQuery = "INSERT INTO order_has_product (order_id, product_id, quantity, price) VALUES ($order_id, $product_id, $quantity, $price)";
            mysqli_query($con, $insertOrderItemQuery);
        }
    }

    // Clear the cart after the order is placed
    $_SESSION['cart'] = array();
    updateCartBadge();

    // Redirect to the order confirmation page or display a success message
   echo '<script type="text/javascript">window.location.href="cart.php";</script>';
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            background-color: rgb(205, 204, 202);
        }

        .container {
            background-color: white;
            margin-top: 20px;
            padding: 20px;
            border-radius: 10px;
        }

        h1 {
            color: rgb(0, 44, 62);
        }

        table {
            width: 100%;
        }

        th {
            background-color: rgb(0, 44, 62);
            color: white;
        }

        .total-price {
            font-weight: bold;
        }

        .checkout-btn {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Display Cart Items -->
        <?php if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])): ?>
            <h1 class="mt-3">Shopping Cart</h1>
           
            <div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $totalPrice = 0;

                        foreach ($_SESSION['cart'] as $product_id => $quantity):
                            $productQuery = "SELECT * FROM `product` WHERE `id` = $product_id";
                            $result = $con->query($productQuery);

                            if ($result->num_rows > 0):
                                $product = $result->fetch_assoc();
                                $subtotal = $quantity * $product['price'];
                                $totalPrice += $subtotal;
                        ?>
                            <tr>
                                <td><?php echo $product['name']; ?></td>
                                <td>$<?php echo $product['price']; ?></td>
                                <td>
                                    <form method="post" action="cart.php">
                                        <input type="hidden" name="quantity[<?php echo $product_id; ?>]" value="<?php echo $quantity; ?>">
                                        <input type="number" name="quantity[<?php echo $product_id; ?>]" value="<?php echo $quantity; ?>" min="0">
                                </td>
                                <td>$<?php echo number_format($subtotal, 2); ?></td>
                                <td>
                                        <button type="submit" name="update_cart" class="btn btn-primary">Update</button>
                                    </form>
                                    <a href="cart.php?remove_from_cart=true&product_id=<?php echo $product_id; ?>" class="btn btn-danger">Remove</a>
                                </td>
                            </tr>
                        <?php endif; endforeach; ?>
                    </tbody>
                </table>

                <!-- Display Total Price -->
                <p class="total-price">Total Price: $<?php echo number_format($totalPrice, 2); ?></p>

                <!-- Checkout Button -->
                <form method="get" action="cart.php" class="checkout-btn">
                    <input type="hidden" name="checkout" value="true">
                    <button type="submit" class="btn btn-success">Proceed to Checkout</button>
                </form>
              
            </div>
               <a href="product.php" class="btn btn-secondary mb-3 mt-3">Back to Products</a>
        <?php else: ?>
            <p class="mt-3">Your cart is empty.</p>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS and any additional scripts if needed -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
