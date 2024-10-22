<?php 
// Detect the current session
session_start();
// Create a container, 60% width of viewport
$MainContent = "<div style='width:100%; margin:auto;'>";
// $MainContent .= "<link rel='stylesheet' href='css/site.css'>";
// Display Page Header.
$MainContent .= "<div class='row' style='padding:5px'>"; // Start header row
$MainContent .= "<div class='col-12'>";
$MainContent .= "<span class='page-title'>Product Categories</span>";

$MainContent .= "<hr style='height:5px;color:gray;'/>";

$MainContent .= "</div>";
$MainContent .= "</div>"; // End header row

// Include the PHP file that establishes database connection handle: $conn
include_once("mysql_conn.php");

// To Do:  Starting ....
$qry= "SELECT * FROM Category";
$result= $conn->query($qry);
$MainContent.="<div class='col-12 auto-margin' align='center' style='margin:auto;'>";

$MainContent.="<div class='row justify-content-center'  align='center' >";

while ($row=$result->fetch_array()) {
    //encode special character(&)
    $catname=urlencode($row["CatName"]);
    $catProduct="catProduct.php?cid=$row[CategoryID]&catName=$catname";
    $MainContent.="<a href=$catProduct>";
    $MainContent.="<div class='col-md-3 category-product'  >";
    // $MainContent.="<div class='row' style='display:flex; flex-wrap:wrap' >";
    // $MainContent.="<div class='col-12 border border-black rounded' style='margin:auto'; >";
    $img="./Images/category/$row[CatImage]";
    $MainContent.="<div >";
    $MainContent.="<img src='$img' style='margin-left:auto;  
    ' class='img-fluid'/>";
    $MainContent.="</div>";

    $MainContent.= "<div class='col-12' style='margin-top:20px';>";
    $MainContent.= "<p><a href=$catProduct>$row[CatName]</a></p>";
    $MainContent .= $row['CatDesc'];
    $MainContent.="</div>";


    $MainContent .= "</div>";
    $MainContent.="</a>";
    // $MainContent .= "</div>";

    // $MainContent .= "</div>";
    
    

}
$conn->close(); // Close database connnection

// To Do:  Ending ....

$MainContent .= "</div>"; // End of container
$MainContent .= "</div>"; // End of container

$MainContent .= "</div>"; // End of container

include("MasterTemplate.php"); 

?>
