<?php
session_start();
if(isset($_SESSION['Username'])){
ob_start();
include("include/inc.php");
    // Delete Single Order
    if (isset($_GET["id"]) && is_numeric($_GET["id"])){
        $single_order = $db->prepare("DELETE FROM cart WHERE id = ?");
        $single_order->execute(array($_GET["id"]));
        header("location: shop-cart.php");
        exit;
    }
}