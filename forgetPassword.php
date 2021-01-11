<?php 
$MainContent = "<div style='width:80%; margin:auto;'>";
$MainContent .= "<form action='securityQuestion.php' method='post'>"; 
$MainContent .= "<div class='form-group row'>";
$MainContent .= "<div class='col-sm-9 offset-sm-3'>";
$MainContent .= "<span class='page-title'>Forget Password</span>";
$MainContent .= "</div>";
$MainContent .= "</div>";
$MainContent .= "<div class='form-group row'>";
$MainContent .= "<label class='col-sm-3 col-form-label' for='eMail'>
                 Email Address:</label>";
$MainContent .= "<div class='col-sm-9'>";
$MainContent .= "<input class='form-control' name='eMail' id='eMail'
                        type='email' required />";
$MainContent .= "</div>";
$MainContent .= "</div>";
$MainContent .= "<div class='form-group row'>";       
$MainContent .= "<div class='col-sm-9 offset-sm-3'>";
$MainContent .= "<button type='submit'>Submit</button>";
$MainContent .= "</div>";
$MainContent .= "</div>";
$MainContent .= "</form>";

// Process after user click the submit button
if (isset($_POST['eMail'])) {
	// Read email address entered by user
	$eMail = $_POST['eMail'];
	// Retrieve shopper record based on e-mail address
	include_once("mysql_conn.php");
	$qry = "SELECT * FROM Shopper WHERE Email=?";
	$stmt = $conn->prepare($qry);
	$stmt->bind_param("s", $eMail); 	// "s" - string 
	$stmt->execute();
	$result = $stmt->get_result();
	$stmt->close();
	# if ($conn->num_rows($result) > 0) {
	if ($result->num_rows > 0) {
		header("Location: securityQuestion.php");
	}
	else {
		$MainContent .= "<p><span style='color:red;'>Wrong E-mail address!</span><p>";
	}
	$conn->close();
}

$MainContent .= "</div>";
include("MasterTemplate.php");
?>