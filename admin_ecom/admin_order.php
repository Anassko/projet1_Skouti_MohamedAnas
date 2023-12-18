<?php
include("../db.php");
include("../head.php");

// preparation requete
$orderQuery = "SELECT id, ref, date, total FROM `user_order`";
$orderResult = $con->prepare($orderQuery);
$orderResult->execute();
$orderResult->store_result();

// Bind the results to variables
$orderResult->bind_result($id, $ref, $date, $total);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: rgb(205, 204, 202);
        }

        table {
            margin-top: 20px;
        }

        th,
        td {
            text-align: center;
        }

        th {
            background-color: rgb(0, 44, 62);
            color: #f8f9fa;
        }

        .confirm-btn {
            padding: 5px 10px;
            background-color: #28a745;
            color: #ffffff;
            border: none;
            cursor: pointer;
        }

        .confirm-btn:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>

    <div class="container">
        <h3>Orders</h3>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Order ID</th>
                    <th>Reference</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($orderResult->fetch()) {
                ?>
                    <tr>
                        <td><?php echo $id; ?></td>
                        <td><?php echo $ref; ?></td>
                        <td><?php echo $date; ?></td>
                        <td><?php echo $total; ?></td>
                        <td>
                            <form action="confirm_order.php?order_id=<?php echo $id; ?>" method="post">
                                <input type="hidden" name="order_id" value="<?php echo $id; ?>">
                                <button type="submit" class="btn btn-success confirm-btn">Confirm Order</button>
                            </form>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>

</body>

</html>
