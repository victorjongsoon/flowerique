<?php 
// Detect the current session
session_start();
// Create a container, 60% width of viewport
$MainContent = "<div style='width:60%; margin:auto;'>";
// Display Page Header.
$MainContent .= "<div class='row' style='padding:5px'>"; // Start header row
$MainContent .= "<div class='col-12'>";
$MainContent .= "<span class='page-title'>Product Categories</span>";
$MainContent .= "<p>Select a category listed below:</p>";
$MainContent .= "</div>";
$MainContent .= "</div>"; // End header row

// Include the PHP file that establishes database connection handle: $conn
include_once("mysql_conn.php");

// To Do:  Starting ....
$qry= "SELECT * FROM Category";
$result= $conn->query($qry);

while ($row=$result->fetch_array()) {
    $MainContent.="<div class='row' style='padding:5px'>";
    //encode special character(&)
    $catname=urlencode($row["CatName"]);
    $catProduct="catProduct.php?cid=$row[CategoryID]&catName=$catname";
    $MainContent.= "<div class='col-8'>";
    $MainContent.= "<p><a href=$catProduct>$row[CatName]</a></p>";
    $MainContent .= $row['CatDesc'];
    $MainContent.="</div>";

    //Righ Column -display the cateogry's image
    $img="./Images/category/$row[CatImage]";
    $MainContent.="<div class='col-4'>";
    $MainContent.="<img src='$img'/>";
    $MainContent.="</div>";
    $MainContent .= "</div>";
}

// To Do:  Ending ....

$conn->close(); // Close database connnection
$MainContent .= "</div>"; // End of container
include("MasterTemplate.php"); 
?>
