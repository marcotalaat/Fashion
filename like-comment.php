<?php
session_start();
if (isset($_SESSION["Username"])){
ob_start();
include("include/database.php");
$comment_id = $_POST["comment_id"];
$like = $db->prepare("UPDATE comments SET ONE(likes = likes + 1) WHERE id = $comment_id");
$like->execute();

} ?>