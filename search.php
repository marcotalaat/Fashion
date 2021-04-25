<?php
session_start();
ob_start();
include("include/inc.php");
    // search result
            $search = $_POST["search"];
            $search_res = $db->prepare("
            SELECT * FROM products WHERE name LIKE '%$search%' OR price LIKE '%$search%' ");
            $search_res->execute();
            $search_res_row = $search_res->fetchAll();
            ?>
        <section class="sh-product"> <!-- Search Result of products -->
            <div class="container">
            <h2 class="bold main-color text-center p-5">Search Result: </h2>
                <div class="row">
                    <?php foreach ($search_res_row as $search_one){ ?>
                    <div class="col-sm-12 col-md-6 col-lg-4">
                        <div>
                            <img class="img-fluid img-product" src="img/product/<?php echo $search_one["img"] ?>">
                            <h5 class="text-center p-3"><a href="product.php?id=<?php echo $search_one["id"] ?>&page=view"><?php echo $search_one["name"] ?></a></h5>
                            <h6 class="text-center p-1 bold main-color"><?php echo "$ " . $search_one["price"] ?></h6>
                        </div>
                    </div>
                    <?php } // end of loop ?>
                </div> <!-- End of row -->
            </div> <!-- End of Conatiner -->
        </section>
        <?php



        include("include/instagram.php");
        include("include/footer.php");
?>