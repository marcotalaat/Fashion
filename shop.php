<?php
session_start();
if(isset($_SESSION['Username'])){
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

<!-- Shop Section Begin -->
<section class="shop spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3">
                <div class="shop__sidebar">
                    <div class="sidebar__categories">
                        <div class="section-title">
                            <h4>Categories</h4>
                        </div>
                        <div class="categories__accordion">
                            <div class="accordion" id="accordionExample">
                            <?php 
                            // Fetch all categoires
                            foreach ($all_cats_row as $cat){
                            ?>
                                <div class="card">
                                    <div class="card-heading active">
                                        <a href="category.php?id=<?php echo $cat["id"] ?>"><?php echo $cat["name"] ?></a>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <form action="<?php $_SERVER["PHP_SELF"] ?>?filter=" method="GET">
                    <div class="sidebar__filter">
                        <div class="section-title">
                            <h4>Shop by price</h4>
                        </div>
                        <div class="filter-range-wrap">
                            <div class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
                                data-min="5" data-max="1000"></div>
                            <div class="range-slider">
                                <div class="price-input">
                                    <p>Price($): </p>
                                    <input type="number" id="minamount" name="minamount">
                                    <input type="number" id="maxamount" name="maxamount" >
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="sidebar__sizes">
                        <div class="section-title">
                            <h4>Shop by size</h4>
                        </div>
                        <div class="size__list">
                            <label for="xxs">
                                xxs
                                <input type="checkbox" id="xxs" name="size[]" value="xxs">
                                <span class="checkmark"></span>
                            </label>
                            <label for="xs">
                                xs
                                <input type="checkbox" id="xs" name="size[]" value="xs">
                                <span class="checkmark"></span>
                            </label>
                            <label for="xss">
                                xs-s
                                <input type="checkbox" id="xss" name="size[]" value="xss">
                                <span class="checkmark"></span>
                            </label>
                            <label for="s">
                                s
                                <input type="checkbox" id="s" name="size[]" value="s">
                                <span class="checkmark" ></span>
                            </label>
                            <label for="m">
                                m
                                <input type="checkbox" id="m" name="size[]" value="m">
                                <span class="checkmark"></span>
                            </label>
                            <label for="ml">
                                m-l
                                <input type="checkbox" id="ml" name="size[]" value="ml">
                                <span class="checkmark"></span>
                            </label>
                            <label for="l">
                                l
                                <input type="checkbox" id="l" name="size[]" value="l">
                                <span class="checkmark"></span>
                            </label>
                            <label for="xl">
                                xl
                                <input type="checkbox" id="xl" name="size[]" value="xl">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </div>
                    <div class="sidebar__color">
                        <div class="section-title">
                            <h4>Shop by color</h4>
                        </div>
                        <div class="size__list color__list">
                            <label for="black">
                                Blacks
                                <input type="checkbox" id="black" name="color[]" value="black">
                                <span class="checkmark"></span>
                            </label>
                            <label for="whites">
                                Whites
                                <input type="checkbox" id="whites" name="color[]" value="white">
                                <span class="checkmark"></span>
                            </label>
                            <label for="reds">
                                Reds
                                <input type="checkbox" id="reds" name="color[]" value="red">
                                <span class="checkmark"></span>
                            </label>
                            <label for="greys">
                                Greys
                                <input type="checkbox" id="greys" name="color[]" value="grey">
                                <span class="checkmark"></span>
                            </label>
                            <label for="blues">
                                Blues
                                <input type="checkbox" id="blues" name="color[]" value="blue">
                                <span class="checkmark"></span>
                            </label>
                            <label for="beige">
                                Beige Tones
                                <input type="checkbox" id="beige" name="color[]" value="beige">
                                <span class="checkmark"></span>
                            </label>
                            <label for="greens">
                                Greens
                                <input type="checkbox" id="greens" name="color[]" value="greens">
                                <span class="checkmark"></span>
                            </label>
                            <label for="yellows">
                                Yellows
                                <input type="checkbox" id="yellows" name="color[]" value="yellows">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </div>
                    <input type="submit" class="btn main-background white-color d-block btn-lg" value="Filter">
                   </form>
                </div>
            </div>
            <div class="col-lg-9 col-md-9">
                <div class="row">
                    <?php
                    if (isset($_GET["page"])){
                    // Select All products
                    $limit = 11;
                    $page = $_GET["page"];
                    $start = ($page - 1) * $limit;
                    $all_pro = $db->prepare("SELECT * FROM products LIMIT $start, $limit");
                    $all_pro->execute();
                    $all_pro_row = $all_pro->fetchAll();
                    
                    $pages = $db->prepare("SELECT COUNT(id) FROM products");
                    $pages->execute();
                    $pages = $pages->fetchAll();
                    $total = ceil($pages[0][0] / $limit);
                ?>
                    <?php foreach($all_pro_row as $product){ ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="product__item">
                            <div class="product__item__pic set-bg"
                                data-setbg="img/product/<?php echo $product["img"] ?>">
                                <?php 
                                    if ($product["sale"] == 1) {
                                        echo '<div class="label sale">Sale</div>';
                                    }
                                 ?>
                                <div class="label new">New</div>
                                <ul class="product__hover">
                                    <li><a href="img/shop/shop-1.jpg" class="image-popup"><span
                                                class="arrow_expand"></span></a></li>
                                    <li><a href="#"><span class="icon_heart_alt"></span></a></li>
                                    <li><a href="#"><span class="icon_bag_alt"></span></a></li>
                                </ul>
                            </div>
                            <div class="product__item__text">
                                <h6><a href="product.php?id=<?php echo $product["id"] ?>&page=view"
                                        target="_balnk"><?php echo $product["name"] ?></a></h6>
                                <div class="rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                                <div class="product__price"><?php echo $product["price"] ?></div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="col-lg-12 text-center">
                        <div class="pagination__option">
                            <?php for($i = 1; $i <= $total; $i++){ ?>
                            <a href="?page=<?php echo $i?>"><?php echo $i ?></a>
                            <?php } ?>
                            <!--                             <a href="#">2</a>
                            <a href="#">3</a> -->
                            <a href="#"><i class="fa fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <?php } else{
                // Filter Result
                // Price
                $minamount = $_GET["minamount"];
                $maxamount = $_GET["maxamount"];
                
                // Fetch all query from url
                $url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_QUERY);
                parse_str($url, $array);

                $array_size = array_values($array["size"]);
                $str_size = implode(" ", $array_size);

                $array_color = array_values($array["color"]);
                $str_color = implode(" ", $array_color);

                // Stmt of filter
                $filter = $db->prepare("
                SELECT * FROM products WHERE products.price < $maxamount AND products.price > $minamount 
                AND size LIKE '%$str_size%' AND color LIKE '%$str_color%' ");
                $filter->execute();
                $filter_row = $filter->fetchAll();

                // Print result in template ?>
                <?php
                if (!empty($filter_row)){
                foreach($filter_row as $filter_one){ ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="product__item">
                            <div class="product__item__pic set-bg"
                                data-setbg="img/product/<?php echo $filter_one["img"] ?>">
                                <?php 
                                    if ($filter_one["sale"] == 1) {
                                        echo '<div class="label sale">Sale</div>';
                                    }
                                 ?>
                                <div class="label new">New</div>
                                <ul class="product__hover">
                                    <li><a href="img/shop/shop-1.jpg" class="image-popup"><span
                                                class="arrow_expand"></span></a></li>
                                    <li><a href="#"><span class="icon_heart_alt"></span></a></li>
                                    <li><a href="#"><span class="icon_bag_alt"></span></a></li>
                                </ul>
                            </div>
                            <div class="product__item__text">
                                <h6><a href="product.php?id=<?php echo $filter_one["id"] ?>&page=view"
                                        target="_balnk"><?php echo $filter_one["name"] ?></a></h6>
                                <div class="rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                                <div class="product__price"><?php echo $filter_one["price"] ?></div>
                            </div>
                        </div>
                    </div>
                    <?php } // End of loop
                }else{
                    echo "<h4 class='text-center'>
                    Sorry, we couldn't find your order. 
                        <a href='contact.php' class='main-color bold'> Contact Us</a>
                    </h4>" ;
                }
                } // End of Else
                ?>

        </div>
    </div>
</section>
<!-- Shop Section End -->


<!-- Instagram Begin -->
<?php include("include/instagram.php"); ?>
<!-- Instagram End -->

<?php include("include/footer.php"); } ?>

