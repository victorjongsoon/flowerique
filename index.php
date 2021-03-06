<?php 
// Detect the current session
session_start();
$MainContent = "";
$MainContent .= "<link rel='stylesheet' href='css/site.css'>";
$MainContent .= "<div class='latest-products'>";
$MainContent .= "<div class='container'>";
$MainContent .= "<div class='row'>";
$MainContent .= "<div class='col-md-12'>";
$MainContent .= "<div class='section-heading'>";
$MainContent .= "<h2>Featured Products</h2>";
$MainContent .= "<a href='category.php'>view more <i class='fa fa-angle-right'></i></a>";
$MainContent .= "<hr/>";
$MainContent .= "</div>";
$MainContent .= "</div>";

include_once("mysql_conn.php");

$qry ="SELECT * FROM product WHERE cast(now() as date) > OfferStartDate AND cast(now() as date) <OfferEndDate ORDER BY ProductTitle" ;
$result=$conn->query($qry);
include_once('productListTemplate.php');


$MainContent .= "</div>";
$MainContent .= "</div>";
$MainContent .= "</div>";

include("MasterTemplate.php");
?>



