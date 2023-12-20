<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }

        #sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            background-color: #343a40; /* dark background color */
            padding-top: 20px;
        }

        #sidebar a {
            padding: 10px;
            text-decoration: none;
            font-size: 18px;
            color: #818182;
            display: block;
            transition: 0.3s;
        }

        #sidebar a:hover {
            color: #f8f9fa; /* light text color */
        }

        #content {
            margin-left: 250px;
            padding: 16px;
        }

        #leaveControlPanel {
            position: fixed;
            top: 10px;
            right: 10px;
        }

        #leaveControlPanel a {
            padding: 10px;
            text-decoration: none;
            font-size: 18px;
            color: #fff; /* Text color */
            background-color: #8B0000; /* Background color */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        #leaveControlPanel a:hover {
            background-color: #6A0000; /* Hover background color */
        }
    </style>
</head>
<body>

<div id="sidebar">
    <a href="inserting_pro.php">Insert Products</a>
    <a href="user_table_admin.php">Users</a>
    <a href="delete_product.php">Delete Products</a>
    <a href="admin_order.php">Orders</a>
</div>

<div id="content">
    <h2>Main Content Area</h2>
    <p>Control Panel</p>
</div>

<!-- "Leave control panel" button -->
<div id="leaveControlPanel">
    <a href="../index.php" class="principalpage">Go to principal page</a>
    <a href="logout.php">Logout</a>
</div>

</body>
</html>
