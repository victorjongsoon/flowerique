<?php 
$MainContent.="<div class='col-xm-11  container auto-margin'  style='padding:5px' id='product'>";


$MainContent.="<div class='row center justify-content-center ' align='center'  >";

   

$index=0;
while ($row=$result->fetch_array()) {
    $validItem=False;

    if(isset($minPrice)){
        if (new DateTime() >= new DateTime($row["OfferStartDate"]) and new DateTime() <= new DateTime($row["OfferEndDate"])){
            if ($row["OfferedPrice"]>=$minPrice and $row["OfferedPrice"]<=$maxPrice){
                $validItem=True;
            }
        }
        else{

            if ($row["Price"]>=$minPrice and $row["Price"]<=$maxPrice){
                $validItem=True;
            }
        

        }
    }
    else{
        $validItem=True;
    }

    if($validItem==True){

    
        $index+=1;
        $product="productDetails.php?pid=$row[ProductID]";
        $formmatedPrice= number_format($row["Price"],2);

        $MainContent.="<a href=$product>";
        $MainContent.="<div class='col-md-3 col-sm-4 category-product' name='productItem' >";
        $img = "./Images/Products/$row[ProductImage]";
        $MainContent.="<div class=float-right>";
        if (new DateTime() >= new DateTime($row["OfferStartDate"]) and new DateTime() <= new DateTime($row["OfferEndDate"])) {    $MainContent.="<span class='badge badge-pill badge-info'>On Offer!</span>";
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

        if (new DateTime() >= new DateTime($row["OfferStartDate"]) and new DateTime() <= new DateTime($row["OfferEndDate"])) {
            $formmatedOfferedPrice=number_format($row["OfferedPrice"],2);
            $MainContent.= "Price: <span ><del >S$ $formmatedPrice</del> <ins class='offered-price d-inline'style='font-weight:bold;color:red;'>S$$formmatedOfferedPrice</ins></span>";  
        }
        else{
            $MainContent.= "Price: <span style='font-weight:bold;color:red;'>S$ $formmatedPrice</span>";
        }
        if($row["Quantity"]<=0){
            $MainContent.= " <div style='font-weight:bold;color:red;'>Currently Out of Stock!</div>";
        }
        $MainContent.="</div>";
        $MainContent.="</div>";
        // $MainContent.="</div>";


        $MainContent.="</a>";
    }

}
//to add hiddeen divs to fill up empty space to make layout consistent
//only when it is more than one row

if($index>3){


for ($i=0;$i<3;$i++ ){

    if($index%3==0)
        break;
    $MainContent.="<div class='col-md-3 col-sm-4 category-product' name='productItem' style='visibility:hidden;' >";
    $MainContent.="</div>";
    $index+=1;


}
}
else if($index==0 and $result->num_rows>0){

    $MainContent.="<h4 
    style='color:red'>No Record Found</h4>";
}

$MainContent.="</div>";
$MainContent.="</div>";
// $MainContent.="</div>";


    

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