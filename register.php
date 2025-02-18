<script type="text/javascript">
function validateForm()
{
    // Check if password matched
	if (document.register.password.value != document.register.password2.value){
        alert("Passwords not matched!");
        return false; // cancel submission
    }

    // Password Strength
    var strongRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})");
    
    if(strongRegex.test(document.register.password.value)) {
        
    }
    else{
        alert("Your password must be 8 characters long containing at least 1 lowercase alphabetical character, 1 uppercase alphabetical character, 1 numeric character, and one special character");
        return false; // cancel submission
    }

	// Check if telephone number entered correctly
	// Singapore telephone number consists of 8 digits,
	// start with 6, 8 or 9
    if (document.register.phone.value != ""){
        var str = document.register.phone.value;
        if (str.length != 8) {
            alert("Please enter a 8-digit phone number.");
            return false; // cancel submission
        }
        else if (str.substr(0,1) != "6" && str.substr(0,1) != "8" && str.substr(0,1) != "9") {
                     alert("Phone number in Singapore should start with 6, 8 or 9.");
                     return false; // cancel submission
                 }
    }
    return true;  // No error found
}
</script>

<?php
// Detect the current session
session_start();

$today = date("Y-m-d");  
$MainContent = "<div style='width:80%; margin:auto;'>";
$MainContent .= "<form name='register' action='registration.php' method='post' 
                       onsubmit='return validateForm()'>";
$MainContent .= "<div class='form-group row'>";
$MainContent .= "<div class='col-sm-9 offset-sm-3'>";
$MainContent .= "<span class='page-title'>Membership Registration</span>";
$MainContent .= "</div>";
$MainContent .= "</div>";

$MainContent .= "<div class='form-group row'>";
$MainContent .= "<label class='col-sm-3 col-form-label' for='name'>Name:</label>";
$MainContent .= "<div class='col-sm-9'>";
$MainContent .= "<input class='form-control' name='name' id='name' 
                  type='text' required /> (required)";
$MainContent .= "</div>";
$MainContent .= "</div>";

$MainContent .= "<div class='form-group row'>";
$MainContent .= "<label class='col-sm-3 col-form-label' for='birthday'>Birthday:</label>";
$MainContent .= "<div class='col-sm-9'>";
$MainContent .= "<input type='date' id='birthday' name='birthday' max='$today'>";
$MainContent .= "</div>";
$MainContent .= "</div>";

$MainContent .= "<div class='form-group row'>";
$MainContent .= "<label class='col-sm-3 col-form-label' for='address'>Address:</label>";
$MainContent .= "<div class='col-sm-9'>";
$MainContent .= "<textarea class='form-control' name='address' id='address'
                  cols='25' rows='4' ></textarea>";
$MainContent .= "</div>";
$MainContent .= "</div>";
$MainContent .= "<div class='form-group row'>";
$MainContent .= "<label class='col-sm-3 col-form-label' for='country'>Country:</label>";
$MainContent .= "<div class='col-sm-9'>";
$MainContent .= "<input class='form-control' name='country' id='country' type='text' />";
$MainContent .= "</div>";
$MainContent .= "</div>";
$MainContent .= "<div class='form-group row'>";
$MainContent .= "<label class='col-sm-3 col-form-label' for='phone'>Phone:</label>";
$MainContent .= "<div class='col-sm-9'>";
$MainContent .= "<input class='form-control' name='phone' id='phone' type='text' />";
$MainContent .= "</div>";
$MainContent .= "</div>";
$MainContent .= "<div class='form-group row'>";
$MainContent .= "<label class='col-sm-3 col-form-label' for='email'>
                 Email Address:</label>";
$MainContent .= "<div class='col-sm-9'>";
$MainContent .= "<input class='form-control' name='email' id='email' 
                  type='email' required /> (required)";
$MainContent .= "</div>";
$MainContent .= "</div>";

$MainContent .= "<div class='form-group row'>";
$MainContent .= "<label class='col-sm-3 col-form-label' for='password'>
                 Password:</label>";
$MainContent .= "<div class='col-sm-9'>";
$MainContent .= "<input class='form-control' name='password' id='password' 
                  type='password' required /> (required)";
$MainContent .= "</div>";
$MainContent .= "</div>";

$MainContent .= "<div class='form-group row'>";
$MainContent .= "<label class='col-sm-3 col-form-label' for='password2'>
                 Retype Password:</label>";
$MainContent .= "<div class='col-sm-9'>";
$MainContent .= "<input class='form-control' name='password2' id='password2' 
                  type='password' required /> (required)";
$MainContent .= "</div>";
$MainContent .= "</div>";

$MainContent .= "<div class='form-group row'>";
$MainContent .= "<label class='col-sm-3 col-form-label' for='pwdquestion'>Choose a security question:</label>";
$MainContent .= "<div class='col-sm-9'>";
$MainContent .= "<select id='pwdquestion' name='pwdquestion'>
                 <option value='Which polytechnic?'>Which polytechnic?</option>
                 <option value='wife's name?'>wife's name?</option>
                 <option value='How many brothers and sisters?'>How many brothers and sisters?</option>
                 <option value='Which Country were you born in?'>Which Country were you born in?</option>
                 <option value='What is your pet's name?'>What is your pet's name?</option>
                 </select>";
$MainContent .= "</div>";
$MainContent .= "</div>";

$MainContent .= "<div class='form-group row'>";
$MainContent .= "<label class='col-sm-3 col-form-label' for='pwdanswer'>
                 Answer:</label>";
$MainContent .= "<div class='col-sm-9'>";
$MainContent .= "<input class='form-control' name='pwdanswer' id='pwdanswer' 
                  type='text' required /> (required)";
$MainContent .= "</div>";
$MainContent .= "</div>";

$MainContent .= "<div class='form-group row'>";       
$MainContent .= "<div class='col-sm-9 offset-sm-3'>";
$MainContent .= "<button type='submit' class='button'>Register</button>";
$MainContent .= "</div>";
$MainContent .= "</div>";
$MainContent .= "</form>";
$MainContent .= "</div>";
include("MasterTemplate.php"); 
?>


