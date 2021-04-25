<?php
session_start();
include("include/inc.php");
?>
<!-- Breadcrumb Begin -->
<div class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__links">
                    <a href="./front-page.php"><i class="fa fa-home"></i> Home</a>
                    <span>Shop</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->




<!-- Blog Section Begin -->
<section class="blog spad">
    <div class="container">
        <div class="outer-blog">
            <?php 
            // Get query from blog tabel then loop it
            $blog = $db->prepare("SELECT * FROM blog");
            $blog->execute();
            $blog_row = $blog->fetchAll();
            
            foreach($blog_row as $post){
            ?>
            <div class="blog__item">
                <div class="banner-blog">
                    <img src="img/blog/<?php echo $post["img"] ?>" alt="">
                </div>
                <div class="blog__item__text">
                    <h6><a
                            href="blog-details.php?id=<?php echo $post["id"] ?>&page=view"><?php echo substr($post["post"], 0, 20) . " ..." ?></a>
                    </h6>
                    <ul>
                        <li>by <span><?php echo $author_row[0]; ?></span></li>
                        <li><i class="fas fa-calendar-week"></i>
                            <?php echo date("d M - h a", strtotime($post["datetime"])) ?></li>
                    </ul>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
    </div>
</section>
<!-- Blog Section End -->

<!-- Instagram Begin -->
<?php include("include/instagram.php"); ?>
<!-- Instagram End -->

<?php include("include/footer.php") ?>