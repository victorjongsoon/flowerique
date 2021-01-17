<?php
// Detect the current session
session_start();
include_once("mysql_conn.php");

$today = date("Y-m-d");  
$MainContent = "<div style='width:80%; margin:auto;'>";
$MainContent .= "<form name='addFeedback' action='' method='post'>";
$MainContent .= "<div class='form-group row'>";
$MainContent .= "<div class='col-sm-9 offset-sm-3'>";
$MainContent .= "<span class='page-title'>Add Feedback</span>";
$MainContent .= "</div>";
$MainContent .= "</div>";

$MainContent .= "<div class='form-group row'>";
$MainContent .= "<label class='col-sm-3 col-form-label' for='subject'>Subject Name:</label>";
$MainContent .= "<div class='col-sm-9'>";
$MainContent .= "<input class='form-control' name='subject' id='subject' 
                  type='text' required /> (required)";
$MainContent .= "</div>";
$MainContent .= "</div>";

$MainContent .= "<div class='form-group row'>";
$MainContent .= "<label class='col-sm-3 col-form-label' for='feedback'>Feedback:</label>";
$MainContent .= "<div class='col-sm-9'>";
$MainContent .= "<textarea required class='form-control' name='feedback' id='feedback'
                  cols='25' rows='4' ></textarea> (required)";
$MainContent .= "</div>";
$MainContent .= "</div>";

$MainContent .= "<div class='form-group row'>";
$MainContent .= "<label class='col-sm-3 col-form-label' for='rating'>Rating:</label>";
$MainContent .= "<div class='col-sm-9'>";
$MainContent .= "<select id='rating' name='rating' required>
                    <option value='1'>1</option>
                    <option value='2'>2</option>
                    <option value='3'>3</option>
                    <option value='4'>4</option>
                    <option value='5'>5</option>
                 </select>";
$MainContent .= "<div>Please rate our products and services:</div>";
$MainContent .= "<div>1 - Extremely Poor</div>";
$MainContent .= "<div>2 - Slightly Poor</div>";
$MainContent .= "<div>3 - Average</div>";
$MainContent .= "<div>4 - Above Average</div>";
$MainContent .= "<div>5 - Excellent</div>";
$MainContent .= "</div>";
$MainContent .= "</div>";

$MainContent .= "<div class='form-group row'>";       
$MainContent .= "<div class='col-sm-9 offset-sm-3'>";
$MainContent .= "<button name='submit' type='submit' class='button'>Submit</button>";
$MainContent .= "</div>";
$MainContent .= "</div>";
$MainContent .= "</form>";


if(isset($_POST['submit'])){ 
   //Define the INSERT SQL Statement
   $qry = "INSERT INTO feedback (ShopperID, Subject, Content, Rank) VALUES (?, ?, ?, ?)";
   // Prepare statement for execution
   $stmt = $conn->prepare($qry);
   // "ssssss" - 6 string parameters
   $stmt->bind_param("ssss", $_SESSION["ShopperID"], $_POST['subject'], $_POST['feedback'], $_POST['rating']);
   // Execute statement (SQL is more secure as it prevent risk of SQL Injection)
   if ($stmt->execute()){ // SQL statement executed successfully
      $MainContent .= "Submit successful!<br/>";
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

$MainContent .= "</div>";
include("MasterTemplate.php"); 
?>


