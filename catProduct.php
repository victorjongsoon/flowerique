

<?php 
// Detect the current session
session_start();

// Create a container, 60% width of viewport
$MainContent = "<div style='width:100%; margin:auto;'>";
// Display Page Header - 
// Category's name is read from query string passed from previous page.
$MainContent .= "<div class='row' style='padding:5px'>";
$MainContent .= "<div class='col-12'>";
$MainContent .= "<span class='page-title'>$_GET[catName]</span>";
// $MainContent .='<div class="dropdown float-right">
// <button onclick="myFunction()" class="dropbtn button">Dropdown</button>
// <div id="myDropdown" class="dropdown-content">
//   <a href="#">Link 1</a>
//   <a href="#">Link 2</a>
//   <a href="#">Link 3</a>
// </div>
// </div>';
$MainContent.='<div class="btn-group float-right">
<button type="button" onclick= "myFunction()" class="btn button dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
  Filter
</button>
';
$MainContent.='</div>';

$MainContent .= "<hr style='height:5px;color:gray;'/>";

$MainContent .= "</div>";

$MainContent .= "</div>";


// Include the PHP file that establishes database connection handle: $conn
include_once("mysql_conn.php"); 

// To Do:  Starting ....
$cid=$_GET["cid"];
$qry ="SELECT p.* FROM CatProduct cp INNER JOIN product p ON cp.ProductID=p.ProductID where cp.CategoryID=? ORDER BY p.ProductTitle";
$stmt=$conn->prepare($qry);
$stmt->bind_param("i",$cid);
$stmt->execute();
$result=$stmt->get_result();
$stmt->close();

$MainContent.="<div class='row'>";
include_once('filter.php');

include('productListTemplate.php');

$MainContent.="</div>";
// To Do:  Ending ....

$conn->close(); // Close database connnection
$MainContent .= "</div>"; // End of container
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

