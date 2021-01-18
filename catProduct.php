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
$MainContent .= "</div>";
$MainContent .= "</div>";

// Include the PHP file that establishes database connection handle: $conn
include_once("mysql_conn.php"); 

// To Do:  Starting ....
$cid=$_GET["cid"];
$qry ="SELECT p.ProductID, p.ProductTitle, p.ProductImage, p.Price, p.Quantity FROM CatProduct cp INNER JOIN product p ON cp.ProductID=p.ProductID where cp.CategoryID=?";
$stmt=$conn->prepare($qry);
$stmt->bind_param("i",$cid);
$stmt->execute();
$result=$stmt->get_result();
$stmt->close();

while ($row=$result->fetch_array()) {
    include('productListTemplate.php');
}
// To Do:  Ending ....

$conn->close(); // Close database connnection
$MainContent .= "</div>"; // End of container
include("MasterTemplate.php");  
?>
