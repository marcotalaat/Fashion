<?php include("database.php"); include("stmts.php"); ?>
<!-- Header Section Begin -->
<header class="header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-3 col-lg-2">
                <div class="header__logo">
                <?php if (!isset($_SESSION["Username"] )){ ?>
                    <a href="index.php"><img src="img/logo.png" alt=""></a>
                    <?php }else{
                        echo '<a href="dashboard.php"><img src="img/logo.png" alt=""></a>';
                    } ?>
                </div>
            </div>
            <div class="col-xl-6 col-lg-7">
                <nav class="header__menu">
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="category.php?id=1">Men’s</a></li>
                        <li><a href="category.php?id=2">Women’s</a></li>
                        <li><a href="./shop.php?page=1">Shop</a></li>
                        <li><a href="./blog.php">Blog</a></li>
                        <li><a href="./contact.php">Contact</a></li>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-3">
                <div class="header__right">
                    <div class="header__right__auth">
                    <?php if (isset($_SESSION["Username"] )){ ?>
                        <div class="position-relative">
                            <img class="img-profile" src="img/users/<?php echo $user_row["img"] ?>"
                                alt="Profile-picture">
                            <a
                                href="profile.php?id=<?php echo $_SESSION["ID"]?>&page=edit"><?php echo $_SESSION["Username"] ?></a>
                        </div>
                        <?php } else{
                            echo "<a href='log-in.php' ><span>Log in</span></a>";
                            echo "<a href='sing-up.php'><span>Sign Up</span></a>";
                        } ?>
                    </div>

                    <ul class="header__right__widget">
                        <li><span class="icon_search search-switch"></span></li>
                        <!--                             <li><a href="#"><span class="icon_heart_alt"></span>
                                <div class="tip">2</div>
                            </a></li> -->
                        <li><a href="shop-cart.php"><span class="icon_bag_alt"></span>
                        <?php if (isset($_SESSION["Username"] )){ ?>
                                <div class="tip"><?php echo $cart_count[0]; ?></div>
                                <?php } ?>
                            </a></li>
                            <?php if (isset($_SESSION["Username"] )){ ?>
                        <li><a href="log-out.php" class="exit"><i class="fas fa-sign-out-alt"></i></a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="canvas__open">
            <i class="fa fa-bars"></i>
        </div>
    </div>
</header>
<!-- Header Section End -->