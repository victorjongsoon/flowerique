<?php 
$MainContent.="<div class='col-12 auto-margin' align='center' style='padding:5px'>";
$MainContent.="<div class='row justify-content-center'  align='center' >";
while ($row=$result->fetch_array()) {


$product="productDetails.php?pid=$row[ProductID]";
$formmatedPrice= number_format($row["Price"],2);

$MainContent.="<div class='col-md-3 col-sm-4 category-product'  >";
$img = "./Images/Products/$row[ProductImage]";

$MainContent.="<div class='auto-margin'>";
$MainContent.="<img class='img-fluid ' src='$img'/>";

$MainContent.="</div>";
$MainContent.="<div>";
$MainContent.="<p><a href=$product>$row[ProductTitle]</a></p>";
$MainContent.= "Price: <span style='font-weight:bold;color:red;'>S$ $formmatedPrice</span>";
$MainContent.="</div>";
$MainContent.="</div>";



}
$MainContent.="</div>";
$MainContent.="</div>";

    

?>
<!-- <?php 
// $MainContent.="<div class='col-12 auto-margin' align='center' style='padding:5px'>";
// $MainContent.="<div class='row justify-content-center'  align='center' >";
// while ($row=$result->fetch_array()) {


// $product="productDetails.php?pid=$row[ProductID]";
// $formmatedPrice= number_format($row["Price"],2);

// $MainContent.="<div class='col-md-3 category-product'  >";
// $MainContent.="<div>";
// $MainContent.="<p><a href=$product>$row[ProductTitle]</a></p>";
// $MainContent.= "Price: <span style='font-weight:bold;color:red;'>S$ $formmatedPrice</span>";
// $MainContent.="</div>";

// $img = "./Images/Products/$row[ProductImage]";

// $MainContent.="<div class='col-4 img-fluid'>";
// $MainContent.="<img  src='$img'/>";
// $MainContent.="</div>";

// $MainContent.="</div>";
// }
// $MainContent.="</div>";
// $MainContent.="</div>";

    

?> -->