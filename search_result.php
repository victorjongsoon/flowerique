<?php
session_start();

if (isset($_GET['message'])) {    
    $row= $_GET['message'];
    while ($row) {
            
                include_once('productListTemplate.php');
            }
 }

$MainContent .= "</div>"; // End of Container
