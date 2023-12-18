<?php
include("db.php");
include("head.php");
include("header.php");

// Example dummy data for blog posts
$blogPosts = [
    ['id' => 1, 'title' => 'Discover the Latest Fashion Trends', 'content' => 'Explore fashion trends for this season and stay on the cutting edge of style.'],
    ['id' => 2, 'title' => 'Tips for Flawless Makeup', 'content' => 'Learn professional makeup tips to achieve a flawless look every time.'],
    ['id' => 3, 'title' => 'How to Elegantize Your Outfits with Accessories', 'content' => 'Discover how to choose and pair accessories to make your outfits even more stylish.']
];
?>

<!DOCTYPE html>
<html>

<body class="sub_page">
    <div class="hero_area"> </div>

    <section class="inner_page_head">
        <div class="container_fuild">
            <div class="row">
                <div class="col-md-12">
                    <div class="full">
                        <h3>Blog List</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="why_section layout_padding">
        <div class="container">
            <!-- Loop to display each blog post -->
            <?php foreach ($blogPosts as $blogPost) { ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box">
                            <div class="detail-box">
                                <!-- Blog post title -->
                                <h5><?php echo $blogPost['title']; ?></h5>
                                <!-- Blog post content -->
                                <p><?php echo $blogPost['content']; ?></p>
                                <a href="?id=<?php echo $blogPost['id']; ?>">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>

   
    <?php
    if (isset($_GET['id'])) {
        $postId = $_GET['id'];
        // Fetch and display blog post content based on the ID
        $postContent = "The content for blog post ";
        echo "<div class='container'>$postContent</div>";
    }
    ?>

    <!-- Footer -->
    <?php include("footer.php") ?>

    <!-- jQuery -->
    <script src="js/jquery-3.4.1.min.js"></script>
    <!-- Popper.js -->
    <script src="js/popper.min.js"></script>
    <!-- Bootstrap.js -->
    <script src="js/bootstrap.js"></script>
    <!-- Custom.js -->
    <script src="js/custom.js"></script>
</body>

</html>
