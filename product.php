<?php
session_start();
include("include/inc.php");
?>
<?php
    $product_id = isset($_GET["id"]) && is_numeric($_GET["id"]) ? $_GET["id"] : 0;
    $stmt = $db->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute(array($product_id));
    $row = $stmt->fetch();
    if (isset($_GET["id"]) && is_numeric($_GET["id"]) && isset($_GET["page"]) && $_GET["page"] == "view"){
?>
<section class="single-product">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-lg-4">
                <form action="shop-cart.php?user_id=<?php echo $_SESSION["ID"] ?>" method="POST" enctype="multipart/form-data">
                    <input type="text" name="product-id" value="<?php echo $row["id"] ?>" hidden>
                    <img class="img-fluid img-product" src="img/product/<?php echo $row["img"] ?>">
                    <input type="text" name="cart-img" value="<?php echo $row["img"] ?>" hidden>
                            </div>
                            <div class="col-sm-12 col-lg-8">
                            <div class="float-right control-product">
                                <?php   
                                // Delete product for admins only
                                if(isset($_SESSION['Username'])){ 
                                if ($_SESSION["Admin"] == 1){ ?>
                                <a href="?id=<?php echo $row["id"] ?>&page=edit" class="btn btn-primary">
                                    <span class="edit"><i class="far fa-edit"></i></span>
                                </a>
                                <a href="?id=<?php echo $row["id"] ?>&page=delete" class="btn btn-danger">
                                    <span class="delete"><i class="fas fa-trash-alt"></i></span>
                                </a>
                                <?php
                                }
                             } ?>
                             </div>
                        <h2 class="bold main-color"><?php echo $row["name"] ?></h2>
                        <input type="text" name="owner" value="<?php echo $_SESSION["ID"] ?>" hidden>
                        <input type="text" name="cart-name" value="<?php echo $row["name"] ?>" hidden>
                        <hr>
                        <h6>Description: <?php echo $row["description"] ?></h6>
                        <hr>
                        <h6>Category:
                            <?php
                            $cat = $db->prepare("SELECT categories.name 
                                            FROM products INNER JOIN categories ON products.category = categories.id LIMIT 1");
                            $cat->execute();
                            $row_cat = $cat->fetch();
                            echo $row_cat[0];
                            ?></h6>
                        <hr>
                        <h6>Color: <?php echo $row["color"] ?></h6>
                        <input type="text" name="cart-color" value="<?php echo $row["color"] ?>" hidden>
                        <hr>
                        <h6>Made in : <?php echo $row["made"] ?></h6>
                        <hr>
                        <h6>Have Sale?: <?php if ($row["sale"] == 0) {
                            echo "No";
                        }else{
                            echo "Yes";
                        } ?></h6>
                        <hr>
                        <h3 class="bold main-color text-center"><?php echo "$" . $row["price"] ?></h3>
                        <div class="pro-qty product-qty text-right">
                            <input type="text" name="quantity" value="1">
                        </div>
                        <input type="number" name="cart-price" value="<?php echo $row["price"] ?>" hidden>
                        <?php if(isset($_SESSION['Username'])){  ?>
                        <input type="submit" class="add-cart" value="Add to Cart">
                        <?php }else{ echo "<a href='sign-up.php' class='add-cart d-block text-center'>Add to Cart</a>"; } ?>
                </form>
            </div>
        </div>
    </div>
</section>
<?php
    }
    // Delete Page of Single Product
    if (isset($_GET["id"]) && is_numeric($_GET["id"]) && isset($_GET["page"]) && $_GET["page"] == "delete"){
        $stmt = $db->prepare("DELETE FROM products WHERE id = ?");
        $stmt->execute(array($product_id));
        $row = $stmt->fetch();
    }

    // Edit Page of Single Product
    if (isset($_GET["id"]) && is_numeric($_GET["id"]) && isset($_GET["page"]) && $_GET["page"] == "edit"){ ?>
<div class="container">
    <div class="mange-cat">
        <h2 class="bold main-background white-color">Edit Product</h2>
    </div>
    <form action="?id=<?php echo $product_id ?>&page=update" method="POST" enctype="multipart/form-data">
        <input type="number" name="product" value="<?php echo $product_id ?>" hidden>
        <div class="form-group">
            <label for="name">Product Name</label>
            <input type="text" name="pro_name" class="form-control" id="name" value="<?php echo $row["name"] ?>">
        </div>
        <input type="file" name="pro_img">
        <div class="form-group">
            <label for="pro-desc">Description</label>
            <textarea name="pro_desc" class="form-control" id="pro-desc"
                value="<?php echo $row["description"] ?>"><?php echo $row["description"] ?></textarea>
        </div>
        <div class="form-group">
            <label for="price">Product Price</label>
            <input type="number" min="1" name="price" class="form-control" id="price"
                value="<?php echo $row["price"] ?>">
        </div>
        <div class="form-group">
            <label for="made">Made In...</label>
            <input type="text" name="made" class="form-control" id="made" value="<?php echo $row["made"] ?>">
        </div>
        <div class="form-group">
            <label for="color">Color</label>
            <input type="text" name="color" class="form-control" id="color" value="<?php echo $row["color"] ?>">
        </div>
        <div class="sale">
            <h5>Has Sale?</h5>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="sale" id="sale-yes" value="1"
                    <?php if ($row["sale"] == 1) { echo "checked";} ?>>
                <label class="form-check-label" for="sale-yes">Yes</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="sale" id="sale-no" value="0"
                    <?php if ($row["sale"] == 0) { echo "checked";} ?>>
                <label class="form-check-label" for="sale-no">No</label>
            </div>
        </div>
        <div class="sale">
            <h5>Trend ?</h5>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="trend" id="trend-yes" value="1"
                    <?php if ($row["trend"] == 1) { echo "checked";} ?>>
                <label class="form-check-label" for="trend-yes">Yes</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="trend" id="trend-no" value="0"
                    <?php if ($row["trend"] == 0) { echo "checked";} ?>>
                <label class="form-check-label" for="trend-no">No</label>
            </div>
        </div>
        <div class="sale">
            <h5>Best Seller ?</h5>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="seller" id="seller-yes" value="1"
                    <?php if ($row["best_seller"] == 1) { echo "checked";} ?>>
                <label class="form-check-label" for="seller-yes">Yes</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="seller" id="seller-no" value="0"
                    <?php if ($row["best_seller"] == 0) { echo "checked";} ?>>
                <label class="form-check-label" for="seller-no">No</label>
            </div>
        </div>
        <div class="sale">
            <h5>Feature ?</h5>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="feature" id="feature-yes" value="1"
                    <?php if ($row["feature"] == 1) { echo "checked";} ?>>
                <label class="form-check-label" for="feature-yes">Yes</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="feature" id="feature-no" value="0"
                    <?php if ($row["feature"] == 0) { echo "checked";} ?>>
                <label class="form-check-label" for="feature-no">No</label>
            </div>
        </div>
        <div class="category">
            <h5>Category</h5>
            <?php foreach ($all_cats_row as $cat){ ?>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="category" id="<?php echo $cat["id"] ?>"
                    value="<?php echo $cat["id"] ?>" <?php if ($cat["id"]  == $row["category"]) { echo "checked";} ?>>
                <label class="form-check-label" for="<?php echo $cat["id"] ?>"><?php echo $cat["name"] ?></label>
            </div>
            <?php } ?>
        </div>
        <input type="submit" value="Edit Product" class="btn main-background white-color">
    </form>
</div>
<?php
    } // End if of edit page

    // Update Page of Single Product
    if (isset($_GET["id"]) && is_numeric($_GET["id"]) && isset($_GET["page"]) && $_GET["page"] == "update"){
        $pro_name = $_POST["pro_name"];
        $pro_desc = $_POST["pro_desc"];
        $made = $_POST["made"];
        $color = $_POST["color"];
        $sale = $_POST["sale"];
        $price = $_POST["price"];
        $trend = $_POST["trend"];
        $seller = $_POST["seller"];
        $feature = $_POST["feature"];
        $category = $_POST["category"];

        $stmt = $db->prepare("UPDATE products 
        SET name = ?, description = ?, price = ?, sale = ?, made = ?, color = ?, category = ?, trend = ?, best_seller = ?, feature = ? WHERE id = $product_id");
        $stmt->execute(array($pro_name, $pro_desc, $price, $sale, $made, $color, $category, $trend, $seller, $feature ));
        echo "Updated Done...";
        header("location: product.php?id=<?php echo $product_id ?>&page=view");
exit;
}
?>

<?php include("include/footer.php") ?>