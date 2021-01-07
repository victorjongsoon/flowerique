<?php 
$MainContent.="<div class='row' style='padding:5px'>";
$product="productDetails.php?pid=$row[ProductID]";
$formmatedPrice= number_format($row["Price"],2);
$MainContent.="<div class='col-8'>";
$MainContent.="<p><a href=$product>$row[ProductTitle]</a></p>";
$MainContent.= "Price: <span style='font-weight:bold;color:red;'>S$ $formmatedPrice</span>";
$MainContent.="</div>";

$img = "./Images/Products/$row[ProductImage]";

$MainContent.="<div class='col-4'>";
$MainContent.="<img  src='$img'/>";
$MainContent.="</div>";

$MainContent.="</div>";
?>