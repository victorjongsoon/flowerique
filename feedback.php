<?php 
// Detect the current session
session_start();
include_once("mysql_conn.php");

// Check if user logged in 
if (! isset($_SESSION["ShopperID"])) {
	// redirect to login page if the session variable shopperid is not set
    $link = "login.php";
}
else{
    $link = "addFeedback.php";
}

$MainContent = "";
$MainContent .= "<link rel='stylesheet' href='css/site.css'>";
$MainContent .= "<div class='latest-products'>";
$MainContent .= "<div class='container'>";
$MainContent .= "<div class='row'>";
$MainContent .= "<div class='col-md-12'>";
$MainContent .= "<div class='section-heading'>";
$MainContent .= "<h2>Feedback</h2>";
$MainContent .= "<a href='$link'>Add Feedback<i class='fa fa-angle-right'></i></a>";
$MainContent .= "<hr/>";
$MainContent .= "</div>";
$MainContent .= "</div>";

$qry = "SELECT *
From feedback fb INNER JOIN shopper s ON fb.ShopperID=s.ShopperID";
$stmt = $conn->prepare($qry);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {

        $name = $row["Name"];
        $subject = $row["Subject"];
        $content = $row["Content"];
        $rank = $row["Rank"];

        $MainContent .= "<div class='col-md-5'>";
        $MainContent .= "<div class='product-item'>";
        $MainContent .= "<div class='down-content'>";
        $MainContent .= "<h4>$subject</h4>";
        $MainContent .= "<h4>$rank out of 5 stars</h4>";
        $MainContent .= "<h6>'$content'</h6>";
        $MainContent .= "<p>by: $name</p>";
        $MainContent .= "</div>";
        $MainContent .= "</div>";
        $MainContent .= "</div>";

    }
} else {
    echo "0 results";
}

$MainContent .= "</div>";
$MainContent .= "</div>";
$MainContent .= "</div>";


include("MasterTemplate.php");
?>