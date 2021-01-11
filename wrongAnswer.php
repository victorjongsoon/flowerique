<?php 
// Detect the current session
session_start();

$MainContent = "<div>";
$MainContent .= "<p><span style='color:red;'>Wrong Answer!</span><p>";
$MainContent .= "</div>";

include("MasterTemplate.php"); 
?>