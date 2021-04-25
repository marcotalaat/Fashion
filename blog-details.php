<?php
session_start();
ob_start();
include("include/inc.php");
?>
<?php 

        $post_id = $_GET["id"];
        $page = $_GET["page"];

        if (isset($post_id) && is_numeric($post_id)){
            $stmt_post = $db->prepare("SELECT * FROM blog WHERE id = ?");
            $stmt_post->execute(array($post_id));
            $post = $stmt_post->fetch();

            // Get Max id
            $id_stmt = $db->prepare("SELECT MAX(id) FROM `blog`");
            $id_stmt->execute();
            $id_row = $id_stmt->fetch();
            $id = $id_row[0];

            //Get number of comments
            $num_comment = $db->prepare("SELECT COUNT(comment) FROM comments WHERE blog_id = ?");
            $num_comment->execute(array($post_id));
            $num_comment_row = $num_comment->fetch();
            
            //insert in comments table
            if ($_SERVER["REQUEST_METHOD"] == "POST"){

                if ($_POST["request_comment"] == "req_comment"){

                //Comment stmt
/*                 $comment = filter_var($_POST["comment"], FILTER_SANITIZE_SPECIAL_CHARS);
                $user_id = $_POST["user"];
                $blog_id = $_POST["post"];

                $stmt_comm = $db->prepare("INSERT INTO comments (comment, datetime,user_id, blog_id) 
                                                                                    VALUES (:comment, now(),:user_id, :blog_id)");
                $stmt_comm->execute(array(
                    "comment" => $comment,
                    "user_id" => $user_id,
                    "blog_id" => $blog_id
                ));
                header("location: blog-details.php?id=$post_id&page=view");
                exit; */
            }elseif($_POST["request_comment"] == "req_reply"){
                $reply = filter_var($_POST["reply"], FILTER_SANITIZE_SPECIAL_CHARS);
                $user_reply = $_POST["user_reply"];
                $post_reply = $_POST["post_reply"];
                $comment_reply = $_POST["comment_reply"];

                $stmt_reply = $db->prepare("
                INSERT INTO reply (reply, datetime, user_reply, main_comment, main_blog) 
                                VALUES (:reply, now(), :user_reply, :main_comment, :main_blog)");
                $stmt_reply->execute(array(
                    "reply" => $reply,
                    "user_reply" => $user_reply,
                    "main_comment" => $comment_reply,
                    "main_blog"=> $post_reply
                ));
                header("location: blog-details.php?id=$post_id&page=view");
                exit;
            }
        }
            // Get comment from comments table
            $get_comm = $db->prepare("SELECT * FROM comments WHERE blog_id = ?");
            $get_comm->execute(array($post_id));
            $fetch_comm = $get_comm->fetchAll();

            $get_user = $db->prepare("SELECT users.username FROM users INNER JOIN comments ON users.id = comments.user_id");
            $get_user->execute();
            $fetch_user = $get_user->fetch();

            $get_user_img = $db->prepare("SELECT users.img FROM users INNER JOIN comments ON users.id = comments.user_id");
            $get_user_img->execute();
            $fetch_user_img = $get_user_img->fetch();

/*             // Get number of likes
            $count_likes = $db->prepare("SELECT likes FROM comments WHERE id = $comment_id");
            $count_likes->execute();
            $res_count_likes = $count_likes->fetch();
            $count_likes_num = $res_count_likes[0]; */
        // View Single post
        if (isset($post_id) && is_numeric($post_id) && isset($page) && $page == "view"){
?>

<!-- Breadcrumb Begin -->
<div class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__links">
                    <a href="./front-page.php"><i class="fa fa-home"></i> Home</a>
                    <a href="./blog.php">Blog</a>
                    <span><?php echo substr($post["post"], 0, 20) . " ..."; ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Blog Details Section Begin -->
<section class="blog-details spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8">
                <div class="blog__details__content">
                    <div class="blog__details__item">
                        <!-- <img src="img/blog/details/blog-details.jpg" alt=""> -->
                        <div class="blog__details__item__title">
                            <!-- <span class="tip">Street style</span> -->
                            <div class="control float-right">
                                <a href="blog-details.php?id=<?php echo $post_id?>&page=edit" class="btn btn-success"><i
                                        class="fas fa fa-edit fa-1x"></i></a>
                                <a href="blog-details.php?id=<?php echo $post_id?>&page=delete"
                                    class="btn btn-danger delete"><i class="fas fa fa-trash fa-1x"></i></a>
                            </div>
                            <h4><?php echo substr($post["post"], 0, 20) . " ..."; ?></h4>
                            <ul>
                                <li>by <span><?php echo $author_row[0];?></span></li>
                                <li><i class="fas fa-calendar-week"></i>
                                    <?php echo date("d M - h a", strtotime($post["datetime"]) ); ?></li>
                                <li class="comment-count"><?php echo $num_comment_row[0]; ?> Comment(s)</li>
                            </ul>
                        </div>
                    </div>
                    <div class="poster-post p-3">
                        <img src="img\blog\<?php echo $post["img"]; ?>" class="img-fluid img-responsive" alt="poster">
                    </div>
                    <div class="blog__details__quote">
                        <div class="icon"><i class="fa fa-quote-left"></i></div>
                    </div>
                    <div class="blog__details__desc">
                        <p><?php echo $post["post"];?></p>
                    </div>
                    <div class="blog__details__tags">
                        <?php $tags_arr = explode(" ", $post["tags"]);
                        foreach ($tags_arr as $tag){
                    ?>
                        <span class="tag"><?php echo $tag;?></span>
                        <?php } ?>
                    </div>
                    <div class="blog__details__btns">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="blog__details__btn__item">
                                    <?php if ($post_id - 1 > 0){ ?>
                                    <h6><a href="?id=<?php echo $post_id - 1; ?>&page=view"><i
                                                class="fa fa-angle-left"></i> Previous posts</a></h6>
                                    <?php }else{echo "<span><i class='fa fa-angle-left'></i> Previous posts</span>"; } ?>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="blog__details__btn__item blog__details__btn__item--next">
                                    <?php if (($post_id + 1) <= $id){ ?>
                                    <h6><a href="?id=<?php echo $post_id + 1; ?>&page=view">Next posts <i
                                                class="fa fa-angle-right"></i></a></h6>
                                    <?php }else{echo "<span><i class='fa fa-angle-right'></i> Next posts</span>"; } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="blog__details__comment">
                        <h5 class="header-comment-number"><?php echo $num_comment_row[0]; ?> Comment(s)</h5>
                        <!-- <a href="#" class="leave-btn">Leave a comment</a> -->
                        <div class="blog__comment__item">
                            <section class="load-comment">
                                <!-- Loop Comment Box -->
                                <?php foreach($fetch_comm as $one_comment){ ?>
                                <div class="blog__comment__item__pic">
                                    <img src="img/users/<?php echo $fetch_user_img[0] ?>" alt="">
                                </div>
                                <div class="blog__comment__item__text">
                                <?php if(isset($_SESSION['Username']) && $_SESSION["Username"] == $fetch_user[0] ) { ?>
                                    <span class="delete delete-comment">
                                        <input type="hidden" class="delete-comment-id" value="<?php echo $one_comment["id"]; ?>">
                                        <i class="fas fa-times"></i>
                                    </span>
                                    <?php } ?>
                                    <h6><?php echo $fetch_user[0]; ?></h6>
                                    <p><?php echo $one_comment["comment"]; ?></p>
                                    <ul>
                                        <li><i class="fa fa-clock-o"></i>
                                            <?php echo date("M d,  Y", strtotime($one_comment["datetime"])); ?></li>
                                        <!-- <li><i class="fa fa-heart-o"></i> 12</li> -->
                                        <!--  <li class="reply"><i class="fa fa-share"></i> 1</li> -->
                                        <?php 
                                       
                                            // Get number of likes
                                            $count_likes = $db->prepare("SELECT likes FROM comments WHERE id = ?");
                                            $count_likes->execute(array($one_comment["id"]));
                                            $res_count_likes = $count_likes->fetch();
                                            $count_likes_num = $res_count_likes[0];
                                        ?>
                                        <li class="like-comment"><input type="hidden" class="comment-id"
                                                value="<?php echo $one_comment["id"]; ?>">
                                            <i class="far fa-heart" data-replace="fas"></i>
                                            <span class="number-likes"><?php echo $count_likes_num ?></span>
                                        </li>

                                        <!-- form of Reply -->
                                        <form action="<?php $_SERVER["PHP_SELF"] ?>" class="form-reply" method="POST">
                                            <input type="hidden" name="request_comment" value="req_reply">
                                            <input type="hidden" name="user_reply"
                                                value="<?php echo $_SESSION["ID"]; ?>">
                                            <input type="hidden" name="post_reply" value="<?php echo $post_id; ?>">
                                            <input type="hidden" name="comment_reply"
                                                value="<?php echo $one_comment["id"]; ?>">
                                            <div class="form-group">
                                                <textarea name="reply" class="form-control" id="reply"
                                                    placeholder="Your Reply..."></textarea>
                                            </div>
                                            <input type="submit" class="btn btn-primary" value="Raply">
                                        </form>
                                        <!-- End of form Reply -->

                                    </ul>
                                </div>
                                <hr>
                                <?php } ?>
                                <!-- End Loop Comment Box -->
                            </section>
                        </div>
                        <?php if(isset($_SESSION['Username'])) { ?>
                        <!-- form of comment -->
                        <form action="comment.php" method="POST" id="form-comment">
                            <input type="hidden" name="request_comment" class="request_comment" value="req_comment">
                            <input type="hidden" name="user" class="user" value="<?php echo $_SESSION["ID"]; ?>">
                            <input type="hidden" name="post" class="post" value="<?php echo $post_id; ?>">
                            <div class="form-group">
                                <textarea name="comment" class="form-control comment" id="post"
                                    placeholder="Your comment..." ></textarea>
                            </div>
                            <input type="button" class="btn btn-primary add-comment" value="Add Comment">
                        </form>
                        <!-- End of form comment -->
                        <?php }else{
                            echo "You must register to add comment(s)
                             <a href='log-in.php' target='_blank' class='main-color'>Log in</a> OR 
                             <a href='sign-up.php' target='_blank' class='main-color'>Sing Up</a> ";
                        } ?>

                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="blog__sidebar">
                    <div class="blog__sidebar__item">
                        <div class="section-title">
                            <h4>Categories</h4>

                            <ul class="p-2">
                                <?php 
                            // Fetch all categoires
                            foreach ($all_cats_row as $cat){
                            ?>
                                <li><a href="category.php?id=<?php echo $cat["id"] ?>"><?php echo $cat["name"] ?></a>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>
                        <div class="blog__sidebar__item">
                            <div class="section-title">
                                <h4>Latest posts</h4>
                            </div>
                            <?php 
                            // Fetch all Blogs
                            foreach ($all_blog_row as $blog){
                            ?>
                            <a href="blog-details.php?id=<?php echo $blog["id"]; ?>&page=view"
                                class="blog__feature__item">
                                <div class="blog-img-sidebar">
                                    <img src="img/blog/<?php echo $blog["img"]; ?>" alt="">
                                </div>
                                <div class="blog__feature__item__text d-inline">
                                    <h6><?php echo substr($blog["post"], 0, 10) . " ..."; ?></h6>
                                    <span><?php echo date("M d, Y", strtotime($blog["datetime"])); ?></span>
                                </div>
                            </a>
                            <?php } ?>
                        </div>
                        <div class="blog__sidebar__item">
                            <div class="section-title">
                                <h4>Tags cloud</h4>
                            </div>
                            <div class="blog__sidebar__tags">
                                <?php 
                            // Fetch all Blogs
                            foreach ($all_tags_row as $tag){
                                $array_tag = explode(" ", $tag[0]);
                                foreach($array_tag as $one_tag){
                            ?>
                                <a href="#"><?php echo $one_tag; ?></a>
                                <?php }} ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
<!-- Blog Details Section End -->
<?php 
    } elseif(isset($post_id) && is_numeric($post_id) && isset($page) && $page == "edit"){ ?>
<div class="container">
    <h2 class="text-center main-color bold p-2">Edit Blog</h2>
    <div class="edit-blog">
        <form action="?id=<?php echo $post_id; ?>&page=update" method="POST" enctype="multipart/form-data">
            <div class="form-group position-relative edit-photo">
                <img src="img\blog\<?php echo $post["img"]; ?>" alt="poster">
                <label for="post-img" class="input-file"><i class="fas fa-upload"></i></label>
                <input type="file" id="post-img" value="<?php echo $post["img"]; ?>" name="post-img">
            </div>
            <input type="hidden" name="request" value="form_blog">
            <input type="hidden" name="request_comment" value="req_update">
            <input type="hidden" name="author" value="<?php echo $_SESSION["ID"] ?>">
            <div class="form-group">
                <label for="post">Post</label>
                <textarea name="post" class="form-control" id="post"
                    placeholder="Your post..."><?php echo $post["post"]; ?></textarea>
            </div>
            <div class="form-group">
                <label for="post" class="d-block">Tag(s) <span class="faint-color">(Separate by space)</span> </label>
                <input type="text" id="tags" class="form-control" name="tags" value="<?php echo $post["tags"]; ?>">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Update Post">
            </div>
        </form>
    </div>
</div>
<?php }elseif(isset($post_id) && is_numeric($post_id) && isset($page) && $page == "update"){
    
    if ($_POST["request_comment"] == "req_update"){
        // Receive data from blog form
        $author_id = filter_var($_POST["author"], FILTER_SANITIZE_SPECIAL_CHARS);
        $post = filter_var($_POST["post"], FILTER_SANITIZE_SPECIAL_CHARS);
        $tags = filter_var($_POST["tags"], FILTER_SANITIZE_SPECIAL_CHARS);

        // Update photo
        $post_img = $_FILES["post-img"];
        $post_img_name = $_FILES["post-img"]["name"];
        $post_img_type = $_FILES["post-img"]["type"];
        $post_img_tmp = $_FILES["post-img"]["tmp_name"];
    
        $post_exp = explode(".", $post_img_name);
        $post_meme = strtolower(end($post_exp));
        if (in_array($post_meme, img_allowed())){
            $post_last_name = rand(0, 100000) . "_" . $post_img_name;
            move_uploaded_file($post_img_tmp, "img\blog\\" . $post_last_name);
        }

        $update_blog = $db->prepare("UPDATE blog 
        SET author_id = ?, post = ?, tags = ?, img = ?,datetime = now() WHERE id = $post_id ");
        $update_blog->execute(array($author_id, $post, $tags, $post_last_name ));
        echo "Updated Done...";
        header("location: blog-details.php?id=$post_id&page=view");
        exit;
        }
    }elseif(isset($post_id) && is_numeric($post_id) && isset($page) && $page == "delete"){
        $delete_blog = $db->prepare("DELETE FROM blog WHERE id = ?");
        $delete_blog->execute(array($post_id));
        header("location: blog.php");
        exit;

    }
    ?>


<!-- Instagram Begin -->
<?php include("include/instagram.php"); ?>
<!-- Instagram End -->
<?php include("include/footer.php") ?>
<?php
        }else{
            echo "<div class='container'><h2 class='main-color'>Sorry you make a mistake :(</h2></div>";
            header("location: front-page.php");
            exit;
        }