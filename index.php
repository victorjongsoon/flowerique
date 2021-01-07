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
$MainContent .= "<a href='products.php'>view more <i class='fa fa-angle-right'></i></a>";
$MainContent .= "<hr/>";
$MainContent .= "</div>";
$MainContent .= "</div>";

// Item 1
$MainContent .= "<div class='col-md-4'>";
$MainContent .= "<div class='product-item'>";
$MainContent .= "<a href='product-details.php'><img src='Images/Products/Blissful_Bundle.jpg' alt='' width='370' height='270'></a>";
$MainContent .= "<div class='down-content'>";
$MainContent .= "<a href='product-details.php'><h4>Lorem ipsum dolor sit amet.</h4></a>";
$MainContent .= "<h6><small><del>$999.00 </del></small> $779.00</h6>";
$MainContent .= "<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cum dicta voluptas quia dolor fuga odit.</p>";
$MainContent .= "</div>";
$MainContent .= "</div>";
$MainContent .= "</div>";

// Item 2
$MainContent .= "<div class='col-md-4'>";
$MainContent .= "<div class='product-item'>";
$MainContent .= "<a href='product-details.php'><img src='Images/Products/Blooms_of_Sunshine.jpg' alt='' width='370' height='270'></a>";
$MainContent .= "<div class='down-content'>";
$MainContent .= "<a href='product-details.php'><h4>Lorem ipsum dolor sit amet.</h4></a>";
$MainContent .= "<h6><small><del>$99.00</del></small>  $79.00</h6>";
$MainContent .= "<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Non beatae soluta, placeat vitae cum maxime culpa itaque minima.</p>";
$MainContent .= "</div>";
$MainContent .= "</div>";
$MainContent .= "</div>";

// item 3
$MainContent .= "<div class='col-md-4'>";
$MainContent .= "<div class='product-item'>";
$MainContent .= "<a href='product-details.php'><img src='Images/Products/Lavish_Prosperity.jpg' alt='' width='370' height='270'></a>";
$MainContent .= "<div class='down-content'>";
$MainContent .= "<a href='product-details.php'><h4>Lorem ipsum dolor sit amet.</h4></a>";
$MainContent .= "<h6><small><del>$99.00</del></small>  $79.00</h6>";
$MainContent .= "<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Non beatae soluta, placeat vitae cum maxime culpa itaque minima.</p>";
$MainContent .= "</div>";
$MainContent .= "</div>";
$MainContent .= "</div>";

// item 4
$MainContent .= "<div class='col-md-4'>";
$MainContent .= "<div class='product-item'>";
$MainContent .= "<a href='product-details.php'><img src='Images/Products/Vine_Grace.jpg' alt='' width='370' height='270'></a>";
$MainContent .= "<div class='down-content'>";
$MainContent .= "<a href='product-details.php'><h4>Lorem ipsum dolor sit amet.</h4></a>";
$MainContent .= "<h6><small><del>$99.00</del></small>  $79.00</h6>";
$MainContent .= "<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Non beatae soluta, placeat vitae cum maxime culpa itaque minima.</p>";
$MainContent .= "</div>";
$MainContent .= "</div>";
$MainContent .= "</div>";

// item 5
$MainContent .= "<div class='col-md-4'>";
$MainContent .= "<div class='product-item'>";
$MainContent .= "<a href='product-details.php'><img src='Images/Products/Together_Forever.jpg' alt='' width='370' height='270'></a>";
$MainContent .= "<div class='down-content'>";
$MainContent .= "<a href='product-details.php'><h4>Lorem ipsum dolor sit amet.</h4></a>";
$MainContent .= "<h6><small><del>$99.00</del></small>  $79.00</h6>";
$MainContent .= "<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Non beatae soluta, placeat vitae cum maxime culpa itaque minima.</p>";
$MainContent .= "</div>";
$MainContent .= "</div>";
$MainContent .= "</div>";

$MainContent .= "</div>";
$MainContent .= "</div>";
$MainContent .= "</div>";

include("MasterTemplate.php");
?>