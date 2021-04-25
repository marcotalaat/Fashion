<?php
session_start();

ob_start();
include("include/inc.php");
?>
<?php
        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            $owner = $_POST["owner"];
            $product_id = $_POST["product-id"];
            $img = $_POST["cart-img"];
            $name = $_POST["cart-name"];
            $color = $_POST["cart-color"];
            $price = $_POST["cart-price"];
            $quantity = $_POST["quantity"];

            // Insert data to cart table
            $stmt = $db->prepare("INSERT INTO cart (owner_id ,product_id, img, name, color, quantity, price, total)
                VALUES (:owner ,:id, :img, :name, :color, :quantity, :price, :total)");
            $stmt->execute(array(
                "owner" => $owner,
                "id" => $product_id,
                "img" => $img,
                "name" => $name,
                "color" => $color,
                "quantity" => $quantity,
                "price" => $price,
                "total" => $price * $quantity
            ));

            header("location: shop-cart.php");
            exit;
            //=======================
        }
        if(isset($_SESSION['Username'])){
        // Fetch data from cart table
        $cart = $db->prepare("SELECT * FROM cart WHERE owner_id = ?");
        $cart->execute(array($_SESSION["ID"]));
        $cart_row = $cart->fetchAll();
        }

?>
    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="./front-page.php"><i class="fa fa-home"></i> Home</a>
                        <span>Shopping cart</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Shop Cart Section Begin -->
    <section class="shop-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="shop__cart__table table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Product</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Total</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                            if(isset($_SESSION['Username'])){
                            foreach($cart_row as $single_cart) { ?>
                                <tr>
                                    <td class="cart__product__item">
                                        <img src="img/product/<?php echo $single_cart["img"] ?>" 
                                        alt="<?php echo $single_cart["name"] ?>"
                                        style="width: 100px; height: 100px"
                                        >
                                        <div class="cart__product__item__title">
                                            <h6><?php echo $single_cart["name"] ?></h6>
                                            <div class="rating">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="cart__price"><?php echo $single_cart["price"] ?></td>
                                    <td class="cart__quantity">
                                        <span class="text-center"><?php echo $single_cart["quantity"] ?></span>
                                    </td>
                                    <td class="cart__total"><?php $total = ($single_cart["price"]) * ($single_cart["quantity"]); echo $total; ?></td>
                                    <td class="cart__close"><a href="delete.php?id=<?php echo $single_cart["id"] ?>"><span class="icon_close delete"></span></a></td>
                                </tr>
                            <?php } } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="cart__btn cont-shop">
                        <a href="index.php">Continue Shopping</a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="cart__btn update__btn">
                        <a href="?page=delete" class="delete delete-all-cart"><span class="icon_loading"></span>Delete All Order</a>
                        <?php
                        if(isset($_SESSION['Username'])){
                        if (isset($_GET["page"]) && $_GET["page"] == "delete"){
                            $delete_all = $db->prepare("DELETE FROM cart WHERE owner_id = ?");
                            $delete_all->execute(array($_SESSION["ID"]));
                            //$delete_all = $delete_all->fetchAll();
                            header("location: shop-cart.php");
                            exit;
                        }
                    }
                        ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="discount__content">
                        <h6>Discount codes</h6>
                        <form action="#">
                            <input type="text" placeholder="Enter your coupon code">
                            <button type="submit" class="site-btn">Apply</button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4 offset-lg-2">
                    <div class="cart__total__procced">
                        <h6>Cart total</h6>
                        <ul>
                            <li>Subtotal <span><?php 
                            if(isset($_SESSION['Username'])){
                                $sub_total = $db->prepare("SELECT SUM(cart.total) FROM cart WHERE owner_id =?");
                                $sub_total->execute(array($_SESSION["ID"]));
                                $tota_row = $sub_total->fetch();
                                echo "$ " . $tota_row[0];
                            
                            ?></span></li>
                            <li>Total <span><?php
                                echo "$ " . $tota_row[0];
                            }
                            ?></span></li>
                        </ul>
                        <a href="#" class="primary-btn">Proceed to checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shop Cart Section End -->

    <!-- Instagram Begin -->
    <?php include("include/instagram.php"); ?>
    <!-- Instagram End -->

    <?php  include("include/footer.php");