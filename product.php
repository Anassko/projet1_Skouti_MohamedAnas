<?php
include("db.php");
include("head.php");
include("header.php");

// Fetch products from the database using prepared statement
$productQuery = "SELECT id, name, price, img_url FROM `product`";
$stmt = $con->prepare($productQuery);
$stmt->execute();

// Bind the result variables
$stmt->bind_result($id, $name, $price, $img_url);

// Fetch results into an associative array
$products = [];
while ($stmt->fetch()) {
    $products[] = [
        'id' => $id,
        'name' => $name,
        'price' => $price,
        'img_url' => $img_url,
    ];
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="css/Fontawesome.css">
   <style>
       @import url("https://fonts.googleapis.com/css?family=Poppins:400,500,600,700|Didact+Gothic&display=swap");

       * {
           margin: 0;
           padding: 0;
           box-sizing: border-box;
       }

       body {
           font-size: 16px;
           color: #292929;
           line-height: 1.7em;
           font-weight: 400;
           background: #F0F0F0;
           font-family: "Didact Gothic", sans-serif;
       }

       .section-bg {
           padding: 60px 0;
           background: #F0F0F0;
           display: flex;
           justify-content: space-around;
           flex-wrap: wrap;
           align-items: center;
       }

       .section-title {
           margin-bottom: 25px;
       }

       .section-title h2 {
           position: relative;
           font-size: 32px;
           line-height: 1.4;
           font-weight: 700;
           letter-spacing: 1px;
           z-index: 1;
           text-transform: capitalize;
           display: inline-block;
           font-family: "Didact Gothic", sans-serif;
       }

       .single-product {
           box-shadow: inset -2px -2px 8px white,
           inset -2px -2px 12px rgba(255, 255, 255, 0.5),
           inset 2px 2px 4px rgba(255, 255, 255, 0.1),
           inset 2px 2px 8px rgba(0, 0, 0, 0.15);
           padding: 30px;
           border-radius: 12px;
           margin-bottom: 50px;
       }

       .single-product .product-thumb {
           margin-bottom: 20px;
       }

       .single-product .product-title {
           margin-bottom: 20px;
           text-align: center;
           align-items: center;
       }

       .single-product .product-title h3 {
           font-family: "Didact Gothic", sans-serif;
           font-size: 20px;
           font-weight: 300;
       }

       .single-product .product-title h3 a {
           color: #292929;
           text-decoration: none;
       }

       .single-product .product-title h3 a:hover {
           color: #7289ab;
       }

       .single-product:hover {
           box-shadow: -2px -2px 8px white,
           -2px -2px 12px rgba(255, 255, 255, 0.5),
           inset 2px 2px 4px rgba(255, 255, 255, 0.1),
           2px 2px 8px rgba(0, 0, 0, 0.15);
       }

       img {
           display: inline-block;
           max-width: 100%;
       }

       .product-btns {
           display: flex;
           justify-content: center;
       }

       a {
           text-decoration: none;
           cursor: pointer;
           transition: .3s;
           color: #292929;
       }

       .btn-small {
           display: inline-block;
           font-size: 14px;
           font-weight: 700;
           text-transform: uppercase;
           padding: 8px 32px;
           border-radius: 50px;
           text-decoration: none;
           box-shadow: inset -2px -2px 8px white,
           inset -2px -2px 12px rgba(255, 255, 255, 0.5),
           inset 2px 2px 4px rgba(255, 255, 255, 0.1),
           inset 2px 2px 8px rgba(0, 0, 0, 0.15);
           transition: 0.4s;
       }

       .btn-round {
           display: inline-block;
           font-size: 14px;
           font-weight: 700;
           text-transform: uppercase;
           height: 45px;
           width: 45px;
           text-align: center;
           line-height: 45px;
           border-radius: 50%;
           text-decoration: none;
           box-shadow: -2px -2px 8px white,
           -2px -2px 12px rgba(255, 255, 255, 0.5),
           inset 2px 2px 4px rgba(255, 255, 255, 0.1),
           2px 2px 8px rgba(0, 0, 0, 0.15);
       }

       .btn-small:hover {
           box-shadow: -2px -2px 8px white,
           -2px -2px 12px rgba(255, 255, 255, 0.5),
           inset 2px 2px 4px rgba(255, 255, 255, 0.1),
           2px 2px 8px rgba(0, 0, 0, 0.15);
           color: #7289ab;
           text-decoration: none;
       }

       .btn-small:hover span {
           display: inline-block;
           transform: scale(0.98);
       }

       .btn-round:hover {
           box-shadow: inset -2px -2px 8px white,
           inset -2px -2px 12px rgba(255, 255, 255, 0.5),
           inset 2px 2px 4px rgba(255, 255, 255, 0.1),
           inset 2px 2px 8px rgba(0, 0, 0, 0.15);
           color: #7289ab;
       }

       .button-center {
           justify-content: center;
           text-align: center;
       }

       .bttn-def {
           display: inline-block;
           font-size: 14px;
           font-weight: 700;
           text-transform: uppercase;
           letter-spacing: 1px;
           padding: 14px 42px;
           border-radius: 50px;
           text-decoration: none;
           font-family: "Poppins", sans-serif;
           box-shadow: -2px -2px 8px white, -2px -2px 12px rgba(255, 255, 255, 0.5), inset 2px 2px 4px rgba(255, 255, 255, 0.1), 2px 2px 8px rgba(0, 0, 0, 0.15);
           transition: 0.4s;
       }

       .bttn-def:hover {
           color: #7289ab;
           box-shadow: inset -2px -2px 8px white, inset -2px -2px 12px rgba(255, 255, 255, 0.5), inset 2px 2px 4px rgba(255, 255, 255, 0.1), inset 2px 2px 8px rgba(0, 0, 0, 0.15);
       }

       .bttn-def:hover span {
           display: inline-block;
           transform: scale(0.98);
       }
   </style>
</head>

<body class="sub_page">
   <section class="section-bg">
      <div class="container">
         <div class="heading_container heading_center">
            <h2>
               Our <span>products</span>
            </h2>
         </div>

         <div class="row">
            <?php
            if (!empty($products)) {
               foreach ($products as $product) {
                  ?>
                  <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                     <div class="single-product">
                        <div class="product-thumb">
                           <img src="<?php echo $product['img_url']; ?>" alt="">
                        </div>
                        <div class="product-title">
                           <h3><a href=""><?php echo $product['name']; ?></a></h3>
                        </div>
                        <div class="product-btns">
                           <a href="" class="btn-small mr-2">$<?php echo $product['price']; ?></a>
                           <a href="cart.php?add_to_cart=1&product_id=<?php echo $product['id']; ?>" class="btn-round mr-2"><i class="fa fa-shopping-cart"></i></a>
                           <a href="" class="btn-round"><i class="fas fa-info-circle"></i></a>
                        </div>
                     </div>
                  </div>
                  <?php
               }
            } else {
               ?>
               <div class="col">
                  <p>No products available.</p>
               </div>
               <?php
            }
            ?>
         </div>

         <div class="btn-box">
            <a href="">
               View All products
            </a>
         </div>
      </div>
   </section>

   <!-- jQuery -->
   <script src="js/jquery-3.4.1.min.js"></script>
   <!-- Popper.js -->
   <script src="js/popper.min.js"></script>
   <!-- Bootstrap.js -->
   <script src="js/bootstrap.js"></script>
   <!-- Custom.js -->
   <script src="js/custom.js"></script>

   <?php
   include("footer.php")
   ?>
</body>
</html>
