<?php include("database.php"); include("stmts.php"); ?>

<!-- Offcanvas Menu Begin -->

<div class="offcanvas-menu-overlay"></div>

<div class="offcanvas-menu-wrapper">

    <div class="offcanvas__close">+</div>

    <ul class="offcanvas__widget">

        <li><span class="icon_search search-switch"></span></li>

        <li><a href="shop-cart.php"><span class="icon_bag_alt"></span>
                <?php if(isset($_SESSION["Username"])){ ?>
                <div class="tip"><?php echo $cart_count[0]; ?></div>


            </a></li>
        <li><a href="log-out.php" class="exit"><i class="fas fa-sign-out-alt"></i></a></li>
        <?php } else{
            echo " <a href='log-in.php' class='p-2'><span>Log in</span></a> / ";
            echo "<a href='sing-up.php' class='p-2'><span>Sign Up</span></a>";
        } ?>

    </ul>

    <div class="offcanvas__logo">

        <?php if (!isset($_SESSION["Username"] )){ ?>
        <a href="index.php"><img src="img/logo.png" alt=""></a>
        <?php }else{
                        echo '<a href="dashboard.php"><img src="img/logo.png" alt=""></a>';
        } ?>

    </div>

    <div id="mobile-menu-wrap"></div>

    <div class="offcanvas__auth">

    </div>


    <?php if(isset($_SESSION["Username"])){ ?>
    <a href="profile.php?id=<?php echo $_SESSION["ID"]?>&page=edit">

        <img class="img-profile" src="img/users/<?php echo $user_row["img"] ?>" alt="Profile-picture">
        <?php } ?>
    </a>



</div>

<!-- Offcanvas Menu End -->