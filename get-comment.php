<?php
session_start();
error_reporting(0);
if (isset($_SESSION["Username"])){
ob_start();
include("include/database.php");
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $post_id = $_POST["post_id"];
    if (isset($_POST["comment_id"])){
    $comment_id = $_POST["comment_id"];
        // Get number of likes
        $count_likes = $db->prepare("SELECT likes FROM comments WHERE id = ?");
        $count_likes->execute(array($comment_id));
        $res_count_likes = $count_likes->fetch();
        $count_likes_num = $res_count_likes[0];
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

    //Get number of comments
    $num_comment = $db->prepare("SELECT COUNT(comment) FROM comments WHERE blog_id = ?");
    $num_comment->execute(array($post_id));
    $num_comment_row = $num_comment->fetch();

?>

<input type="hidden" class="comment-number" value="<?php echo $num_comment_row[0]; ?>">
<!-- Loop Comment Box -->
<?php foreach($fetch_comm as $one_comment){ ?>
<div class="blog__comment__item__pic">
    <img src="img/users/<?php echo $fetch_user_img[0] ?>" alt="">
</div>
<div class="blog__comment__item__text">
    <span class="delete delete-comment">
        <input type="hidden" class="delete-comment-id" value="<?php echo $one_comment["id"]; ?>">
        <i class="fas fa-times"></i>
    </span>
    <h6><?php echo $fetch_user[0]; ?></h6>
    <p><?php echo $one_comment["comment"]; ?></p>
    <ul>
        <li><i class="fa fa-clock-o"></i>
            <?php echo date("M d,  Y", strtotime($one_comment["datetime"])); ?></li>
        <!-- <li><i class="fa fa-heart-o"></i> 12</li> -->
        <!--  <li class="reply"><i class="fa fa-share"></i> 1</li> -->
        <!-- form of Reply -->
        <li class="like-comment"><input type="hidden" class="comment-id" value="<?php echo $one_comment["id"]; ?>">
            <i class="far fa-heart" data-replace="fas"></i>
            <span class="number-likes"><?php echo $count_likes_num ?></span>
        </li>
        <form action="<?php $_SERVER["PHP_SELF"] ?>" class="form-reply" method="POST">
            <input type="hidden" name="request_comment" value="req_reply">
            <input type="hidden" name="user_reply" value="<?php echo $_SESSION["ID"]; ?>">
            <input type="hidden" name="post_reply" value="<?php echo $post_id; ?>">
            <input type="hidden" name="comment_reply" value="<?php echo $one_comment["id"]; ?>">
            <div class="form-group">
                <textarea name="reply" class="form-control" id="reply" placeholder="Your Reply..."></textarea>
            </div>
            <input type="submit" class="btn btn-primary" value="Raply">
        </form>
        <!-- End of form Reply -->

    </ul>
</div>
<hr>
<?php } }?>
<!-- End Loop Comment Box -->