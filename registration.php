<?php 

// Detect the current session
session_start();
$MainContent = "";

// Read the data input from previous page
$name = $_POST["name"];
$address = $_POST["address"];
$country = $_POST["country"];
$phone = $_POST["phone"];
$email = $_POST["email"];
$password = $_POST["password"];
$birthday = $_POST["birthday"];
$pwdquestion = $_POST["pwdquestion"];
$pwdanswer = $_POST["pwdanswer"];

//Include the PHP file that establishes database connection handle: $conn
include_once("mysql_conn.php");

// ensure email is unique
if($email != "") {
    $qry = "SELECT * FROM shopper where Email=?";
    $stmt = $conn->prepare($qry);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $row = $result->fetch_array();
    if (isset($row['Email'])){
        $MainContent = "<div style='width:100%; margin:auto;'>";
        $MainContent .= "<h3 style='color:red'>Email Exist</h3>";
        $MainContent .= "<p>Click<a href='register.php'> here</a> to try again.</p>";
        $MainContent .= "</div>";
        
    }
    else{
        //Define the INSERT SQL Statement
        $qry = "INSERT INTO Shopper (Name, Address, Country, Phone, Email, Password, BirthDate, PwdQuestion, PwdAnswer) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        // Prepare statement for execution
        $stmt = $conn->prepare($qry);
        // "ssssss" - 6 string parameters
        $stmt->bind_param("sssssssss", $name, $address, $country, $phone, $email, $password, $birthday, $pwdquestion, $pwdanswer);
        // Execute statement (SQL is more secure as it prevent risk of SQL Injection)
        if ($stmt->execute()){ // SQL statement executed successfully
            // Retrieve the Shopper ID assigned to the new shopper
            $qry = "SELECT LAST_INSERT_ID() AS ShopperID";
            $result = $conn->query($qry); // Execute the SQL and get the returned result
            while ($row = $result->fetch_array()){
                $_SESSION["ShopperID"] = $row["ShopperID"];
            }
            // Display successfuly message and ShopperID
            $MainContent .= "Registration successful!<br/>";
            $MainContent .= "Your ShopperID is $_SESSION[ShopperID]<br/>";
            // Save the Shopper Name in a session variable
            $_SESSION["ShopperName"] = $name ;
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
else{
    $MainContent .= "<h3 style='color:red'>Error in inserting record</h3>";
}

include("MasterTemplate.php")
?>

