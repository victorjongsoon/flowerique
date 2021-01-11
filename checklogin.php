<?php
// Detect the current session
session_start();

// Reading inputs entered in previous page
$email = $_POST["email"];
$pwd = $_POST["password"];

// To Do 1 (Practical 2): Validate login credentials with database
$checkLogin = FALSE;

// Include the PHP file that establishes database connection handle: $conn
include_once("mysql_conn.php");
$qry = "SELECT * FROM Shopper WHERE Email=?";
$stmt = $conn->prepare($qry);
$stmt->bind_param("s", $email);
$stmt->execute();
$result1 = $stmt->get_result();
$stmt->close();

if($result1->num_rows > 0){
	$row1 = $result1->fetch_array();

	if($pwd == $row1["Password"]){
		$checkLogin = TRUE;

		// Save user's info in session variables
		$_SESSION["ShopperName"] = $row1["Name"];
		$_SESSION["ShopperID"] = $row1["ShopperID"];

		// To Do 2 (Practical 4): Get active shopping cart
		$qry = "SELECT ShopCartID FROM shopcart WHERE OrderPlaced = 0 ORDER BY ShopCartID DESC LIMIT 1";
		$result = $conn->query($qry);
		$row = $result->fetch_array();
		if (empty($row["ShopCartID"])) {
			unset($_SESSION["Cart"]);
		}
		else{
			$_SESSION["Cart"] = $row["ShopCartID"];
		}

		$qry = "SELECT COUNT(*) AS count FROM ShopCartItem WHERE ShopCartID = ?";
		$stmt = $conn->prepare($qry);
		$stmt->bind_param("i", $_SESSION["Cart"]); // i - integer
		$stmt->execute();
		$result = $stmt->get_result();
		$stmt->close();
		while ($row = $result->fetch_array()){
			if ($row["count"] > 0){
				$_SESSION["NumCartItem"] = $row["count"];
			}
			else
			{
				unset($_SESSION["NumCartItem"]);
			}
		}
		// End of To Do 2
		
	} 
	else{
		$MainContent = "<h3 style='color:red'>Invalid Login Credentials - <br />
						password is incorrect!</h3>";
	}
}
else{
	$MainContent = "<h3 style='color:red'>Invalid Login Credentials - <br />
					Email Address is incorrect!</h3>";
}

$conn->close(); // Close database connection

if ($checkLogin == TRUE){
	// Redirect to home page
	header("Location: index.php");
	exit;
}

include("MasterTemplate.php");
?>