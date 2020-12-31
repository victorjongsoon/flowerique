<?php
//Connection Parameters
$servername = 'localhost'; // local WampServer
$username = 'root';
$userpwd = '';
$dbname = 'flowerique'; 

// Create connection
$conn = new mysqli($servername, $username, $userpwd, $dbname);
// Check connection
if ($conn->connect_error) {
	// access the property or call the method of an object using the -> sign
	die("Connection failed: " . $conn->connect_error);	
	
}

// To access this database in other pages, use include_once("mysql_conn.php")
?>
