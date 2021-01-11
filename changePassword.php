<script type="text/javascript">
function validateForm()
{
    // Check if password matched
	if (document.changePwd.pwd1.value != document.changePwd.pwd2.value) {
 	    alert("Passwords not matched!");
        return false;   // cancel submission
    }
    return true;  // No error found
}
</script>

<?php
// Detect the current session
session_start();
// To Do 1: Check if user logged in 

// End of To Do 1

$MainContent = "<div style='width:80%; margin:auto;'>";
$MainContent .= "<form name='changePwd' method='post' 
                       onsubmit='return validateForm()'>";
$MainContent .= "<div class='form-group row'>";
$MainContent .= "<div class='col-sm-9 offset-sm-3'>";
$MainContent .= "<span class='page-title'>Change Password</span>";
$MainContent .= "</div>";
$MainContent .= "</div>";
$MainContent .= "<div class='form-group row'>";
$MainContent .= "<label class='col-sm-3 col-form-label' for='pwd1'>
                 New Password:</label>";
$MainContent .= "<div class='col-sm-9'>";
$MainContent .= "<input class='form-control' name='pwd1' id='pwd1' 
                        type='password' required />";
$MainContent .= "</div>";
$MainContent .= "</div>";
$MainContent .= "<div class='form-group row'>";
$MainContent .= "<label class='col-sm-3 col-form-label' for='pwd2'>
                 Retype Password:</label>";
$MainContent .= "<div class='col-sm-9'>";
$MainContent .= "<input class='form-control' name='pwd2' id='pwd2'
                        type='password' required />";
$MainContent .= "</div>";
$MainContent .= "</div>";
$MainContent .= "<div class='form-group row'>";       
$MainContent .= "<div class='col-sm-9 offset-sm-3'>";
$MainContent .= "<button type='submit'>Update</button>";
$MainContent .= "</div>";
$MainContent .= "</div>";
$MainContent .= "</form>";

// Process after user click the submit button
if (isset($_POST['pwd1'])) {
    // To Do 2: Read new password entered by user
    $pwd1 = $_POST["pwd1"];
    $pwd2 = $_POST["pwd2"];
    if ($pwd1 == $pwd2){
        include_once("mysql_conn.php");
        $qry = "SELECT * FROM Shopper WHERE ShopperId=?";
        $stmt = $conn->prepare($qry);
        $stmt->bind_param("i", $_SESSION["ShopperID"]); 	// "s" - string 
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows > 0) {
            $row = $result->fetch_array();
            // To Do 3: Hash the default password
            $pwd = $pwd2;
            // To Do 4: Update the new password hash
            $qry = "UPDATE Shopper SET Password=? WHERE ShopperID=?";
            $stmt = $conn->prepare($qry);
            $stmt->bind_param("si", $pwd, $_SESSION["ShopperID"]);
            $stmt->execute();
            $stmt->close();
        }
        $MainContent .= "<p>Your new password is successfullt updated. Thank you</p>";
        
    }
    else{
 $MainContent .= "<p><span style='color:red;'>
        Mailer Error: . $error . </span></p>";
    }
	
}

$MainContent .= "</div>";
include("MasterTemplate.php"); 
?>