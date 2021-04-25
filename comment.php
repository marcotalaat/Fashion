<?php
session_start();
if (isset($_SESSION["Username"])){
ob_start();
include("include/inc.php");
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $comment = filter_var($_POST["comment"], FILTER_SANITIZE_SPECIAL_CHARS);
        $user_id = $_POST["user"];
        $blog_id = $_POST["post"];

        $stmt_comm = $db->prepare("INSERT INTO comments (comment, datetime,user_id, blog_id) 
                                                                            VALUES (:comment, now(),:user_id, :blog_id)");
        $stmt_comm->execute(array(
            "comment" => $comment,
            "user_id" => $user_id,
            "blog_id" => $blog_id
        ));
    }
}