<?php 
// Detect the current session
session_start();
session_destroy();
$MainContent = "<div>";
$MainContent .= "<p><span style='color:red;'>Wrong Email Address</span><p>";
$MainContent .= "<p>Click<a href='forgetPassword.php'> here</a> to try again.</p>";
$MainContent .= "</div>";

include("MasterTemplate.php"); 
?>