<?php
include("../db.php");

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Get the order ID to confirm
    $orderId = $_POST["order_id"];

    // Prepare the query to update the order
    $updateQuery = "UPDATE user_order SET date = date, total = total, user_id = user_id WHERE id = ?";
    $updateStatement = $con->prepare($updateQuery);

    // Check if preparing the query failed
    if (!$updateStatement) {
        die("Error preparing the query: " . $con->error);
    }

    // Bind the parameters
    $updateStatement->bind_param("i", $orderId);

    // Execute the update query
    if ($updateStatement->execute()) {
        echo "Order updated successfully!";
    } else {
        echo "Error updating the order: " . $updateStatement->error;
    }

    // Close the statement and connection
    $updateStatement->close();
    $con->close();
} else {
    // Redirect to an error page if the form is not submitted
    header("Location: error.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Order</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>

    <a href="admin_order.php" class="btn btn-secondary mt-3">Return to Orders</a>

</body>
<style>
 body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .container {
            text-align: center;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 350px;
        }

        h3 {
            color: #007bff;
            margin-bottom: 20px;
        }

        .success-message {
            color: #28a745;
            margin-top: 15px;
        }

        .error-message {
            color: #dc3545;
            margin-top: 15px;
        }

        .return-btn {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
        }

        .return-btn:hover {
            background-color: #0069d9;
            color: #fff;
        }
    </style>
</html>