<?php
    session_start();
    unset($_SESSION["minPrice"]);
    unset($_SESSION["maxPrice"]);
    unset($_SESSION["occasion"]);
    header("location: catProduct.php?cid=$_GET[cid]&catName=$_GET[catName]");

?>