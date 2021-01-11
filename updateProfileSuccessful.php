<?php 
// Detect the current session
session_start();

$MainContent = "<div>";
$MainContent .= "<p><span>Profile Updated Successfully.</span></p>";
$MainContent .= "<p>Click<a href='index.php'> here</a> to continue shopping.</p>";
$MainContent .= "</div>";

include("MasterTemplate.php"); 
?>