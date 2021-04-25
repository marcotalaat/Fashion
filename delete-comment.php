<?php
session_start();
if (isset($_SESSION["Username"])){
ob_start();
include("include/database.php");

    //Delete Comment
    $comment_id = $_POST["comment_id"];
    $delete_comment = $db->prepare("DELETE FROM comments WHERE id = $comment_id");
    $delete_comment->execute();
}
 ?>
