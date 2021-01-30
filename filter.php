


<?php

include_once("mysql_conn.php"); 

$qry ="SELECT DISTINCT * from productspec ps Inner Join specification s on ps.SpecId =s.SpecId where s.SpecName='Occasion' ";


$result2=$conn->query($qry);




// $MainContent.='<div class="col-12" id="slider"></div>';
if(isset($_GET["minPrice"]))
{
    $minPrice=$_GET['minPrice'];
}
else{
    $minPrice=0;
}
if(isset($_GET["maxPrice"])){
    $maxPrice=$_GET['maxPrice'];

}
else{
    $maxPrice=9999;
}


$MainContent.='<div id="myDropdown" class="col-4 border rounded" style="display:None;">';
$MainContent.= '<form action="" method="get">
<div class="form-group">
<h3 align="center">Filtered Search</h3>
<label for="range">Price Range</label>
<div class="row justify-content-center">
<input type="number" class="form-control col-lg-5 col-sm-11" name="minPrice" placeholder="Min Price" min=0 value=0>
<div class="input-group-addon col-1 d-flex justify-content-center"> - </div>

<input type="number" class="form-control col-lg-5 col-sm-11" name="maxPrice" placeholder="Max Price" min=0 value=9999>
</div>
</div>
<div class="form-group">
<label for="ocassion">Ocassion: </label>
<select class="form-control col-12" name="occasion">';
$MainContent.="<option value=''> ---Select One --- </option>" ;
while ($row2=$result2->fetch_array()) {
  
 $MainContent.="<option value='$row2[SpecVal]'> $row2[SpecVal] </option>" ;
 
}
$MainContent.='</select>';

// while ($row=$result->fetch_array()) {

// $MainContent.='<div class="form-check">
// <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
// <label class="form-check-label" for="defaultCheck1">
//   Default checkbox
// </label>
// </div>';


$MainContent.='</div>';

$MainContent.='<div class="float-right mt-25">';
$MainContent.='<input type="submit" class="button" value="Search">';
$MainContent.="<input type='hidden' name='catName' class='button' value='$_GET[catName]'>";
$MainContent.="<input type='hidden' name='cid' class='button' value='$_GET[cid]'>";
$MainContent.='</div>';
$MainContent.= '</form >';

$MainContent.='</div>';


    include_once('mysql_conn.php');
    if(isset($_GET["keywords"])){
    $_SESSION['keywords']=$_GET['keywords'];
    $SearchText="%".$_GET["keywords"]."%";
    }
    else{
        $SearchText="%";
    }
  

    // To Do (DIY): Retrieve list of product records with "ProductTitle" 
    // contains the keyword entered by shopper, and display them in a table.
    if (isset($_GET["minPrice"])){
        $_SESSION["minPrice"]=$_GET["minPrice"];
        $_SESSION["maxPrice"]=$_GET["maxPrice"];
        $_SESSION["occasion"]=$_GET["occasion"];
        $occasion= "%".$_GET["occasion"]."%";

        #case where the filter is being called from the search page
        if(!isset($_GET["cid"])){

            $qry= "SELECT p.*,ps.*,s.* FROM product p INNER JOIN productspec ps ON p.productId= ps.productId INNER JOIN specification s ON ps.specId= s.specId WHERE (ProductTitle LIKE ? OR ProductDesc LIKE ?) AND p.Price>= ? AND p.Price<=? AND s.SpecName='Occasion' AND (ps.SpecVal LIKE ?) ORDER BY ProductTitle";
            $stmt=$conn->prepare($qry);
            $stmt->bind_param('ssiis',$SearchText,$SearchText,$_GET['minPrice'],$_GET['maxPrice'],$occasion);
            $stmt->execute();
            $result=$stmt->get_result();

            $stmt->close();
            $conn->close(); // Close database connnection

        }
        #when it is in the product category page
        else{
            $qry= "SELECT p.*,ps.*,s.*,cp.* FROM product p INNER JOIN productspec ps ON p.productId= ps.productId INNER JOIN specification s ON ps.specId= s.specId INNER JOIN catProduct cp ON cp.productID = p.productID WHERE cp.categoryId= $cid AND p.Price>= ? AND p.Price<=? AND s.SpecName='Occasion' AND (ps.SpecVal LIKE ?)  ORDER BY ProductTitle";
            $stmt=$conn->prepare($qry);
            $stmt->bind_param('iis',$_GET['minPrice'],$_GET['maxPrice'],$occasion);
            $stmt->execute();
            $result=$stmt->get_result();
        }
    
 
    
    if ($result->num_rows>0){
        // header("location: catProduct.php?cid=$_GET[cid]&catName=$_GET[catName]&minPrice=$_GET[minPrice]&maxPrice=$_GET[maxPrice]");
        include('filteredResults.php');
     }
     else{
        $MainContent.='<div class="col-8">';
        $MainContent.="<h4 
        style='color:red'>No Record Found</h3>";
        $MainContent.='</div >';

     }
    }
	 //To Do (DIY): End of Code



?>


 <!-- <a class="dropdown-item" href="#">Action</a>
  <a class="dropdown-item" href="#">Another action</a>
  <a class="dropdown-item" href="#">Something e lse here</a>
  <div class="dropdown-divider"></div>
  <a class="dropdown-item" href="#">Separated link</a> -->