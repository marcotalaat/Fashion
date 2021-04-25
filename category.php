<?php
session_start();
if(isset($_SESSION['Username'])){ }
include("include/inc.php");
?>
<?php 
    $cat_id = isset($_GET["id"]) && is_numeric($_GET["id"]) ? $_GET["id"] : 0;
    $stmt = $db->prepare("SELECT name, description FROM categories WHERE id= ?");
    $stmt->execute(array($cat_id));
    $row = $stmt->fetch();

    // Get products of this category
    $products = $db->prepare("SELECT id,name, price, img FROM products WHERE category = ?");
    $products->execute(array($cat_id));
    $products_row = $products->fetchAll();
?>
<div class="banner-cat">
    <div class="welcome-cat text-center">
        <h2 class="bold white-color">Welcome in <?php echo $row["name"] ?> Category</h2>
        <h6 class="white-color"><?php echo $row["description"] ?></h6>
        <a data href="#category"><span class="down"><i class="fas fa-arrow-down"></i></span></a>
    </div>
</div>
<section class="category position-relative" id="category">
    <div class="container">
        <div class="row">

            <?php foreach($products_row as $product){ ?>
            <div class="col-sm-12 col-md-4 col-lg-3">
                <a href="product.php?id=<?php echo $product["id"] ?>&page=view">
                <div class="product-in-category">
                    <div class="text-center">
                    <img src="img/product/<?php echo $product["img"] ?>" alt="<?php echo $product["name"] ?>">
                    </div>
                    <h4 class="text-center p-2"><?php echo $product["name"] ?></h4>
                    <h6 class="text-center bold main-color p-2">$ <?php echo $product["price"] ?></h6>
                </div>
                </a>
            </div>
            <?php } ?>

        </div>
    </div>
</section>

<?php include("include/footer.php");?>