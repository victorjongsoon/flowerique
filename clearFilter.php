<?php
    session_start();
    unset($_SESSION["minPrice"]);
    unset($_SESSION["maxPrice"]);
    unset($_SESSION["occasion"]);
    if(!isset($_GET['keywords'])){
        header("location: catProduct.php?cid=$_GET[cid]&catName=$_GET[catName]");
    }
    else{
        header("location: search.php?keywords=$_GET[keywords]");

    }
   
?>