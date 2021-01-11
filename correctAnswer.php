<?php 
// Detect the current session
session_start();
session_destroy();
$MainContent = "<div>";
$MainContent .= "<p>You new password is: Password$1</p>";
$MainContent .= "<p>Please change your password after you login.</p>";
$MainContent .= "<p>Click<a href='login.php'> here</a> to login.</p>";
$MainContent .= "</div>";

include("MasterTemplate.php"); 
?>