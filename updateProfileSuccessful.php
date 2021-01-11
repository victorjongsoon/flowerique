<?php 
// Detect the current session
session_start();

$MainContent = "<div>";
$MainContent .= "<p><span>Profile Updated Successfully.</span><p>";
$MainContent .= "</div>";

include("MasterTemplate.php"); 
?>