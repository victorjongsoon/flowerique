<script type="text/javascript">
function validateForm()
{
    // Check if telephone number entered correctly
        // Singapore telephone number consists of 8 digits,
        // start with 6, 8 or 9
        if (document.updateProfile.phone.value != ""){
            var str = document.updateProfile.phone.value;
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
// Check if user logged in 
if (! isset($_SESSION["ShopperID"])) {
	// redirect to login page if the session variable shopperid is not set
	header ("Location: login.php");
	exit;   
}

//Include the PHP file that establishes database connection handle: $conn
include_once("mysql_conn.php");
$qry = "SELECT * FROM shopper where ShopperID=?";
$stmt = $conn->prepare($qry);
$stmt->bind_param("s", $_SESSION["ShopperID"]);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_array()){
    $name = $row["Name"];
    $address = $row["Address"];
    $country = $row["Country"];
    $phone = $row["Phone"];
    $email = $row["Email"];
    $birthday = $row["BirthDate"];
    $pwdquestion = $row["PwdQuestion"];
    $pwdanswer = $row["PwdAnswer"];
}

$today = date("Y-m-d");  
$MainContent = "<div style='width:80%; margin:auto;'>";
$MainContent .= "<form name='updateProfile' method='post' 
                       onsubmit='return validateForm()'>";
$MainContent .= "<div class='form-group row'>";

$MainContent .= "<div class='col-sm-9 offset-sm-3'>";
$MainContent .= "<span class='page-title'>Update Profile</span>";
$MainContent .= "<a href='changePassword.php' style='float:right;'>Change Password</a>";
$MainContent .= "</div>";
$MainContent .= "</div>";

// Name
$MainContent .= "<div class='form-group row'>";
$MainContent .= "<label class='col-sm-3 col-form-label' for='name'>
                 Name:</label>";
$MainContent .= "<div class='col-sm-9'>";
$MainContent .= "<input class='form-control' name='name' id='name' value='$name'
                        type='text' required />";
$MainContent .= "</div>";
$MainContent .= "</div>";

// Birthday
$MainContent .= "<div class='form-group row'>";
$MainContent .= "<label class='col-sm-3 col-form-label' for='birthday'>
                 Birthday:</label>";
$MainContent .= "<div class='col-sm-9'>";
$MainContent .= "<input class='form-control' name='birthday' id='birthday' value='$birthday' max='$today'
                        type='date' required />";
$MainContent .= "</div>";
$MainContent .= "</div>";

// Address
$MainContent .= "<div class='form-group row'>";
$MainContent .= "<label class='col-sm-3 col-form-label' for='address'>
                 Address:</label>";
$MainContent .= "<div class='col-sm-9'>";
$MainContent .= "<input class='form-control' name='address' id='address' value='$address' 
                        type='text' required />";
$MainContent .= "</div>";
$MainContent .= "</div>";

// Country
$MainContent .= "<div class='form-group row'>";
$MainContent .= "<label class='col-sm-3 col-form-label' for='country'>
                 Country:</label>";
$MainContent .= "<div class='col-sm-9'>";
$MainContent .= "<input class='form-control' name='country' id='country' value='$country' 
                        type='text' required />";
$MainContent .= "</div>";
$MainContent .= "</div>";

// Phone
$MainContent .= "<div class='form-group row'>";
$MainContent .= "<label class='col-sm-3 col-form-label' for='phone'>
                 Phone:</label>";
$MainContent .= "<div class='col-sm-9'>";
$MainContent .= "<input class='form-control' name='phone' id='phone' value='$phone' 
                        type='text' required />";
$MainContent .= "</div>";
$MainContent .= "</div>";

// Email
$MainContent .= "<div class='form-group row'>";
$MainContent .= "<label class='col-sm-3 col-form-label' for='email'>
                 Email:</label>";
$MainContent .= "<div class='col-sm-9'>";
$MainContent .= "<input class='form-control' name='email' id='email' value='$email' 
                        type='email' required />";
$MainContent .= "</div>";
$MainContent .= "</div>";

// pwdQuestion
$MainContent .= "<div class='form-group row'>";
$MainContent .= "<label class='col-sm-3 col-form-label' for='pwdquestion'>Choose a security question:</label>";
$MainContent .= "<div class='col-sm-9'>";
$MainContent .= "<select id='pwdquestion' name='pwdquestion' value='$pwdquestion'>
                    <option value='Which polytechnic?'>Which polytechnic?</option>
                    <option value='wife's name?'>wife's name?</option>
                    <option value='How many brothers and sisters?'>How many brothers and sisters?</option>
                    <option value='Which Country were you born in?'>Which Country were you born in?</option>
                    <option value='What is your pet's name?'>What is your pet's name?</option>
                 </select>";
$MainContent .= "</div>";
$MainContent .= "</div>";

// pwdAnswer
$MainContent .= "<div class='form-group row'>";
$MainContent .= "<label class='col-sm-3 col-form-label' for='pwdanswer'>
                 Answer:</label>";
$MainContent .= "<div class='col-sm-9'>";
$MainContent .= "<input class='form-control' name='pwdanswer' id='pwdanswer' value='$pwdanswer'
                  type='text' required /> (required)";
$MainContent .= "</div>";
$MainContent .= "</div>";

// Button
$MainContent .= "<div class='form-group row'>";       
$MainContent .= "<div class='col-sm-9 offset-sm-3'>";
$MainContent .= "<button name='submit' type='submit'>Update</button>";
$MainContent .= "</div>";
$MainContent .= "</div>";

$MainContent .= "</form>";

// Process after user click the submit button
if(isset($_POST['submit'])){ 
    if ($_POST['email'] == $email){
        //Define the INSERT SQL Statement
        $qry = "UPDATE Shopper SET Name=?, Address=?, Country=?, Phone=?, BirthDate=?, PwdQuestion=?, PwdAnswer=? WHERE ShopperID=?";
        // Prepare statement for execution
        $stmt = $conn->prepare($qry);

        $stmt->bind_param("ssssssss", $_POST['name'], $_POST['address'], $_POST['country'], $_POST['phone'], $_POST['birthday'], $_POST['pwdquestion'], $_POST['pwdanswer'], $_SESSION["ShopperID"]);
        // Execute statement (SQL is more secure as it prevent risk of SQL Injection)
        if ($stmt->execute()){ // SQL statement executed successfully
            // Refresh page
            header("Location: index.php");
            // Save the Shopper Name in a session variable
            $_SESSION["ShopperName"] = $_POST['name'];
        }
        else{ // Display error message
            $MainContent .= "<h3 style='color:red'>Error in inserting record</h3>";
        }
        // Release the resource allocated for prepared statement
        $stmt->close();
        // Close database connection
        // allow maximum concurrent access
        $conn->close();
    }
    else{
        $qry = "SELECT * FROM shopper where Email=? and Email NOT LIKE ?";
        $stmt = $conn->prepare($qry);
        $stmt->bind_param("ss", $_POST['email'], $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $row = $result->fetch_array();
        if (isset($row['Email'])){
            $MainContent .= "<h3 style='color:red'>Email Exist</h3>";
        }
        else{
            //Define the INSERT SQL Statement
            $qry = "UPDATE Shopper SET Email=?, Name=?, Address=?, Country=?, Phone=?, BirthDate=?, PwdQuestion=?, PwdAnswer=? WHERE ShopperID=?";
            // Prepare statement for execution
            $stmt = $conn->prepare($qry);

            $stmt->bind_param("sssssssss", $_POST['email'], $_POST['name'], $_POST['address'], $_POST['country'], $_POST['phone'], $_POST['birthday'], $_POST['pwdquestion'], $_POST['pwdanswer'], $_SESSION["ShopperID"]);
            // Execute statement (SQL is more secure as it prevent risk of SQL Injection)
            if ($stmt->execute()){ // SQL statement executed successfully
                // Refresh page
                header("Location: index.php");
                // Save the Shopper Name in a session variable
                $_SESSION["ShopperName"] = $_POST['name'];
            }
            else{ // Display error message
                $MainContent .= "<h3 style='color:red'>Error in inserting record</h3>";
            }
            // Release the resource allocated for prepared statement
            $stmt->close();
            // Close database connection
            // allow maximum concurrent access
            $conn->close();
        }
    }
}


$MainContent .= "</div>";

include("MasterTemplate.php"); 
?>