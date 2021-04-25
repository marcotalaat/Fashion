<?php
session_start();
if(isset($_SESSION['Username'])) {
ob_start();
include("include/inc.php");
?>

<!-- Categories Section Begin -->
<section class="categories">
    <div class="container">
        <div class="row cat-layout">
            <?php foreach ($cats_row as $cat){ ?>
            <div class="col-lg-6 p-0">
                <div class="categories__item set-bg" data-setbg="img/categories/<?php echo $cat["cat_img"] ?>">
                    <div class="categories__text">
                        <h4><?php echo $cat['name'] ?></h4>
                        <p><?php echo $cat['description'] ?></p>
                        <a href="category.php?id=<?php echo $cat["id"] ?>" target="_blank">Shop now</a>
                    </div>
                </div>
            </div>
            <?php } ?>

        </div>
    </div>
    </div>
</section>
<!-- Categories Section End -->

<!--===================================================== 
========================Products=========================
======================================================== -->

<!-- Product Section Begin -->
<section class="product spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4">
                <div class="section-title">
                    <h4>New product</h4>
                </div>
            </div>
            <?php
            // Get name of all categories
            $name_cats = $db->prepare("SELECT name FROM categories LIMIT 10");
            $name_cats->execute();
            $name_cats_row = $name_cats->fetchAll();
            ?>
            <div class="col-lg-8 col-md-8">
                <ul class="filter__controls">
                    <li class="active" data-filter="*">All</li>
                    <?php foreach($name_cats_row as $name_cat){ ?>
                    <li data-filter=".<?php echo strtolower($name_cat["name"]) ?>"><?php echo $name_cat["name"] ?></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <?php 
            // Get Products
            $products = $db->prepare("SELECT * FROM products LIMIT 8");
            $products->execute();
            $products_row = $products->fetchAll();
        ?>
        <div class="row property__gallery">
            <?php foreach ($products_row as $product){ ?>
            <div class="col-lg-3 col-md-4 col-sm-6 mix <?php
                $stmt = $db->prepare("SELECT 
                categories.name
                FROM
                categories
                INNER JOIN products
                ON categories.id = products.category ");
                $stmt->execute();
                $row = $stmt->fetch();
                echo strtolower($row["name"]);
                ?> ">
                <div class="product__item">
                    <div class="product__item__pic set-bg" data-setbg="img/product/<?php echo $product["img"] ?>">
                        <?php 
                        if ($product["sale"] == 1) {
                            echo '<div class="label sale">Sale</div>';
                        }
                    ?>
                        <div class="label new">New</div>
                        <ul class="product__hover">
                            <li><a href="img/product/<?php echo $product["img"] ?>" class="image-popup"><span
                                        class="arrow_expand"></span></a></li>
                            <li><a href="#"><span class="icon_heart_alt"></span></a></li>
                            <li><a href="shop-cart.php?user_id=<?php echo $_SESSION["ID"] ?>"><span class="icon_bag_alt"></span></a></li>
                        </ul>
                    </div>
                    <div class="product__item__text">
                        <h6><a href="product.php?id=<?php echo $product["id"] ?>&page=view"
                                target="_blank"><?php echo $product["name"] ?></a></h6>
                        <div class="rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </div>
                        <div class="product__price"><?php echo "$ " . $product["price"] ?></div>
                    </div>
                </div>
            </div>
            <?php } ?>

        </div>
    </div>
</section>
<!-- Product Section End -->

<!-- Banner Section Begin -->
<section class="banner set-bg" data-setbg="img/banner/banner-1.jpg">
    <div class="container">
        <div class="row">
            <div class="col-xl-7 col-lg-8 m-auto">
                <div class="banner__slider owl-carousel">
                    <div class="banner__item">
                        <div class="banner__text">
                            <span>The Chloe Collection</span>
                            <h1>The Project Jacket</h1>
                            <a href="#">Shop now</a>
                        </div>
                    </div>
                    <div class="banner__item">
                        <div class="banner__text">
                            <span>The Chloe Collection</span>
                            <h1>The Project Jacket</h1>
                            <a href="#">Shop now</a>
                        </div>
                    </div>
                    <div class="banner__item">
                        <div class="banner__text">
                            <span>The Chloe Collection</span>
                            <h1>The Project Jacket</h1>
                            <a href="#">Shop now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Banner Section End -->

<!-- Trend Section Begin -->
<section class="trend spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="trend__content">
                    <div class="section-title">
                        <h4>Hot Trend</h4>
                    </div>
                    <?php 
                            // Trend item from database
                            $trend = $db->prepare("SELECT * FROM products WHERE trend = 1  LIMIT 3");
                            $trend->execute();
                            $trend_row = $trend->fetchAll();

                            foreach($trend_row as $trend_product){
                        ?>
                    <div class="trend__item">
                        <div class="trend__item__pic">
                            <img src="img/product/<?php echo $trend_product["img"] ?>"
                                alt="<?php echo $trend_product["name"] ?>" style="width: 90px; height: 90px">
                        </div>
                        <div class="trend__item__text">
                            <h6><?php echo $trend_product["name"] ?></h6>
                            <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <div class="product__price"><?php echo "$ " . $trend_product["price"] ?></div>
                        </div>
                    </div>
                    <?php } ?>

                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="trend__content">
                    <div class="section-title">
                        <h4>Best seller</h4>
                    </div>
                    <?php 
                            // Trend item from database
                            $seller_stmt = $db->prepare("SELECT * FROM products WHERE best_seller = 1 LIMIT 3");
                            $seller_stmt->execute();
                            $seller_row = $seller_stmt->fetchAll();

                            foreach($seller_row as $seller_product){
                        ?>
                    <div class="trend__item">
                        <div class="trend__item__pic">
                            <img src="img/product/<?php echo $seller_product["img"] ?>"
                                alt="<?php echo $seller_product["name"] ?>" style="width: 90px; height: 90px">
                        </div>
                        <div class="trend__item__text">
                            <h6><?php echo $seller_product["name"] ?></h6>
                            <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <div class="product__price"><?php echo "$ " . $seller_product["price"] ?></div>
                        </div>
                    </div>
                    <?php } ?>

                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="trend__content">
                    <div class="section-title">
                        <h4>Feature</h4>
                    </div>
                    <?php 
                            // Trend item from database
                            $feature_stmt = $db->prepare("SELECT * FROM products WHERE feature = 1 LIMIT 3");
                            $feature_stmt->execute();
                            $feature_row = $feature_stmt->fetchAll();

                            foreach($feature_row as $featrue_product){
                        ?>
                    <div class="trend__item">
                        <div class="trend__item__pic">
                            <img src="img/product/<?php echo $featrue_product["img"] ?>"
                                alt="<?php echo $featrue_product["name"] ?>" style="width: 90px; height: 90px">
                        </div>
                        <div class="trend__item__text">
                            <h6><?php echo $featrue_product["name"] ?></h6>
                            <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <div class="product__price"><?php echo $featrue_product["price"] ?></div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Trend Section End -->

<!-- Discount Section Begin -->
<!-- <section class="discount">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 p-0">
                <div class="discount__pic">
                    <img src="img/discount.jpg" alt="">
                </div>
            </div>
            <div class="col-lg-6 p-0">
                <div class="discount__text">
                    <div class="discount__text__title">
                        <span>Discount</span>
                        <h2>Summer 2019</h2>
                        <h5><span>Sale</span> 50%</h5>
                    </div>
                    <div class="discount__countdown" id="countdown-time">
                        <div class="countdown__item">
                            <span>22</span>
                            <p>Days</p>
                        </div>
                        <div class="countdown__item">
                            <span>18</span>
                            <p>Hour</p>
                        </div>
                        <div class="countdown__item">
                            <span>46</span>
                            <p>Min</p>
                        </div>
                        <div class="countdown__item">
                            <span>05</span>
                            <p>Sec</p>
                        </div>
                    </div>
                    <a href="#">Shop now</a>
                </div>
            </div>
        </div>
    </div>
</section> -->
<!-- Discount Section End -->

<!-- Services Section Begin -->
<section class="services spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="services__item">
                    <i class="fa fa-car"></i>
                    <h6>Free Shipping</h6>
                    <p>For all oder over $99</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="services__item">
                    <i class="fa fa-money"></i>
                    <h6>Money Back Guarantee</h6>
                    <p>If good have Problems</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="services__item">
                    <i class="fa fa-support"></i>
                    <h6>Online Support 24/7</h6>
                    <p>Dedicated support</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="services__item">
                    <i class="fa fa-headphones"></i>
                    <h6>Payment Secure</h6>
                    <p>100% secure payment</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Services Section End -->

<!-- Instagram Begin -->
<?php include("include/instagram.php"); ?>
<!-- Instagram End -->

<?php include("include/footer.php");
}