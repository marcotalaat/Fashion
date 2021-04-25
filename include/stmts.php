<?php
    /* ============================================================== 
    =======================USERS TABLE============================= */
    if (isset($_SESSION["Username"] )){
    $user = $db->prepare("SELECT * FROM users WHERE id = ?");
    $user->execute(array($_SESSION["ID"]));
    $user_row = $user->fetch();
    }
    /* ============================================================== 
    =======================CATEGORIES TABLE======================== */
    // Select All Categories
    $all_cats = $db->prepare("SELECT * FROM categories");
    $all_cats->execute();
    $all_cats_row = $all_cats->fetchAll();

/*     // Select first row in categories table
    $one_cat = $db->prepare("SELECT * FROM categories LIMIT 1");
    $one_cat->execute();
    $one_cat_row = $one_cat->fetch(); */

    // Select all rows in categories except first
    $cats = $db->prepare("SELECT * FROM `categories` LIMIT 4");
    $cats->execute();
    $cats_row = $cats->fetchAll();
    /* ============================================================== */

    /* ============================================================== 
    =======================PRODUCTS TABLE======================== */
    // Select All Categories
    $all_pro = $db->prepare("SELECT * FROM products LIMIT 9");
    $all_pro->execute();
    $all_pro_row = $all_pro->fetchAll();
    /* ============================================================== */

    /* ============================================================== 
    =======================BLOG TABLE============================== */
    // Get username
    $author = $db->prepare("SELECT users.username FROM users INNER JOIN blog ON users.id = blog.author_id");
    $author->execute();
    $author_row = $author->fetch();

    /* ============================================================== 
    =======================COMMENT TABLE========================== */
    // Get username
    $comment_img = $db->prepare("SELECT users.img FROM users INNER JOIN comments ON users.id = comments.user_id");
    $comment_img->execute();
    $comment_img_row = $comment_img->fetch();

    /* ============================================================== 
    =======================BLOG TABLE============================== */
    // Select All Blogs
    $all_blog = $db->prepare("SELECT * FROM blog LIMIT 5");
    $all_blog->execute();
    $all_blog_row = $all_blog->fetchAll();
    /* ============================================================== */

    /* ============================================================== 
    =======================BLOG TABLE============================== */
    // Select All Tags
    $all_tags = $db->prepare("SELECT tags FROM blog");
    $all_tags->execute();
    $all_tags_row = $all_tags->fetchAll();
    /* ============================================================== */

    /* ============================================================== 
    =======================SHOP CART TABLE========================= */
    // Select All Tags
    if (isset($_SESSION["Username"] )){
    $cart_total = $db->prepare("SELECT COUNT(id) FROM cart WHERE owner_id = ?");
    $cart_total->execute(array($_SESSION["ID"]));
    $cart_count = $cart_total->fetch();
    }
    /* ============================================================== */