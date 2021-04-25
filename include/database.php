<?php
/*    $dsn = "mysql:host=sql307.epizy.com;dbname=epiz_28391963_fashion";
    $user = "epiz_28391963";
    $pass = "TPDnl4Cp35zk";
    $option = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
    );
    
    try {
        $db = new PDO($dsn,$user,$pass,$option);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e){
        echo "Falied " . $e->getMessage();
    }  */
   $dsn = "mysql:host=localhost;dbname=fashion";
    $user = "root";
    $pass = "";
    $option = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
    );
    
    try {
        $db = new PDO($dsn,$user,$pass,$option);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e){
        echo "Falied " . $e->getMessage();
    } 