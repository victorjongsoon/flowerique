<?php 
// Detect the current session
session_start();
// Create a container, 60% width of viewport
$MainContent = "<div style='width:100%; margin:auto;'>";
$MainContent .= "<link rel='stylesheet' href='css/site.css'>";
// Display Page Header.
$MainContent .= "<div class='row' style='padding:5px'>"; // Start header row
$MainContent .= "<div class='col-12 ' align='center'>";
$MainContent .= "<span class='page-title'>Product Categories</span>";
$MainContent .= "<p>Select a category listed below:</p>";
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

    $MainContent.="<div class='col-3' style='	outline: 2px solid #eee;    outline-offset: -15px; border-radius:15px;
    padding:25px
    ' >";
    // $MainContent.="<div class='row' style='display:flex; flex-wrap:wrap' >";
    // $MainContent.="<div class='col-12 border border-black rounded' style='margin:auto'; >";
    $img="./Images/category/$row[CatImage]";
    $MainContent.="<div >";
    $MainContent.="<img src='$img' style='margin-left:auto;  
    '/>";
    $MainContent.="</div>";
    //encode special character(&)
    $catname=urlencode($row["CatName"]);
    $catProduct="catProduct.php?cid=$row[CategoryID]&catName=$catname";
    $MainContent.= "<div class='col-12' style='margin-top:20px';>";
    $MainContent.= "<p><a href=$catProduct>$row[CatName]</a></p>";
    $MainContent .= $row['CatDesc'];
    $MainContent.="</div>";


    $MainContent .= "</div>";
    // $MainContent .= "</div>";

    // $MainContent .= "</div>";
    

}

// To Do:  Ending ....

$conn->close(); // Close database connnection
$MainContent .= "</div>"; // End of container
$MainContent .= "</div>"; // End of container

$MainContent .= "</div>"; // End of container

include("MasterTemplate.php"); 
?>
