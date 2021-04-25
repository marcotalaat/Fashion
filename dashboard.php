<?php
session_start();
ob_start();
if(isset($_SESSION['Username'])){
include("include/inc.php");
?>
<?php
        if ($_SESSION["Admin"] == 1){ // if admin

        // Take data from category form
    if (isset($_POST["request"])){
        if ($_POST["request"] == "form_cat"){
            $cat_name = filter_var($_POST["cat_name"], FILTER_SANITIZE_SPECIAL_CHARS );
            $cat_desc = filter_var($_POST["cat_desc"], FILTER_SANITIZE_SPECIAL_CHARS);
            $cat_owner = $_POST["cat_owner"];
    
            // Image of category and it's variables
            $cat_img = $_FILES["cat_img"];
            $cat_img_name = $_FILES["cat_img"]["name"];
            $cat_img_type = $_FILES["cat_img"]["type"];
            $cat_img_tmp = $_FILES["cat_img"]["tmp_name"];
            
            $cat_exp = explode(".", $cat_img_name);
            $cat_name_format = strtolower(end($cat_exp));
            if (in_array($cat_name_format, img_allowed())){
                $cat_final_name = rand(0,10000) . "_" . $cat_img_name;
                move_uploaded_file($cat_img_tmp, "img/categories/" . $cat_final_name);
            }

            // Form Errors of Category
            $cat_errors = array();
            // Cat Name
            if(strlen($cat_name) == ""){
                $cat_errors[] = "Category name oblegatory";
            }
            if(strlen($cat_name) != "" && strlen($cat_name) < 2){
                $cat_errors[] = "Category name must not be less than 3 charachters";
            }

            // Cat Description
            if(strlen($cat_desc) == ""){
                $cat_errors[] = "Category description oblegatory";
            }
            if(strlen($cat_desc) != "" && strlen($cat_desc) < 4){
                $cat_errors[] = "Category description must not be less than 4 charachters";
            }
            // Cat Photo
            if(strlen($cat_name_format) == ""){
                $cat_errors[] = "Category photo oblegatory";
            }

            if(empty($cat_errors)){
                $cat_insert = $db->prepare("INSERT INTO categories (name, description, owner, cat_img) 
                                                                    VALUES (:name, :desc, :owner, :img)");
                    $cat_insert->execute(array(
                        "name" => $cat_name,
                        "desc"  => $cat_desc,
                        "owner" => $cat_owner,
                        "img" => $cat_final_name
                    ));
                header("location: front-page.php");
                exit;
            }
        }elseif ($_POST["request"] == "form_blog"){
            
        // Receive data from blog form
        $author_id = filter_var($_POST["author"], FILTER_SANITIZE_SPECIAL_CHARS);
        $post = filter_var($_POST["post"], FILTER_SANITIZE_SPECIAL_CHARS);
        $tags = filter_var($_POST["tags"], FILTER_SANITIZE_SPECIAL_CHARS);
        
        // Upload photo
        $post_img = $_FILES["post-img"];
        $post_img_name = $_FILES["post-img"]["name"];
        $post_img_type = $_FILES["post-img"]["type"];
        $post_img_tmp = $_FILES["post-img"]["tmp_name"];
    
        $post_exp = explode(".", $post_img_name);
        $post_meme = strtolower(end($post_exp));
        if (in_array($post_meme, img_allowed())){
            $post_last_name = rand(0, 100000) . "_" . $post_img_name;
            //copy($post_img_tmp, "img\blog\\" . $post_last_name);
            move_uploaded_file($post_img_tmp, "img/blog/" . $post_last_name);
        }
        // Form Errors of Post
        $post_errors = array();
        // Post Content
        if(strlen($post) == ""){
            $post_errors[] = "Post content oblegatory";
        }
        if(strlen($post) != "" && strlen($post) < 2){
            $post_errors[] = "Post content must not be less than 3 charachters";
        }

        // Post Tags
        if(strlen($tags) == ""){
            $post_errors[] = "Tags oblegatory";
        }

        // Post Photo
        if(strlen($post_meme) == ""){
            $post_errors[] = "Post photo oblegatory";
        }

        // Insert data in table blog
        if(empty($post_errors)){
        $blog = $db->prepare("INSERT INTO blog(author_id,post, tags,img, datetime) VALUES(:author_id,:post, :tags,:img, now())");
        $blog->execute(array(
            "author_id" => $author_id,
            "post" => $post,
            "tags" => $tags,
            "img" => $post_last_name
        ));
        header("location: blog.php");
        $db = NULL;
        exit;
        }// End Post Error

        }elseif ($_POST["request"] == "form_pro"){
                    // Convert Array to string to store in database in color and size
        $color = filter_var($_POST["color"], FILTER_SANITIZE_SPECIAL_CHARS);

        $size = @($_POST["size"]);

        // Get product details 
        $pro_name = filter_var($_POST["pro_name"], FILTER_SANITIZE_SPECIAL_CHARS);
        $pro_desc =  filter_var($_POST["pro_desc"], FILTER_SANITIZE_SPECIAL_CHARS);
        $made = filter_var($_POST["made"], FILTER_SANITIZE_SPECIAL_CHARS);
        $sale = @($_POST["sale"]);
        $trend = @($_POST["trend"]);
        $seller = @($_POST["seller"]);
        $feature = @($_POST["feature"]);
        $price = filter_var($_POST["price"], FILTER_SANITIZE_SPECIAL_CHARS);
        $category = @($_POST["category"]);
        $pro_owner = $_POST["pro_owner"];

        // Image of category and it's variables
        $pro_img = $_FILES["pro_img"];
        $pro_img_name = $_FILES["pro_img"]["name"];
        $pro_img_type = $_FILES["pro_img"]["type"];
        $pro_img_tmp = $_FILES["pro_img"]["tmp_name"];
        
        $pro_exp = explode(".", $pro_img_name);
        $pro_name_format = strtolower(end($pro_exp));
        if (in_array($pro_name_format, img_allowed())){
            $pro_final_name = rand(0,10000) . "_" . $pro_img_name;
            move_uploaded_file($pro_img_tmp, "img/product/" . $pro_final_name);
        }

        // Products Form Errors
        $product_errors = array();
        // Product Name
        if(strlen($pro_name) == ""){
            $product_errors[] = "Product description oblegatory";
        }
        if(strlen($pro_name) != "" && strlen($pro_name) < 2){
            $product_errors[] = "Product description must not be less than 2 charachters";
        }

        // Product description
        if(strlen($pro_desc) == ""){
            $product_errors[] = "Product description oblegatory";
        }
        if(strlen($pro_desc) != "" && strlen($pro_desc) < 5){
            $product_errors[] = "Product description must not be less than 5 charachters";
        }
        // Product Made
        if(strlen($made) == ""){
            $product_errors[] = "Product description oblegatory";
        }
        if(strlen($made) != "" && strlen($pro_desc) < 1){
            $product_errors[] = "Product description must not be less than 1 charachters";
        }
        //Product Price
        if($price == ""){
            $product_errors[] = "Price oblegatory";
        }
        //Product Color
        if($color == ""){
            $product_errors[] = "Color oblegatory";
        }
        //Product Size
        if($size == ""){
            $product_errors[] = "Size oblegatory";
        }

        // Product Sale & Trend & Seller & Feature & Category
        if($sale == ""){
            $product_errors[] = "Sale oblegatory";
        }
        if($trend == ""){
            $product_errors[] = "Trend oblegatory";
        }
        if($seller == ""){
            $product_errors[] = "Seller oblegatory";
        }
        if($feature == ""){
            $product_errors[] = "Feature oblegatory";
        }
        if($category == ""){
            $product_errors[] = "Category oblegatory";
        }
        // Product Photo
        if(strlen($pro_name_format) == ""){
            $product_errors[] = "Product Photo oblegatory";
        }

        // Insert product in database
        if(empty($product_errors)){

            $color_imp = implode(" ", $color);
            $color_exp = explode(" ", $color_imp);
            $size_imp = implode(" ", $size);
            
       $cat_insert = $db->prepare("INSERT INTO
             products (owner, name, description, size,price, sale, made, color, img, category, trend, best_seller, feature) 
            VALUES (:owner, :name, :desc, :size,:price, :sale, :made, :color, :img, :category, :trend, :seller, :feature)");
        $cat_insert->execute(array(
            "owner" => $pro_owner,
            "name"  => $pro_name,
            "desc" => $pro_desc,
            "size" => $size_imp,
            "price"  => $price,
            "sale"  => $sale,
            "made"  => $made,
            "color"  => $color_imp,
            "category" => $category,
            "trend" => $trend,
            "seller" => $seller,
            "feature" => $feature,
            "img" => $pro_final_name
        ));
        header("location: front-page.php");
        exit;
        }
    }
    } // End if of POST REQUEST
    ?>
<section class="dashboard">
    <div class="container">
        <div class="row">

            <!-- Content of dashboard -->
            <div class="col-sm-12 col-lg-8">
                <!--===================================================== 
            ========================Post in Blog page==================
            ======================================================== -->
                <section class="manage-blog">
                    <div class="for-popup">
                        <h2 class="bold main-background white-color title"><i class="fas fa-blog"></i> Blog</h2>
                    </div>
                    <div class="pop-up">
                        <form action="<?php $_SERVER["PHP_SELF"] ?>" method="POST" enctype="multipart/form-data"
                            class="p-0">
                            <?php 
                        if (!empty($post_errors)){
                            foreach($post_errors as $post_error){
                                echo "<div class='alert alert-danger' >" . $post_error . "</div>";
                            }
                        }
                        ?>
                            <input type="hidden" name="request" value="form_blog">
                            <input type="hidden" name="author" value="<?php echo $_SESSION["ID"] ?>">
                            <div class="form-group">
                                <label for="post">Post</label>
                                <textarea name="post" class="form-control" id="post"
                                    placeholder="Your post..."></textarea>
                            </div>
                            <div class="form-group">
                                <label for="post" class="d-block">Tag(s) <span class="faint-color">(Separate by
                                        space)</span> </label>
                                <input type="text" id="tags" class="form-control" name="tags">
                            </div>
                            <div class="form-group">
                                <label for="post-img" class="upload"><i class="fas fa-upload"></i> Upload Photo</label>
                                <input type="file" id="post-img" name="post-img">
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Post">
                            </div>
                        </form>
                    </div>
                </section>

                <!--===================================================== 
            ========================Category=========================
            ======================================================== -->
                <section class="category">
                    <div class="mange-cat for-popup">
                        <h2 class="bold main-background white-color title"><i class="fas fa-th-list"></i> Manage
                            Category</h2>
                    </div>
                    <div class="pop-up">
                        <button class="show-table">Show All Category</button>
                        <table class="table hide">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Mange</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($all_cats_row as $single_cat) {?>
                                <tr>
                                    <th scope="row"><?php echo $single_cat["id"] ?></th>
                                    <td>
                                        <img src="img/categories/<?php echo $single_cat["cat_img"] ?>" class="img-fluid"
                                            style="width:60px; height:50px">
                                    </td>
                                    <td><?php echo $single_cat["name"] ?></td>
                                    <td><?php echo $single_cat["description"] ?></td>
                                    <td>

                                        <a href="categories.php?cat=edit&id=<?php echo $single_cat["id"] ?>">
                                            <button class="btn btn-success">Edit</button>
                                        </a>

                                        <a href="categories.php?cat=delete&id=<?php echo $single_cat["id"] ?>">
                                            <button class="btn btn-danger">Delete</button>
                                        </a>
                                    </td>
                                </tr>
                                <?php }?>
                            </tbody>
                        </table>

                        <form action="<?php $_SERVER["PHP_SELF"] ?>" method="POST" enctype="multipart/form-data">
                            <?php 
                        if (!empty($cat_errors)){
                            foreach($cat_errors as $cat_error){
                                echo "<div class='alert alert-danger' >" . $cat_error . "</div>";
                            }
                        }
                        ?>
                            <input type="hidden" name="request" value="form_cat">
                            <div class="form-group">
                                <label for="name">Category Name</label>
                                <input type="text" name="cat_name" class="form-control" id="name">
                            </div>
                            <div class="form-group">
                                <label for="cat_img" class="upload"><i class="fas fa-upload"></i> Upload Photo</label>
                                <input type="file" id="cat_img" name="cat_img">
                            </div>
                            <div class="form-group">
                                <label for="cat-desc">Description</label>
                                <textarea name="cat_desc" class="form-control" id="cat-desc"
                                    placeholder="Write short description, please..."></textarea>
                            </div>
                            <input type="number" name="cat_owner" value="<?php echo $_SESSION["ID"] ?>" hidden>
                            <input type="submit" value="Add Category" class="btn main-background white-color">
                        </form>
                    </div>
                </section>
                <!--===================================================== 
            ========================Products=========================
            ======================================================== -->
                <section class="manage-product">
                    <div class="for-popup">
                        <h2 class="bold main-background white-color title"><i class="fas fa-box-open"></i> Manage
                            Product
                        </h2>
                    </div>
                    <div class="pop-up">
                        <form action="<?php $_SERVER["PHP_SELF"] ?>" method="POST" enctype="multipart/form-data">
                            <?php 
                        if (!empty($product_errors)){
                            foreach($product_errors as $product_error){
                                echo "<div class='alert alert-danger' >" . $product_error . "</div>";
                            }
                        }
                        ?>
                            <input type="hidden" name="request" value="form_pro">
                            <div class="form-group">
                                <label for="name">Product Name</label>
                                <input type="text" name="pro_name" class="form-control" id="name">
                            </div>
                            <div class="form-group">
                                <label for="pro_img" class="upload"><i class="fas fa-upload"></i> Upload Photo</label>
                                <input type="file" id="pro_img" name="pro_img">
                            </div>
                            <div class="form-group">
                                <label for="pro-desc">Description</label>
                                <textarea name="pro_desc" class="form-control" id="pro-desc"
                                    placeholder="Write short description, please..."></textarea>
                            </div>
                            <div class="form-check p-0">
                                <h5>Size</h5>
                                <div class="p-4 d-inline">
                                    <input class="form-check-input" type="checkbox" name="size[]" value="s" id="s">
                                    <label class="form-check-label" for="s">S</label>
                                </div>
                                <div class="p-3 d-inline">
                                    <input class="form-check-input" type="checkbox" name="size[]" value="xs" id="xs">
                                    <label class="form-check-label" for="xs">XS</label>
                                </div>
                                <div class="p-3 d-inline">
                                    <input class="form-check-input" type="checkbox" name="size[]" value="xxs" id="xxs">
                                    <label class="form-check-label" for="xxs">XXS</label>
                                </div>
                                <div class="p-3 d-inline">
                                    <input class="form-check-input" type="checkbox" name="size[]" value="xss" id="xss">
                                    <label class="form-check-label" for="xss">XSS</label>
                                </div>
                                <div class="p-3 d-inline">
                                    <input class="form-check-input" type="checkbox" name="size[]" value="m" id="m">
                                    <label class="form-check-label" for="m">M</label>
                                </div>
                                <div class="p-3 d-inline">
                                    <input class="form-check-input" type="checkbox" name="size[]" value="ml" id="ml">
                                    <label class="form-check-label" for="ml">ML</label>
                                </div>
                                <div class="p-3 d-inline">
                                    <input class="form-check-input" type="checkbox" name="size[]" value="l" id="l">
                                    <label class="form-check-label" for="l">L</label>
                                </div>
                                <div class="p-3 d-inline">
                                    <input class="form-check-input" type="checkbox" name="size[]" value="xl" id="xl">
                                    <label class="form-check-label" for="xl">XL</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="price">Product Price</label>
                                <input type="number" min="1" name="price" class="form-control" id="price">
                            </div>
                            <div class="form-group">
                                <label for="made">Made In...</label>
                                <input type="text" name="made" class="form-control" id="made">
                            </div>
                            <div class="form-group">
                                <label for="color">Color</label>
                                <input type="text" name="color[]" class="form-control" id="color">
                            </div>
                            <div class="sale">
                                <h5>Has Sale?</h5>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="sale" id="sale-yes" value="1">
                                    <label class="form-check-label" for="sale-yes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="sale" id="sale-no" value="0">
                                    <label class="form-check-label" for="sale-no">No</label>
                                </div>
                            </div>
                            <div class="sale">
                                <h5>Trend ?</h5>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="trend" id="trend-yes" value="1">
                                    <label class="form-check-label" for="trend-yes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="trend" id="trend-no" value="0">
                                    <label class="form-check-label" for="trend-no">No</label>
                                </div>
                            </div>
                            <div class="sale">
                                <h5>Best Seller ?</h5>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="seller" id="seller-yes"
                                        value="1">
                                    <label class="form-check-label" for="seller-yes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="seller" id="seller-no" value="0">
                                    <label class="form-check-label" for="seller-no">No</label>
                                </div>
                            </div>
                            <div class="sale">
                                <h5>Feature ?</h5>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="feature" id="feature-yes"
                                        value="1">
                                    <label class="form-check-label" for="feature-yes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="feature" id="feature-no"
                                        value="0">
                                    <label class="form-check-label" for="feature-no">No</label>
                                </div>
                            </div>
                            <div class="category">
                                <h5>Category</h5>
                                <?php foreach ($all_cats_row as $cat){ ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="category"
                                        id="<?php echo $cat["id"] ?>" value="<?php echo $cat["id"] ?>">
                                    <label class="form-check-label"
                                        for="<?php echo $cat["id"] ?>"><?php echo $cat["name"] ?></label>
                                </div>
                                <?php } ?>
                            </div>
                            <input type="number" name="pro_owner" value="<?php echo $_SESSION["ID"] ?>" hidden>
                            <input type="submit" value="Add Product" class="btn main-background white-color">
                        </form>
                    </div>
                </section>

            </div>
            <!-- Content of dashboard End -->

            <?php
            //Get Counts from tables
            $count = "SELECT 
            ( SELECT COUNT(id) FROM users), 
            (SELECT COUNT(id) FROM categories ),
            (SELECT COUNT(id) FROM products ),
            (SELECT COUNT(id) FROM blog )";
            $stmt = $db->prepare($count);
            $stmt->execute();
            $row_count = $stmt->fetch();

            ?>

            <!-- SideBar -->
            <div class="col-sm-12 col-lg-4">
                <div class="sidebar">
                    <h4 class="white-color bold p-1">Statistics</h4>
                    <ul>
                        <li>Users <span><?php echo $row_count[0] ?></span></li>
                        <li>Categories <span><?php echo $row_count[1] ?></span></li>
                        <li>Products <span><?php echo $row_count[2] ?></span></li>
                        <li>Posts <span><?php echo $row_count[3] ?></span></li>
                    </ul>
                </div>
            </div>
            <!-- SideBar End -->
        </div>
    </div>

</section>

<?php
        }else{ // if not admin
            echo "Hello person";



        } // end if of Admin or not
    } // End if of Session Username (Main)
    include("include/footer.php");