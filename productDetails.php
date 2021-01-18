<?php 
session_start(); // Detect the current session
// Create a container, 90% width of viewport
$MainContent = "<div style='width:80%; margin:auto;'>";

$pid=$_GET["pid"]; // Read Product ID from query string

// Include the PHP file that establishes database connection handle: $conn
include_once("mysql_conn.php"); 
$qry = "SELECT * from product where ProductID=?";
$stmt = $conn->prepare($qry);
$stmt->bind_param("i", $pid); 	// "i" - integer 
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

// To Do 1:  Display Product information. Starting ....

while($row=$result->fetch_array())
{
    $MainContent.="<div class='row'>";
    $MainContent.="<div class= 'col-sm-12' style='padding:5px'>";
    $MainContent.="<span class='page-title'>$row[ProductTitle]</span>";
    $MainContent.="</div>";
    $MainContent.="</div>";
    #new role
    $MainContent.="<div class='row'>";
    $MainContent.="<div class='col-sm-8' style='padding:5px'>";
    $MainContent.= "<p>$row[ProductDesc]</p>";

    $qry= "SELECT s.SpecName, ps.SpecVal FROM productspec ps INNER JOIN specification s ON ps.SpecID= s.SpecID WHERE ps.ProductID=? ORDER BY ps.priority";

    $stmt=$conn->prepare($qry);
    $stmt->bind_param('i',$pid);
    $stmt->execute();
    $result2=$stmt->get_result();
    $stmt->close();
    while($row2=$result2->fetch_array()){
        $MainContent.=$row2["SpecName"].": ".$row2["SpecVal"]."<br />";
    }

    $MainContent.="</div>";

    //right column
    
    $img="./Images/Products/$row[ProductImage]";
    $MainContent.="<div class='col-sm-3' style='vertical-align:top;padding:5px;'>";
    $MainContent.="<p><img src='$img' class='img-fluid' /></p>";

    //product price
    $formattedPrice= number_format($row["Price"],2);
    $MainContent.="Price:<span  style='font-weight:bold; color:red;'> S$ $formattedPrice</span>";

}

// To Do 1:  Ending ....

// To Do 2:  Create a Form for adding the product to shopping cart. Starting ....
$MainContent.="<form action='cartFunctions.php' method='post'>";
$MainContent.= "<input type='hidden' name ='action' value ='add'/>";
$MainContent.= "<input type='hidden' name ='product_id' value ='$pid'/>";

$MainContent.="Quantity: <input type='number' name='quantity' value='1' min='1' max ='10' style='width:40px' required/>";
$MainContent.= "<button class='button type='submit'>Add to Cart</button>";
$MainContent.="</form>";
$MainContent.="</div>";
$MainContent.="</div>";
$MainContent .= "</div>"; // End of container
include("MasterTemplate.php");  
?>
