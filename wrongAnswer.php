<?php 
// Detect the current session
session_start();

$MainContent = "<div>";
$MainContent .= "<p><span style='color:red;'>Wrong Answer!</span><p>";
$MainContent .= "<p>Click<a href='forgetPassword.php'> here</a> to try again.</p>";
$MainContent .= "</div>";

include("MasterTemplate.php"); 
?>