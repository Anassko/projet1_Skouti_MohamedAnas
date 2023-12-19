<?php


?>
<head>
 
 <style>
     body {
         font-family: 'Arial', sans-serif;
     }

     #sidebar {
         height: 100%;
         width: 250px;
         position: fixed;
         background-color: #343a40; /* Bootstrap dark background color */
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
         color: #f8f9fa; /* Bootstrap light text color */
     }

     #content {
         margin-left: 250px;
         padding: 16px;
     }
 </style>
</head>
<body>

<div id="sidebar">
 <a href="inserting_pro.php">Insert Products</a>
 <a href="delete_product.php">Delete Products</a>
 <a href="admin_order.php">Orders</a>
 <a href="user_table_admin.php">Users</a>
 <a href="../index.php" class="btn btn-secondary">Leave the Control Panel</a>
</div>

<div id="content">
 <h2>Main Content Area</h2>
 <p>Control Panel</p>
</div>

</body>
</html>
