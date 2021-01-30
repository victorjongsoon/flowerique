<?php 
$MainContent.="<div class='col-12 auto-margin' align='center' style='padding:5px' id='product'>";
$MainContent.="<div class='row justify-content-center'  align='center' >";
while ($row=$result->fetch_array()) {


    $product="productDetails.php?pid=$row[ProductID]";
    $formmatedPrice= number_format($row["Price"],2);

    $MainContent.="<a href=$product>";
    $MainContent.="<div class='col-md-3 col-sm-4 category-product' name='productItem' >";
    $img = "./Images/Products/$row[ProductImage]";
    $MainContent.="<div class=float-right>";
    if (new DateTime() > new DateTime($row["OfferStartDate"]) and new DateTime() < new DateTime($row["OfferEndDate"])) {    $MainContent.="<span class='badge badge-pill badge-info'>On Offer!</span>";
    }


    $MainContent.="</div>";
    $MainContent.="<div class='auto-margin'>";
    $MainContent.="<img class='img-fluid ' src='$img'/>";

    $MainContent.="</div>";
    $MainContent.="<div>";
    $MainContent.="<p><a href=$product>$row[ProductTitle]</a></p>";
    // if($row['Offered']==1){
    //     $formmatedOfferedPrice=number_format($row["OfferedPrice"],2);
    //     $MainContent.= "Price: <span style='font-weight:bold;color:red;'><del>S$ $formmatedPrice</del> <ins class='offered-price d-inline'>S$$formmatedOfferedPrice</ins></span>";  
    // }

    if (new DateTime() > new DateTime($row["OfferStartDate"]) and new DateTime() < new DateTime($row["OfferEndDate"])) {
        $formmatedOfferedPrice=number_format($row["OfferedPrice"],2);
        $MainContent.= "Price: <span style='font-weight:bold;color:red;'><del>S$ $formmatedPrice</del> <ins class='offered-price d-inline'>S$$formmatedOfferedPrice</ins></span>";  
    }
    else{
        $MainContent.= "Price: <span style='font-weight:bold;color:red;'>S$ $formmatedPrice</span>";
    }

    $MainContent.="</div>";
    $MainContent.="</div>";

    $MainContent.="</a>";


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