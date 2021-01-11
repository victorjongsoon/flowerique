<?php 
session_start();
// Read the data input from previous page
$eMail = $_SESSION["eMail"];

// Retrieve shopper record based on e-mail address
include_once("mysql_conn.php");
$qry = "SELECT * FROM Shopper WHERE Email=?";
$stmt = $conn->prepare($qry);
$stmt->bind_param("s", $eMail); 	// "s" - string 
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
while ($row = $result->fetch_array()){
    $pwdquestion = $row["PwdQuestion"];
}

$MainContent = "<div style='width:80%; margin:auto;'>";
$MainContent .= "<form name='pwdRecovery' method='post'>";
$MainContent .= "<div class='form-group row'>";
$MainContent .= "<div class='col-sm-9 offset-sm-3'>";
$MainContent .= "<span class='page-title'>Answer the following question</span>";
$MainContent .= "</div>";
$MainContent .= "</div>";

// Email
$MainContent .= "<div class='form-group row'>";
$MainContent .= "<label class='col-sm-3 col-form-label' for='email'>
                Email:</label>";
$MainContent .= "<div class='col-sm-9'>";
$MainContent .= "<input class='form-control' name='email' id='email' value='$eMail' 
                        type='email' readonly='readonly' />";
$MainContent .= "</div>";
$MainContent .= "</div>";

$MainContent .= "<div class='form-group row'>";
$MainContent .= "<label class='col-sm-3 col-form-label' for='pwdquestion'>
                Security question:</label>";
$MainContent .= "<div class='col-sm-9'>";
$MainContent .= "<input class='form-control' name='pwdquestion' id='pwdquestion' value='$pwdquestion' 
                        type='pwdquestion' disabled />";
$MainContent .= "</div>";
$MainContent .= "</div>";

// pwdAnswer
$MainContent .= "<div class='form-group row'>";
$MainContent .= "<label class='col-sm-3 col-form-label' for='pwdanswer'>
                Answer:</label>";
$MainContent .= "<div class='col-sm-9'>";
$MainContent .= "<input class='form-control' name='pwdanswer' id='pwdanswer'
                type='text' required /> (required)";
$MainContent .= "</div>";
$MainContent .= "</div>";

// Button
$MainContent .= "<div class='form-group row'>";       
$MainContent .= "<div class='col-sm-9 offset-sm-3'>";
$MainContent .= "<button name='submit' type='submit'>Submit</button>";
$MainContent .= "</div>";
$MainContent .= "</div>";

$MainContent .= "</form>";

// Process after user click the submit button
if(isset($_POST['submit'])){ 
    $qry = "SELECT * FROM Shopper WHERE Email=?";
    $stmt = $conn->prepare($qry);
    $stmt->bind_param("s", $_POST['email']); 	// "s" - string 
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    while ($row = $result->fetch_array()){
        $pwdanswer = $row["PwdAnswer"];
        $shopperId = $row["ShopperID"];
    }
    if ($_POST['pwdanswer'] == $pwdanswer) {
        // Update the default new password to shopper's account
        $row = $result->fetch_array();
        $new_pwd = "Password$1"; // Default password
        $qry = "UPDATE Shopper SET Password=? WHERE ShopperID=?";
        $stmt = $conn->prepare($qry);
        $stmt->bind_param("si", $new_pwd, $shopperId);
        $stmt->execute();
        $stmt->close();
        header("Location: correctAnswer.php");
    }
    else {
        header("Location: wrongAnswer.php");
    }
}

$MainContent .= "</div>";
include("MasterTemplate.php");
?>