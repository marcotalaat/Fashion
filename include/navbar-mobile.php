<?php include("database.php"); include("stmts.php"); ?>
<!-- Header Section for Mobile Begin -->
<section class="navbar-mobile">
    <span class="close-menu"><i class="fa fa-times"></i></span>
    <!-- Profile Photo and Name -->
    <div class="profile-photo">
        <div class="photo">
            <a href="profile.php?id=<?php echo $_SESSION["ID"]?>&page=edit">
                <img class="img-profile" src="img/users/<?php echo $user_row["img"] ?>" alt="Profile-picture">
            </a>
        </div>
        <div class="name">
            <a href="profile.php?id=<?php echo $_SESSION["ID"]?>&page=edit"
                class="bold main-color"><?php echo $user_row["full_name"] ?></a>
            <h6 class="bold"><?php echo $user_row["email"] ?></h6>
        </div>
        <nav class="navbar-list">
            <ul>
                <li class="active"><a href="front-page.php">Home</a></li>
                <li><a href="category.php?id=1">Men’s</a></li>
                <li><a href="category.php?id=2">Women’s</a></li>
                <li><a href="./shop.php?page=1">Shop</a></li>
                <li><a href="./blog.php">Blog</a></li>
                <li><a href="./contact.php">Contact</a></li>
                <li><a href="shop-cart.php"><span class="icon_bag_alt"></span>
                                <span class="tip cart-mobile"><?php echo $cart_count[0]; ?></span>
                            </a></li>
                <li><a href="log-out.php" class="exit"><i class="fas fa-sign-out-alt"></i></a></li>
            </ul>
        </nav>
    </div>
    <!-- =================== -->
</section>
<!-- Header Section for Mobile End -->