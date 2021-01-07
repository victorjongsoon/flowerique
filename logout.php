<?php 
// Detect the current session
session_start();
// End the current session
session_destroy();
// Redirect to home page
header("Location: index.php");
?>