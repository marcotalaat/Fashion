<?php
include("database.php");
    // Title of Pages
    function get_title() {
        global $title;
        if (isset($title)){
            echo $title;
        }else{
            echo "Defult";
        }
    }

    // stmt users
    $stmt = $db->prepare("SELECT * FROM users");
    $stmt->execute();
    $row = $stmt->fetchAll();

    // Format images Allowed
    function img_allowed(){
        return array("jpg", "jpeg", "png", "gif");
    };
