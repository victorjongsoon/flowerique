<?php 
// Detect the current session
session_start();

$MainContent = "<div>";
$MainContent .= "<p>You new password is: Password$1</p>";
$MainContent .= "</div>";

include("MasterTemplate.php"); 
?>