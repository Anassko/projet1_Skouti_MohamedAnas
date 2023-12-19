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
