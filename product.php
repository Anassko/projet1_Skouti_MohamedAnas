<?php
include("db.php");
include("head.php");
include("header.php");

// Fetch products from the database using prepared statement
$productQuery = "SELECT id, name, price, img_url FROM `product`";
$stmt = mysqli_prepare($con, $productQuery);
mysqli_stmt_execute($stmt);

// Bind the result variables
mysqli_stmt_bind_result($stmt, $id, $name, $price, $img_url);

// Initialize an empty array to store products
$products = [];

// Fetch results into the associative array
while (mysqli_stmt_fetch($stmt)) {
    // Store product data in the array using array() function
    $products[] = array($id, $name, $price, $img_url);
}

mysqli_stmt_close($stmt);
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
            <div class="search-container">
                            <input type="text" id="searchInput" placeholder="Search products...">
                            <button onclick="searchProducts()">Search</button>
                            </div>
            <div class="row">
                <?php
                // Iterate through the products array
                foreach ($products as $product) {
                ?>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                        <div class="single-product">
                            <div class="product-thumb">
                                <img src="<?php echo isset($product[3]) ? $product[3] : ''; ?>" alt="">
                            </div>
                            <div class="product-title">
                                <h3><a href=""><?php echo isset($product[1]) ? $product[1] : ''; ?></a></h3>
                            </div>
                            <div class="product-btns">
                                <a href="" class="btn-small mr-2">$<?php echo isset($product[2]) ? $product[2] : ''; ?></a>
                                <a href="cart.php?add_to_cart=1&product_id=<?php echo isset($product[0]) ? $product[0] : ''; ?>" class="btn-round mr-2"><i class="fa fa-shopping-cart"></i></a>
                                <a href="" class="btn-round"><i class="fas fa-info-circle"></i></a>
                            </div>
                        </div>
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
    <script>
    function searchProducts() {
        var input, filter, products, product, title, i;
        input = document.getElementById('searchInput');
        filter = input.value.toUpperCase();
        products = document.getElementsByClassName('single-product');

        for (i = 0; i < products.length; i++) {
            title = products[i].getElementsByClassName('product-title')[0].getElementsByTagName('a')[0];
            if (title.innerHTML.toUpperCase().indexOf(filter) > -1) {
                products[i].style.display = "";
            } else {
                products[i].style.display = "none";
            }
        }
    }
</script>
    <?php
    include("footer.php")
    ?>
</body>

</script>


</html>

