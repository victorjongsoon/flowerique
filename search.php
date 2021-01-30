<?php 
// Detect the current session
session_start();

// // HTML Form to collect search keyword and submit it to the same page 
// // in server
$MainContent = "<div style='width:100%; margin:auto;'>"; // Container
// $MainContent .= "<form name='frmSearch' method='get' action=''>";
// $MainContent .= "<div class='form-group row'>"; // 1st row
$MainContent .= "<div class='row' style='padding:5px'>";
$MainContent .= "<div class='col-12'>";
$MainContent .= "<span class='page-title'>Search Result</span>";
$MainContent.='<div class="btn-group float-right">
<input type="button" onclick= "myFunction()" class="btn button dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" value="Filter">
  

';
$MainContent.='</div>';


$MainContent .= "<hr style='height:5px;color:gray;'/>";
$MainContent .= "</div>";

$MainContent .= "</div>";
// $MainContent .= "</div>"; // End of 1st row
// $MainContent .= "<div class='form-group row'>"; // 2nd row
// $MainContent .= "<label for='keywords' 
//                   class='col-sm-3 col-form-label'>Product Title:</label>";
// $MainContent .= "<div class='col-sm-6'>";
// if(isset($_GET['keywords'])){


// $MainContent .= "<input class='form-control' name='keywords' id='keywords' value='$_GET[keywords]' type='search' />";
// }
// else{
//     $MainContent .= "<input class='form-control' name='keywords' id='keywords'  type='search' />";
   
// }
// $MainContent .= "</div>";
// $MainContent .= "<div class='col-sm-3'>";
// $MainContent .= "<button class='btn btn-primary type='submit'>Search</button>";
// $MainContent .= "</div>";
// $MainContent .= "</div>";  // End of 2nd row
// $MainContent .= "</form>";

// The search keyword is sent to server
if (isset($_GET['keywords'])) {
    include_once('mysql_conn.php');
    // $_SESSION['keywords']=$_GET['keywords'];
	$SearchText="%".$_GET["keywords"]."%";
    // To Do (DIY): Retrieve list of product records with "ProductTitle" 
	// contains the keyword entered by shopper, and display them in a table.
    $qry= "SELECT * FROM product WHERE ProductTitle LIKE ? OR ProductDesc LIKE ? ORDER BY ProductTitle";
    $stmt=$conn->prepare($qry);
    $stmt->bind_param('ss',$SearchText,$SearchText);
    $stmt->execute();
    $result=$stmt->get_result();

    $stmt->close();
    if ($result->num_rows>0){

        $MainContent.="<div class='row'>";
        include_once('filter.php');
        
        include('productListTemplate.php');
        
        $MainContent.="</div>";
            


     }
     else{
         $MainContent.="<h4 
         style='color:red'>No Record Found</h4>";
     }
	 //To Do (DIY): End of Code
}

$MainContent .= "</div>"; // End of Container
include("MasterTemplate.php");
?>

<script type="text/javascript">
// var slider = document.getElementById('slider');

// noUiSlider.create(slider, {
//     start: [20, 80],
//     connect: true,
//     range: {
//         'min': 0,
//         'max': 100
//     }
//   };
function myFunction() {
  
  var x = document.getElementById("myDropdown");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
  var productListing= document.getElementById("product");
  var productItem=document.getElementsByName("productItem");
  if (x.style.display === "none") {
    productListing.className = "col-12 auto-margin";
    for (var i = 0; i < productItem.length; i++) {
      productItem[i].className="col-md-3 col-sm-4 category-product";    }

  } else {

    for (var i = 0; i < productItem.length; i++) {
      productItem[i].className="col-md-5 col-sm-5 category-product";   }
    productListing.className = "col-8";
  }

  
};
</script>